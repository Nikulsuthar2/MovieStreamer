<?php
/*
|------------------------------------------------------------------------
| Movie Streaming & Subscription Website
|------------------------------------------------------------------------
| Author: Nikul Suthar
| Copyright: © 2025 Nikul Suthar or Your Organization
| Description: This PHP file is part of the movie streaming 
| and subscription website project.
| 
| Feel free to explore, learn, and enhance this project. 
| Please provide appropriate credit if you use or modify it.
|------------------------------------------------------------------------
*/
session_start();
session_destroy();
if($_GET['id'] == 2){
    header("location: Admin/AdminLogin.php");
}
if($_GET['id'] == 1){
    header("location: User/UserLogin.php");
}
?>