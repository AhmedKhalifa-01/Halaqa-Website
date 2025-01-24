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

/* adding new accout */


	if(isset($_POST['add_std'])){
		if($_SESSION['staff_job'] == 'JOB_02'){
			$name = $_POST['name'];
			$lvl = $_POST['lvl'];
			$nat = $_POST['nat'];
			$id = $_POST['id'];
			$bd = $_POST['bd'];
			$bloc = $_POST['bloc'];
			$enrollDate = $_POST['enrolldate'];
			$phone = $_POST['phone'];
			$pRequired = '';
			if (isset($_POST['pRequired'])) {
				// Checkbox was checked
				$pRequired = $_POST['pRequired'];
			} else {
				// Checkbox was not checked
				$pRequired = 'NO';
			}
			$last_sorah = $_POST['last_sorah'];
			$tested = $_POST['tested'];
			if(isset($_POST['courses'])){
				$courses = $_POST['courses'];
			}else{
				$courses = "لا يوجد";
			}
			$email = $_POST['email'];
			$pass = $_POST['pass'];
			
			// Adding personal image
			$currentDirectory = getcwd();
			$uploadDirectory = "/imgs/";
		  
			$errors = []; // Store errors here
		  
			$fileExtensionsAllowed = ['jpeg','jpg','png','gif']; // These will be the only file extensions allowed 
		  
			$fileName = $_FILES['file']['name']; // The original name of the file on the client machine.
			$fileSize = $_FILES['file']['size'];
			$fileTmpName  = $_FILES['file']['tmp_name']; // The temporary filename of the file in which the uploaded file was stored on the server.
	
		  
			$uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);  // basename Return filename from the specified path:
		  
			$db_path = $uploadDirectory . basename($fileName);
			$filename = $_FILES['file']['name'];
		  
			// if (! in_array($fileExtension,$fileExtensionsAllowed)) { // search for the file extention in the given array
			//     $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
			// }
			  
			if ($fileSize > 40000000) {
				$errors[] = "File exceeds maximum size (4MB)";
			}
			$didUpload = move_uploaded_file($fileTmpName, $uploadPath); // moves an uploaded file to a new destination
			$sql = "INSERT INTO `pending_std`(`std_name`, `std_lvl`, `std_nat`, `std_id_num`, `std_birth_date`, `std_birth_loc`, `std_enroll_date`, `std_phone`,`std_last_sorah`, `std_tested`,`email`, `pass`,`std_v_mem`,`state`,`pRequired`) 
								VALUES ('".$name."','".$lvl."','".$nat."','".$id."','".$bd."','".$bloc."','".$enrollDate."','".$phone."','".$last_sorah."','".$tested."','".$email."','".$pass."','".$tested."','منتظم','".$pRequired."')";
			if ($didUpload) {
				$img = basename($fileName);
				$sql = "INSERT INTO `pending_std`(`std_name`, `std_lvl`, `std_nat`, `std_id_num`, `std_birth_date`, `std_birth_loc`, `std_enroll_date`, `std_phone`, `std_last_sorah`, `std_tested`, `std_profile`,`email`, `pass`,`std_v_mem`,`state`,`pRequired`) VALUES ('".$name."','".$lvl."','".$nat."','".$id."','".$bd."','".$bloc."','".$enrollDate."','".$phone."','".$last_sorah."','".$tested."','".$img."','".$email."','".$pass."','".$tested."','منتظم','".$pRequired."')";
			}
				$result = mysqli_query($conn,$sql);
				$student_id = mysqli_insert_id($conn);
				if($result){
					if (!empty($courses) and $courses != "لا يوجد") {
						foreach ($courses as $course_id) {
							echo $course_id;
							$sql = "INSERT INTO student_courses (student_id, course_id) VALUES ('$student_id', '$course_id')";
							mysqli_query($conn, $sql);
						}
					}
					echo "<script>alert('تمت إضافة الطالب ، بانتظار الموافقة');</script>";
					echo "<script>window.location.href='new_acc.php';</script>";
				}else{
					echo "<script>alert('خطأ في اضافة الطالب');</script>";
				}
		}else{
			$name = $_POST['name'];
			$lvl = $_POST['lvl'];
			$nat = $_POST['nat'];
			$id = $_POST['id'];
			$bd = $_POST['bd'];
			$bloc = $_POST['bloc'];
			$enrollDate = $_POST['enrolldate'];
			$phone = $_POST['phone'];
			$last_sorah = $_POST['last_sorah'];
			$pRequired = '';
			if (isset($_POST['pRequired'])) {
				// Checkbox was checked
				$pRequired = $_POST['pRequired'];
			} else {
				// Checkbox was not checked
				$pRequired = 'NO';
			}
			$tested = $_POST['tested'];
			if(isset($_POST['courses'])){
				$courses = $_POST['courses'];
			}else{
				$courses = "لا يوجد";
			}
			$email = $_POST['email'];
			$pass = $_POST['pass'];
	
			// Adding personal image
			$currentDirectory = getcwd();
			$uploadDirectory = "/imgs/";
		  
			$errors = []; // Store errors here
		  
			$fileExtensionsAllowed = ['jpeg','jpg','png','gif']; // These will be the only file extensions allowed 
		  
			$fileName = $_FILES['file']['name']; // The original name of the file on the client machine.
			$fileSize = $_FILES['file']['size'];
			$fileTmpName  = $_FILES['file']['tmp_name']; // The temporary filename of the file in which the uploaded file was stored on the server.
	
		  
			$uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);  // basename Return filename from the specified path:
		  
			$db_path = $uploadDirectory . basename($fileName);
			$filename = $_FILES['file']['name'];
		  
			// if (! in_array($fileExtension,$fileExtensionsAllowed)) { // search for the file extention in the given array
			//     $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
			// }
			  
			if ($fileSize > 40000000) {
				$errors[] = "File exceeds maximum size (4MB)";
			}
			$didUpload = move_uploaded_file($fileTmpName, $uploadPath); // moves an uploaded file to a new destination
			$sql = "INSERT INTO `students`(`std_name`, `std_lvl`, `std_nat`, `std_id_num`, `std_birth_date`, `std_birth_loc`, `std_enroll_date`, `std_phone`,`std_last_sorah`, `std_tested`,`email`, `pass`,`std_v_mem`,`state`,`pRequired`) 
								VALUES ('".$name."','".$lvl."','".$nat."','".$id."','".$bd."','".$bloc."','".$enrollDate."','".$phone."','".$last_sorah."','".$tested."','".$email."','".$pass."','".$tested."','منتظم','".$pRequired."')";
			if ($didUpload) {
				$img = basename($fileName);
				$sql = "INSERT INTO `students`(`std_name`, `std_lvl`, `std_nat`, `std_id_num`, `std_birth_date`, `std_birth_loc`, `std_enroll_date`, `std_phone`, `std_last_sorah`, `std_tested`, `std_profile`,`email`, `pass`,`std_v_mem`,`state`,`pRequired`) VALUES ('".$name."','".$lvl."','".$nat."','".$id."','".$bd."','".$bloc."','".$enrollDate."','".$phone."','".$last_sorah."','".$tested."','".$img."','".$email."','".$pass."','".$tested."','منتظم','".$pRequired."')";
			}
				$result = mysqli_query($conn,$sql);
				$student_id = mysqli_insert_id($conn);
				if($result){
					if (!empty($courses) and $courses != "لا يوجد") {
						foreach ($courses as $course_id) {
							echo $course_id;
							$sql = "INSERT INTO student_courses (student_id, course_id) VALUES ('$student_id', '$course_id')";
							mysqli_query($conn, $sql);
						}
					}
					echo "<script>alert('تمت إضافة الطالب بنجاح');</script>";
					echo "<script>window.location.href='new_acc.php';</script>";
				}else{
					echo "<script>alert('خطأ في اضافة الطالب');</script>";
			}
		}
		
	}
	

	if(isset($_POST['add_staff'])){
		$name = $_POST['name'];
		$lvl = $_POST['lvl'];
		$nat = $_POST['nat'];
		$id = $_POST['id'];
		$bd = $_POST['bd'];
//		$bloc = $_POST['bloc'];
		$enrollDate = $_POST['enroll_date'];
		$phone = $_POST['phone'];
		$extraphone = $_POST['extraphone'];
		$loc = $_POST['loc'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		if (isset($_POST['istemp'])) {
			// Checkbox was checked
			$istemp = $_POST['istemp'];
		} else {
			// Checkbox was not checked
			$istemp = '';
		}

		// Adding personal image
		$currentDirectory = getcwd();
		$uploadDirectory = "/imgs/";
      
        $errors = []; // Store errors here
      
        $fileExtensionsAllowed = ['jpeg','jpg','png','gif']; // These will be the only file extensions allowed 
      
        $fileName = $_FILES['file']['name']; // The original name of the file on the client machine.
        $fileSize = $_FILES['file']['size'];
        $fileTmpName  = $_FILES['file']['tmp_name']; // The temporary filename of the file in which the uploaded file was stored on the server.

      
        $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);  // basename Return filename from the specified path:
      
        $db_path = $uploadDirectory . basename($fileName);
        $filename = $_FILES['file']['name'];
      
        // if (! in_array($fileExtension,$fileExtensionsAllowed)) { // search for the file extention in the given array
        //     $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        // }
          
        if ($fileSize > 40000000) {
            $errors[] = "File exceeds maximum size (4MB)";
        }
		$didUpload = move_uploaded_file($fileTmpName, $uploadPath); // moves an uploaded file to a new destination
          
		$sql = "INSERT INTO `staff`(`staff_name`, `staff_nat`, `staff_id_num`, `staff_birthday`, `staff_lvl`, `staff_enroll`, `staff_phone`, `staff_extraphone`, `staff_address`, `staff_job`,`email`, `pass`,`istemp`) VALUES
									('".$name."','".$nat."','".$id."','".$bd."','".$lvl."','".$enrollDate."','".$phone."','".$extraphone."','".$loc."','JOB_03','".$email."','".$pass."','".$istemp."')";
			

        if ($didUpload) {
            $img = basename($fileName);
			$sql = "INSERT INTO `staff`(`staff_name`, `staff_nat`, `staff_id_num`, `staff_birthday`, `staff_lvl`, `staff_enroll`, `staff_phone`, `staff_extraphone`, `staff_address`, `staff_job`, `staff_profile`, `email`, `pass`,`istemp`) VALUES
										 ('".$name."','".$nat."','".$id."','".$bd."','".$lvl."','".$enrollDate."','".$phone."','".$extraphone."','".$loc."','JOB_03','".$img."','".$email."','".$pass."','".$istemp."')";
		}

			$result = mysqli_query($conn,$sql);
			echo mysqli_error($conn);
			if($result){
				echo "<script>alert('تمت إضافة المعلم بنجاح');</script>";
				echo "<script>window.location.href='new_acc.php';</script>";
			}else{
				echo "<script>alert('NOt');</script>";
			}
		}
	if(isset($_POST['add_manager'])){
		$name = $_POST['name'];
		$lvl = $_POST['lvl'];
		$nat = $_POST['nat'];
		$id = $_POST['id'];
		$bd = $_POST['bd'];
//		$bloc = $_POST['bloc'];
		$enrollDate = $_POST['enroll_date'];
		$phone = $_POST['phone'];
		$extraphone = $_POST['extraphone'];
		$loc = $_POST['loc'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];

		// Adding personal image
		$currentDirectory = getcwd();
		$uploadDirectory = "/imgs/";
      
        $errors = []; // Store errors here
      
        $fileExtensionsAllowed = ['jpeg','jpg','png','gif']; // These will be the only file extensions allowed 
      
        $fileName = $_FILES['file']['name']; // The original name of the file on the client machine.
        $fileSize = $_FILES['file']['size'];
        $fileTmpName  = $_FILES['file']['tmp_name']; // The temporary filename of the file in which the uploaded file was stored on the server.

      
        $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);  // basename Return filename from the specified path:
      
        $db_path = $uploadDirectory . basename($fileName);
        $filename = $_FILES['file']['name'];
      
        // if (! in_array($fileExtension,$fileExtensionsAllowed)) { // search for the file extention in the given array
        //     $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        // }
          
        if ($fileSize > 40000000) {
            $errors[] = "File exceeds maximum size (4MB)";
        }
		$didUpload = move_uploaded_file($fileTmpName, $uploadPath); // moves an uploaded file to a new destination

		$sql = "INSERT INTO `staff`(`staff_name`, `staff_nat`, `staff_id_num`, `staff_birthday`, `staff_lvl`, `staff_enroll`, `staff_phone`, `staff_extraphone`, `staff_address`, `staff_job`, `email`, `pass`) VALUES
		('".$name."','".$nat."','".$id."','".$bd."','".$lvl."','".$enrollDate."','".$phone."','".$extraphone."','".$loc."','JOB_02','".$email."','".$pass."')";

        if ($didUpload) {
            $img = basename($fileName);
			$sql = "INSERT INTO `staff`(`staff_name`, `staff_nat`, `staff_id_num`, `staff_birthday`, `staff_lvl`, `staff_enroll`, `staff_phone`, `staff_extraphone`, `staff_address`, `staff_job`, `staff_profile`, `email`, `pass`) VALUES
			('".$name."','".$nat."','".$id."','".$bd."','".$lvl."','".$enrollDate."','".$phone."','".$extraphone."','".$loc."','JOB_02','".$img."','".$email."','".$pass."')";
		}
			$sql = "INSERT INTO `staff`(`staff_name`, `staff_nat`, `staff_id_num`, `staff_birthday`, `staff_lvl`, `staff_enroll`, `staff_phone`, `staff_extraphone`, `staff_address`, `staff_job`, `staff_profile`, `email`, `pass`) VALUES
										 ('".$name."','".$nat."','".$id."','".$bd."','".$lvl."','".$enrollDate."','".$phone."','".$extraphone."','".$loc."','JOB_02','".$img."','".$email."','".$pass."')";
			$result = mysqli_query($conn,$sql);

			if($result){
				echo "<script>alert('تمت إضافة الإداري بنجاح');</script>";
				echo "<script>window.location.href='new_acc.php';</script>";
			}else{
				echo "<script>alert('ERROR');</script>";
			}
		}
	
	//Visitor
	if(isset($_POST['add_visitor'])){
		if(isset($_POST['name']) and isset($_POST['id']) and isset($_POST['pass'])){	
			$name = $_POST['name'];
			$pass = $_POST['pass'];
			$id = $_POST['id'];
			$sql = "INSERT INTO `staff`(`staff_name`, `staff_nat`, `staff_id_num`, `staff_birthday`, `staff_lvl`, `staff_enroll`, `staff_phone`, `staff_extraphone`, `staff_address`, `staff_job`, `staff_profile`, `email`, `pass`) VALUES
										 ('".$name."','N/A','".$id."','0000-00-00','N/A','0000-00-00','N/A','N/A','N/A','JOB_04','N/A','N/A','".$pass."')";
			$result = mysqli_query($conn,$sql);
			if($result){
				echo "<script>alert('تمت إضافة الزائر بنجاح');</script>";
				echo "<script>window.location.href='new_acc.php';</script>";
			}else{
				echo mysqli_error($conn);
				echo "<script>alert('ERROR');</script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>صفحة المسؤول </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<?php
		if($_SESSION['community'] == "4"){
			echo '<link rel="stylesheet" href="./style2.css?v=8">';
		}else{
			echo '<link rel="stylesheet" href="./style.css?v=8">';
		}
	?>
	

</head>
<body>
<!-- partial:index.partial.html -->
<header class="header">

	<div class="header-content responsive-wrapper">
		<div class="header-logo">
			<div class="b_con"><button class="l-button">القائمة</button></div>

			<div class="list">
					<?php if($_SESSION['staff_job'] == "JOB_02" or $_SESSION['staff_job'] == "JOB_03"){?>
						<a href="staff_acc.php" class="active">الصفحة الشخصية</a>
					<?php } ?>
					<a href="new_acc.php" class="active">إضافة حساب</a>
					<?php if($_SESSION['staff_job'] == "JOB_01"){?>
						
					<?php } ?>
					
					<?php
						$sql = "SELECT * FROM std_exc WHERE seen = 0";
						$sql2 = "SELECT * FROM pending_std WHERE seen = 0"; 
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0  or mysqli_num_rows(mysqli_query($conn,$sql2)) > 0) and $_SESSION['staff_job'] == 'JOB_01'){
					?>
						<a href="std_management.php" style="background-color:darkred; color:white;">إدارة الطلاب</a>
					<?php }else{?>
						<a href="std_management.php">إدارة الطلاب</a>
					<?php } ?>
						<?php if($_SESSION['staff_job'] != "JOB_03"){?>
							<a href="staff_management.php">إدارة المعلمين</a>
						<?php } ?>
						<?php if($_SESSION['staff_job'] == "JOB_01"){?>
							<a href="man_man.php">إدارة الإداريين</a>
						<?php } ?>
						<?php
						$sql = "SELECT * FROM pending_parent WHERE seen = 0";
						if(mysqli_num_rows(mysqli_query($conn,$sql)) > 0 and ($_SESSION['staff_job'] == 'JOB_01' and $_SESSION['staff_job'] == 'JOB_02') ){
					?>
					<a href="parents_man.php" style="background-color:darkred; color:white;">إدارة أولياء الأمور</a>
					<?php }else{?>
					<a href="parents_man.php">إدارة أولياء الأمور</a>
					<?php } ?>
						<a href="ring_man.php">إدارة الحلقات  التسميع</a>
					<a href="tasheeh_man.php">حلقة تصحيح التلاوة</a>
						
						<a href="mton_man.php">إدارة المتون</a>
						<a href="course_man.php" >إدارة الدورات</a>
						<?php if($_SESSION['staff_job'] != "JOB_03"){?>
							<a href="prize_man.php">إدارة الجوائز</a>
						<?php } ?>
						<?php
							if($_SESSION['staff_job'] == 'JOB_01'){
								echo '<a href="homepage_man.php">إدارة الصفحة الرئيسية</a>
										<a href="message_details.php" target="_blank">عرض الرسائل</a>';
							}
						?>
						<a href="change_pwd.php">تغيير كلمة المرور</a>
						<?php
							if($_SESSION['staff_job'] == 'JOB_01'){
								echo '<a href="send_msg.php">إرسال رسالة</a>';
							echo '<a href=" visitor_man.php">إدارة الزوار</a>';
							}else{
								echo '<a href="my_msgs.php" target="_blank">عرض رسائلي</a>';
							}
						?></br></br>
			<div style="margin-bottom: 100px;">
					</div>
</div>
		</div>
		<div class="header-navigation">
			
			<nav class="header-navigation-links">

				<?php
					include('headerlogo.php');
				?>
				
				
				
				
				
			</nav>
			
		</div>
	</div>
</header>
<main class="main">
	<div class="responsive-wrapper">
		

		<div class="content-header">
			
			<div class="content-header-intro">
				<?php if($_SESSION['staff_job'] == 'JOB_01' or $_SESSION['staff_job'] == 'JOB_02' or $_SESSION['staff_job'] == 'JOB_03'){
					$sql = "SELECT staff_name FROM staff WHERE staff_id = '".$_SESSION['email']."'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
					echo '<div class="main-header"><h1>'.$row['staff_name'].'</h1></div>';
				}?>
			<?php if($_SESSION['staff_job'] != "JOB_03"){?>
				<h2>إضافة و تعديل جميع البيانات</h2>
				
			<?php }else{?>
				<h2>الوصول للحسابات مصرح للمدير و الإداريين فقط</h2>
			<?php } ?>
			</div>
		</div>
		<div class="content">
		
			<div class="content-panel">
				
				<div class="vertical-tabs">
					<?php if($_SESSION['staff_job'] == "JOB_02" or $_SESSION['staff_job'] == "JOB_03"){?>
						<a href="staff_acc.php" class="active">الصفحة الشخصية</a>
					<?php } ?>
					<a href="new_acc.php" class="active">إضافة حساب</a>
					<?php if($_SESSION['staff_job'] == "JOB_01"){?>
						
					<?php } ?>
					<?php
						$sql = "SELECT * FROM std_exc WHERE seen = 0";
						$sql2 = "SELECT * FROM pending_std WHERE seen = 0"; 
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0  or mysqli_num_rows(mysqli_query($conn,$sql2)) > 0) and $_SESSION['staff_job'] == 'JOB_01'){
					?>
						<a href="std_management.php" style="background-color:darkred; color:white;">إدارة الطلاب</a>
					<?php }else{?>
						<a href="std_management.php">إدارة الطلاب</a>
					<?php } ?>
					<?php if($_SESSION['staff_job'] != "JOB_03"){?>
					<a href="staff_management.php">إدارة المعلمين</a>
					<?php } ?>
					<?php if($_SESSION['staff_job'] == "JOB_01"){?>
						<a href="man_man.php">إدارة الإداريين</a>
					<?php } ?>
					<?php
						$sql = "SELECT * FROM pending_parent WHERE seen = 0";
						if(mysqli_num_rows(mysqli_query($conn,$sql)) > 0 and ($_SESSION['staff_job'] == 'JOB_01' and $_SESSION['staff_job'] == 'JOB_02') ){
					?>
					<a href="parents_man.php" style="background-color:darkred; color:white;">إدارة أولياء الأمور</a>
					<?php }else{?>
					<a href="parents_man.php">إدارة أولياء الأمور</a>
					<?php } ?>
					<a href="ring_man.php">إدارة الحلقات  التسميع</a>
					<a href="tasheeh_man.php">حلقة تصحيح التلاوة</a>
					
					<a href="mton_man.php">إدارة المتون</a>
					<a href="course_man.php" >إدارة الدورات</a>
					<?php if($_SESSION['staff_job'] != "JOB_03"){?>
					<a href="prize_man.php">إدارة الجوائز</a>
					<?php } ?>
					<?php
						if($_SESSION['staff_job'] == 'JOB_01'){
							echo '<a href="homepage_man.php">إدارة الصفحة الرئيسية</a>
									<a href="message_details.php" target="_blank">عرض الرسائل</a>';
						}
					?>
					<a href="change_pwd.php">تغيير كلمة المرور</a>
					<?php
						if($_SESSION['staff_job'] == 'JOB_01'){
							echo '<a href="send_msg.php">إرسال رسالة</a>';
							echo '<a href=" visitor_man.php">إدارة الزوار</a>';
						}else{
							echo '<a href="my_msgs.php" target="_blank">عرض رسائلي</a>';
						}
					?></br></br></br></br></br></br></br></br></br></br></br></br></br>
				</div>
			</div>
			<div class="content-main" style="width:600px;">
				<?php if($_SESSION['staff_job'] != "JOB_03"){?>
				<center style="margin-bottom:20px;"><a href="new_acc.php" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
					<?php if(isset($_GET['type'])) { if($_GET['type'] == 'std'){ ?>
						<article class="card">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/student.png"/></span>
									<h3>إضافة طالب</h3>
								</div>
							</div>
							<div class="card-body">
								<form class="login-form" action="new_acc.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
									<input type="text" placeholder="اسم الطالب" name="name" id="name" />
									<span id="name_error" style="color: red;"></span>
									<input type="text" placeholder="المرحلة الدراسية" name="lvl" id="lvl" />
									<span id="lvl_error" style="color: red;"></span>
									<input type="text" placeholder="الجنسية" name="nat" id="nat" />
									<span id="nat_error" style="color: red;"></span>
									<input type="text" placeholder="رقم الهوية" name="id" id="id" />
									<span id="id_error" style="color: red;"></span>
									<p style="font-size: 12px;width: 100%;">تاريخ الميلاد : </p>
									<input type="date" placeholder="تاريخ الميلاد" name="bd" id="bd" />
									<span id="bd_error" style="color: red;"></span>
									<input type="text" placeholder="مكان الميلاد" name="bloc" id="bloc" />
									<span id="bloc_error" style="color: red;"></span>
									<p style="font-size: 12px;width: 100%;">تاريخ الالتحاق بالمجمع : </p>
									<input type="date" placeholder="تاريخ الالتحاق بالمجمع" name="enrolldate" id="enrolldate" />
									<span id="enrolldate_error" style="color: red;"></span>
									<input type="text" placeholder="رقم الجوال" name="phone" id="phone" />
									<span id="phone_error" style="color: red;"></span>
									<label style="width:auto;margin:10px 0;padding:20px;">
										<input style="width:auto;margin:0p;padding:20px;" type="checkbox" name="pRequired" value="YES">
										يحتاج ولي أمر
									</label>
									<input type="text" placeholder="آخر سورة يحفظها" name="last_sorah" id="last_sorah" />
									<input type="text" placeholder="الأجزاء التي تم اختبارها" name="tested" id="tested" />
									<p style="font-size: 12px;width: 100%;">الصورة الشخصية : </p>
									<input type="file" name="file" id="file" />
									<input type="text" placeholder="الإيميل" name="email" id="email" />
									<input type="password" placeholder="كلمة المرور" name="pass" id="pass" />
									<span id="pass_error" style="color: red;"></span>
									<button type="submit" name="add_std">إضافة</button>
								</form>
							</div>
						</article>

					<?php }?>

					<?php if($_GET['type'] == 'teacher'){ ?>
						<article class="card">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/adult.png" /></span>
									<h3>إضافة معلم</h3>
								</div>
							</div>
							<div class="card-body">
								<form class="login-form" action="new_acc.php" method="post" enctype="multipart/form-data">
									<input type="text" placeholder="الاسم" name="name"/>
									<input type="text" placeholder="الجنسية" name="nat"/>
									<input type="text" placeholder="رقم الهوية" name="id"/>
									<p style="font-size: 12px;width: 100%;">تاريخ الميلاد : </p>
									<input type="date" placeholder="تاريخ الميلاد" name="bd"/>
									<input type="text" placeholder="المستوى العلمي" name="lvl"/>
									<p style="font-size: 12px;width: 100%;">تاريخ الالتحاق بالمجمع : </p>
									<input type="date" placeholder="تاريخ الالتحاق بالمجمع" name="enroll_date"/>
									<input type="text" placeholder="رقم جوال" name="phone"/>
									<input type="text" placeholder="جوال إضافي" name="extraphone"/>
									<input type="text" placeholder="مكان السكن" name="loc"/>
									<p style="font-size: 12px;width: 100%;">الصورة الشخصية : </p>
									<label style = "width:auto;margin:0p;padding:20px;">
										<input style = "width:auto;margin:0p;padding:20px;" type="checkbox" name="istemp" value="محتسب">
										محتسب
									</label>
									<input type="file" placeholder="الصورة الشخصية" name="file"/>
									<input type="text" placeholder="الإيميل" name="email"/>
									<input type="password" placeholder="كلمة المرور" name="pass"/>
									<button type="submit" name="add_staff">إضافة</button>
								</form>
							</div>
						</article>
					<?php }?>

					<?php if($_GET['type'] == 'manager'){ ?>
						<article class="card">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/man.png" /></span>
									<h3>إضافة إداري</h3>
								</div>
							</div>
							<div class="card-body">
								<form class="login-form" action="new_acc.php" method="post" enctype="multipart/form-data">
									<input type="text" placeholder="الاسم" name="name"/>
									<input type="text" placeholder="الجنسية" name="nat"/>
									<input type="text" placeholder="رقم الهوية" name="id"/>
									<p style="font-size: 12px;width: 100%;">تاريخ الميلاد : </p>
									<input type="date" placeholder="تاريخ الميلاد" name="bd"/>
									<input type="text" placeholder="المستوى العلمي" name="lvl"/>
									<p style="font-size: 12px;width: 100%;">تاريخ الالتحاق بالمجمع : </p>
									<input type="date" placeholder="تاريخ الالتحاق بالمجمع" name="enroll_date"/>
									<input type="text" placeholder="رقم جوال" name="phone"/>
									<input type="text" placeholder="جوال إضافي" name="extraphone"/>
									<input type="text" placeholder="مكان السكن" name="loc"/>
									<p style="font-size: 12px;width: 100%;">الصورة الشخصية : </p>
									<input type="file" placeholder="الصورة الشخصية" name="file"/>
									<input type="text" placeholder="الإيميل" name="email"/>
									<input type="password" placeholder="كلمة المرور" name="pass"/>
									<button type="submit" name="add_manager">إضافة</button>
								</form>
							</div>
						</article>
					<?php }?>

					<?php if($_GET['type'] == 'visitor'){ ?>
						<article class="card">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/visit.png" /></span>
									<h3>إضافة زائر</h3>
								</div>
							</div>
							<div class="card-body">
								<form class="login-form" action="new_acc.php" method="post" enctype="multipart/form-data">
									<input type="text" placeholder="الاسم" name="name"/>
									<input type="text" placeholder="رقم الهاتف" name="id"/>
									<input type="password" placeholder="كلمة المرور" name="pass"/>
									<button type="submit" name="add_visitor">إضافة</button>
								</form>
							</div>
						</article>	
					<?php }?>


					<?php }else{?>
					<?php 
						if($_SESSION['staff_job'] == 'JOB_02'){
					?>
					<a href="new_acc.php?type=std&waiting=1" class="new_card" style="height: 100px;">
						<article class="card">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/student.png"/></span>
									<h3>إضافة طالب</h3>
								</div>
							</div>
							<div class="card-body">
							</div>
						</article>
					</a>
					<?php 
						}else{
					?>
					<a href="new_acc.php?type=std" class="new_card">
						<article class="card">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/student.png"/></span>
									<h3>إضافة طالب</h3>
								</div>
							</div>
							<div class="card-body">
							</div>
						</article>
					</a>
					<?php 
						}
					?>
					
					<?php 
						if($_SESSION['staff_job'] == 'JOB_02'){
					?>
					<a href="new_parent.php?waiting=1" class="new_card" style="">
						<article class="card">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/adult.png"/></span>
									<h3>إضافة ولي أمر</h3>
								</div>
							</div>
							<div class="card-body">
							</div>
						</article>
					</a>
					<?php } ?>
					<?php 
						if($_SESSION['staff_job'] == 'JOB_01'){
					?>
					<a href="new_acc.php?type=teacher" class="new_card" style=";">
						<article class="card">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/parent.png"/></span>
									<h3>إضافة معلم</h3>
								</div>
							</div>
							<div class="card-body">
							</div>
						</article>
					</a>		
					<a href="new_acc.php?type=manager" class="new_card" style="">
						<article class="card">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/man.png"/></span>
									<h3>إضافة إداري</h3>
								</div>
							</div>
							<div class="card-body">
							</div>
						</article>
					</a>
					<a href="new_acc.php?type=visitor" class="new_card" style="">
						<article class="card">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/visit.png"/></span>
									<h3>إضافة زائر</h3>
								</div>
							</div>
							<div class="card-body">
							</div>
						</article>
					</a>
					<?php } ?>
					<?php } ?>
					
				</div>
				<?php } ?>
			</div>
			
		</div>
	</div>
