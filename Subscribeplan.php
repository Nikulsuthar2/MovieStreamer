<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username']))
{
    header('location: AdminLogin.php');
}
if(isset($_GET['del']))
{
    $q1 = "DELETE FROM `subscription_dtl` WHERE id = $_GET[del]";
    $r1 = mysqli_query($con,$q1);
    if($r1)
    {
        header("location: Subscribeplan.php");
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
    <title>Subscription Plan</title>
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
            <a class="sideitem" href="Actors.php">Actors</a>
            <a class="sideitem active" href="Subscribeplan.php">Subscription plan</a>
            </ul>
        </div>
        <div class="mainview">
            <div class="header">
                <h1>Subscription Plans</h1>
                <a class="addbtn" href="addSubplan.php">+ Add Plan</a>
            </div>
            <div class="mainlist">
                <div class="litopbar">
                    <label>Subscription plan details</label>
                </div>
                <div class="litable">
                    <table>
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th width="30%">Operations</th>
                        </tr>
                        <?php
                            $sql = "select * from subscription_dtl order by id";
                            $res = mysqli_query($con,$sql);
                            if($res){
                                while($row = mysqli_fetch_assoc($res)){
                                    echo "<tr>
                                    <td>".$row['id']."</td>
                                    <td>".$row['Name']."</td>
                                    <td>".$row['price']."</td>
                                    <td>".$row['Duration']."</td>
                                    <td>
                                    <a type='submit' name='update' class='editbtn' href='updateSubplan.php?updt=".$row['id']."'>UPDATE</a>
                                    <a class='deletebtn' href='Subscribeplan.php?del=".$row['id']."'>DELETE</a></td></tr>";
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