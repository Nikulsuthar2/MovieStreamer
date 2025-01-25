<?php
/*
|--------------------------------------------------------------------------
| Movie Streaming & Subscription Website
|--------------------------------------------------------------------------
| Author: Nikul Suthar
| Copyright: © 2025 Nikul Suthar or Your Organization
| Description: This PHP file is part of the movie streaming 
| and subscription website project.
| 
| Feel free to explore, learn, and enhance this project. 
| Please provide appropriate credit if you use or modify it.
|-------------------------------------------------------------------------
*/
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/payrecipt.css">
    <title>Payment Sucessful</title>
</head>
<body onload="document.body.style.opacity='1'">
    <div class="payrecipt">
        <h1 class="paysuccessheader">Payment Successful</h1>
        <label class="moneypaid">&#8377 <?php if(isset($_GET["price"])){echo $_GET["price"];}?> Paid</label>
        <label class="monthfree">Now FREE for  <?php if(isset($_GET["month"])){echo $_GET["month"];}?> Month</label>
        <a class="gohomebtn" href="UserHome.php">GO TO HOME</a>
    </div>
</body>
</html>
<!-- GithubRepo - https://github.com/Nikulsuthar2/MovieStreamer -->
<!-- Github - https://github.com/Nikulsuthar2 -->
