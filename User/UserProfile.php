<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userhome.css">
    <link rel="stylesheet" href="../CSS/userprofile.css">
    <script src="../JS/jquery-3.6.0.js"></script>
    <title>User Profile</title>
</head>
<body>
    <!--Navigation Bar -->
    <?php include('UserNavbar.php'); ?>
    <?php
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
                $userdtl = mysqli_fetch_assoc($res);
                $subexpdt = $userdtl['sub_exp_date'];
                $currentdt = date("Y-m-d");
                if($currentdt > $subexpdt && $subexpdt != null)
                {
                    $resetsubq = "UPDATE `user_dtl` SET `subscription`='free',`sub_date`=null,`sub_exp_date`=null WHERE user_id = $userid";
                    $resetresult = mysqli_query($con,$resetsubq);
                    if($resetresult)
                    {
                        header('location: UserProfile.php');
                    }
                }
            }
        }
    ?>
    <div class="mainbody">
        <div class="userdetail">
            <table class="dtlsection">
                <tr class="detail">
                    <td class="dtlname">Name</td>
                    <td class="dtlvalue">: <?php echo $userdtl["name"];?></td>
                </tr>
                <tr class="detail">
                    <td class="dtlname">Email</td>
                    <td class="dtlvalue">: <?php echo $userdtl["email"];?></td>
                </tr>
                <tr class="detail">
                    <td class="dtlname">Subscription</td>
                    <td class="dtlvalue">
                        <?php 
                            if($userdtl['subscription'] == "paid")
                                echo "<font style='color:green'>: Active</font>";
                            else
                                echo "<font style='color:red'>: Inactive</font>";
                        ?>
                    </td>
                </tr>
                <tr class="detail">
                    <td class="dtlname">Subscription Type</td>
                    <td class="dtlvalue">
                        <?php 
                            if($userdtl['sub_type'] == NULL)
                                echo ": --/--";
                            else
                            {
                                $q = "select Name from subscription_dtl where id = $userdtl[sub_type]";
                                $r = mysqli_query($con, $q);
                                if($r)
                                {
                                    $ro = mysqli_fetch_assoc($r);
                                    echo ": ".$ro['Name'];
                                }
                                else
                                {
                                    echo ": --/--";
                                }
                            }
                        ?>
                    </td>
                </tr>
                <tr class="detail">
                    <td class="dtlname">Subscription Date  </td>
                    <td class="dtlvalue">: <?php echo date('d-M-Y',strtotime($userdtl["sub_date"]));?></td>
                </tr>
                <tr class="detail">
                    <td class="dtlname">Subscription Expire Date  </td>
                    <td class="dtlvalue">: <?php echo date('d-M-Y',strtotime($userdtl["sub_exp_date"]));?></td>
                </tr>
            </table>
            <a class="purchasebtn" href="BuySubscription.php?id=<?php echo $userid?>">Purchase</a>
        </div>
        <div class="userwishlist">
            <div class='heading'>
                <label>Wishlist</label>
            </div>
            <div class="wishlistmovie">
            <?php
                $wishmov = "select a.user_id, a.movie_id, b.movie_id, b.posterpath from wishlist a, movie_dtl b where a.movie_id = b.movie_id and a.user_id = $_COOKIE[userid]";
                $wishmovres = mysqli_query($con,$wishmov);
                if($wishmovres && mysqli_num_rows($wishmovres) > 0)
                {
                    while($wishitem = mysqli_fetch_array($wishmovres))
                    {
                        echo "<a href='MoviePlayer.php?movid=$wishitem[movie_id]'>
                        <img class='movSmallPoster' src='$wishitem[posterpath]' height='300px'>
                        </a>";
                    }
                } else {
                    echo "<div>Wishlist is Empty</div>";
                }
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
            ?>
            </div>
        </div>
    </div>
</body>
</html>
<!-- GithubRepo - https://github.com/Nikulsuthar2/MovieStreamer -->
<!-- Github - https://github.com/Nikulsuthar2 -->
