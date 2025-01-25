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
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/forgotpass.css">
    <link rel="stylesheet" href="../CSS/loginsignin.css">
    <title>Reset Password</title>
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
            <h1 class="heading1">Reset Password</h1>
            <div class="formcontrols">
                <input hidden type="text" name="uid" value="
                <?php 
                    if(isset($_GET["uid"]))
                        echo $_GET["uid"];
                    elseif(isset($_POST["uid"]))
                        echo $_POST["uid"];
                ?>">
                <label class="ilabel">New Password</label>
                <input type="password" class="inputfield" name="Upswd" placeholder="Enter your New Password">
                <label class="ilabel">Confirm New Password</label>
                <input type="password" class="inputfield" name="UCpswd" placeholder="Re-Enter your New Password">
            </div>
            <?php
            session_start();
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if(isset($_POST['resetpass'])){
                    if($_POST['Upswd'] != $_POST['UCpswd'])
                    {
                        echo "<p style='color: red;'>Password doesn't Match</p>";
                    }
                    if($_POST['Upswd'] == $_POST['UCpswd'])
                    {
                        $pass = mysqli_real_escape_string($con,$_POST['Upswd']);
                        $sql = "UPDATE `user_dtl` SET `password` = '$_POST[Upswd]' WHERE `user_id`='$_POST[uid]'";
                        $result = mysqli_query($con,$sql);
                        if($result)
                        {
                            echo "<script>alert('Password Reset Sucessfully')
                            window.location = 'UserLogin.php'
                            </script>";
                        }
                    }
                }
            }
            
            ?>
            <input class="loginbutton" type="submit" value="Reset Password" name="resetpass">
        </form>
        <a class="gotologin" href="UserLogin.php">Go To Login Page</a>
    </div>
</body>
</html>
<!-- GithubRepo - https://github.com/Nikulsuthar2/MovieStreamer -->
<!-- Github - https://github.com/Nikulsuthar2 -->
