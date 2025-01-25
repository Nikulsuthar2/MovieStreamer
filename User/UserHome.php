<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userhome.css">
    <script src="../JS/jquery-3.6.0.js"></script>
    
    <title>HOME</title>
</head>
<body>
    <!--Navigation Bar -->
    <?php include('UserNavbar.php'); ?>
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
                        <a class='playbtn' href='MoviePlayer.php?movid=$bigpost[movie_id]'><img src='../Assets/Videobutton/play_arrow_white.png' width='50px'>PLAY</a>
                    </div>";
            }
            ?>
        </div>
        <div class="movGenreSection">
            <div class='genreTitle'>
                <label>Recently Added</label>
                <a class='viewmorebtn' href='CategoryResult.php?recentid=1&name=Recently Added'>View More</a>
            </div>
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
            <div class='genreTitle'>
                <label>Recently Released</label>
                <a class="viewmorebtn" href='CategoryResult.php?recentid=2&name=Recently Released'>View More</a>
            </div>
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
            $catq = "select distinct a.cat_id, b.cat_name from genre_dtl a, category b where a.cat_id = b.cat_id";
            $catresult = mysqli_query($con,$catq);
            if($catresult)
            {
                while($category = mysqli_fetch_assoc($catresult))
                {
                    echo "<div class='movGenreSection'>
                    <div class='genreTitle'>
                        <label>".$category['cat_name']."</label>
                        <a class='viewmorebtn' href='CategoryResult.php?catid=$category[cat_id]&name=$category[cat_name]'>View More</a>
                    </div>
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
            /*
            |-------------------------------------------------------------------------
            | Movie Streaming & Subscription Website
            |-------------------------------------------------------------------------
            | Author: Nikul Suthar
            | Copyright: © 2025 Nikul Suthar or Your Organization
            | Description: This PHP file is part of the movie streaming 
            | and subscription website project.
            | 
            | Feel free to explore, learn, and enhance this project. 
            | Please provide appropriate credit if you use or modify it.
            |-------------------------------------------------------------------------
            */
        ?>
    </div>
</body>
</html>
<!-- GithubRepo - https://github.com/Nikulsuthar2/MovieStreamer -->
<!-- Github - https://github.com/Nikulsuthar2 -->
