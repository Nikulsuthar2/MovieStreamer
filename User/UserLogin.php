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
    <link rel="stylesheet" href="../CSS/loginsignin.css">
    <title>User Login</title>
</head>
<body>
    <!--Navigation Bar -->
    <nav>
        <label class="Logo">MOVIE STREAMER</label>
        <ul class="drawer">
            <li><a class="adminbtn" href="../Admin/AdminLogin.php">ADMIN</a></li>
            <li><a class="loginbtn" href="UserSignin.php">SIGN IN</a></li>
        </ul>
    </nav>
    <div class="mainbody">
        <form action="" method="POST">
            <h1 class="heading1">Login</h1>
            <div class="formcontrols">
                <label class="ilabel">Email ID</label>
                <input type="email" class="inputfield" name="Uemail" placeholder="Enter your email address">
                <label class="ilabel">Password</label>
                <input type="password" class="inputfield" name="Upswd" placeholder="Enter your password">

                <a class="forgotpass" href="ForgotPass.php">Forgot password?</a>

            </div>
            <?php
            session_start();
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $email = mysqli_real_escape_string($con,$_POST['Uemail']);
                $password = mysqli_real_escape_string($con,$_POST['Upswd']);
            
                $sql = "select user_id,name from user_dtl where email='$email' and password='$password'";
                $result = mysqli_query($con,$sql);

                $count = mysqli_num_rows($result);
                $userdtl = mysqli_fetch_row($result);

                if($count == 1){
                    setcookie("username",$userdtl[1],time()+86400);
                    setcookie("userid",$userdtl[0],time()+86400);
                    $_SESSION['username'] = $userdtl[1];
                    $_SESSION['userid'] = $userdtl[0];

                    header("location: UserHome.php");
                }
                else{
                    if(isset($_POST['login']))
                    {
                        echo "<p style='color: red;'>Account doesn't Exist</p>";
                        unset($_POST['login']);
                    }
                }
            }
            
            ?>
            <input class="loginbutton" type="submit" value="LOG IN" name="login">
            <!--
            <label class="ilabel">Don't have an account? <a href="UserSignin.php">Sign Up</a></label>
            -->
        </form>
    </div>
</body>
</html>