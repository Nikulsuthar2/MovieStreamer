<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username']) || !isset($_SESSION['userid']))
{
    header('location: UserLogin.php');
}
else
{
    $userid = $_SESSION['userid'];
    $q = "select * from user_dtl where user_id = $userid";
    $res = mysqli_query($con, $q);
    if($res)
    {
        $subscription = mysqli_fetch_assoc($res);
        $subexpdt = $subscription['sub_exp_date'];
        $currentdt = date("Y-m-d");
        if($currentdt > $subexpdt)
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
    <link rel="stylesheet" href="CSS/comman.css">
    <link rel="stylesheet" href="CSS/userhome.css">
    <script src="JS/jquery-3.6.0.js"></script>
    <script>
        $(document).ready(function(){
            $(".searchbtn").click(function(){
                var search = $(".searchbox").val();
                $(location).attr('href', "UserSearchResult.php?search="+search)
            });
        })
    </script>
    <title>HOME</title>
</head>
<body>
    <!--Navigation Bar -->
    <nav>
        <div class="navmenucontainer">
            <label class="Logo">MOVIE STREAMER</label>
            <ul class="navmenu">
                <li><a class="navmenuitem menuactive" href="UserHome.php">Home</a></li>
                <li><a class="navmenuitem" href="#">Free</a></li>
                <li><a class="navmenuitem" href="#">Kids</a></li>
            </ul>
        </div>
        <div class="searchbar">
            <input class="searchbox" type="search" name="search" placeholder="Search Movies" list="searchActor">
            <datalist id="searchActor">
                <?php 
                $q2 = "select * from movie_dtl order by name";
                $result2 = mysqli_query($con,$q2);
                if($result2)
                {
                    while($row2 = mysqli_fetch_assoc($result2))
                    {
                        echo "<option value='$row2[Name]'>";
                    }
                }
                ?>
            </datalist>
            <button class="searchbtn"><img src="Assets/Formcontrols/ic_search_black_48dp.png" width="30px"></button>
        </div>
        <ul class="drawer">
            <?php 
            if(in_array("free",$subscription))
            {
                echo "<li><a class='subscribebtn' href='BuySubscription.php?id=$userid'>SUBSCRIBE</a></li>";
            }
            ?>
            <li><a class="adminbtn" href="#"><?php if(isset($_SESSION['username'])){ echo $_SESSION['username'];}?></a></li>
            <li><a class="loginbtn" href="logout.php?id=1">LOG OUT</a></li>
        </ul>
    </nav>
    <div class="mainbody">
        <div class="recentbig">
            <?php 
            $q1 = "select * from movie_dtl order by movie_id desc limit 1";
            $r1 = mysqli_query($con,$q1);
            $bigpost = mysqli_fetch_assoc($r1);
            if($r1)
            {
                echo "<img class='bighomeimg' src='$bigpost[posterpath]' height='100%' width='100%'>";
                echo "<div class='textboxonimg'>
                        <label class='bigmovname'>$bigpost[Name]</label>
                        <a class='playbtn' href='MoviePlayer.php?movid=$bigpost[movie_id]'><img src='Assets/Videobutton/play_arrow_white.png' width='50px'>PLAY</a>
                    </div>";
            }
            ?>
        </div>
        <div class="movGenreSection">
            <label class="genreTitle">Recently Added</label>
            <div class="movielist">
                <?php 
                $recentq = "select * from movie_dtl order by movie_id desc limit 10";
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
                ?>
            </div>
        </div>
        <div class="movGenreSection">
            <label class="genreTitle">Recently Released</label>
            <div class="movielist">
                <?php 
                $recentq = "select * from movie_dtl order by releasedt desc limit 10";
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
                ?>
            </div>
        </div>
        <?php
            $catq = "select * from category";
            $catresult = mysqli_query($con,$catq);
            if($catresult)
            {
                while($category = mysqli_fetch_assoc($catresult))
                {
                    echo "<div class='movGenreSection'>
                    <label class='genreTitle'>".$category['cat_name']."</label>
                    <div class='movielist'>";
                    
                    $genmovq = "select a.movie_id, a.posterpath, b.cat_id from movie_dtl a, genre_dtl b where a.movie_id = b.movie_id and b.cat_id = '$category[cat_id]'";
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
                            
                    echo "</div></div>";
                }
            }
        ?>
    </div>
</body>
</html>