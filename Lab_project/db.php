<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "lab";

// Enable MySQLi exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    $conn = mysqli_connect($host, $user, $password, $dbname);
} 
catch (mysqli_sql_exception $e) {
  echo"connection failed:" . $e->getMessage() . "<br>";
  exit();
}
?>