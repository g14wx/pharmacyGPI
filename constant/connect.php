<?php
// DB credentials.
$servername = "host.docker.internal";
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
