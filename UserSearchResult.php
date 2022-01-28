<?php
include 'db.php';
if(isset($_GET['search']))
{
    $Svalue = $_GET['search'];
    echo "<script>alert('$Svalue')</script>";
}
?>