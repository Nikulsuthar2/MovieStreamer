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
    $q = "select subscription from user_dtl where user_id = $userid";
    $res = mysqli_query($con, $q);
    if($res)
    {
        $subscription = mysqli_fetch_assoc($res);
    }



    $movid = $_GET['movid'];
    $q = "select * from movie_dtl where movie_id = $movid";
    $res = mysqli_query($con, $q);
    if($res)
    {
        $movdtl = mysqli_fetch_assoc($res);
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
    <title><?php if(isset($movdtl)){echo $movdtl['Name'];}?></title>
</head>
<body>
    <!--Navigation Bar -->
    <nav>
        <div class="navmenucontainer">
            <label class="Logo">MOVIE STREAMER</label>
            <ul class="navmenu">
                <li><a class="navmenuitem menuactive" href="#">Home</a></li>
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
        <div class="moviecontainer">
            <video class="videoplayer" src="<?php if(isset($movdtl)){echo $movdtl['moviepath'];}?>" controls autoplay loop></video>
            <img class="movieposter" src="<?php if(isset($movdtl)){echo $movdtl['posterpath'];}?>" >
        </div>
        <div class="movinfobox">
            <h1 class="movtitle"><?php if(isset($movdtl)){echo $movdtl['Name'];}?></h1>
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
            </div>
        </div>
    </div>
</body>
</html>