






<?php
    /* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
			//	if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
		//	}
		}			
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}
	

    if($_GET['type'] == 1){
        $sql = 'DELETE FROM staff WHERE staff_id = '.$_GET['id'].'';
        $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "<script>alert('خطأ في حذف الحساب')</script>";
           // echo "<script>window.location.href='staff_management.php';</script>";
           echo mysqli_error($conn);

        }else{
            echo "<script>window.location.href='staff_management.php';</script>";
        }
    }else{
        $sql = "DELETE FROM students WHERE std_id = '".$_GET['id']."'";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "<script>alert('خطأ في حذف الحساب')</script>";
         //   echo "<script>window.location.href='std_management.php';</script>";
         echo mysqli_error($conn);
        }else{
            if($_GET['fromCom'] == '1'){
                //echo mysqli_error($conn);
	    echo "<script>window.location.href='community_man.php';</script>";
	}else{
	    echo "<script>window.location.href='std_management.php';</script>";
	}
        }
    }
    
    
    

?>