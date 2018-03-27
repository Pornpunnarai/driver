<?php

$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "chiangmaibus";
$char_set = "charset=utf8";
$objCon = mysqli_connect($serverName,$username,$password,$dbName);
mysqli_set_charset($objCon,"utf8");

?>