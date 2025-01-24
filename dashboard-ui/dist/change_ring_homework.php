<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
			if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
			}
		}
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}	
	if(isset($_POST['ch'])){

		if($_POST['div'] != "no"){
			mysqli_query($conn,"DELETE FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."'  AND rev_id = '".$_GET['rev_id']."' AND type = 'review'");
			mysqli_query($conn,"DELETE FROM sora_face WHERE std_id = '".$_GET['std_id']."'  AND rev_id = '".$_GET['rev_id']."' AND type = 'review'");
		}
		if($_POST['div'] == "no"){
		}
		else if($_POST['div'] == "ay"){
			if(isset($_POST['courses'])){
				$courses = $_POST["courses"];
				$pages1 = $_POST["pages1"];
				$pages2 = $_POST["pages2"];

				// $numberSelector = $_POST['numberSelector'];
				// $quarterHalfSelector = $_POST['quarterHalfSelector'];

				// Loop through the selected courses and page ranges
				for ($i = 0; $i < count($courses); $i++) {
					$course = $conn->real_escape_string($courses[$i]);
					$page1_range = $conn->real_escape_string($pages1[$i]);
					$page2_range = $conn->real_escape_string($pages2[$i]);

					if($course != "none"){
						$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','review','1','".$_GET['rev_id']."')";
						$result = mysqli_query($conn,$sql);
						if(!$result){
							echo mysqli_error($conn);
						}
					}
				}
			}
				if(isset($_POST['sora'])){

					$courses = $_POST["sora"];

					// Loop through the selected courses and page ranges
					for ($i = 0; $i < count($courses); $i++) {
						
						$course = $conn->real_escape_string($courses[$i]);

						if($course != "none"){

							$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','-','-','".date('Y-m-d')."','review','1','".$_GET['rev_id']."')";
							$result = mysqli_query($conn,$sql);
							if(!$result){
								echo mysqli_error($conn);
							}
						}
					}
				}
				if(isset($_POST['part'])){
					$courses = $_POST["part"];

					for ($i = 0; $i < count($courses); $i++) {
						$course = $conn->real_escape_string($courses[$i]);

						if($course != "none"){

							$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','*','*','".date('Y-m-d')."','review','1','".$_GET['rev_id']."')";
							$result = mysqli_query($conn,$sql);
							if(!$result){
								echo mysqli_error($conn);
							}
						}
					}
				}
				if(isset($_POST['numberSelector'])){
					$numberSelector = $_POST['numberSelector'];
					$quarterHalfSelector = $_POST['quarterHalfSelector'];
					$nu = $conn->real_escape_string($numberSelector);
					$qu = $conn->real_escape_string($quarterHalfSelector);
					if($qu == "نصف"){
						$qu = 0.5;
					}else if($qu == "ربع"){
						$qu = 0.25;
					}else{
						$qu = 0;
					}
					$val = 0;
					try {
						if (isset($nu) && isset($qu)) { // Check if the variables are set
						  if (is_numeric($nu) && is_numeric($qu)) { // Check if the variables are numeric
							$val = $nu + $qu; // Try to add the values
						  } else {
							throw new Exception("One or both variables are not numeric"); // Throw an Exception if one or both variables are not numeric
						  }
						} else {
						  throw new Exception("One or both variables are not set"); // Throw an Exception if one or both variables are not set
						}
					  } catch (Exception $e) {
						//echo "Error: " . $e->getMessage(); // Handle the Exception by printing the error message
					}
					if($qu > 0){
						$val = $val + $qu;
						
					}
					$sql = "INSERT INTO `sora_face`(`std_id`, `face`, `type`, `date`, `rev_id`) VALUES ('".$_GET['std_id']."','".$val."','review','".date('Y-m-d')."','".$_GET['rev_id']."')";
					mysqli_query($conn,$sql);
				}
			
			
		}else if($_POST['div'] == "pa"){
			if(isset($_POST["part"])){
				$courses = $_POST["part"];
				// $numberSelector = $_POST['fnumberSelector'];
				// $quarterHalfSelector = $_POST['fquarterHalfSelector'];

				// Loop through the selected courses and page ranges
				for ($i = 0; $i < count($courses); $i++) {
					$course = $conn->real_escape_string($courses[$i]);
					if($course != "none"){
								
						$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','*','*','".date('Y-m-d')."','review','1','".$_GET['rev_id']."')";
						$result = mysqli_query($conn,$sql);
						if(!$result){
							echo mysqli_error($conn);
						}

					}
				}
			}
			if(isset($_POST['courses'])){
				$courses = $_POST["courses"];
				$pages1 = $_POST["pages1"];
				$pages2 = $_POST["pages2"];

				// // $numberSelector = $_POST['numberSelector'];
				// // $quarterHalfSelector = $_POST['quarterHalfSelector'];

				// Loop through the selected courses and page ranges
				for ($i = 0; $i < count($courses); $i++) {
					$course = $conn->real_escape_string($courses[$i]);
					$page1_range = $conn->real_escape_string($pages1[$i]);
					$page2_range = $conn->real_escape_string($pages2[$i]);

					if($course != "none"){

						$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','review','1','".$_GET['rev_id']."')";
						$result = mysqli_query($conn,$sql);
						if(!$result){
							echo mysqli_error($conn);
						}
					}
				}
				
			}
			if(isset($_POST['sora'])){
				// // $numberSelector = $_POST['snumberSelector'];
				// // $quarterHalfSelector = $_POST['squarterHalfSelector'];

				$courses = $_POST["sora"];

				// Loop through the selected courses and page ranges
				for ($i = 0; $i < count($courses); $i++) {
					
					$course = $conn->real_escape_string($courses[$i]);

					if($course != "none"){
						
						$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','-','-','".date('Y-m-d')."','review','1','".$_GET['rev_id']."')";
						$result = mysqli_query($conn,$sql);
						if(!$result){
							echo mysqli_error($conn);
						}
					}
				}
			}
			if(isset($_POST['numberSelector'])){
				
				$numberSelector = $_POST['numberSelector'];
				$quarterHalfSelector = $_POST['quarterHalfSelector'];
				$nu = $conn->real_escape_string($numberSelector);
				$qu = $conn->real_escape_string($quarterHalfSelector);
				if($qu == "نصف"){
					$qu = 0.5;
				}else if($qu == "ربع"){
					$qu = 0.25;
				}else{
					$qu = 0;
				}
				
				$val = 0;
				try {
					if (isset($nu) && isset($qu)) { // Check if the variables are set
					  if (is_numeric($nu) && is_numeric($qu)) { // Check if the variables are numeric
						$val = $nu + $qu; // Try to add the values
					  } else {
						throw new Exception("One or both variables are not numeric"); // Throw an Exception if one or both variables are not numeric
					  }
					} else {
					  throw new Exception("One or both variables are not set"); // Throw an Exception if one or both variables are not set
					}
				} catch (Exception $e) {
					
					//echo "Error: " . $e->getMessage(); // Handle the Exception by printing the error message
				}
				if($qu > 0){
					$val = $val + $qu;
				}
				$sql = "INSERT INTO `sora_face`(`std_id`, `face`, `type`, `date`,`rev_id`) VALUES ('".$_GET['std_id']."','".$val."','review','".date('Y-m-d')."','".$_GET['rev_id']."')";
				mysqli_query($conn,$sql);
			}
		}else{
			if(isset($_POST["sora"])){
				// // $numberSelector = $_POST['snumberSelector'];
				// // $quarterHalfSelector = $_POST['squarterHalfSelector'];
				$courses = $_POST["sora"];

				// Loop through the selected courses and page ranges
				for ($i = 0; $i < count($courses); $i++) {
					$course = $conn->real_escape_string($courses[$i]);


					if($course != "none"){
								
						
						$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','-','-','".date('Y-m-d')."','review','1','".$_GET['rev_id']."')";
						$result = mysqli_query($conn,$sql);
						if(!$result){
							echo mysqli_error($conn);
						}
					}
				}
			}

				if(isset($_POST['courses'])){
					
					$courses = $_POST["courses"];
					$pages1 = $_POST["pages1"];
					$pages2 = $_POST["pages2"];

					// Loop through the selected courses and page ranges
					for ($i = 0; $i < count($courses); $i++) {
						$course = $conn->real_escape_string($courses[$i]);
						$page1_range = $conn->real_escape_string($pages1[$i]);
						$page2_range = $conn->real_escape_string($pages2[$i]);


						if($course != "none"){
							
							$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','review','1','".$_GET['rev_id']."')";
							$result = mysqli_query($conn,$sql);
						}
					}
				}
				if(isset($_POST['part'])){
					$courses = $_POST["part"];
					for ($i = 0; $i < count($courses); $i++) {
						$course = $conn->real_escape_string($courses[$i]);

						if($course != "none"){
							
							$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','*','*','".date('Y-m-d')."','review','1','".$_GET['rev_id']."')";
							$result = mysqli_query($conn,$sql);
							if(!$result){
								echo mysqli_error($conn);
							}
						}
					}
				}
				if(isset($_POST['numberSelector'])){
					$numberSelector = $_POST['numberSelector'];
					$quarterHalfSelector = $_POST['quarterHalfSelector'];
					$nu = $conn->real_escape_string($numberSelector);
					$qu = $conn->real_escape_string($quarterHalfSelector);
					if($qu == "نصف"){
						$qu = 0.5;
					}else if($qu == "ربع"){
						$qu = 0.25;
					}else{
						$qu = 0;
					}
					$val = 0;
					try {
						if (isset($nu) && isset($qu)) { // Check if the variables are set
						  if (is_numeric($nu) && is_numeric($qu)) { // Check if the variables are numeric
							$val = $nu + $qu; // Try to add the values
						  } else {
							throw new Exception("One or both variables are not numeric"); // Throw an Exception if one or both variables are not numeric
						  }
						} else {
						  throw new Exception("One or both variables are not set"); // Throw an Exception if one or both variables are not set
						}
					  } catch (Exception $e) {
						//echo "Error: " . $e->getMessage(); // Handle the Exception by printing the error message
					}
					if($qu > 0){
						$val = $val + $qu;
					}
					$sql = "INSERT INTO `sora_face`(`std_id`, `face`, `type`, `date`,`rev_id`) VALUES ('".$_GET['std_id']."','".$val."','review','".date('Y-m-d')."','".$_GET['rev_id']."')";
					mysqli_query($conn,$sql);
				}
			
		}
		if($_POST['cdiv'] != "cno"){
			mysqli_query($conn,"DELETE FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."'  AND rev_id = '".$_GET['rev_id']."' AND type = 'recite'");
			mysqli_query($conn,"DELETE FROM sora_face WHERE std_id = '".$_GET['std_id']."'  AND rev_id = '".$_GET['rev_id']."' AND type = 'recite'");
		}
		if($_POST['cdiv'] == "cno"){
			
		}else if($_POST['cdiv'] == "cay"){
			if(isset($_POST['ccourses'])){

				$ccourses = $_POST["ccourses"];
				$cpages1 = $_POST["cpages1"];
				$cpages2 = $_POST["cpages2"];

				// Loop through the selected courses and page ranges
				
				for ($i = 0; $i < count($ccourses); $i++) {
					$course = $conn->real_escape_string($ccourses[$i]);
					$page1_range = $conn->real_escape_string($cpages1[$i]);
					$page2_range = $conn->real_escape_string($cpages2[$i]);

					if($course != "none"){
					   
						$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";

						//$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";
						$result = mysqli_query($conn,$sql);
						if(!$result){
							echo mysqli_error($conn);
						}
					}
				}
			}
				if(isset($_POST['csora'])){									
					$courses = $_POST["csora"];
					
					for ($i = 0; $i < count($courses); $i++) {
					

						if($course != "none"){
							
							$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','-','-','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";

							//$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";
							$result = mysqli_query($conn,$sql);
							if(!$result){
								echo mysqli_error($conn);
							}
						}
					}
				}
				if(isset($_POST['cpart'])){	
					$courses = $_POST["cpart"];
					
					for ($i = 0; $i < count($courses); $i++) {
						$course = $conn->real_escape_string($courses[$i]);

						

						if($course != "none"){
							
							$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','*','*','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";

							$result = mysqli_query($conn,$sql);
							if(!$result){
								echo mysqli_error($conn);
							}
						}
					}
				}
				if(isset($_POST['snumberSelector'])){
					$numberSelector = $_POST['snumberSelector'];
					$quarterHalfSelector = $_POST['squarterHalfSelector'];
					$nu = $conn->real_escape_string($numberSelector);
					$qu = $conn->real_escape_string($quarterHalfSelector);
					if($qu == "نصف"){
						$qu = 0.5;
					}else if($qu == "ربع"){
						$qu = 0.25;
					}else{
						$qu = 0;
					}
					$val = 0;
					try {
						if (isset($nu) && isset($qu)) { // Check if the variables are set
						  if (is_numeric($nu) && is_numeric($qu)) { // Check if the variables are numeric
							$val = $nu + $qu; // Try to add the values
						  } else {
							throw new Exception("One or both variables are not numeric"); // Throw an Exception if one or both variables are not numeric
						  }
						} else {
						  throw new Exception("One or both variables are not set"); // Throw an Exception if one or both variables are not set
						}
					  } catch (Exception $e) {
						//echo "Error: " . $e->getMessage(); // Handle the Exception by printing the error message
					}
					if($qu > 0){
						$val = $val + $qu;
					}
					$sql = "INSERT INTO `sora_face`(`std_id`, `face`, `type`, `date`, `rev_id`) VALUES ('".$_GET['std_id']."','".$val."','recite','".date('Y-m-d')."','".$_GET['rev_id']."')";
					mysqli_query($conn,$sql);
				}
			
			
		}else if($_POST['cdiv'] == "cpa"){
			if(isset($_POST["cpart"])){
				$courses = $_POST["cpart"];
				
				for ($i = 0; $i < count($courses); $i++) {
					$course = $conn->real_escape_string($courses[$i]);

				
					if($course != "none"){
						
						$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','*','*','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";

						$result = mysqli_query($conn,$sql);
						if(!$result){
							echo mysqli_error($conn);
						}
					}
				}
			}
			
			if(isset($_POST['ccourses'])){
				
				$ccourses = $_POST["ccourses"];
				$cpages1 = $_POST["cpages1"];
				$cpages2 = $_POST["cpages2"];
				// Loop through the selected courses and page ranges
				for ($i = 0; $i < count($ccourses); $i++) {
					$course = $conn->real_escape_string($ccourses[$i]);
					$page1_range = $conn->real_escape_string($cpages1[$i]);
					$page2_range = $conn->real_escape_string($cpages2[$i]);

				

					if($course != "none"){
						$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";

						//$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";
						$result = mysqli_query($conn,$sql);
						if(!$result){
							echo mysqli_error($conn);
						}
					}
				}
			}
			if(isset($_POST['csora'])){									
				
				for ($i = 0; $i < count($courses); $i++) {
					$course = $conn->real_escape_string($courses[$i]);
					
					if($course != "none"){
						
						$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','-','-','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";

						$result = mysqli_query($conn,$sql);
						if(!$result){
							echo mysqli_error($conn);
						}
					}
				}
				
			}
			if(isset($_POST['snumberSelector'])){
				$numberSelector = $_POST['snumberSelector'];
				$quarterHalfSelector = $_POST['squarterHalfSelector'];
				$nu = $conn->real_escape_string($numberSelector);
				$qu = $conn->real_escape_string($quarterHalfSelector);
				if($qu == "نصف"){
					$qu = 0.5;
				}else if($qu == "ربع"){
					$qu = 0.25;
				}else{
					$qu = 0;
				}
				$val = 0;
				try {
					if (isset($nu) && isset($qu)) { // Check if the variables are set
					  if (is_numeric($nu) && is_numeric($qu)) { // Check if the variables are numeric
						$val = $nu + $qu; // Try to add the values
					  } else {
						throw new Exception("One or both variables are not numeric"); // Throw an Exception if one or both variables are not numeric
					  }
					} else {
					  throw new Exception("One or both variables are not set"); // Throw an Exception if one or both variables are not set
					}
				  } catch (Exception $e) {
					//echo "Error: " . $e->getMessage(); // Handle the Exception by printing the error message
				}
				if($qu > 0){
					$val = $val + $qu;
				}
				$sql = "INSERT INTO `sora_face`(`std_id`, `face`, `type`, `date`, `rev_id`) VALUES ('".$_GET['std_id']."','".$val."','recite','".date('Y-m-d')."','".$_GET['rev_id']."')";
				mysqli_query($conn,$sql);
			}
		}else{
			if(isset($_POST["csora"])){
				
				$courses = $_POST["csora"];
				
				for ($i = 0; $i < count($courses); $i++) {
					$course = $conn->real_escape_string($courses[$i]);
					
					if($course != "none"){
						
						$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','-','-','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";

						$result = mysqli_query($conn,$sql);
						if(!$result){
							echo mysqli_error($conn);
						}
					}
				}
			}
				if(isset($_POST['ccourses'])){
					
					
					$ccourses = $_POST["ccourses"];
					$cpages1 = $_POST["cpages1"];
					$cpages2 = $_POST["cpages2"];
					// Loop through the selected courses and page ranges
					for ($i = 0; $i < count($ccourses); $i++) {
						$course = $conn->real_escape_string($ccourses[$i]);
						$page1_range = $conn->real_escape_string($cpages1[$i]);
						$page2_range = $conn->real_escape_string($cpages2[$i]);

						if($course != "none"){
							$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";

							//$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";
							$result = mysqli_query($conn,$sql);
							if(!$result){
								echo mysqli_error($conn);
							}
						}
					}
				}
				if(isset($_POST['cpart'])){	
					$courses = $_POST["cpart"];

					for ($i = 0; $i < count($courses); $i++) {
						$course = $conn->real_escape_string($courses[$i]);

						if($course != "none"){
							
							$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','*','*','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";

							//$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','recite','1','".$_GET['rev_id']."')";
							$result = mysqli_query($conn,$sql);
							if(!$result){
								echo mysqli_error($conn);
							}
						}
					}
				}
				if(isset($_POST['snumberSelector'])){
					$numberSelector = $_POST['snumberSelector'];
					$quarterHalfSelector = $_POST['squarterHalfSelector'];
					$nu = $conn->real_escape_string($numberSelector);
					$qu = $conn->real_escape_string($quarterHalfSelector);
					
					if($qu == "نصف"){
						$qu = 0.5;
					}else if($qu == "ربع"){
						$qu = 0.25;
					}else{
						$qu = 0;
					}
					$val = 0;
					try {
						if (isset($nu) && isset($qu)) { // Check if the variables are set
						  if (is_numeric($nu) && is_numeric($qu)) { // Check if the variables are numeric
							$val = $nu + $qu; // Try to add the values
						  } else {
							throw new Exception("One or both variables are not numeric"); // Throw an Exception if one or both variables are not numeric
						  }
						} else {
						  throw new Exception("One or both variables are not set"); // Throw an Exception if one or both variables are not set
						}
					  } catch (Exception $e) {
						//echo "Error: " . $e->getMessage(); // Handle the Exception by printing the error message
					}
					if($qu > 0){
						$val = $val + $qu;
					}
					$sql = "INSERT INTO `sora_face`(`std_id`, `face`, `type`, `date`,`rev_id`) VALUES ('".$_GET['std_id']."','".$val."','recite','".date('Y-m-d')."','".$_GET['rev_id']."')";
					mysqli_query($conn,$sql);
				}
			
		}
		mysqli_query($conn,"
							CREATE TEMPORARY TABLE tmp_table
							SELECT MIN(id) AS min_id
							FROM std_homework_soras
							GROUP BY std_id, sora, s_from, s_to, date, type, state, rev_id;
							
							DELETE FROM std_homework_soras
							WHERE id NOT IN (SELECT min_id FROM tmp_table);
							
							DROP TEMPORARY TABLE IF EXISTS tmp_table;
		");
		mysqli_query($conn,"DELETE FROM std_homework_sora WHERE sora = '-'");
		mysqli_query($conn,"DELETE FROM sora_face WHERE face = '0'");
		
		echo "<script>window.location.href='change_ring_homework.php?ring_id=".$_GET['ring_id']."&std_id=".$_GET['std_id']."';</script>";
	}
	
?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>درجات</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
	<?php
		if($_SESSION['community'] == "4"){
			echo '<link rel="stylesheet" href="./style2.css?v=8">';
		}else{
			echo '<link rel="stylesheet" href="./style.css?v=8">';
		}
	?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
		table {
			border-collapse: collapse;
			max-width: auto;
			margin: 0 auto;
			margin-top: 10px;
		}
		h1{
			
			font-size: 32px;
			font-weight: bold;
		}

		thead th {
			background-color: #f2f2f2;
			border: 1px solid #ddd;
			font-weight: bold;
			padding: 10px;
			text-align: right;
		}

		tbody tr {
			border: 1px solid #ddd;
		}

		tbody td {
			font-size:16px;
			font-weight:bold;
			padding: 20px;
			text-align: right;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		td:nth-child(even) {
			background-color: #f2f2f2;
		}
		td:nth-child(even):hover {
			background-color: #f9f9f9;
		}

		td:nth-child(odd) {
			background-color: #fff;
		}
		td:nth-child(odd):hover {
			background-color: #f2f2f2;
		}
		@media screen and (min-width: 1200px) {
			article{
				width:500px;			
			}	
			.card-grid {
				grid-template-columns: repeat(2, 0fr);
				margin-right: 400px;
			}
		}
		thead {
			position: sticky;
			top: 0;
			z-index: 1;
		}
	</style>
</head>
<body>
<center style="margin-bottom:20px;"><a href="change_ring_res.php?ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
				<center>
				<?php if(isset($_GET['std_id']) and isset($_GET['date'])){?>
					<form class="login-form" id="myForm" action="change_ring_homework.php?ring_id=<?php echo $_GET['ring_id'];?>&std_id=<?php echo $_GET['std_id'];?>&date=<?php echo $_GET['date'];?>&rev_id=<?php echo $_GET['rev_id'];?>" method="post" onsubmit="return validateForm();">

					<div class="card-grid" style="font-size:18px;" >
							<article class="card" style="width:300px;">
								<div class="card-header">
									<div>
										<span><img src="imgs/icons/quran.png" /></span>
										<?php
											$sql = "SELECT std_name from students WHERE std_id = '".$_GET['std_id']."'";
											$name = mysqli_fetch_assoc(mysqli_query($conn,$sql))['std_name'];
										?>	
										<h3><?php echo $name; ?></h3>
									</div>
								</div>
								<div class="card-body">
								<?php
										$sqlPlan = "SELECT * FROM review_plan WHERE std_id = '".$_GET['std_id']."'";
										$resultPlan = mysqli_query($conn,$sqlPlan);
										$revPlan = "no";
										if(mysqli_num_rows($resultPlan) > 0){
											$rowPlan = mysqli_fetch_assoc($resultPlan);
											$revPlan = $rowPlan['amount'];
											if($revPlan == "0"){
												$revPlan = "no";
												echo '<h1 style="font-size:19px;">خطة الحفظ : <color style="color:#b40836">متوقف</color></h1></br>';

											}else{
												echo '<h1 style="font-size:19px;">خطة الحفظ : <color style="color:#b40836">'.$rowPlan['amount'].'</color></h1></br>';
											}
											//  خط الحفظ
										}else{
											
											echo '<h1 style="font-size:19px;color:#b40836;">الطالب ليس لديه خطة حفظ</h1></br>';
										}
										echo "<p id='revPlan' style='display:none;'>$revPlan</p>";
										echo "<input id='revPlan' type= 'text' name='revPlan' style='display:none; value='.$revPlan.'/>";
										
										$sqlPlan = "SELECT * FROM recite_plan WHERE std_id = '".$_GET['std_id']."'";
										$recPlan = "no";
										$resultPlan = mysqli_query($conn,$sqlPlan);
										if(mysqli_num_rows($resultPlan) > 0){
											$rowPlan = mysqli_fetch_assoc($resultPlan);
											$recPlan = $rowPlan['amount'];
											if($recPlan == "0"){
												$recPlan = "no";
											}
											echo '<h1 style="font-size:19px;">خطة المراجعة : <color style="color:#b40836">'.$rowPlan['amount'].'</color></h1></br>';
										}else{
											echo '<h1 style="font-size:19px;color:#b40836;">الطالب ليس لديه خطة مراجعة</h1></br>';
										}
										echo "<p id='recPlan' style='display:none;'>$recPlan</p>";
										echo "<input id='recPlan' type= 'text' name='recPlan' style='display:none; value='.$revPlan.'/>";

										echo '<h1 style="font-size:19px;">واجب الحفظ : </h1>';
										if($revPlan != "no"){
										$sqlDateReview = "SELECT date FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='review' AND state = '1' ORDER BY date DESC LIMIT 1";
$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDateReview));
$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='review' AND date = '".$rowRDate['date']."' AND state = '1'";
$rres = mysqli_query($conn,$sql);
if(mysqli_num_rows($rres) > 0){
    echo '<center><table style="margin-bottom:10px;width:250px;border:1px solid black;"><tr>';
    $count = 0;
    while($rrow = mysqli_fetch_assoc($rres)){
        if($count % 3 == 0 && $count != 0){
            echo '</tr><tr>';
        }
        if($rrow['s_from'] == '-'){
            echo '<td style="font-size:12px; padding:5px;color:#1c9300;"> سورة '.$rrow['sora'].'</td>';
        }else{
			if($rrow['s_from'] == '*'){
				echo '<td style="font-size:12px; padding:5px;color:#1c9300;"> الجزء '.$rrow['sora'].'</td>';
			}else{
				echo '<td style="font-size:12px; padding:5px;color:#1c9300;">'.$rrow['sora'].'</br> '.$rrow['s_from'].' - '.$rrow['s_to'].'</td>';
			}
        }
        $count++;
    }
    echo '</tr></table></center>';
}else{
    $sqlDateReview = "SELECT date FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='review' ORDER BY date DESC LIMIT 1";
	$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDateReview));
	$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='review' AND date = '".$rowRDate['date']."'";
	$rres = mysqli_query($conn,$sql);
	if(mysqli_num_rows($rres) > 0){
		echo '<center><table style="margin-bottom:10px;width:250px;border:1px solid black;"><tr>';
		$count = 0;
		while($rrow = mysqli_fetch_assoc($rres)){
			if($count % 3 == 0 && $count != 0){
				echo '</tr><tr>';
			}
			if($rrow['s_from'] == '-'){
				echo '<td style="font-size:12px; padding:5px;color:#1c9300;"> سورة '.$rrow['sora'].'</td>';
			}else{
				if($rrow['s_from'] == '*'){
					echo '<td style="font-size:12px; padding:5px;color:#1c9300;"> الجزء '.$rrow['sora'].'</td>';
				}else{
					echo '<td style="font-size:12px; padding:5px;color:#1c9300;">'.$rrow['sora'].'</br> '.$rrow['s_from'].' - '.$rrow['s_to'].'</td>';
				}
			}
			$count++;
		}
		echo '</tr></table></center>';
	}else{
		echo '<h1 style="font-size:18px;color:#1c9300;">الطالب ليس لديه واجب حفظ</h1></br>';
	}
}}else{
	echo '<h1 style="font-size:18px;color:#1c9300;">الطالب ليس لديه واجب حفظ</h1></br>';
}
												echo '<h1 style="font-size:19px;">واجب المراجعة : </h1>';
												if($recPlan != "no"){
$sqlDateReview = "SELECT date FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='recite' AND state = '1' ORDER BY date DESC LIMIT 1";
$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDateReview));
$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='recite' AND date = '".$rowRDate['date']."' AND state = '1'";
$rres = mysqli_query($conn,$sql);
if(mysqli_num_rows($rres) > 0){
    echo '<center><table style="margin-bottom:10px;width:250px;border:1px solid black;"><tr>';
    $count = 0;
    while($rrow = mysqli_fetch_assoc($rres)){
        if($count % 3 == 0 && $count != 0){
            echo '</tr><tr>';
        }
        if($rrow['s_from'] == '-'){
            echo '<td style="font-size:12px; padding:5px;width:30px;color:#1c9300;"> سورة '.$rrow['sora'].'</td>';
        }else{
			if($rrow['s_from'] == '*'){
				echo '<td style="font-size:12px; padding:5px;color:#1c9300;"> الجزء '.$rrow['sora'].'</td>';
			}else{
				echo '<td style="font-size:12px; padding:5px;color:#1c9300;">'.$rrow['sora'].'</br> '.$rrow['s_from'].' - '.$rrow['s_to'].'</td>';
			}
		}
        $count++;
    }
    echo '</tr></table></center>';
}else{
	$sqlDateReview = "SELECT date FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='recite' ORDER BY date DESC LIMIT 1";
	$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDateReview));
	$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='recite' AND date = '".$rowRDate['date']."'";
	$rres = mysqli_query($conn,$sql);
	if(mysqli_num_rows($rres) > 0){
		echo '<center><table style="margin-bottom:10px;width:250px;border:1px solid black;"><tr>';
		$count = 0;
		while($rrow = mysqli_fetch_assoc($rres)){
			if($count % 3 == 0 && $count != 0){
				echo '</tr><tr>';
			}
			if($rrow['s_from'] == '-'){
				echo '<td style="font-size:12px; padding:5px;width:30px;color:#1c9300;"> سورة '.$rrow['sora'].'</td>';
			}else{
				if($rrow['s_from'] == '*'){
					echo '<td style="font-size:12px; padding:5px;color:#1c9300;"> الجزء '.$rrow['sora'].'</td>';
				}else{
					echo '<td style="font-size:12px; padding:5px;color:#1c9300;">'.$rrow['sora'].'</br> '.$rrow['s_from'].' - '.$rrow['s_to'].'</td>';
				}
			}
			$count++;
		}
		echo '</tr></table></center>';
	}else{
		echo '<h1 style="font-size:18px;color:#1c9300;">الطالب ليس لديه واجب مراجعة</h1></br>';
	}
}}else{
	echo '<h1 style="font-size:18px;color:#1c9300;">الطالب ليس لديه واجب مراجعة</h1></br>';
}
									?>
							</div>
						</article>

						
						<article class="card" id="homework" style="margin-top:10px">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/quran.png" /></span>
									<h3>تغيير الواجب</h3>
								</div>
							</div>
							<div class="card-body">
								<!-- واجب الحفظ -->
								<!-- واجب الحفظ -->
								<!-- واجب الحفظ -->
								<!-- واجب الحفظ -->
								<!-- واجب الحفظ -->
								<?php
									if($revPlan == 'no'){
								?>
								<div id="review" style="display:none">
								<?php
									}else{
								?>
									<div id="review">
								<?php
									}
								?>
								<h2 style="font-weight:bold;">واجب الحفظ </h2>
								<center>
									<label for="div0">لا يوجد</label>
									<input style="width:auto;margin-left:10px;" type="radio" name="div" id="div0" value="no" checked onclick="showDiv('div0')">
									
									<label for="div1-radio">آيات</label>
									<input style="width:auto;margin-left:10px;" type="radio" name="div" id="div1-radio" value="ay" onclick="showDiv('div1')">
										
									<label for="div2-radio">سور</label>
									<input style="width:auto;" type="radio" name="div" id="div2-radio" value="so" onclick="showDiv('div2')">

									<label for="div3-radio">أجزاء</label>
									<input style="width:auto;" type="radio" name="div" id="div3-radio" value="pa" onclick="showDiv('div3')">
										
								</center>
								<center>
								</center>
								<center>
									<div id="div1" class="cont" style="display:none;">
										<div id="course-container" style="margin-bottom:10px;">
											<div class="course-container" id="course1-container">
												<ul>
													<li style="display:inline;">
													<select style="width:20%;height:30px;" name="courses[]" id="course1">
														<option value="none" selected></option>
														<?php echo generateOptions(); ?>
													</select>
													</li>
													<li style="display:inline;"><input style="width:20%;height:30px;padding:0px;text-align:center;" type="text" placeholder="من" name="pages1[]" id="pages1" class="page-range"></li>
													<li style="display:inline;"><input style="width:20%;height:30px;padding:0px;text-align:center;" placeholder="إلى" type="text" name="pages2[]" id="pages2" class="page-range"></li>
													
												</ul>
											</div>
										</div>
										
										<ul>
											<li style="display:inline;"><input style="width:43.3%;font-size:11px;" type="button" onclick="addCourse()" value="إضافة سورة"></li>
											<li style="display:inline;"><input style="width:43.3%;font-size:11px;" type="button" onclick="removeLastCourse()" value="حذف سورة"></li>
										</ul>
									</div>
								</center>
								<center><div id="div2" class="cont" style="display:none;">
									<div id="sora" style="margin-bottom:10px;">
										<div class="sora" id="sora1">
											<ul>
												<li style="display:inline;">
													<select style="display:flex;width:30%;height:80px;margin-bottom:8px;" name="sora[]" id="s1" multiple>
														
														<?php echo generateOptions(); ?>
													</select>
												</li>
												
											</ul>
										</div>
									</div>

								</div></center>
								<center><div id="div3" class="cont" style="display:none;">
									<div id="pa" style="margin-bottom:10px;">
										<div class="part" id="part1">
											<ul>
												<li style="display:inline;">
													<select style="width:30%;height:80px;margin-bottom:8px;display:flex" name="part[]" id="p1" multiple>
														
														<?php 
															for($i = 1;$i <=30;$i++){
																echo "<option value='".$i."'>".$i."</option>";
															} 
														?>
													</select>
												</li>
												
											</ul>
										</div>
									</div>
									
								</div>
								<div id="faces" style="display:none;">
														<div id="numberSelectorContainer" style="width:20%;display:inline-block;">
															<select id="numberSelector" name="numberSelector" style="width:100%;height:30px;">
																<option value="" style="padding:5px;">عدد الأوجه</option>
																<option value="1">1</option>
																<option value="2">2</option>
																<option value="3">3</option>
																<option value="4">4</option>
																<option value="5">5</option>
																<option value="6">6</option>
																<option value="7">7</option>
																<option value="8">8</option>
																<option value="9">9</option>
																<option value="10">10</option>
																<option value="11">11</option>
																<option value="12">12</option>
																<option value="13">13</option>
																<option value="14">14</option>
																<option value="15">15</option>
																<option value="16">16</option>
																<option value="17">17</option>
																<option value="18">18</option>
																<option value="19">19</option>
																<option value="20">20</option>
																<option value="21">21</option>
																<option value="22">22</option>
																<option value="23">23</option>
																<option value="24">24</option>
																<option value="25">25</option>
																<option value="26">26</option>
																<option value="27">27</option>
																<option value="28">28</option>
																<option value="29">29</option>
																<option value="30">30</option>
																<option value="31">31</option>
																<option value="32">32</option>
																<option value="33">33</option>
																<option value="34">34</option>
																<option value="35">35</option>
																<option value="36">36</option>
																<option value="37">37</option>
																<option value="38">38</option>
																<option value="39">39</option>
																<option value="40">40</option>
																<option value="41">41</option>
																<option value="42">42</option>
																<option value="43">43</option>
																<option value="44">44</option>
																<option value="45">45</option>
																<option value="46">46</option>
																<option value="47">47</option>
																<option value="48">48</option>
																<option value="49">49</option>
																<option value="50">50</option>
																<option value="51">51</option>
																<option value="52">52</option>
																<option value="53">53</option>
																<option value="54">54</option>
																<option value="55">55</option>
																<option value="56">56</option>
																<option value="57">57</option>
																<option value="58">58</option>
																<option value="59">59</option>
																<option value="60">60</option>
																<option value="61">61</option>
																<option value="62">62</option>
																<option value="63">63</option>
																<option value="64">64</option>
																<option value="65">65</option>
																<option value="66">66</option>
																<option value="67">67</option>
																<option value="68">68</option>
																<option value="69">69</option>
																<option value="70">70</option>
																<option value="71">71</option>
																<option value="72">72</option>
																<option value="73">73</option>
																<option value="74">74</option>
																<option value="75">75</option>
																<option value="76">76</option>
																<option value="77">77</option>
																<option value="78">78</option>
																<option value="79">79</option>
																<option value="80">80</option>
																<option value="81">81</option>
																<option value="82">82</option>
																<option value="83">83</option>
																<option value="84">84</option>
																<option value="85">85</option>
																<option value="86">86</option>
																<option value="87">87</option>
																<option value="88">88</option>
																<option value="89">89</option>
																<option value="90">90</option>
																<option value="91">91</option>
																<option value="92">92</option>
																<option value="93">93</option>
																<option value="94">94</option>
																<option value="95">95</option>
																<option value="96">96</option>
																<option value="97">97</option>
																<option value="98">98</option>
																<option value="99">99</option>
																<option value="100">100</option>
															</select>
														</div>
														<div id="optionsContainer" style="display:inline-block;width:20%;">
															<select id="quarterHalfSelector" name="quarterHalfSelector" style="width:100%;height:30px;">
																<option value="0" selected>-----------</option>
																<option value="ربع">ربع</option>
																<option value="نصف">نصف</option>
															</select>
														</div>
													</div>
												</center>
							</div>
								<!-- واجب المراجعة -->
								<!-- واجب المراجعة -->
								<!-- واجب المراجعة -->
								<!-- واجب المراجعة -->
								<?php
									if($recPlan == 'no'){
								?>
								<div id="recite" style="display:none">
								<?php
									}else{
								?>
									<div id="recite">
								<?php
									}
								?>
								<h2 style="font-weight:bold;">واجب المراجعة </h2>
								<center>
									<label for="cdiv0">لا يوجد</label>
									<input style="width:auto;margin-left:10px;" type="radio" name="cdiv" id="cdiv0" value="cno" checked onclick="showCDiv('cdiv0')" checked>

									<label for="cdiv1-radio">آيات</label>
									<input style="width:auto;margin-left:10px;" type="radio" name="cdiv" id="cdiv1-radio" value="cay" onclick="showCDiv('cdiv1')">
										
									<label for="cdiv2-radio">سور</label>
									<input style="width:auto;" type="radio" name="cdiv" id="cdiv2-radio" value="cso" onclick="showCDiv('cdiv2')">
									
									<label for="cdiv3-radio">أجزاء</label>
									<input style="width:auto;" type="radio" name="cdiv" id="cdiv3-radio" value="cpa" onclick="showCDiv('cdiv3')">
										
								</center>
								<center>
									<div id="cdiv0" class="ccont">
										
									</div>
								</center>
								<center>
									<div id="cdiv1" class="ccont" style="display:none;">
									<div id="ccourse-container" style="margin-bottom:10px;">
										<div class="ccourse-container" id="ccourse1-container">
											<ul>
												<li style="display:inline;">
													<select style="width:20%;height:30px;" name="ccourses[]" id="ccourse1">
													<option value="none" selected></option>
													<?php echo generateOptions(); ?>
													</select>
												</li>
												<li style="display:inline;"><input style="width:20%;height:30px;padding:0px;text-align:center;" type="text" placeholder="من" name="cpages1[]" id="cpages1" class="page-range"></li>
												<li style="display:inline;"><input style="width:20%;height:30px;padding:0px;text-align:center;" placeholder="إلى" type="text" name="cpages2[]" id="cpages2" class="page-range"></li>
												
											</ul>
										</div>
									</div>
									<ul>
										<li style="display:inline;"><input style="width:43.3%;font-size:16px;" type="button" onclick="addCCourse()" value="إضافة سورة"></li>
										<li style="display:inline;"><input style="width:43.3%;font-size:16px;" type="button" onclick="removeCLastCourse()" value="حذف سورة"></li>
									</ul>
								</div></center>
								<center><div id="cdiv2" class="ccont" style="display:none;">
									<div id="csora" style="margin-bottom:10px;">
										<div class="csora" id="csora1">
											<ul>
												<li style="display:inline;">
													<select style="display:flex;width:30%;height:80px;margin-bottom:7px;" name="csora[]" id="cs1" multiple>
														<?php echo generateOptions(); ?>
													</select>
												</li>
												
											</ul>
										</div>
									</div>
								</div></center>
								<center><div id="cdiv3" class="ccont" style="display:none;">
									<div id="cpa" style="margin-bottom:10px;">
										<div class="cpart" id="cpart1">
											<ul>
												<li style="display:inline;">
													<select style="display:flex;width:30%;height:80px;margin-bottom:8px;" name="cpart[]" id="cp1" multiple>
														
														<?php 
															for($i = 1;$i <=30;$i++){
																echo "<option value='".$i."'>".$i."</option>";
															} 
														?>
													</select>
												</li>
												
											</ul>
										</div>
									</div>

								</div>
								<div id="cfaces" style="display:none;">
														<div id="snumberSelectorContainer" style="width:20%;display:inline-block;">
															<select id="snumberSelector" name="snumberSelector" style="width:100%;height:30px;">
																<option value="" style="padding:5px;">عدد الأوجه</option>
																<option value="1">1</option>
																<option value="2">2</option>
																<option value="3">3</option>
																<option value="4">4</option>
																<option value="5">5</option>
																<option value="6">6</option>
																<option value="7">7</option>
																<option value="8">8</option>
																<option value="9">9</option>
																<option value="10">10</option>
																<option value="11">11</option>
																<option value="12">12</option>
																<option value="13">13</option>
																<option value="14">14</option>
																<option value="15">15</option>
																<option value="16">16</option>
																<option value="17">17</option>
																<option value="18">18</option>
																<option value="19">19</option>
																<option value="20">20</option>
																<option value="21">21</option>
																<option value="22">22</option>
																<option value="23">23</option>
																<option value="24">24</option>
																<option value="25">25</option>
																<option value="26">26</option>
																<option value="27">27</option>
																<option value="28">28</option>
																<option value="29">29</option>
																<option value="30">30</option>
																<option value="31">31</option>
																<option value="32">32</option>
																<option value="33">33</option>
																<option value="34">34</option>
																<option value="35">35</option>
																<option value="36">36</option>
																<option value="37">37</option>
																<option value="38">38</option>
																<option value="39">39</option>
																<option value="40">40</option>
																<option value="41">41</option>
																<option value="42">42</option>
																<option value="43">43</option>
																<option value="44">44</option>
																<option value="45">45</option>
																<option value="46">46</option>
																<option value="47">47</option>
																<option value="48">48</option>
																<option value="49">49</option>
																<option value="50">50</option>
																<option value="51">51</option>
																<option value="52">52</option>
																<option value="53">53</option>
																<option value="54">54</option>
																<option value="55">55</option>
																<option value="56">56</option>
																<option value="57">57</option>
																<option value="58">58</option>
																<option value="59">59</option>
																<option value="60">60</option>
																<option value="61">61</option>
																<option value="62">62</option>
																<option value="63">63</option>
																<option value="64">64</option>
																<option value="65">65</option>
																<option value="66">66</option>
																<option value="67">67</option>
																<option value="68">68</option>
																<option value="69">69</option>
																<option value="70">70</option>
																<option value="71">71</option>
																<option value="72">72</option>
																<option value="73">73</option>
																<option value="74">74</option>
																<option value="75">75</option>
																<option value="76">76</option>
																<option value="77">77</option>
																<option value="78">78</option>
																<option value="79">79</option>
																<option value="80">80</option>
																<option value="81">81</option>
																<option value="82">82</option>
																<option value="83">83</option>
																<option value="84">84</option>
																<option value="85">85</option>
																<option value="86">86</option>
																<option value="87">87</option>
																<option value="88">88</option>
																<option value="89">89</option>
																<option value="90">90</option>
																<option value="91">91</option>
																<option value="92">92</option>
																<option value="93">93</option>
																<option value="94">94</option>
																<option value="95">95</option>
																<option value="96">96</option>
																<option value="97">97</option>
																<option value="98">98</option>
																<option value="99">99</option>
																<option value="100">100</option>
															</select>
														</div>
														<div id="soptionsContainer" style="display:inline-block;width:20%;">
															<select id="squarterHalfSelector" name="squarterHalfSelector" style="width:100%;height:30px;">
																<option value="0" selected>-----------</option>
																<option value="ربع">ربع</option>
																<option value="نصف">نصف</option>
															</select>
														</div>
														</div>
							</center>
								</div>
							</div>
							<div class="card-footer">
								<button type="submit" name="ch">تغيير الواجب</button>
							</div>
						</artice>
						