</main>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script>
  <script  src="./script.js"></script>
  <script>
	var button = document.querySelector('.l-button');
	var list = document.querySelector('.list');

	button.addEventListener('click', function() {
	list.classList.toggle('show');
	});

	var header = document.querySelector('.header');
	var nav = document.querySelector('.vertical-tabs');

	window.addEventListener('scroll', function() {
	var headerHeight = header.offsetHeight;
	var scrollTop = window.scrollY;

	if (scrollTop > headerHeight) {
		nav.style.top = 90+'px';
	} else {
		nav.style.top = headerHeight - scrollTop +192+ 'px';
	}
	});
	document.addEventListener('click', function(event) {
		if (!list.contains(event.target) && !button.contains(event.target)) {
			list.classList.remove('show');
		}
	});

  </script>
		<script>
			function validateForm() {
				var name = document.getElementById("name").value;
				var lvl = document.getElementById("lvl").value;
				var nat = document.getElementById("nat").value;
				var id = document.getElementById("id").value;
				var bd = document.getElementById("bd").value;
				var bloc = document.getElementById("bloc").value;
				var enrolldate = document.getElementById("enrolldate").value;
				var phone = document.getElementById("phone").value;
				var last_sorah = document.getElementById("last_sorah").value;
				var tested = document.getElementById("tested").value;
				var email = document.getElementById("email").value;
				var pass = document.getElementById("pass").value;
				var error = "";

				if (name === "") {
					error += "يرجى إدخال اسم الطالب\n";
					document.getElementById("name_error").innerHTML = "يرجى إدخال اسم الطالب";
				} else {
					document.getElementById("name_error").innerHTML = "";
				}

				if (lvl === "") {
					error += "يرجى إدخال المرحلة الدراسية\n";
					document.getElementById("lvl_error").innerHTML = "يرجى إدخال المرحلة الدراسية";
				} else {
					document.getElementById("lvl_error").innerHTML = "";
				}

				if (nat === "") {
					error += "يرجى إدخال الجنسية\n";
					document.getElementById("nat_error").innerHTML = "يرجى إدخال الجنسية";
				} else {
					document.getElementById("nat_error").innerHTML = "";
				}

				if (id === "") {
					error += "يرجى إدخال رقم الهوية\n";
					document.getElementById("id_error").innerHTML = "يرجى إدخال رقم الهوية";
				} else {
					document.getElementById("id_error").innerHTML = "";
				}

				if (bd === "") {
					error += "يرجى إدخال تاريخ الميلاد\n";
					document.getElementById("bd_error").innerHTML = "يرجى إدخال تاريخ الميلاد";
				} else {
					document.getElementById("bd_error").innerHTML = "";
				}

				if (bloc === "") {
					error += "يرجى إدخال مكان الميلاد\n";
					document.getElementById("bloc_error").innerHTML = "يرجى إدخال مكان الميلاد";
				} else {
					document.getElementById("bloc_error").innerHTML = "";
				}

				if (enrolldate === "") {
					error += "يرجى إدخال تاريخ الالتحاق بالمجمع\n";
					document.getElementById("enrolldate_error").innerHTML = "يرجى إدخال تاريخ الالتحاق بالمجمع";
				} else {
					document.getElementById("enrolldate_error").innerHTML = "";
				}

				if (pass === "") {
					error += "يرجى إدخال كلمة المرور\n";
					document.getElementById("pass_error").innerHTML = "يرجى إدخال كلمة المرور";
				} else {
					document.getElementById("pass_error").innerHTML = "";
				}

				if (error !== "") {
					//alert(error);
					return false;
				}
			}
			</script>						
</body>
<script>
		function confirmLogOut() {
			if (confirm("هل أنت متأكد من تسجيل الخروج ؟")) {
				return true;
			} else {
				return false;
			}
		}
	</script>
</html>
