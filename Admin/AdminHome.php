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
session_start();
include 'db.php';

if(!isset($_SESSION['username']))
{
    header('location: AdminLogin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/adminhome.css">
    <title>Admin Home</title>
</head>
<body>
    <!--Navigation Bar -->
    <nav>
        <label class="Logo">MOVIE STREAMER</label>
        <ul class="drawer">
            <li>
                <a class="adminbtn" href="#">
                <?php 
                if(isset($_SESSION['username']))
                {
                    if(is_array($_SESSION['username'])){
                        echo implode($_SESSION['username']);
                    }
                    else{
                        echo $_SESSION['username'];
                    }
                }
                ?>
                </a>
            </li>
            <li><a class="loginbtn" href="../logout.php?id=2">LOG OUT</a></li>
        </ul>
    </nav>
    <div class="mainbody">
        <div class="sidebar">
            <a class="sideitem active" href="AdminHome.php">Dashboard</a>
            <a class="sideitem" href="Users.php">Users</a>
            <a class="sideitem" href="Movies.php">Movies</a>
            <a class="sideitem" href="Actors.php">Actors</a>
            <a class="sideitem" href="Subscribeplan.php">Subscription plan</a>
            <a class="sideitem" href="Paymentdtl.php">Payment Details</a>
            </ul>
        </div>
        <div class="mainview">
            <div class="header">
                <h1>ADMIN HOME</h1>
            </div>
            <div class="adminhomemain">
                <div class="itemcard">
                    <h2 class="itemlabel">Total User</h2>
                    <label class="itemvalue">
                        <?php
                        $q1 = "select user_id from user_dtl";
                        $res1 = mysqli_query($con,$q1);
                        $usercount = mysqli_num_rows($res1);
                        if($res1)
                        {
                            echo $usercount;
                        }
                        ?>
                    </label>
                </div>
                <div class="itemcard">
                    <h2 class="itemlabel">Total Movies</h2>
                    <label class="itemvalue">
                        <?php
                        $q2 = "select movie_id from movie_dtl";
                        $res2 = mysqli_query($con,$q2);
                        $moviecount = mysqli_num_rows($res2);
                        if($res2)
                        {
                            echo $moviecount;
                        }
                        ?>
                    </label>
                </div>
                <div class="itemcard">
                    <h2 class="itemlabel">Total Actors</h2>
                    <label class="itemvalue">
                        <?php
                        $q3 = "select actor_id from actor_dtl";
                        $res3 = mysqli_query($con,$q3);
                        $actorcount = mysqli_num_rows($res3);
                        if($res3)
                        {
                            echo $actorcount;
                        }
                        ?>
                    </label>
                </div>
                <div class="itemcard">
                    <h2 class="itemlabel">Total Active Subscription</h2>
                    <label class="itemvalue">
                        <?php
                        $q4 = "select user_id from user_dtl where Subscription = 'paid'";
                        $res4 = mysqli_query($con,$q4);
                        $subsripcount = mysqli_num_rows($res4);
                        if($res4)
                        {
                            echo $subsripcount;
                        }
                        ?>
                    </label>
                </div>
                <div class="itemcard">
                    <h2 class="itemlabel">Total InActive Subscription</h2>
                    <label class="itemvalue">
                        <?php
                        $q5 = "select user_id from user_dtl where Subscription = 'free'";
                        $res5 = mysqli_query($con,$q5);
                        $nonsubsripcount = mysqli_num_rows($res5);
                        if($res5)
                        {
                            echo $nonsubsripcount;
                        }
                        ?>
                    </label>
                </div>
                <div class="itemcard">
                    <h2 class="itemlabel">Total Earning</h2>
                    <label class="itemvalue">
                        <?php
                        $q6 = "select sum(pay_amount) from payment_dtl";
                        $res6 = mysqli_query($con,$q6);
                        if($res6)
                        {
                            echo "&#8377;".mysqli_fetch_row($res6)[0];
                        }
                        ?>
                    </label>
                </div>
                <?php
                $q7 = "SELECT s.name, COUNT(u.user_id) as ucount FROM `subscription_dtl` s LEFT JOIN user_dtl u on s.id = u.sub_type GROUP by s.Name ORDER by s.price";
                $res7 = mysqli_query($con,$q7);
                if($res7){
                    while($row = mysqli_fetch_assoc($res7)){
                        echo "<div class='itemcard' style='background-color:royalblue'>
                    <h2 class='itemlabel'>".$row["name"]." Subscriptions</h2>
                    <label class='itemvalue'>
                        ".$row["ucount"]."
                    </label>
                </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>