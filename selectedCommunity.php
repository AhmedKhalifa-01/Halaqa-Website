<?php
    include('includes/connection.php');
    session_start(); // Start the session

    if(isset($_GET['c_id'])){
        $_SESSION['community'] =  $_GET['c_id'];
        echo "<script>window.location.href='main.php';</script>";
    }
?>