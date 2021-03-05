<?php

$servername = "155.138.141.168";
$username = "qfraypuzjb";
$password = "hGhT5XqQJE";
$dbname = "qfraypuzjb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


// sql to create table
$sql = "CREATE TABLE usage_history (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
sid VARCHAR(255) NOT NULL,
twillio_usage VARCHAR(55) NOT NULL,
email VARCHAR(50),
timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  echo "Table MyGuests created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>