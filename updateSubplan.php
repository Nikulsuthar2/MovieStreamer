<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username']))
{
    header('location: AdminLogin.php');
}

if(isset($_GET['updt'])){
    $q = "select * from `subscription_dtl` where id = $_GET[updt]";
    $res = mysqli_query($con,$q);
    if($res){
        $subdtl = mysqli_fetch_assoc($res);
    }
}
else{
    header("location: Subscribeplan.php");
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
    <title>Update Subscribeplan Plan</title>
</head>
<body>
    <!--Navigation Bar -->
    <nav>
        <label class="Logo">MOVIE STREAMER</label>
        <ul class="drawer">
            <li><a class="adminbtn" href="#"><?php if(isset($_SESSION['username'])){ echo $_SESSION['username'];}?></a></li>
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
                <h1>Update Subscription Plan</h1>
                <a class="addbtn" href="Subscribeplan.php">Go Back</a>
            </div>
            <div class="mainform">
                <div class="litopbar">
                    <label>Subscription Plan Details</label>
                </div>
                <form class="actordtl" action="updateSubplan.php" method="POST">
                <label class="lblfrm">Plan Name</label>
                    <input class="txtboxfrm" type="text" name="Sname" value="<?php if(isset($_GET['updt'])){ echo $subdtl['Name'];}?>" placeholder="Enter the name of Plan" required autofocus>

                    <label class="lblfrm">Plan Price</label>
                    <input class="txtboxfrm" type="text" name="Sprice" value="<?php if(isset($_GET['updt'])){ echo $subdtl['price'];}?>" placeholder="Enter the Price of Plan" required>

                    <label class="lblfrm">Plan Duration (in months)</label>
                    <input class="txtboxfrm" type="text" name="Sdura" value="<?php if(isset($_GET['updt'])){ echo $subdtl['Duration'];}?>" placeholder="Enter the Duration of Plan" required>
                    
                    <input hidden type="text" name="Sid" value="<?php if(isset($_GET['updt'])){ echo $subdtl['id'];}?>">

                    <input class="addactbtn" type="submit" name="upsubplan" value="UPDATE PLAN">
                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST")
                    {
                        if(isset($_POST['upsubplan']))
                        {
                            $id =  mysqli_real_escape_string($con,$_POST['Sid']);
                            $Sname= mysqli_real_escape_string($con,$_POST['Sname']);
                            $Sprice= mysqli_real_escape_string($con,$_POST['Sprice']);
                            $Sdura= mysqli_real_escape_string($con,$_POST['Sdura']);

                            $sql = "UPDATE `subscription_dtl` SET `Name`='$Sname', `price`='$Sprice', `Duration`='$Sdura' where id = $id";

                            $res = mysqli_query($con,$sql);
                            if($res)
                            {
                                header("location: Subscribeplan.php");
                            }
                            else
                            {
                                echo "Error :- ".mysqli_error($con);
                            }
                            unset($_POST['upsubplan']);
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>