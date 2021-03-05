<?php 

/*error_reporting(E_ALL);
ini_set('display_errors','1'); */
?>
<html>
    <head>
    <title>Daily Report</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php include('config.php');
    /* $querys=mysqli_query($conn,'select * from usage_history');
   echo "count:";
   echo  $rows = mysqli_num_rows($querys); */
  
   
   
	function last_usage($sid,$time,$usage){
	   global $conn;
	   $sql="select * from usage_history where sid='$sid' and timestamp > now() - interval $time minute order by id asc";
	   $query=mysqli_query($conn,$sql);
	   $row = mysqli_num_rows($query); 
       if($row>0){
		$results = mysqli_fetch_array($query);
		$ttusage =  ($usage-$results['twillio_usage']);
		
       }else{
           	$ttusage = '0';
       }
       echo 	$ttusage;
	}
	
    ?>
    </head>
    <body>
    <div class="logo-container">
<div>
	<img src="https://reporting.leadzengine.com/dailyreport/assets/img/leadzengine50px.png">
</div>
</div>
    <div class="container">
		<div class="row">
			<h2 class="text-center">Monthly Report</h2>
	        <p class="text-center">From Dated: <?php echo date('Y-m-01'); ?> to
	  		<?php echo date("Y-m-d");; ?></p>
		</div>
    
        <div class="row">
          <div class="col-md-12">
             
<?php 
if(isset($_GET['success'])){ ?>
<?php  if($_GET['success']==1) {?>
 <div class="alert alert-success">
 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> New User Created Successfully.
</div>
<?php  } ?>
<?php  if($_GET['success']==3) {?>
 <div class="alert alert-success">
 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> User Updated Successfully.
</div>
<?php  } ?>
<?php  if($_GET['success']==2) {?>
 <div class="alert alert-danger">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Danger!</strong>Something Went Wrong.Please try again.
</div>
<?php } ?>
<?php } ?>
<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
   <!-- <p data-placement="top" data-toggle="tooltip" title="ADD"><button class="btn btn-primary btn-xs" data-title="ADD" data-toggle="modal" data-target="#add"><span class="glyphicon glyphicon-plus"></span></button></p> -->
    				<thead>
						<tr>
						    <th>Id</th>
						    <th>Account Name</th>
							<th>Status</th>
							<th>3 Min Usage</th>
							<th>5 Min Usage</th>
							<th>24 hours Usage</th>
							<th>Usage this month</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
						    <th>Id</th>
						    <th>Account Name</th>
							<th>Status</th>
							<th>1 Min Usage</th>
							<th>5 Min Usage</th>
							<th>24 hours Usage</th>
							<th>Usage this month (USD)</th>
						</tr>
					</tfoot>
					<tbody>
					    <?php $sql="Select * from users ";
					    $query=mysqli_query($conn,$sql);
					    $counter = 1;
					    foreach( $query as $data){ ?>
							<tr id="row<?php echo $data['id']; ?>">
							    <td><?php echo $counter; ?></td>
								<td><?php echo $data['name']; ?></td>
								<td><?php echo strtoupper($data['status']); ?></td>
								<td><?php  last_usage($data['sid'],3,$data['twillio_usage']);?></td>
								<td><?php  last_usage($data['sid'],5,$data['twillio_usage']);?></td>
								<td><?php  last_usage($data['sid'],1440,$data['twillio_usage']);?></td>
								<td><?php echo $data['twillio_usage']; ?></td>
								
	                            <!--<td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" onclick="edit('<?php // echo $data['id']; ?>')"><span class="glyphicon glyphicon-pencil"></span></button></p></td> -->
							</tr>
						 <?php $counter ++; } ?>
     					</tbody>
					</table>
				</div>
				</div>
			</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title custom_align" style="color:black;" id="Heading">Edit Your Detail</h4>
        </div>
      <form method="Post" action="function.php">
          <div class="modal-body">

          <div class="form-group">
          <input class="form-control " name="edit_name" id="edit_name" type="text" placeholder="NAME" required="" readonly disabled>
          </div>

          <div class="form-group">
          <input type="hidden" name="edit_id" id="edit_id">
          <input type="hidden" name="type" id="edit" value="edit">
          <label> Set the limit </label>
          <input class="form-control " name="edit_limit" id="edit_limit" type="text" placeholder="Edit your Limit" required="">
          </div>
          </div>
          <div class="modal-footer ">
        <button type="submit" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
        </form>
      </div>
        </div>
  	</div>
    </div>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title custom_align" id="Heading">Add Your Detail</h4>
      </div>
      <form method="Post" action="function.php">
        <div class="modal-body">
     
        <div class="form-group">
         <input type="hidden" name="type" value="add">
      
        <input class="form-control" name="sid" type="text" placeholder="SID" required="">
        </div>

        <div class="form-group">
        
        
      <input class="form-control" name="name" type="text" placeholder="NAME" required="">
        </div>
      </div>
          <div class="modal-footer ">
        <button type="submit" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Add</button>
      </div>
      </form>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>
    
    
<script>
  $(document).ready(function() {
      $('#datatable').dataTable(
        { "pageLength": 200 }
         );
     } );

function deletedata(id){      
    swal({
 		 title: "Are you sure?",
  		 text: "Are you sure want to delete this user ?",
  		 icon: "warning",
  		 buttons: true,
  		 dangerMode: true,
		})
		 .then((willDelete) => {
		 if (willDelete) {
   			var data={"delete":id,"type":"delete"}      
			 $.ajax({
			  type: "POST",
			  url: 'function.php',
			  data: data,
			  success: function (response) {
			   $(`#row${id}`).hide();
			   swal("User Deleted Successfully", {
			      icon: "success",
			    });
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }
		});
		  } else {
		    swal("User is safe");
		  }

		});
		}

function edit(id){
var data={"id":id,"type":"editajax"}      
 $.ajax({
  type: "POST",
  url: 'function.php',
  data: data,
 success: function (response) {
             var jsonData = JSON.parse(response);

    console.log(jsonData);
     $('#edit').modal('show'); 
     $('#edit_id').val(jsonData.id);
     $('#edit_limit').val(jsonData.limit_per_month);
     $('#edit_name').val(jsonData.name);
        },
	error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	  }
	});
    
}
</script> 
</body>
</html>