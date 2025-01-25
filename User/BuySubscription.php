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

if(!isset($_SESSION['username']) || !isset($_SESSION['userid']))
{
    header('location: UserLogin.php');
}
else
{
    $q = "SELECT * FROM `subscription_dtl` order by id";
    $r  = mysqli_query($con,$q);
    if($r)
    {
        $plandata = array();
        while($row = mysqli_fetch_assoc($r))
        {
            $plandata[] = $row;
        }
    }
}
?>

<!-- GithubRepo - https://github.com/Nikulsuthar2/MovieStreamer -->
<!-- Github - https://github.com/Nikulsuthar2 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userhome.css">
    <script src="../JS/jquery-3.6.0.js"></script>
    <script>
        $(document).ready(function(){
            $(".searchbtn").click(function(){
                var search = $(".searchbox").val();
                $(location).attr('href', "UserSearchResult.php?search="+search)
            });
        })
    </script>
    <title>Buy subscription</title>
</head>
<body>
    <!--Navigation Bar -->
    <nav>
        <div class="navmenucontainer">
            <label class="Logo">MOVIE STREAMER</label>
        </div>
        <ul class="drawer">
        <li>
                <a class="adminbtn" href="UserProfile.php?uid=<?php if(isset($_COOKIE["userid"])){echo $_COOKIE["userid"];}?>">
                <?php 
                if(isset($_COOKIE['username']))
                {
                    if(is_array($_COOKIE['username'])){
                        echo implode($_COOKIE['username']);
                    }
                    else{
                        echo $_COOKIE['username'];
                    }
                }
                ?>
                </a>
            </li>
            <li><a class="loginbtn" href="../logout.php?id=1">LOG OUT</a></li>
        </ul>
    </nav>
    <div class="planbody">
        <div class="heading">
            <label>Subscribe</label>
            <a class="gobackbtn" href="UserHome.php">Go Back</a>
        </div>
        <form action="BuySubscription.php" method="POST" class="planform">
        <input hidden name="userid" value="<?php if(isset($_GET['id'])){echo $_GET['id'];}?>">
            <table class="tbody">
                <tr>
                    <th>Plan</th>
                    <?php
                        foreach($plandata as $value)
                        {
                            echo "<td>".$value['Name']."</td>";
                        }
                    ?>
                </tr>
                <tr>
                    <th>Price</th>
                    <?php
                        foreach($plandata as $value)
                        {
                            echo "<td>".$value['price']."</td>";
                        }
                    ?>
                </tr>
                <tr>
                    <th>Duration</th>
                    <?php
                        foreach($plandata as $value)
                        {
                            echo "<td>".$value['Duration']."</td>";
                        }
                    ?>
                </tr>
                <tr>
                    <th></th>
                    <?php
                        foreach($plandata as $value)
                        {
                            echo "<td><input class='radiobtn' type='radio' name='selectedplan' value='".$value['id']."'checked></td>";
                        }
                    ?>
                </tr>
            </table>
            <input class="paybtn" type="submit" name="pay" value="PAY">
        </form>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(isset($_POST["pay"]))
            {
                if(isset($_POST['selectedplan']))
                {
                    header("location: Pay.php?plan=$_POST[selectedplan]&id=$_POST[userid]");
                }
            }
        }
        ?>
    </div>
</body>
</html>