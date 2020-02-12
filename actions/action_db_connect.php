<?php 	

$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "n1w4l1_crm";

// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);
$mysqli = new mysqli($localhost, $username, $password, $dbname);
// check connection
 
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}

?>