</div>
</form>
					<?php }else{?>
						<table>
							<thead>
								<tr>
									<th>اسم الطالب</th>
									<th>التاريخ</th>
									<th>اليوم</th>
									<th>واجب الحفظ</th>
									<th>عدد الأوجه</th>
									<th>واجب المراجعة</th>
									<th>عدد الأوجه</th>
									<th>تغيير</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$sql = "SELECT date FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' ORDER BY date DESC LIMIT 1";
									$res = mysqli_query($conn,$sql);
									if(mysqli_num_rows($res) > 0){
										$date = mysqli_fetch_assoc($res)['date'];
									}else{
										$date = date('Y-m-d');
									}
									$sql = "SELECT * FROM students
											INNER JOIN ring ON ring.ring_id = students.temp_ring_id
											WHERE students.temp_ring_id = '".$_GET['ring_id']."'
											AND students.std_id = '".$_GET['std_id']."'
											";
											$result = mysqli_query($conn,$sql);
									if($result){
										while($row = mysqli_fetch_assoc($result)){
											echo '<tr>';
											echo '<td>'.$row['std_name'].'</td>';
											echo '<td>'.$date.'</td>';
											echo '<td>'.getDayOfWeek($date).'</td>';
											$revId = mysqli_fetch_assoc(mysqli_query($conn,"SELECT id FROM review WHERE std_id = '".$_GET['std_id']."' ORDER BY id DESC"))['id'];
											$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM std_homework_soras WHERE rev_id = '".$revId."' and type='review' ORDER BY id DESC";
																	$rres = mysqli_query($conn,$sql);
																	if(mysqli_num_rows($rres) > 0){
																		echo '<td><ul>';
																		while($rrow = mysqli_fetch_assoc($rres)){
																			if($rrow['s_from'] == '-'){
																				echo '<li> سورة '.$rrow['sor'].'</li>';
																			}else{
																				if($rrow['s_from'] == '*'){
																					echo '<li> الجزء '.$rrow['sor'].'</li>';
																				}else{
																					if($rrow['sor'] == ""){
																					
																					}else{
																						echo '<li>'.$rrow['sor'].' من '.$rrow['s_from'].' إلى '.$rrow['s_to'].'</li>';
																					}
																				}
																			}
																			
																			
																		}
																		echo '</ul></td>';
																		$sql = "SELECT * FROM sora_face WHERE rev_id = '".$revId."' AND std_id = '".$row['std_id']."' AND type= 'review'";
																		$rere = mysqli_query($conn,$sql);
																		echo '<td>'.mysqli_fetch_assoc($rere)['face'].'</td>';
																	}else{
																		
																			echo '<td>لم يتم تسجيل واجب</td>';
																			echo '<td>لم يتم تسجيل واجب</td>';
																		
																	}
																	$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM std_homework_soras WHERE rev_id = '".$revId."' and type='recite' ORDER BY id DESC";
																	$rres = mysqli_query($conn,$sql);
																	if(mysqli_num_rows($rres) > 0){
																		echo '<td><ul>';
																		while($rrow = mysqli_fetch_assoc($rres)){
																			if($rrow['s_from'] == '-' and $rrow['sor'] != ""){
																				echo '<li> سورة '.$rrow['sor'].'</li>';
																			}else{
																				if($rrow['s_from'] == '*'){
																					echo '<li> الجزء '.$rrow['sor'].'</li>';
																				}else{
																					if($rrow['sor'] == ""){
																					
																					}else{
																						echo '<li>'.$rrow['sor'].' من '.$rrow['s_from'].' إلى '.$rrow['s_to'].'</li>';
																					}
																				}
																				
																			}
																			
																		}
																		echo '</ul></td>';
																		$sql = "SELECT * FROM sora_face WHERE date = '".$date."' AND std_id = '".$row['std_id']."' AND type= 'recite' ORDER BY id DESC";
																		$rere = mysqli_query($conn,$sql);
																		echo '<td>'.mysqli_fetch_assoc($rere)['face'].'</td>';
																	}else{
																		
																			echo '<td>لم يتم تسجيل واجب</td>';
																			echo '<td>لم يتم تسجيل واجب</td>';
																		
																	}
																	echo '<td>
																			<form class="login-form" action="change_ring_homework.php?ring_id='.$_GET['ring_id'].'&date='.$date.'&std_id='.$row['std_id'].'&rev_id='.$revId.'" method="post">
																					<button type="submit" name="change">تغيير الواجب</button>
																				</form>
																			</td>
																		</tr>';
										}
									}
								?>
							</tbody>
						</table>
							
					<?php }?>
				</div></form>
					</center>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
  <script>
	function addCourse(select) {
		if (select.value !== "") {
			// Create new course row
			var div = document.createElement("div");
			var select_copy = select.cloneNode(true);
			var input1 = document.createElement("input");
			var input2 = document.createElement("input");
			input1.type = "text";
			input1.name = "pages[]";
			input1.placeholder = "From page";
			input2.type = "text";
			input2.name = "pages[]";
			input2.placeholder = "To page";
			div.appendChild(select_copy);
			div.appendChild(input1);
			div.appendChild(input2);
			
			// Add new course row to list
			var course_list = document.getElementById("course-list");
			course_list.appendChild(div);
			
			// Disable selected course in other rows
			var all_selects = document.getElementsByTagName("select");
			for (var i = 0; i < all_selects.length; i++) {
				if (all_selects[i].value === select.value) {
					all_selects[i].disabled = true;
				}
			}
		}
	}
	</script>
	
