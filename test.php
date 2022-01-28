<?php 
session_start();
include 'db.php';

if(isset($_GET['updt']))
{
    $upq1 = "select * from movie_dtl where movie_id ='$_GET[updt]'";
    $upq2 = "select * from cast_dtl where movie_id = $_GET[updt]";
    $upq3 = "select * from genre_dtl where movie_id ='$_GET[updt]'";
    $r1 = mysqli_query($con,$upq1);
    $r2 = mysqli_query($con,$upq2);
    $r3 = mysqli_query($con,$upq3);
    if($r1)
    {
        $movdtl = mysqli_fetch_assoc($r1);
    }
    if($r2)
    {
        $i = 0;
        while($castdtl = mysqli_fetch_assoc($r2))
        {
            $castinmov[$i] = $castdtl['actor_id'];
            $i++;
        }
        echo implode(" - ",$castinmov)."<br>";
    }
}

$q2 = "select * from actor_dtl";
$result2 = mysqli_query($con,$q2);
if($result2)
{
    while($row2 = mysqli_fetch_assoc($result2))
    {
        if(in_array($row2['actor_id'],$castinmov))
        {
            echo "option value='$row2[actor_id]' selected>".$row2['name']." /option<br>";
        }
        else
        {
            echo "option value='$row2[actor_id]'>".$row2['name']." /option<br>";
        }
        
    }

} 
?>