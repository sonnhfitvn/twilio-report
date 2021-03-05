
<?php
	 require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	 error_reporting(E_ALL);
	 ini_set('display_errors','1'); 

	 require_once 'Twilio/autoload.php';
	 use Twilio\Rest\Client;

	 $sid ="AC5e7b83ee2ca9711de6a2816e130b35ca";
	 $token = "33e20e8f3da51fa3cfcd6725bbd6a73d";

	 $sql_select ="SELECT * FROM `users` order by id asc";
     $query_select=mysqli_query($conn,$sql_select);

     mysqli_query($conn, "insert into `logs` SET logs='Process has been started'");

		while($accounts = mysqli_fetch_array($query_select)){
    
			$twilio        = new Client($sid, $token,$accounts['sid'] );
			$readdata =  array_reverse($twilio->usage->records->thisMonth->read(
					array("category" => "totalprice")));
		    $sid_insert = $accounts['sid'];
		    $price = $readdata[0]->price;
    
			// Update usage
			$sql="UPDATE `users` SET twillio_usage='$price'  WHERE sid='$sid_insert'";
			if (mysqli_query($conn, $sql)) {
				echo "Usage of Account-".$accounts['name']." has been updated <br>";
				mysqli_query($conn, "insert into `usage_history` SET twillio_usage='$price',sid='$sid_insert'");   
			} else {
				echo "Usage of Account-".$accounts['name']." has not been updated. Something is wrong <br>";
         } 
		// Update usage
		
		// Send Notification to zapier if usage of last 3 min is more than $10
			 
	   $sql="select * from usage_history where sid='$sid_insert' and timestamp > now() - interval 3 minute order by id asc";
	   $query=mysqli_query($conn,$sql);
	   $row = mysqli_num_rows($query); 
	   
       if($row>0){
		   
		$results = mysqli_fetch_array($query);
	
		 $ttusage =  ($accounts['twillio_usage']-$results['twillio_usage']);
		if($ttusage>10){
			 // Call Zap webhook here
			 
			    $curl = curl_init();
				   $data = array('message' => $accounts['name']);
				   
					$jsonEncodedData = json_encode($data);
					$opts = array(
					CURLOPT_URL             => 'https://hooks.zapier.com/hooks/catch/3754354/ocx7jy8',
					CURLOPT_RETURNTRANSFER  => true,
					CURLOPT_CUSTOMREQUEST   => 'POST',
					CURLOPT_POST            => 1,
					CURLOPT_POSTFIELDS      => $jsonEncodedData,
					CURLOPT_HTTPHEADER  => array('Content-Type: application/json','Content-Length: ' . strlen($jsonEncodedData))                                                                       
					);

					// Set curl options
					curl_setopt_array($curl, $opts);

					// Get the results
					$result = curl_exec($curl);
					curl_close($curl);
					
			 // Zapier Webhook Ends here
		}else{
			
		}
       }
	   
		// Semd Notification to Zapier if usage is more than 3 min
    }
     mysqli_query($conn, "insert into `logs` SET logs='Process has been finished'");
	 mysqli_query($conn, "delete from `usage_history` WHERE timestamp <= DATE_SUB(NOW(), INTERVAL 2 DAY)");
