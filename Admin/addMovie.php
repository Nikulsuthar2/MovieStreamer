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
    <link rel="stylesheet" href="../CSS/select2-4.0.13/dist/css/select2.min.css">
    <script src="../JS/jquery-3.6.0.js"></script>
    <script src="../CSS/select2-4.0.13/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $(".js-example-basic-multiple").select2();
        })
    </script>
    <title>Add Movies</title>
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
                <h1>Add Movies</h1>
                <a class="addbtn" href="Movies.php">Go Back</a>
            </div>
            <div class="mainform">
                <div class="litopbar">
                    <label>Movie details</label>
                </div>
                <form class="actordtl" action="addMovie.php" method="POST" enctype="multipart/form-data">
                    <label class="lblfrm">Movie Name</label>
                    <input class="txtboxfrm" type="text" name="Mname" placeholder="Enter the name of Movie" required autofocus>
                    <label class="lblfrm">Select Poster</label>
                    <input type="file" name="Mpostname" required>
                    <label class="lblfrm">Select Movie</label>
                    <input type="file" name="Mmovname" required>
                    <label class="lblfrm">Provider</label>
                    <input class="txtboxfrm" type="text" name="Mproname" placeholder="Enter the name of Provider" required>
                    <label class="lblfrm">Language</label>
                    <input class="txtboxfrm" type="text" name="Mlang" placeholder="Enter the Language of Movie" required>
                    <label class="lblfrm">Release Date</label>
                    <input class="txtboxfrm" type="date" name="Mreldt" required>
                    <label class="lblfrm">Description</label>
                    <textarea class="descbox" name="Mdesc" rows="5" cols="40"></textarea>

                    <label class="lblfrm">Category</label>
                    <select class="js-example-basic-multiple" style="width: 100%;" name="Mcategory[]" multiple="multiple">
                        <?php 
                            $q = "select * from category order by cat_name";
                            $result = mysqli_query($con,$q);
                            if($result)
                            {
                                while($row1 = mysqli_fetch_assoc($result))
                                {
                                    echo "<option value='$row1[cat_id]'>".$row1['cat_name']."</option>";
                                }

                            } 
                        ?>
                    </select>
                    <label class="lblfrm">Cast</label>
                    <select class="js-example-basic-multiple" style="width: 100%;" name="Mcast[]" multiple="multiple">
                        <?php 
                            $q2 = "select name,actor_id from actor_dtl order by name";
                            $result2 = mysqli_query($con,$q2);
                            if($result2)
                            {
                                while($row2 = mysqli_fetch_assoc($result2))
                                {
                                    echo "<option value='$row2[actor_id]'>".$row2['name']."</option>";
                                }

                            } 
                        ?>
                    </select>

                    <label class="lblfrm">Age Limit</label>
                    <input class="txtboxfrm" type="text" name="Magelimit" placeholder="Enter the Age Limit" required>
                    <label class="lblfrm">Subscription Type</label>
                    <select class="txtboxfrm" name="MsubType">
                        <option value="free">Free</option>
                        <option value="paid">paid</option>
                    </select>
                    <label class="lblfrm">IMDB Rating</label>
                    <input class="txtboxfrm" type="text" name="Mrating" placeholder="Enter the IMDB Rating">
                    
                    <input class="addactbtn" type="submit" name="addmovie" value="ADD MOVIE">

                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST")
                    {
                        if(isset($_POST['addmovie'])){
                            $Mmovie = $_FILES['Mmovname']['name'];
                            $Mtmpmovie = $_FILES['Mmovname']['tmp_name'];
                            $Postename = $_FILES['Mpostname']['name'];
                            $Posttmpname = $_FILES['Mpostname']['tmp_name'];
                            if (isset($Mmovie)) {
                                if (!empty($Mmovie)) {
                                    $loc1 = "../Content/Movie/";
                                    if (move_uploaded_file($Mtmpmovie, $loc1 . $Mmovie)) {
                                        echo "Movie uploaded";
                                    } else {
                                        echo "movie not uploaded";
                                    }
                                }
                            }
                            if (isset($Postename)) {
                                if (!empty($Postename)) {
                                    $loc2 = "../Content/Poster/";
                                    if (move_uploaded_file($Posttmpname, $loc2 . $Postename)) {
                                        echo "thumb uploaded";
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

                            $sql = "insert into movie_dtl(Name,releasedt,Provider,language,agelimit,subType,rating,description,moviepath,posterpath) 
                            values('".$Mname."','".$Mreldate."','".$Proname."','".$Mlang."','".$Magelmt."','".$subtype."','".$Mrate."','".$Mdesc."','".$Mmov."','".$Mpost."')";
                            $res = mysqli_query($con,$sql);
                            if($res)
                            {
                                echo "Movie uploaded to db Succesfully";
                                $mov_id = mysqli_insert_id($con);
                                if(isset($_POST['Mcast'])){
                                    foreach($_POST['Mcast'] as $mcast){
                                        $sql1 = "insert into cast_dtl(movie_id,actor_id) values($mov_id,$mcast)";
                                        $res1 = mysqli_query($con,$sql1);
                                        if($res1)
                                        {
                                            echo "cast added sucessfully";
                                        }
                                    }
                                }
                                if(isset($_POST['Mcategory'])){
                                    foreach($_POST['Mcategory'] as $mcat){
                                        $sql2 = "insert into genre_dtl(movie_id,cat_id) values($mov_id,$mcat)";
                                        $res2 = mysqli_query($con,$sql2);
                                        if($res2)
                                        {
                                            echo("<script>location.href = 'Movies.php'</script>");
                                        }
                                    }
                                }
                            }
                            else
                            {
                                echo "Error :- ".mysqli_error($con);
                            }
                            unset($_POST['addmovie']);
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>