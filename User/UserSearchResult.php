<?php
/*
|--------------------------------------------------------------------------
| Movie Streaming & Subscription Website
|-------------------------------------------------------------------------
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

if(!isset($_SESSION['username']) || !isset($_SESSION['userid']))
{
    header('location: UserLogin.php');
}
else
{
    $userid = $_COOKIE['userid'];
    $q = "select * from user_dtl where user_id = $userid";
    $res = mysqli_query($con, $q);
    if($res)
    {
        $subscription = mysqli_fetch_assoc($res);
        $subexpdt = $subscription['sub_exp_date'];
        $currentdt = date("Y-m-d");
        if($currentdt > $subexpdt && $subexpdt != null)
        {
            $resetsubq = "UPDATE `user_dtl` SET `subscription`='free',`sub_date`=null,`sub_exp_date`=null WHERE user_id = $userid";
            $resetresult = mysqli_query($con,$resetsubq);
            if($resetresult)
            {
                header('location: UserHome.php');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/CatResult.css">
    <link rel="stylesheet" href="../CSS/userhome.css">
    <script src="../JS/jquery-3.6.0.js"></script>
    <title>
        <?php
        if(isset($_GET['search']))
        {
            $Svalue = $_GET['search'];
            echo $Svalue;
        }
        ?>
    </title>
</head>
<body>
<?php include('UserNavbar.php'); ?>
    <div class="mainbody">
        <div class="genreTitle">
            <label>
            <?php 
            if(isset($_GET['search']))
            {
                $Svalue = $_GET['search'];
                echo $Svalue;
            }
            ?>
            </label>
        </div>
        <div class="movresult">
            <?php
            $q2 = "select * from movie_dtl where name like '%$Svalue%'";
            $result2 = mysqli_query($con,$q2);
            if($result2)
            {
                while($searchlist = mysqli_fetch_assoc($result2))
                {
                    echo "<a href='MoviePlayer.php?movid=$searchlist[movie_id]'>
                    <img class='movSmallPoster' src='$searchlist[posterpath]' height='300px'>
                    </a>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
<!-- GithubRepo - https://github.com/Nikulsuthar2/MovieStreamer -->
<!-- Github - https://github.com/Nikulsuthar2 -->
