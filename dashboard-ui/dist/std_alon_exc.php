<?php
	/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
    $sql = "INSERT INTO `std_exc`(`std_id`, `sender`, `date`,`state`) VALUES ('".$_GET['std_id']."','".$_GET['std_id']."','".date('Y-m-d')."','انتظار')";
    if(mysqli_query($conn,$sql)){
        echo "<script>alert('تم إرسال طلب الاستئذان ')</script>";
        echo "<script>window.close();</script>";
    }
?>