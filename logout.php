
<?php 
    session_start();
    include('includes/connection.php');

    $teacher_id = mysqli_fetch_assoc(mysqli_query($conn,"SELECT teacher_id FROM teacher_session WHERE session_id = '".session_id()."'"))['teacher_id'];

    $sql = "DELETE FROM teacher_session WHERE teacher_id = '".$teacher_id."'";
    mysqli_query($conn,$sql);
    
    date_default_timezone_set('Asia/Riyadh');
    $currentTime = date('Y-m-d H:i:s');
    $tid = mysqli_num_rows(mysqli_query($conn,"SELECT teacher_id FROM lastlogout WHERE teacher_id = '".$teacher_id."'"));
    if($tid > 0){
        $sql = "UPDATE lastlogout SET last_log_out = '".$currentTime."' WHERE teacher_id = '".$teacher_id."'";
    }else{
        $sql = "INSERT INTO lastlogout (teacher_id, last_log_out)
        VALUES ('".$teacher_id."', '".$currentTime."')";
    }

	mysqli_query($conn,$sql);

    session_destroy();

    // Logout code
    setcookie('email', '', time() - 3600, '/');
    setcookie('job', '', time() - 3600, '/');
    setcookie('sesId', '', time() - 3600, '/');

    header('location:index.php?msg=2');
?>
