<?php
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
    <link rel="stylesheet" href="CSS/comman.css">
    <link rel="stylesheet" href="CSS/adminhome.css">
    <title>Add Actors</title>
</head>
<body>
    <!--Navigation Bar -->
    <nav>
        <label class="Logo">MOVIE STREAMER</label>
        <ul class="drawer">
            <li><a class="adminbtn" href="#"><?php if(isset($_SESSION['username'])){ echo implode($_SESSION['username']);}?></a></li>
            <li><a class="loginbtn" href="logout.php?id=2">LOG OUT</a></li>
        </ul>
    </nav>
    <div class="mainbody">
        <div class="sidebar">
            <a class="sideitem" href="AdminHome.php">Dashboard</a>
            <a class="sideitem" href="Movies.php">Movies</a>
            <a class="sideitem active" href="Actors.php">Actors</a>
            <a class="sideitem" href="Subscribeplan.php">Subscription plan</a>
            </ul>
        </div>
        <div class="mainview">
            <div class="header">
                <h1>Add Actor</h1>
                <a class="addbtn" href="Actors.php">Go Back</a>
            </div>
            <div class="mainform">
                <div class="litopbar">
                    <label>Actors details</label>
                </div>
                <form class="actordtl" action="addActor.php" method="POST" enctype="multipart/form-data">
                    <label class="lblfrm">Actor Name</label>
                    <input class="txtboxfrm" type="text" name="Aname" placeholder="Enter the name of Actor" required autofocus>
                    <label class="lblfrm">Select Image</label>
                    <input type="file" name="imgname" required>
                    <input class="addactbtn" type="submit" name="addactor" value="ADD ACTOR">
                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST")
                    {
                        if(isset($_POST['addactor'])){
                            $filename = $_FILES['imgname']['name'];
                            $tempname = $_FILES['imgname']['tmp_name'];

                            if (isset($filename)) {
                                if (!empty($filename)) {
                                    $loc1 = "Content/Actors/";
                                    if (move_uploaded_file($tempname, $loc1 . $filename)) {
                                        "Actor Image uploaded";
                                        $Aname= mysqli_real_escape_string($con,$_POST['Aname']);
                                        $Aimgpath = $loc1 . $filename;

                                        $sql = "insert into actor_dtl(Name,ImagePath) values('".$Aname."','".$Aimgpath."')";

                                        $res = mysqli_query($con,$sql);
                                        if($res)
                                        {
                                            echo "Actor Added Successfully";
                                            header("location: actors.php");
                                        }
                                        else
                                        {
                                            echo "Error :- ".mysqli_error($con);
                                        }
                                    } 
                                    else {
                                        die("Actor Image not uploaded");
                                    }
                                }
                            }
                            unset($_POST['addactor']);
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>