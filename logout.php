<?php
session_start();
session_destroy();
if($_GET['id'] == 2){
    header("location: AdminLogin.php");
}
if($_GET['id'] == 1){
    header("location: UserLogin.php");
}
?>