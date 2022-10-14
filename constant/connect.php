<?php
// DB credentials.
$servername = "localhost:3306";
$username = "root";
$password = "nike";
$dbname = "farmacia";
//$store_url = "http://localhost/phpinventory/";
// db connection
$connect = new mysqli($servername, $username, $password, $dbname);
// check connection
if ($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}
