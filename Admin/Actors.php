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
if(isset($_GET['del']))
{
    $q = "delete from actor_dtl where actor_id = $_GET[del]";
    $r = mysqli_query($con, $q);
    if($r)
    {
        header("location: actors.php");
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
    <title>Actors</title>
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
    <!--Main Body -->
    <div class="mainbody">
        <!--Side Menu Bar -->
        <div class="sidebar">
            <a class="sideitem" href="AdminHome.php">Dashboard</a>
            <a class="sideitem" href="Users.php">Users</a>
            <a class="sideitem" href="Movies.php">Movies</a>
            <a class="sideitem active" href="Actors.php">Actors</a>
            <a class="sideitem" href="Subscribeplan.php">Subscription plan</a>
            <a class="sideitem" href="Paymentdtl.php">Payment Details</a>
            </ul>
        </div>
        <!--Main View -->
        <div class="mainview">
            <div class="header">
                <h1>Manage Actors</h1>
                <a class="addbtn" href="addActor.php">+ Add Actor</a>
            </div>
            <div class="mainlist">
                <div class="litopbar">
                    <label>Actors List</label>
                    <form action="Actors.php" method="POST">
                        <div class="searchbar">
                        <input class="searchbox" type="search" name="search" placeholder="Search Actors" list="searchActor">
                        <datalist id="searchActor">
                            <!--Get Actors name for search result-->
                        <?php 
                        $q2 = "select name,actor_id from actor_dtl order by name";
                        $result2 = mysqli_query($con,$q2);
                        if($result2)
                        {
                            while($row2 = mysqli_fetch_assoc($result2))
                            {
                                echo "<option value='$row2[name]'>";
                            }
                        }
                        ?>
                        </datalist>
                        <button class="searchbtn" type="submit"><img src="../Assets/Formcontrols/ic_search_black_48dp.png" width="30px"></button>
                        </div>
                    </form>
                </div>
                <div class="litable">
                    <table>
                        <tr>
                            <th width="5%">Sno</th>
                            <th width="6%">Actor ID</th>
                            <th width="5%">Image</th>
                            <th width="30%">Actor Name</th>
                            <th width="30%">Operations</th>
                        </tr>
                        <?php
                        if(isset($_POST['search']))
                        {
                            // get serched actor list
                            $search = $_POST['search'];
                            $sql = "select * from actor_dtl where name like '%".$search."%'";
                            unset($_POST['search']);
                        }
                        else
                        {
                            // get all actor list
                            $sql = "select * from actor_dtl order by name";
                        }
                        $res = mysqli_query($con,$sql);
                        if($res){
                            $count = 1;
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>
                                <td>".$count."</td>
                                <td>".$row['actor_id']."</td>
                                <td><a href='$row[imagepath]'>
                                    <img src='".$row['imagepath']."' width='50px' height='50px' style='object-fit:cover;border-radius: 20%'>
                                </a></td>
                                <td>".$row['name']."</td>
                                <td>
                                <a class='editbtn' href='updateActor.php?updt=".$row['actor_id']."'>EDIT</a>
                                <a class='deletebtn' href='actors.php?del=".$row['actor_id']."'>DELETE</a></td></tr>";
                                $count += 1;
                            }
                        }                      
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
