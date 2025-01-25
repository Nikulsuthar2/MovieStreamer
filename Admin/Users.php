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

if(!isset($_SESSION['username']))
{
    header('location: AdminLogin.php');
}
else {
    $sql1 = "select * from subscription_dtl";
    $res1 = mysqli_query($con,$sql1);
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
    <style>
        td{
            height:fit-content;
        }
        th{
            height:50px;
        }
    </style>
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
            <a class="sideitem active" href="Users.php">Users</a>
            <a class="sideitem" href="Movies.php">Movies</a>
            <a class="sideitem" href="Actors.php">Actors</a>
            <a class="sideitem" href="Subscribeplan.php">Subscription plan</a>
            <a class="sideitem" href="Paymentdtl.php">Payment Details</a>
            </ul>
        </div>
        <!--Main View -->
        <div class="mainview">
            <div class="header" style="display:flex;flex-direction:column;align-items:start;gap:20px">
                <h1>Users</h1>
                <form>
                    <label>Subscription type<label>
                    <select onChange="planSelect(event)">
                        <option value='0'>None</option>
                        <?php
                        if($res1){
                            while($row = mysqli_fetch_assoc($res1)){
                                if(isset($_GET["subtype"]) && $_GET["subtype"] == $row["id"]){
                                    echo "<option value='".$row["id"]."' selected>".$row["Name"]."</option>";
                                } else {
                                    echo "<option value='".$row["id"]."'>".$row["Name"]."</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                    <button>
                </form>
            </div>
            <div class="mainlist">
                <div class="litopbar">
                    <label>User Details</label>
                    <?php 
                    if(isset($_GET["subtype"])){
                        if($_GET["subtype"] > 0)
                            $sql = "select * from user_dtl a, subscription_dtl b where a.sub_type = b.id and a.sub_type =".$_GET["subtype"]." order by a.name";
                        else
                            $sql = "select * from user_dtl a, subscription_dtl b where a.sub_type = b.id order by a.name";

                    } else {
                        $sql = "select * from user_dtl a, subscription_dtl b where a.sub_type = b.id order by a.name";
                    }
                    $res = mysqli_query($con,$sql);
                    echo "<span class='litopval'>Total :- ".mysqli_num_rows($res)."</span>";
                    ?>
                </div>
                <div class="litable">
                    <table>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%">Name</th>
                            <th width="20%">Email</th>
                            <th width="20%">Subscription</th>
                            <th width="20%">Sub_Type</th>
                            <th width="20%">Sub_Date</th>
                            <th width="20%">Sub_Exp_Date</th>
                        </tr>
                        <?php
                        if($res){
                            $count = 1;
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>
                                <td>".$row['user_id']."</td>
                                <td>".$row['name']."</td>
                                <td>".$row['email']."</td>";
                                if($row['subscription'] == 'free'){
                                    echo "<td style='color:red;font-weight:bold;'>InActive</td>";
                                } else {
                                    echo "<td style='color:green;font-weight:bold;'>Active</td>";
                                }
                                echo "<td>".$row['Name']."</td>";
                                echo "<td>".$row['sub_date']."</td>";
                                echo "<td>".$row['sub_exp_date']."</td>";
                                // <td>
                                // <a class='editbtn' href='updateActor.php?updt=".$row['actor_id']."'>EDIT</a>
                                // <a class='deletebtn' href='actors.php?del=".$row['actor_id']."'>DELETE</a></td></tr>";
                                // $count += 1;
                            }
                        }                      
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function planSelect(event){
            location.href = "Users.php?subtype="+event.target.value;
        }
    </script>
</body>
</html>