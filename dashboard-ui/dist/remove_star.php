<?php

    // connect to the database
    $host = 'localhost';
    $dbname = 'u289455186_qr';
    $username = 'u289455186_zaid';
    $password = 'Zaidalkhatab123@*';

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    } catch(PDOException $e) {
        // handle the exception
        die("Database connection failed: " . $e->getMessage());
    }

    // retrieve star data from the request
    $student_id = $_POST['student_id'];
    $star_type = $_POST['star_type'];
    $lim = $_POST['limit'];
    $prize_id = $_POST['prize_id'];

    // remove the star from the database
    $stmt = $db->prepare("DELETE FROM prize_details WHERE std_id = :std_id AND star = :star AND prize_id = :prize_id LIMIT ".$lim."");
    $stmt->bindParam(':std_id', $student_id);
    $stmt->bindParam(':star', $star_type);
    $stmt->bindParam(':prize_id', $prize_id);


    if($stmt->execute()) {
        // success response
        echo "Star removed successfully.";
    } else {
        // error response
        echo "Error removing star.";
    }

?>