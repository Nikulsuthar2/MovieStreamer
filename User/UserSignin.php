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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/loginsignin.css">
    <title>User Signin</title>
</head>
<body>
    <!--Navigation Bar -->
    <nav>
        <label class="Logo">MOVIE STREAMER</label>
        <ul class="drawer">
            <li><a class="adminbtn" href="../Admin/AdminLogin.php">ADMIN</a></li>
            <li><a class="loginbtn" href="UserLogin.php">LOG IN</a></li>
        </ul>
    </nav>
    <div class="mainbody">
        <form action="" method="POST">
            <h1 class="heading1">Create Account</h1>
            <div class="formcontrols">
                <label class="ilabel">Name</label>
                <input type="username" class="inputfield" name="Uname" placeholder="Enter your full name" required autofocus>
                <label class="ilabel">Email ID</label>
                <input type="email" class="inputfield" name="Uemail" placeholder="Enter your email address" required>
                <label class="ilabel">Password</label>
                <input type="password" class="inputfield" name="Upswd" placeholder="Enter your password" minlength="8" maxlength="16" required>
                <label class="ilabel">Confirm Password</label>
                <input type="password" class="inputfield" name="UCpswd" placeholder="Re-Enter your password" minlength="8" maxlength="16" required>
            </div>
            <?php
            session_start();
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if(isset($_POST['signin'])){
                    if($_POST['Upswd'] != $_POST['UCpswd'])
                    {
                        echo "<p style='color: red;'>Password doesn't Match</p>";
                    }
                    if($_POST['Upswd'] == $_POST['UCpswd'])
                    {
                        $name = mysqli_real_escape_string($con,$_POST['Uname']);
                        $email = mysqli_real_escape_string($con,$_POST['Uemail']);
                        $password = mysqli_real_escape_string($con,$_POST['Upswd']);
    
                        $sql = "select user_id from user_dtl where email='$email'";
                        $result = mysqli_query($con,$sql);
    
                        $count = mysqli_num_rows($result);
    
                        if($count == 0){
                            $q = "insert into user_dtl(name,email,password) values('".$name."','".$email."','".$password."')";
                            $res = mysqli_query($con,$q);
    
                            if($res){
                                $_SESSION['curruser'] = $name;
                                setcookie('username',$name,time()+86400);
                            }
                            else{
                                echo "Error :-".mysqli_error($con);
                                die();
                            }
                            header("location: UserLogin.php");
                        }
                        else{
                            echo "<p style='color: red;'>User Already Exist</p>";
                        }
                    }
                    unset($_POST['signin']);
                }
            }
            
            ?>
            <input class="loginbutton" type="submit" value="SIGN IN" name="signin">
        </form>
    </div>
</body>
</html>
<!-- GithubRepo - https://github.com/Nikulsuthar2/MovieStreamer -->
<!-- Github - https://github.com/Nikulsuthar2 -->
