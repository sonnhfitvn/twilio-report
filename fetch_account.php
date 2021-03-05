<?php
include('config.php');
//error_reporting(E_ALL);
//ini_set('display_errors','1');
require_once 'Twilio/autoload.php';
use Twilio\Rest\Client;

$sid ="AC5e7b83ee2ca9711de6a2816e130b35ca";
$token = "33e20e8f3da51fa3cfcd6725bbd6a73d";
$twilio        = new Client($sid, $token);
$accounts = $twilio->api->v2010->accounts
                               ->read();

$counter = 1;
foreach ($accounts as $record) {
      $sql_select ="SELECT * FROM `users` WHERE sid='$record->sid'";
     $query_select=mysqli_query($conn,$sql_select);
       $rowcount=mysqli_num_rows($query_select);

     
     if($rowcount==0){
        $sql="INSERT INTO `users` (`name`, `sid`,status) VALUES ('$record->friendlyName','$record->sid','$record->status')";
    
         $query=mysqli_query($conn,$sql);
         if($query){
             echo "Success<br>";
         }
         echo "Records are updated<br>";
      }else{
          echo "Records are updated<br>";
      }
  
} 