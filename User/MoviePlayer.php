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
    $q = "select subscription,sub_exp_date from user_dtl where user_id = $userid";
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
                $href = "location: MoviePlayer.php?movid=$_GET[movid]";
                header($href);
            }
        }
    }

    if(isset($_GET["wish"]))
    {
        $wishq = "INSERT INTO `wishlist`(`user_id`, `movie_id`) VALUES ('$_COOKIE[userid]','$_GET[wish])')";
        $wishr = mysqli_query($con,$wishq);
        if($wishr)
        {
            echo "<script>alert('Movie added to wishlist')</script>";
            $href = "location: MoviePlayer.php?movid=$_GET[movid]";
            header($href);
        }
    }
    if(isset($_GET["removewish"]))
    {
        $rmovwishq = "DELETE FROM `wishlist` WHERE `user_id`='$_COOKIE[userid]' AND `movie_id`='$_GET[removewish]'";
        $rmovwishr = mysqli_query($con,$rmovwishq);
        if($rmovwishr)
        {
            echo "<script>alert('Movie removed from wishlist')</script>";
            $href = "location: MoviePlayer.php?movid=$_GET[movid]";
            header($href);
        }
    }

    $movid = $_GET['movid'];
    $q = "select * from movie_dtl where movie_id = $movid";
    $res = mysqli_query($con, $q);
    if($res)
    {
        $movdtl = mysqli_fetch_assoc($res);
        $movsubscribe = $movdtl['subType'];
        
        echo "<script>alert(".$movsubscribe.")</script>";
        
        if($movsubscribe == "paid")
        {
            if(in_array("free",$subscription))
            {
                //echo "<script>alert('Not for you')</script>";
                header('location: BuySubscription.php');
            }
        }
    }


    $q1 = "select * from genre_dtl where movie_id = $movid";
    $res2 = mysqli_query($con, $q1);
    if($res2)
    {
        $i = 0;
        while($genredtl = mysqli_fetch_assoc($res2))
        {
            $movgenre[$i] = $genredtl['cat_id'];
            $i++;
        }
    }
    
}
?>
<!-- GithubRepo - https://github.com/Nikulsuthar2/MovieStreamer -->
<!-- Github - https://github.com/Nikulsuthar2  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userhome.css">
    <script src="../JS/jquery-3.6.0.js"></script>
    <title><?php if(isset($movdtl)){echo $movdtl['Name'];}?></title>
</head>
<body>
    <!--Navigation Bar -->
    <?php include('UserNavbar.php'); ?>
    <div class="mainbody">
        <div class="moviecontainer">
            <video class="videoplayer" src="<?php if(isset($movdtl)){echo $movdtl['moviepath'];}?>" controls controlsList="nodownload" autoplay loop></video>
            <img class="movieposter" src="<?php if(isset($movdtl)){echo $movdtl['posterpath'];}?>" >
        </div>
        <div class="movinfobox">
            <div class="movtitle">
                <h1><?php if(isset($movdtl)){echo $movdtl['Name'];}?></h1>
                <?php
                    $wmovq = "SELECT * FROM `wishlist` WHERE `user_id` = '$_COOKIE[userid]'";
                    $wmovres = mysqli_query($con,$wmovq);

                    $isinwishlist = false;
                    if($wmovres)
                    {
                        if(mysqli_num_rows($wmovres) > 0)
                        {
                            while($wishdata = mysqli_fetch_assoc($wmovres))
                            {
                                if($wishdata['movie_id'] == $movdtl['movie_id'])
                                {
                                    $isinwishlist = true;
                                }
                            }
                        }
                        if($isinwishlist)
                        {
                            echo "<a class='wishlistbtn' href='MoviePlayer.php?movid=$_GET[movid]&removewish=$_GET[movid]'>
                                <img src='../Assets/Videobutton/wishlisted.png' height='40px' width='40px'>
                            <a>";
                        }
                        else
                        {
                            echo "<a class='wishlistbtn' href='MoviePlayer.php?movid=$_GET[movid]&wish=$_GET[movid]'>
                                <img src='../Assets/Videobutton/wishlist.png' height='40px' width='40px'>
                            <a>";
                        }
                    }
                    else
                    {
                        echo "<a class='wishlistbtn' href='MoviePlayer.php?movid=$_GET[movid]&wish=$_GET[movid]'>
                                <img src='../Assets/Videobutton/wishlist.png' height='40px' width='40px'>
                            <a>";
                    }
                    ?>
                </h1>
            </div>
            <div class="movsmalldtl">
                <div class="dtlbox">
                    <label>Genre :  
                        <?php 
                        $q = "select * from category order by cat_name";
                        $result = mysqli_query($con,$q);
                        if($result)
                        {
                            while($row1 = mysqli_fetch_assoc($result))
                            {
                                if(in_array($row1['cat_id'],$movgenre))
                                {
                                    echo $row1['cat_name']."/ ";
                                }
                            }
                        }
                        ?>
                    </label>
                    <label>IMDB ratting : <?php if(isset($movdtl)){echo $movdtl['rating']."/10 ";}?></label>
                </div>
                <div class="dtlbox">
                    <label>Release Date : 
                        <?php
                        if(isset($movdtl))
                        {
                            
                            echo date('d-M-Y',strtotime($movdtl['releasedt']));
                        }
                        ?>
                    </label>
                    <label>Provider : <?php if(isset($movdtl)){echo $movdtl['Provider'];}?></label>
                </div>
                <div class="dtlbox">
                    <label>Language : <?php if(isset($movdtl)){echo $movdtl['language'];}?></label>
                    <label>Age limit : <?php if(isset($movdtl)){echo $movdtl['agelimit'];}?></label>
                </div>
                <div class="descbox">
                    <label class="proptitle">Description : <br></label>
                    <div style="padding: 10px;"><label><?php if(isset($movdtl)){echo $movdtl['description'];}?></label></div>
                </div>
                <div class="castdtl" style="margin-bottom:50px">
                    <label class="proptitle">Cast : <br></label>
                    <div class="castbox">
                        <?php 
                            $upq2 = "select * from cast_dtl where movie_id = $movid";
                            $r2 = mysqli_query($con,$upq2);
                            if($r2)
                            {
                                $i = 0;
                                while($castdtl = mysqli_fetch_assoc($r2))
                                {
                                    $castinmov[$i] = $castdtl['actor_id'];
                                    $i++;
                                }
                            }
                            $q2 = "select * from actor_dtl";
                            $result2 = mysqli_query($con,$q2);
                            if($result2)
                            {
                                while($row2 = mysqli_fetch_assoc($result2))
                                {
                                    if(in_array($row2['actor_id'],$castinmov))
                                    {
                                        echo "<div class='castinfo'>
                                        <div class='castimgbox'>
                                        <img class='castimg' src='".$row2['imagepath']."' width='100%' height='100%'></div>
                                        <label class='castname'>".$row2['name']."</label>
                                        </div>";
                                    }
                                }
                            } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>