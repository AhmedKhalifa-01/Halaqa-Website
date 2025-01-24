<?php
    session_start();
    include('../../includes/connection.php');

    $sessionId = session_id();
    date_default_timezone_set('Asia/Riyadh');
    date_default_timezone_set('Asia/Riyadh');
    	$currentTime = date('Y-m-d H:i:s');

    $oldActivity = mysqli_fetch_assoc(mysqli_query($conn,"SELECT last_activity_time FROM teacher_session WHERE session_id = '$sessionId'"))['last_activity_time'];

    $current_time = date('Y-m-d H:i:s'); // Get the current time

    $old_activity_timestamp = strtotime($old_activity);
    $current_time_timestamp = strtotime($current_time);

    $time_difference = $current_time_timestamp - $old_activity_timestamp;
    echo "<script>alert('" .$time_difference. "');</script>";
    if ($time_difference > 20) {
        // Perform your action here
        echo "Time difference is more than 20 seconds. Do something.";
    }

    $sql = "UPDATE teacher_session SET last_activity_time = '$currentTime' WHERE session_id = '$sessionId'";
    mysqli_query($conn, $sql);
?>