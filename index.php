<?php
session_start();
if(!isset($_SESSION["UserID"])) {
    header('Location: php/login.php');
    ?>
    <?php
}
else{
    header('Location: php/manage.php');
}
?>

