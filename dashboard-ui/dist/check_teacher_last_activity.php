<?php
			echo "<script>alert('there is cookie but no session.... removing cookie');</script>";

    session_start();
    include("../../includes/connection.php");
	
?>