<?php
session_start();
if(isset($_GET["price"]))
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Sucessful</title>
</head>
<body>
    <h1 class="paysuccessheader">Payment Successful</h1>
    <label class="moneypaid">&#8377 <?php if(isset($_GET["price"])){echo $_GET["price"];}?> Paid</label>
    <label class="monthfree">Now FREE for  <?php if(isset($_GET["month"])){echo $_GET["month"];}?> Month</label>
    <a href="UserHome.php">GO TO HOME</a>
</body>
</html>