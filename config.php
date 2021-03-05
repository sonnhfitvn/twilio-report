   <?php
         $dbhost = 'localhost';
         $dbuser = 'root';
         $dbpass = 'Ahmad101!!!';
         $db = 'twilio';
    
$conn = new mysqli($dbhost,$dbuser,$dbpass,$db);

// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $conn -> connect_error;
  exit();
}
?>
    
      