<?php
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "route";
$char_set = "charset=utf8";

// Create connection
$objCon = mysqli_connect($serverName,$username,$password,$dbName);
mysqli_set_charset($objCon,"utf8");



$lat = $_POST["lat_value"];
$long = $_POST["lon_value"];
$route = "KW-City";

// Check connection




if(isset($username)&&isset($password)) {

    $sql = "INSERT INTO `route_cm`(`latitude`,`longitude`, `route_name`) VALUES ('".$lat. "','".$long. "','".$route. "')";
    $objQuery = mysqli_query($objCon, $sql);

//    echo $sql;

    header('Location: test.php');

}
else{
    echo "Username and Password Incorrect!";
//    header('Location: login.php');
}

?>