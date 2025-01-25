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


$recentid = false;
$catid = false;
if(isset($_GET['recentid']))
{
    $recentid = true;
}
if(isset($_GET['catid']))
{
    $catid = true;
}
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
    <link rel="stylesheet" href="../CSS/userhome.css">
    <link rel="stylesheet" href="../CSS/CatResult.css">
    <title>
        <?php 
        if($recentid or $catid)
        {
            echo $_GET['name'];
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
            if($recentid or $catid)
            {
                echo $_GET['name'];
            }
            ?>
            </label>
        </div>
        <div class="movresult">
            <?php
            if($recentid)
            {
                if($_GET['recentid']==1)
                {
                    $recentq = "select * from movie_dtl order by movie_id desc";
                    $recentr = mysqli_query($con, $recentq);
                    if($recentr)
                    {
                        while($recentlist = mysqli_fetch_assoc($recentr))
                        {
                            echo "<a href='MoviePlayer.php?movid=$recentlist[movie_id]'>
                            <img class='movSmallPoster' src='$recentlist[posterpath]' height='300px'>
                            </a>";
                        }
                    }
                }
                if($_GET['recentid']==2)
                {
                    $recentq = "select * from movie_dtl order by releasedt desc";
                    $recentr = mysqli_query($con, $recentq);
                    if($recentr)
                    {
                        while($recentlist = mysqli_fetch_assoc($recentr))
                        {
                            echo "<a href='MoviePlayer.php?movid=$recentlist[movie_id]'>
                            <img class='movSmallPoster' src='$recentlist[posterpath]' height='300px'>
                            </a>";
                        }
                    }
                }
                //free movies
                if($_GET['recentid']==3)
                {
                    $recentq = "select * from movie_dtl where subType = 'free' order by releasedt desc";
                    $recentr = mysqli_query($con, $recentq);
                    if($recentr)
                    {
                        while($recentlist = mysqli_fetch_assoc($recentr))
                        {
                            echo "<a href='MoviePlayer.php?movid=$recentlist[movie_id]'>
                            <img class='movSmallPoster' src='$recentlist[posterpath]' height='300px'>
                            </a>";
                        }
                    }
                }
                //kids movies
                if($_GET['recentid']==4)
                {
                    $recentq = "select * from movie_dtl where agelimit < 13 order by releasedt desc";
                    $recentr = mysqli_query($con, $recentq);
                    if($recentr)
                    {
                        while($recentlist = mysqli_fetch_assoc($recentr))
                        {
                            echo "<a href='MoviePlayer.php?movid=$recentlist[movie_id]'>
                            <img class='movSmallPoster' src='$recentlist[posterpath]' height='300px'>
                            </a>";
                        }
                    }
                }
            }
            if($catid)
            {
                $genmovq = "select a.movie_id, a.posterpath, b.cat_id from movie_dtl a, genre_dtl b where a.movie_id = b.movie_id and b.cat_id = '$_GET[catid]'";
                $genreres = mysqli_query($con, $genmovq);
                $count = mysqli_num_rows($genreres);
                if($genreres)
                {
                    while($catlist = mysqli_fetch_assoc($genreres))
                    {
                        echo "<a href='MoviePlayer.php?movid=$catlist[movie_id]'>
                        <img class='movSmallPoster' src='$catlist[posterpath]' height='300px'>
                        </a>";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>