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
if(isset($_GET['updt']))
{
    $upq1 = "select * from movie_dtl where movie_id ='$_GET[updt]'";
    $upq2 = "select * from cast_dtl where movie_id = $_GET[updt]";
    $upq3 = "select * from genre_dtl where movie_id ='$_GET[updt]'";
    $r1 = mysqli_query($con,$upq1);
    $r2 = mysqli_query($con,$upq2);
    $r3 = mysqli_query($con,$upq3);
    if($r1)
    {
        $movdtl = mysqli_fetch_assoc($r1);
    }
    if($r2)
    {
        $i = 0;
        while($castdtl = mysqli_fetch_assoc($r2))
        {
            $castinmov[$i] = $castdtl['actor_id'];
            $i++;
        }
    }
    if($r3)
    {
        $i = 0;
        while($genredtl = mysqli_fetch_assoc($r3))
        {
            $genreinmov[$i] = $genredtl['cat_id'];
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
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/adminhome.css">
    <link rel="stylesheet" href="../CSS/select2-4.0.13/dist/css/select2.min.css">
    <script src="../JS/jquery-3.6.0.js"></script>
    <script src="../CSS/select2-4.0.13/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $(".js-example-basic-multiple").select2();
        })
    </script>
    <title>Update Movies</title>
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
            <a class="sideitem" href="AdminHome.php">Dashboard</a>
            <a class="sideitem" href="Users.php">Users</a>
            <a class="sideitem active" href="Movies.php">Movies</a>
            <a class="sideitem" href="Actors.php">Actors</a>
            <a class="sideitem" href="Subscribeplan.php">Subscription plan</a>
            <a class="sideitem" href="Paymentdtl.php">Payment Details</a>
            </ul>
        </div>
        <div class="mainview">
            <div class="header">
                <h1>Update Movies</h1>
                <a class="addbtn" href="Movies.php">Go Back</a>
            </div>
            <div class="mainform">
                <div class="litopbar">
                    <label>Movie details</label>
                </div>
                <form class="actordtl" action="updateMovie.php?updt=<?php if(isset($_GET['updt'])){ echo $_GET['updt'];}?>" method="POST" enctype="multipart/form-data">
                    <label class="lblfrm">Movie Name</label>
                    <input class="txtboxfrm" type="text" name="Mname" value="<?php if(isset($movdtl['Name'])){echo $movdtl['Name'];}?>" required autofocus>

                    <label class="lblfrm">Select Poster</label>
                    <input type="file" name="Mpostname">

                    <label class="lblfrm">Select Movie</label>
                    <input type="file" name="Mmovname">

                    <label class="lblfrm">Provider</label>
                    <input class="txtboxfrm" type="text" name="Mproname" value="<?php if(isset($movdtl['Provider'])){echo $movdtl['Provider'];}?>" required>
                    
                    <label class="lblfrm">Language</label>
                    <input class="txtboxfrm" type="text" name="Mlang" value="<?php if(isset($movdtl['language'])){echo $movdtl['language'];}?>" required>
                    
                    <label class="lblfrm">Release Date</label>
                    <input class="txtboxfrm" type="date" name="Mreldt" value="<?php if(isset($movdtl['releasedt'])){echo $movdtl['releasedt'];}?>" required>
                    
                    <label class="lblfrm">Description</label>
                    <textarea class="descbox" name="Mdesc" rows="5" cols="40"><?php if(isset($movdtl)){echo $movdtl['description'];}?></textarea>

                    <label class="lblfrm">Category</label>
                    <select class="js-example-basic-multiple" style="width: 100%;" name="Mcategory[]" multiple="multiple">
                    <?php 
                    $q = "select * from category order by cat_name";
                    $result = mysqli_query($con,$q);
                    if($result)
                    {
                        while($row1 = mysqli_fetch_assoc($result))
                        {
                            if(in_array($row1['cat_id'],$genreinmov))
                            {
                                echo "<option value='$row1[cat_id]' selected>".$row1['cat_name']."</option>";
                            }
                            else
                            {
                                echo "<option value='$row1[cat_id]'>".$row1['cat_name']."</option>";
                            }
                        }
                    }
                    ?>
                    </select>
                    <label class="lblfrm">Cast</label>
                    <select class="js-example-basic-multiple" style="width: 100%;" name="Mcast[]" multiple="multiple">
                        <?php 
                            echo $castinmov;
                            $q2 = "select * from actor_dtl";
                            $result2 = mysqli_query($con,$q2);
                            if($result2)
                            {
                                while($row2 = mysqli_fetch_assoc($result2))
                                {
                                    if(in_array($row2['actor_id'],$castinmov))
                                    {
                                        echo "<option value='$row2[actor_id]' selected>".$row2['name']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='$row2[actor_id]'>".$row2['name']."</option>";
                                    }
                                    
                                }
                            } 
                        ?>
                    </select>

                    <label class="lblfrm">Age Limit</label>
                    <input class="txtboxfrm" type="text" name="Magelimit" value="<?php if(isset($movdtl)){echo $movdtl['agelimit'];}?>" required>
                    
                    <label class="lblfrm">Subscription Type</label>
                    <select class="txtboxfrm" name="MsubType">
                        <option value="free" <?php if(isset($movdtl) && $movdtl['subType'] == "free"){echo "selected";}?>>Free</option>
                        <option value="paid" <?php if(isset($movdtl) && $movdtl['subType'] == "paid"){echo "selected";}?>>paid</option>
                    </select>
                    
                    <label class="lblfrm">IMDB Rating</label>
                    <input class="txtboxfrm" type="text" name="Mrating" value="<?php if(isset($movdtl)){echo $movdtl['rating'];}?>">
                    
                    <input hidden type="text" name="movieid" value="<?php if(isset($_GET['updt'])){echo $_GET['updt'];}?>">
                    <input class="addactbtn" type="submit" name="addmovie" value="UPDATE MOVIE">

                    <?php
                    $workd = 0;
                    if(isset($_POST['addmovie'])){
                        $Mmovie = $_FILES['Mmovname']['name'];
                        $Mtmpmovie = $_FILES['Mmovname']['tmp_name'];
                        $Postename = $_FILES['Mpostname']['name'];
                        $Posttmpname = $_FILES['Mpostname']['tmp_name'];
                        if (isset($Mmovie)) {
                            if (!empty($Mmovie)) {
                                $loc1 = "../Content/Movie/";
                                if (move_uploaded_file($Mtmpmovie, $loc1 . $Mmovie)) {
                                    $workd = 1;
                                } else {
                                    echo "movie not uploaded";
                                }
                            }
                        }
                        if (isset($Postename)) {
                            if (!empty($Postename)) {
                                $loc2 = "../Content/Poster/";
                                if (move_uploaded_file($Posttmpname, $loc2 . $Postename)) {
                                    $workd = 2;
                                } else {
                                    echo "thumb not uploaded";
                                }
                            }
                        }
                        $Mname = mysqli_real_escape_string($con,$_POST['Mname']);
                        $Proname = mysqli_real_escape_string($con,$_POST['Mproname']);
                        $Mdesc = mysqli_real_escape_string($con,$_POST['Mdesc']);
                        $Mreldate= mysqli_real_escape_string($con,$_POST['Mreldt']);
                        $Mpost = $loc2 . $Postename;
                        $Mmov = $loc1 . $Mmovie;
                        $subtype = mysqli_real_escape_string($con,$_POST['MsubType']);
                        $Mlang = mysqli_real_escape_string($con,$_POST['Mlang']);
                        $Magelmt = mysqli_real_escape_string($con,$_POST['Magelimit']);
                        $Mrate = mysqli_real_escape_string($con,$_POST['Mrating']);
                        
                        $upid = mysqli_real_escape_string($con,$_POST['movieid']);

                        if(empty($_FILES['Mmovname']['name']) and empty($_FILES['Mpostname']['name']))
                        {
                            $sql = "UPDATE `movie_dtl` SET `name` = '".$Mname."', `releasedt` = '".$Mreldate."', `provider` = '".$Proname."', `language` = '".$Mlang."', `agelimit`= ".$Magelmt.", `subtype` = '".$subtype."', `rating` = ".$Mrate.", `description` = '".$Mdesc."' WHERE movie_id = $upid";
                        }
                        elseif(empty($_FILES['Mmovname']['name']))
                        {
                            $sql = "UPDATE `movie_dtl` SET `name` = '".$Mname."', `releasedt` = '".$Mreldate."', `provider` = '".$Proname."', `language` = '".$Mlang."', `agelimit`= ".$Magelmt.", `subtype` = '".$subtype."', `rating` = ".$Mrate.", `description` = '".$Mdesc."', `posterpath` = '".$Mpost."' WHERE movie_id = $upid";
                        }
                        elseif(empty($_FILES['Mpostname']['name']))
                        {
                            $sql = "UPDATE `movie_dtl` SET `name` = '".$Mname."', `releasedt` = '".$Mreldate."', `provider` = '".$Proname."', `language` = '".$Mlang."', `agelimit`= ".$Magelmt.", `subtype` = '".$subtype."', `rating` = ".$Mrate.", `description` = '".$Mdesc."', `moviepath` = '".$Mmov."' WHERE movie_id = $upid";
                        }
                        else
                        {
                            $sql = "UPDATE `movie_dtl` SET `name` = '".$Mname."', `releasedt` = '".$Mreldate."', `provider` = '".$Proname."', `language` = '".$Mlang."', `agelimit`= ".$Magelmt.", `subtype` = '".$subtype."', `rating` = ".$Mrate.", `description` = '".$Mdesc."', `moviepath` = '".$Mmov."', `posterpath` = '".$Mpost."' WHERE movie_id = $upid";
                        }

                        $res = mysqli_query($con,$sql);
                        if($res)
                        {
                            $mov_id = $upid;
                            if(isset($_POST['Mcast'])){
                                $delcastsql = "delete from cast_dtl where movie_id = $mov_id";
                                $delres = mysqli_query($con,$delcastsql);
                                foreach($_POST['Mcast'] as $mcast){
                                    $sql1 = "insert into cast_dtl(movie_id,actor_id) values($mov_id,$mcast)";
                                    $res1 = mysqli_query($con,$sql1);
                                    if($res1)
                                    {
                                        $workd = 3;
                                    }
                                }
                            }
                            if(isset($_POST['Mcategory'])){
                                $delcatsql = "delete from genre_dtl where movie_id = $mov_id";
                                $delres2 = mysqli_query($con,$delcatsql);
                                foreach($_POST['Mcategory'] as $mcat){
                                    $sql2 = "insert into genre_dtl(movie_id,cat_id) values($mov_id,$mcat)";
                                    $res2 = mysqli_query($con,$sql2);
                                    if($res2)
                                    {
                                        $workd = 4;
                                    }
                                }
                            }
                            if($workd == 4)
                            {
                                echo("<script>location.href = 'movies.php'</script>");
                            }
                        }
                        else
                        {
                            echo "Error :- ".mysqli_error($con);
                        }
                        unset($_POST['addmovie']);
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>