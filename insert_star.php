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
    $date = $_POST['date'];
    $prize_id = $_POST['prize_id'];
    // insert the star into the database
    $stmt = $db->prepare("INSERT INTO prize_details (std_id, date, star, prize_id) VALUES (:std_id, :date, :star, :prize_id)");
    $stmt->bindParam(':std_id', $student_id);
    $stmt->bindParam(':star', $star_type);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':prize_id', $prize_id);
    if($stmt->execute()) {
        // success response
        echo "Star added successfully.";
    } else {
        // error response
        echo "Error adding star.";
    }

?>