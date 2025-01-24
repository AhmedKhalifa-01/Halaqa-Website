<?php
    define('DB_SERVER','localhost');
    define('DB_USER','root');
    define('DB_PASS' ,'');
    define('DB_NAME', 'qr5');

    $conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);


    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

?>
<?php
    $sql = "SELECT * FROM main_posts";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            if($row['end_date'] <= date('Y-m-d')){
                mysqli_query($conn,"DELETE FROM main_posts WHERE post_id = '".$row['post_id']."'");
            }
        }
    }
?>

