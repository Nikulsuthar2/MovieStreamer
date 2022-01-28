<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username']))
{
    header('location: AdminLogin.php');
}
if(isset($_GET['del']))
{
    $q1 = "delete from movie_dtl where movie_id = $_GET[del]";
    $q2 = "delete from cast_dtl where movie_id = $_GET[del]";
    $q3 = "delete from genre_dtl where movie_id = $_GET[del]";
    $r1 = mysqli_query($con, $q1);
    $r2 = mysqli_query($con, $q2);
    $r3 = mysqli_query($con, $q3);
    if($r1 && $r2 && $r3)
    {
        header("location: Movies.php");
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
    <link rel="stylesheet" href="CSS/adminhome.css">
    <title>Movies</title>
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
            <a class="sideitem active" href="Movies.php">Movies</a>
            <a class="sideitem" href="Actors.php">Actors</a>
            <a class="sideitem" href="Subscribeplan.php">Subscription plan</a>
            </ul>
        </div>
        <div class="mainview">
            <div class="header">
                <h1>Manage Movies</h1>
                <a class="addbtn" href="addMovie.php">+ Add Movie</a>
            </div>
            <div class="mainlist">
                <div class="litopbar">
                    <label>Movies List</label>
                    <form action="movies.php" method="POST">
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
                        <button class="searchbtn" type="submit"><img src="Assets/Formcontrols/ic_search_black_48dp.png" width="30px"></button>
                        </div>
                    </form>
                </div>
                <div class="litable">
                    <table>
                        <tr>
                            <th>Sno</th>
                            <th>Image</th>
                            <th>Movie Name</th>
                            <th>Provider</th>
                            <th>Release Date</th>
                            <th>Operations</th>
                        </tr>
                        <?php
                         if(isset($_POST['search']))
                         {
                             $search = $_POST['search'];
                             $sql = "select * from movie_dtl where name like '%".$search."%' limit 10";
                             unset($_POST['search']);
                         }
                         else
                         {
                             $sql = "select * from movie_dtl order by name limit 10";
                         }
                        $res = mysqli_query($con,$sql);
                        if($res){
                            $count = 1;
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>
                                <td>".$count."</td>
                                <td><a href='$row[moviepath]'><img src='".$row['posterpath']."' width='50px'></a></td>
                                <td>".$row['Name']."</td>
                                <td>".$row['Provider']."</td>
                                <td>".$row['releasedt']."</td>
                                <td>
                                <a class='editbtn' href='updateMovie.php?updt=".$row['movie_id']."'>EDIT</a>
                                <a class='deletebtn' href='movies.php?del=".$row['movie_id']."'>DELETE</a></td></tr>";
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