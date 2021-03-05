<?php include('config.php'); 

    
    if($_POST['type']=="delete"){
        
         $id=$_POST['delete'];
         $sql="DELETE FROM `users` WHERE id='$id'";
         if (mysqli_query($conn, $sql)) {
          echo "Record deleted successfully";
          } else {
          echo "Error deleting record: " . mysqli_error($conn);
         }

        
 }
   if($_POST['type']=="add"){
        
         $name=$_POST['name'];
         $sid=$_POST['sid'];
         $sql="INSERT INTO `users` (`name`, `sid`) VALUES ('$name','$sid')";
     if (mysqli_query($conn, $sql)) {
            header('Location:index.php?success=1 ');
          } else {
          header('Location:index.php?success=2 ');

         }

 }
    if($_POST['type']=="editajax"){
        
         $id=$_POST['id'];
         $sql="SELECT * FROM `users` WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $row= mysqli_fetch_array($result);
                echo json_encode($row);


 }
  
     if($_POST['type']=="edit"){
        
         $edit_id=$_POST['edit_id'];
         $edit_limit=$_POST['edit_limit'];
         $sql="UPDATE `users` SET `limit_per_month`='$edit_limit'  WHERE id='$edit_id'";
   
    
         if (mysqli_query($conn, $sql)) {
            header('Location:index.php?success=3 ');
          } else {
          header('Location:index.php?success=2 ');

         }


 }
    
    






?>