</body>

	<script>
        function addCourse() {
            // Get the container element
            var container = document.getElementById("course-container");

            // Clone the original course container
            var originalContainer = document.getElementById("course1-container");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            var newInput = newContainer.querySelector("input");
            newInput.value = "";

            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeLastCourse() {
			// Get the container element
			var container = document.getElementById("course-container");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		// adding sora
		function addSora() {
            // Get the container element
            var container = document.getElementById("sora");

            // Clone the original course container
            var originalContainer = document.getElementById("sora1");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeLastSora() {
			// Get the container element
			var container = document.getElementById("sora");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		//showing the type
		function showDiv(divId) {
			var divs = document.querySelectorAll('.cont');
			var faces = document.getElementById("faces");

			if (divId !== 'div0') {
				faces.style.display = "inline";
			}else{
				faces.style.display = "none";
			}

			for (var i = 0; i < divs.length; i++) {
				if (divs[i].id === divId) {
					divs[i].style.display = "block";
				} else {
					divs[i].style.display = "none";
				}
			}
		}




		function addCCourse() {
            // Get the container element
            var container = document.getElementById("ccourse-container");

            // Clone the original course container
            var originalContainer = document.getElementById("ccourse1-container");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            var newInput = newContainer.querySelector("input");
            newInput.value = "";

            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeCLastCourse() {
			// Get the container element
			var container = document.getElementById("ccourse-container");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		// adding sora
		function addCSora() {
            // Get the container element
            var container = document.getElementById("csora");

            // Clone the original course container
            var originalContainer = document.getElementById("csora1");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeCLastSora() {
			// Get the container element
			var container = document.getElementById("csora");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		//showing the type
		function showCDiv(divId) {
			var divs = document.querySelectorAll('.ccont');
			var faces = document.getElementById("cfaces");

			if (divId !== 'cdiv0') {
				faces.style.display = "inline";
			}else{
				faces.style.display = "none";
			}
			for (var i = 0; i < divs.length; i++) {
				if (divs[i].id === divId) {
				divs[i].style.display = "block";
				} else {
				divs[i].style.display = "none";
				}
			}
		}
    </script>
	<script>
		// Get a reference to the form element
		var form = document.getElementById("myForm");

		// Attach an event listener to the form's submit event
		form.addEventListener("submit", function(event) {
			// Get a reference to the text boxes
			// CODE FOR THE REVIEW HOMEWORK
			// CODE FOR THE REVIEW HOMEWORK

			var rad1 = document.getElementById("div1-radio");
			var rad2 = document.getElementById("div2-radio");
			var disp = document.getElementById("disp");
			var disp2 = document.getElementById("disp2");

			if(rad1.checked){
				var pages1 = document.getElementById("pages1");
				var pages2 = document.getElementById("pages2");
				var course = document.getElementById("course1");
				// Check if the text boxes are empty
				if (pages1.value === "" || pages2.value === "" || course.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						//event.preventDefault();
						//alert("الرجاء اختيار السورة والآيات للحفظ");
					}
				}
			}
			if(rad2.checked){
				var sora = document.getElementById("s1");
				// Check if the text boxes are empty
				if (sora.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						//event.preventDefault();
						//alert("الرجاء اختيار السورة للحفظ");
					}
				}
			}

			// CODE FOR THE RECITE HOMEWORK
			// CODE FOR THE RECITE HOMEWORK

			var rad1 = document.getElementById("cdiv1-radio");
			var rad2 = document.getElementById("cdiv2-radio");

			if(rad1.checked){
				var pages1 = document.getElementById("cpages1");
				var pages2 = document.getElementById("cpages2");
				var course = document.getElementById("ccourse1");
				// Check if the text boxes are empty
				if (pages1.value === "" || pages2.value === "" || course.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						//event.preventDefault();
						//alert("الرجاء اختيار السورة والآيات للمراجعة");
					}
				}
			}
			if(rad2.checked){
				var sora = document.getElementById("cs1");
				// Check if the text boxes are empty
				if (sora.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						//event.preventDefault();
						//alert("الرجاء اختيار السورة للمراجعة");
					}
				}
			}

			
		});
		function validateForm() {
			/*const sselectedNumber = document.getElementById("snumberSelector").value;
			const sselectedQuarterHalf = document.getElementById("squarterHalfSelector").value;

			const cselectedNumber = document.getElementById("cnumberSelector").value;
			const cselectedQuarterHalf = document.getElementById("cquarterHalfSelector").value;

			const csselectedNumber = document.getElementById("csnumberSelector").value;
			const csselectedQuarterHalf = document.getElementById("csquarterHalfSelector").value;*/
			
			var rad1 = document.getElementById("div1-radio");
			var rad2 = document.getElementById("div2-radio");
			var rad3 = document.getElementById("div3-radio");

			var revPlan = document.getElementById("revPlan");
			var recPlan = document.getElementById("recPlan");

			var disp = document.getElementById("disp");
			var disp2 = document.getElementById("disp2");


			if(rad1.checked){
				var pages1 = document.getElementById("pages1");
				var pages2 = document.getElementById("pages2");
				var course = document.getElementById("course1");
				var selectedNumber = document.getElementById("numberSelector");
				var selectedQuarterHalf = document.getElementById("quarterHalfSelector");
				// Check if the text boxes are empty
				if (pages1.value === "" || pages2.value === "" || course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار السورة والآيات للحفظ");
				}
				if (selectedNumber.value === "" && selectedQuarterHalf.value === "0") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للحفظ");
				}
			}
			if(rad2.checked){
				var course = document.getElementById("s1");
				var selectedNumber = document.getElementById("numberSelector");
				var selectedQuarterHalf = document.getElementById("quarterHalfSelector");
				// Check if the text boxes are empty
				if (course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار السور للحفظ");
				}
				if (selectedNumber.value === "" && selectedQuarterHalf.value === "0") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للحفظ");
				}
			}
			if(rad3.checked){
				var course = document.getElementById("p1");
				var selectedNumber = document.getElementById("numberSelector");
				var selectedQuarterHalf = document.getElementById("quarterHalfSelector");
				// Check if the text boxes are empty
				if (course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار الأجزاء للحفظ");
				}
				if (selectedNumber.value === "" || selectedQuarterHalf.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للحفظ");
				}
			}

			var rad1 = document.getElementById("cdiv1-radio");
			var rad2 = document.getElementById("cdiv2-radio");
			var rad3 = document.getElementById("cdiv3-radio");

			if(rad1.checked){
				var pages1 = document.getElementById("cpages1");
				var pages2 = document.getElementById("cpages2");
				var course = document.getElementById("ccourse1");
				var selectedNumber = document.getElementById("snumberSelector");
				var selectedQuarterHalf = document.getElementById("squarterHalfSelector");
				// Check if the text boxes are empty
				if (pages1.value === "" || pages2.value === "" || course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار السورة والآيات للمراجعة");
				}
				if (selectedNumber.value === "" || selectedQuarterHalf.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للمراجعة");
				}
			}
			if(rad2.checked){
				var course = document.getElementById("cs1");
				var selectedNumber = document.getElementById("snumberSelector");
				var selectedQuarterHalf = document.getElementById("squarterHalfSelector");
				// Check if the text boxes are empty
				if (course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار السور للمراجعة");
				}
				if (selectedNumber.value === "" || selectedQuarterHalf.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للمراجعة");
				}
			}
			if(rad3.checked){
				var course = document.getElementById("cp1");
				var selectedNumber = document.getElementById("snumberSelector");
				var selectedQuarterHalf = document.getElementById("squarterHalfSelector");
				// Check if the text boxes are empty
				if (course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار الأجزاء للمراجعة");
				}
				if (selectedNumber.value === "" || selectedQuarterHalf.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للمراجعة");
				}
			}
			
		}
	</script>
</html>


<?php
    function generateOptions() {
        // List of courses
        $soras = array(
                "1"=>"الفاتحة",
                "2"=>"البقرة",
                "3"=>"آل عمران",
                "4"=>"النساء",
                "5"=>"المائدة",
                "6"=>"الأنعام",
                "7"=>"الأعراف",
                "8"=>"الأنفال",
                "9"=>"التوبة",
                "10"=>"يونس",
                "11"=>"هود",
                "12"=>"يوسف",
                "13"=>"الرعد",
                "14"=>"ابراهيم",
                "15"=>"الحجر",
                "16"=>"النحل",
                "17"=>"الإسراء",
                "18"=>"الكهف",
                "19"=>"مريم",
                "20"=>"طه",
                "21"=>"الأنبياء",
                "22"=>"الحج",
                "23"=>"المؤمنون",
                "24"=>"النور",
                "25"=>"الفرقان",
                "26"=>"الشعراء",
                "27"=>"النمل",
                "28"=>"القصص",
                "29"=>"العنكبوت",
                "30"=>"الروم",
                "31"=>"لقمان",
                "32"=>"السجدة",
                "33"=>"الأحزاب",
                "34"=>"سبإ",
                "35"=>"فاطر",
                "36"=>"يس",
                "37"=>"الصافات",
                "38"=>"ص",
                "39"=>"الزمر",
                "40"=>"غافر",
                "41"=>"فصلت",
                "42"=>"الشورى",
                "43"=>"الزخرف",
                "44"=>"الدخان",
                "45"=>"الجاثية",
                "46"=>"الأحقاف",
                "47"=>"محمد",
                "48"=>"الفتح",
                "49"=>"الحجرات",
                "50"=>"ق",
                "51"=>"الذاريات",
                "52"=>"الطور",
                "53"=>"النجم",
                "54"=>"القمر",
                "55"=>"الرحمن",
                "56"=>"الواقعة",
                "57"=>"الحديد",
                "58"=>"المجادلة",
                "59"=>"الحشر",
                "60"=>"الممتحنة",
                "61"=>"الصف",
                "62"=>"الجمعة",
                "63"=>"المنافقون",
                "64"=>"التغابن",
                "65"=>"الطلاق",
                "66"=>"التحريم",
                "67"=>"الملك",
                "68"=>"القلم",
                "69"=>"الحاقة",
                "70"=>"المعارج",
                "71"=>"نوح",
                "72"=>"الجن",
                "73"=>"المزمل",
                "74"=>"المدثر",
                "75"=>"القيامة",
                "76"=>"الانسان",
                "77"=>"المرسلات",
                "78"=>"النبإ",
                "79"=>"النازعات",
                "80"=>"عبس",
                "81"=>"التكوير",
                "82"=>"الإنفطار",
                "83"=>"المطففين",
                "84"=>"الإنشقاق",
                "85"=>"البروج",
                "86"=>"الطارق",
                "87"=>"الأعلى",
                "88"=>"الغاشية",
                "89"=>"الفجر",
                "90"=>"البلد",
                "91"=>"الشمس",
                "92"=>"الليل",
                "93"=>"الضحى",
                "94"=>"الشرح",
                "95"=>"التين",
                "96"=>"العلق",
                "97"=>"القدر",
                "98"=>"البينة",
                "99"=>"الزلزلة",
                "100"=>"العاديات",
                "101"=>"القارعة",
                "102"=>"التكاثر",
                "103"=>"العصر",
                "104"=>"الهمزة",
                "105"=>"الفيل",
                "106"=>"قريش",
                "107"=>"الماعون",
                "108"=>"الكوثر",
                "109"=>"الكافرون",
                "110"=>"النصر",
                "111"=>"المسد",
                "112"=>"الإخلاص",
                "113"=>"الفلق",
                "114"=>"الناس"
        );
    
        // Loop through the courses and create an option element for each one
        $options = "";
        foreach ($soras as $value => $sora) {
            $options .= "<option value=\"$sora\">$sora</option>";
        }
    
        return $options;
    }
?>
<?php
	function getDayOfWeek($dateString) {
		$myDate = new DateTime($dateString);
		$dayOfWeek = $myDate->format('w');
		$daysOfWeek = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
		return $daysOfWeek[$dayOfWeek];
	  }
?>
