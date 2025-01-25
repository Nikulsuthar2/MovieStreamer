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
            <a class="sideitem" href="Users.php">Users</a>
            <a class="sideitem" href="Movies.php">Movies</a>
            <a class="sideitem" href="Actors.php">Actors</a>
            <a class="sideitem" href="Subscribeplan.php">Subscription plan</a>
            <a class="sideitem active" href="Paymentdtl.php">Payment Details</a>
            </ul>
        </div>
        <!--Main View -->
        <div class="mainview">
            <div class="header" style="display:flex;flex-direction:column;align-items:start;gap:20px">
                <h1>Payment Details</h1>
            </div>
            <div class="mainlist">
                <div class="litopbar">
                    <label>Payment history</label>
                    <?php 
                    $sql = "select * from payment_dtl order by id desc";
                    $res = mysqli_query($con,$sql);
                    echo "<span class='litopval'>Total :- ".mysqli_num_rows($res)."</span>";
                    ?>
                </div>
                <div class="litable">
                    <table>
                        <tr>
                            <th width="5%">Payement No.</th>
                            <th width="20%">User ID</th>
                            <th width="20%">User Email</th>
                            <th width="20%">Payment Date</th>
                            <th width="20%">Pay Amount</th>
                        </tr>
                        <?php
                        if($res){
                            $count = 1;
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>
                                <td>".$row['id']."</td>
                                <td>".$row['user_id']."</td>
                                <td>".$row['email']."</td>";
                                echo "<td>".$row['pay_date']."</td>";
                                echo "<td style='color:green;font-weight:bold;'>&#8377;".$row['pay_amount']."</td>";
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