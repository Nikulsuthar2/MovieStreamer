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
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

if(!isset($_SESSION['username']) || !isset($_SESSION['userid']))
{
    header('location: UserLogin.php');
}
else
{
    $userid = $_COOKIE['userid'];
    $q = "select * from user_dtl where user_id = $userid";
    $res = mysqli_query($con, $q);
    if($res)
    {
        $subscription = mysqli_fetch_assoc($res);
        $subexpdt = $subscription['sub_exp_date'];
        $currentdt = date("Y-m-d");
        if($currentdt > $subexpdt && $subexpdt != null)
        {
            $resetsubq = "UPDATE `user_dtl` SET `subscription`='free',`sub_date`=null,`sub_exp_date`=null WHERE user_id = $userid";
            $resetresult = mysqli_query($con,$resetsubq);
            if($resetresult)
            {
                header('location: UserHome.php');
            }
        }
    }
}
?>
<script>
        $(document).ready(function(){
            $(".searchbtn").click(function(){
                var search = $(".searchbox").val();
                $(location).attr('href', "UserSearchResult.php?search="+search)
            });
        })
    </script>
<nav>
    <div class="navmenucontainer">
        <label class="Logo">MOVIE STREAMER</label>
        <ul class="navmenu">
            <li><a class="navmenuitem menuactive" href="UserHome.php">Home</a></li>
            <li><a class="navmenuitem" href="CategoryResult.php?recentid=3&name=Free">Free</a></li>
            <li><a class="navmenuitem" href="CategoryResult.php?recentid=4&name=Kids">Kids</a></li>
        </ul>
    </div>
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
        <button class="searchbtn"><img src="../Assets/Formcontrols/ic_search_black_48dp.png" width="30px"></button>
        </div>
    <ul class="drawer">
        <?php 
        if(in_array("free",$subscription))
        {
            echo "<li><a class='subscribebtn' href='BuySubscription.php?id=$userid'>SUBSCRIBE</a></li>";
        }
        else
        {
            $expdate = strtotime($subexpdt);
            echo "<li>
                <p style='color:yellow;font-weight: bold;padding-right:50px;'>
                    Expire on ".date('d-M-Y',$expdate)."
                </p>
            </li>";
        }
        ?>
        <li>
            <a class="adminbtn" href="UserProfile.php">
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
    <!-- GithubRepo - https://github.com/Nikulsuthar2/MovieStreamer -->
    <!-- Github - https://github.com/Nikulsuthar2 -->
