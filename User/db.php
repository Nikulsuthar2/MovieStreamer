<?php
/*
|-------------------------------------------------------------------------
| Movie Streaming & Subscription Website
|--------------------------------------------------------------------------
| Author: Nikul Suthar
| Copyright: © 2025 Nikul Suthar or Your Organization
| Description: This PHP file is part of the movie streaming 
| and subscription website project.
| 
| Feel free to explore, learn, and enhance this project. 
| Please provide appropriate credit if you use or modify it.
|--------------------------------------------------------------------------
*/
$hostname = "localhost";
$username = "root";
$password = "";
$database = "moviestream";
$con = mysqli_connect($hostname,$username,$password,$database);
if(!$con)
{
    die("connection error");
}
?>