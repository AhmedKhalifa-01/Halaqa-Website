<?php
		include("../../includes/connection.php");

        $sql = "SELECT * FROM tasheeh_att
        WHERE tasmee_id = 39
        ";
        
        $result = mysqli_query($conn,$sql);
        if($result){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo $row['state']."</br>";
                }
            }
        }
	?>