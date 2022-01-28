<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username']) || !isset($_SESSION['userid']))
{
    header('location: UserLogin.php');
}
else
{
    if(isset($_GET["plan"]))
    {
        $q = "SELECT * FROM `subscription_dtl` where id = $_GET[plan]";
        $r  = mysqli_query($con,$q);
        if($r)
        {
            $plandtl = mysqli_fetch_assoc($r);
        }
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
    <link rel="stylesheet" href="CSS/userhome.css">
    <title>PAY</title>
</head>
<body>
    <div class="paymain">
        <div class="heading">
            <label>Make Payment</label>
            <?php
                if(isset($_GET["id"]))
                {
                    echo "<a class='gobackbtn' href='BuySubscription.php?id=$_GET[id]'>Go Back</a>";
                }
                else
                {
                    echo "<a class='gobackbtn' href='UserHome.php'>Go Back</a>";
                }
            ?>
        </div>
        <div class="paymentcontainer">
            <form class="options" action="Pay.php" method="POST">
                <div class="paymentoption">
                    <input hidden type="text" name="planid" value="<?php 
                        if(isset($_GET["plan"]))
                        {
                            echo $_GET["plan"];
                        }
                        else if(isset($_POST["planid"]))
                        {
                            echo $_POST["planid"];
                        }
                    ?>">
                    <input hidden type="text" name="uid" value="<?php 
                        if(isset($_GET["id"]))
                        {
                            echo $_GET["id"];
                        }
                        else if(isset($_POST["uid"]))
                        {
                            echo $_POST["uid"];
                        }
                    ?>">

                    <input class="payopt <?php if(isset($_POST['cards'])){echo "payoptselected";}?>" type="submit" name="cards" value="Debit, Credit Cards">
                    <input class="payopt <?php if(isset($_POST['upi'])){echo "payoptselected";}?>" type="submit" name="upi" value="UPI">
                </div>
                <div class="paymentdtl">
                    <div class='payinfobox'>
                        <h1>Item details</h1>
                        <div class="selectedplan">
                            <label class="boldtitle">Name</label>
                            <label class="boldtitle">Duration</label>
                            <label class="boldtitle">Price</label>
                        </div>
                        <div class="selectedplan">
                            <?php 
                            if(isset($_POST["planid"]))
                            {
                                $q = "SELECT * FROM `subscription_dtl` where id = $_POST[planid]";
                                $r  = mysqli_query($con,$q);
                                if($r)
                                {
                                    $plandtl = mysqli_fetch_assoc($r);
                                }
                            }
                            ?>
                            <label><?php echo $plandtl['Name'];?></label>
                            <label><?php echo $plandtl['Duration'];?> Month</label>
                            <label>&#8377 <?php echo $plandtl['price'];?></label>
                        </div>
                        <div class='selectedpayment'>
                            <?php
                                if(isset($_POST['cards']))
                                {
                                    echo '<div class="cardspay">
                                        <label>Card Holder Name</label>
                                        <input type="text" name="holdername" placeholder="Enter Card Holder Name" required>
                                        <label>Card Number</label>
                                        <input type="text" name="cardnumber" placeholder="Enter Card Number" minlength="16" maxlength="16" required>
                                        <div>
                                            <label>CVV</label>
                                            <input type="text" name="cvv" placeholder="Enter your cvv" maxlength="3" required>
                                        </div>
                                    </div>
                                    <input type="submit" class="paybtn" name="pay" value="PAY">';
                                }
                                if(isset($_POST['upi']))
                                {
                                    echo "payoptselected";
                                }
                                if(isset($_POST["pay"]))
                                {
                                    if(isset($_POST["planid"]))
                                    {
                                        if(isset($_POST["uid"]))
                                        {
                                            echo $_POST["uid"];
                                            $currentdt = date("Y-m-d");
                                            $subexpdt = date('Y-m-d', strtotime('+'.$plandtl["Duration"].' month',strtotime($currentdt)));
                                            $upq = "UPDATE `user_dtl` SET `subscription`='paid',`sub_date`='".$currentdt."',`sub_exp_date`='".$subexpdt."' WHERE `user_id` = '$_POST[uid]'";
                                            $upr  = mysqli_query($con,$upq);
                                            if($upr)
                                            {
                                                header("location: PayRecipt.php?price=$plandtl[price]&month=$plandtl[Duration]");
                                            }
                                            
                                        }
                                    }
                                    
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>