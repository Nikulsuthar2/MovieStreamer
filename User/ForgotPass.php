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
include 'db.php';
?>
<!-- GithubRepo - https://github.com/Nikulsuthar2/MovieStreamer -->
<!-- Github - https://github.com/Nikulsuthar2 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/forgotpass.css">
    <link rel="stylesheet" href="../CSS/loginsignin.css">
    <title>Forgot Password</title>
</head>
<body>
    <!--Navigation Bar -->
    <nav>
        <label class="Logo">MOVIE STREAMER</label>
        <ul class="drawer">
            <li><a class="loginbtn" href="UserSignin.php">SIGN IN</a></li>
        </ul>
    </nav>
    <div class="mainbody">
        <form action="<?php $_PHP_SELF ?>" method="POST" style="display:flex;flex-direction:column;gap:20px;">
            <h1 class="heading1">Forgot Password</h1>
            <div class="formcontrols">
                <label class="ilabel">Email Address</label>
                <input type="email" class="inputfield" name="Uemail" placeholder="Enter your email address">
            </div>
            <?php
            session_start();
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $email = mysqli_real_escape_string($con,$_POST['Uemail']);
            
                $sql = "select * from user_dtl where email='$email'";
                $result = mysqli_query($con,$sql);
                $userdtl = mysqli_fetch_assoc($result);
                $count = mysqli_num_rows($result);

                if($count == 1){
                    header("location: ResetPass.php?uid=$userdtl[user_id]");
                }
                else{
                    if(isset($_POST['forgotpass']))
                    {
                        echo "<p style='color: red;'>Account doesn't Exist</p>";
                        unset($_POST['forgotpass']);
                    }
                }
            }
            
            ?>
            <input class="loginbutton" type="submit" value="Forgot Password" name="forgotpass">
        </form>
    </div>
</body>
</html>