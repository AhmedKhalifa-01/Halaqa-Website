<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
			echo "<script>window.location.href='index.php';</script>";
		}
		
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}

/* adding new accout */

	

?>

<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>تعديل تفاصيل الطالب</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<?php
		if($_SESSION['community'] == "4"){
			echo '<link rel="stylesheet" href="./style2.css?v=8">';
		}else{
			echo '<link rel="stylesheet" href="./style.css?v=8">';
		}
	?>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<!-- partial:index.partial.html -->
<header class="header">
	<div class="header-content responsive-wrapper">
	<div class="header-logo">
			<div class="b_con"><button class="l-button">القائمة</button></div>

			<div class="list">
			<a href="new_acc.php">إضافة حساب</a>
					<?php if($_SESSION['staff_job'] == "JOB_01"){?>
						
					<?php } ?>
					<?php
						$sql = "SELECT * FROM std_exc WHERE seen = 0";
						$sql2 = "SELECT * FROM pending_std WHERE seen = 0"; 
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0  or mysqli_num_rows(mysqli_query($conn,$sql2)) > 0) and $_SESSION['staff_job'] == 'JOB_01'){
					?>
						<a href="std_management.php" style="background-color:darkred; color:white;" class="active">إدارة الطلاب</a>
					<?php }else{?>
						<a href="std_management.php" class="active">إدارة الطلاب</a>
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
							echo '<a href="send_msg.php">إرسال رسالة</a>
							';
						}else{
							echo '<a href="my_msgs.php" target="_blank">عرض رسائلي</a>';
						}
					?>
			</br></br>
			<div style="margin-bottom: 100px;">
					</div>
</div>
		</div>
		<div class="header-navigation">
			<nav class="header-navigation-links">
			<?php
					include('headerlogo.php');
				?>
				
				
			<?php if($_SESSION['staff_job'] == 'JOB_04') {?>
				
				
						</div>
					<?php }else{ ?>
				
				
				<?php } ?>
				
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
				<h2>تعديل تفاصيل الطالب</h2>
				
			<?php }else{?>
				<h2>الوصول للحسابات مصرح للمدير و الإداريين فقط</h2>
			<?php } ?>
			</div>
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					<?php if($_SESSION['staff_job'] == "JOB_02" or $_SESSION['staff_job'] == "JOB_03"){?>
						<a href="staff_acc.php">الصفحة الشخصية</a>
					<?php } ?>
					<a href="new_acc.php">إضافة حساب</a>
					<?php
						$sql = "SELECT * FROM std_exc WHERE seen = 0";
						$sql2 = "SELECT * FROM pending_std WHERE seen = 0"; 
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0  or mysqli_num_rows(mysqli_query($conn,$sql2)) > 0) and $_SESSION['staff_job'] == 'JOB_01'){
					?>
						<a href="std_management.php" style="background-color:darkred; color:white;" class="active">إدارة الطلاب</a>
					<?php }else{?>
						<a href="std_management.php" class="active">إدارة الطلاب</a>
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
					?>
					<div style="margin-bottom: 400px;">
					</div>
				</div>
			</div>
			<div class="content-main">
				<?php if($_SESSION['staff_job'] != "JOB_03"){
					$sql = "SELECT * FROM students WHERE std_id = '".$_GET['std_id']."'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
				?>
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/student.png"/></span>
								<h3>تعديل بيانات طالب</h3>
							</div>
						</div>
						<div class="card-body">
							<form class="login-form" action="std_adjust_details.php?std_id=<?php echo $row['std_id']; ?>" method="post" enctype="multipart/form-data">
								<p style="font-size: 12px;width: 100%;">اسم الطالب : </p>
								<input type="text" placeholder="اسم الطالب" name="name" value="<?php echo $row['std_name']; ?>"/>
								<p style="font-size: 12px;width: 100%;">المرحلة الدراسية : </p>
								<input type="text" placeholder="المرحلة الدراسية" name="lvl" value="<?php echo $row['std_lvl']; ?>"/>
								<p style="font-size: 12px;width: 100%;">الجنسية : </p>
								<input type="text" placeholder="الجنسية" name="nat" value="<?php echo $row['std_nat']; ?>"/>
								<p style="font-size: 12px;width: 100%;">رقم الهوية : </p>
								<input type="text" placeholder="رقم الهوية" name="id" value="<?php echo $row['std_id_num']; ?>"/>
								<p style="font-size: 12px;width: 100%;">تاريخ الميلاد : </p>
								<input type="date" placeholder="تاريخ الميلاد" name="bd" value="<?php echo $row['std_birth_date']; ?>"/>
								<p style="font-size: 12px;width: 100%;">مكان الميلاد : </p>
								<input type="text" placeholder="مكان الميلاد" name="bloc" value="<?php echo $row['std_birth_loc']; ?>"/>
								<p style="font-size: 12px;width: 100%;">تاريخ الالتحاق بالمجمع : </p>
								<input type="date" placeholder="تاريخ الالتحاق بالمجمع" name="enrolldate" value="<?php echo $row['std_enroll_date']; ?>"/>
								<p style="font-size: 12px;width: 100%;">رقم الهاتف : </p>
								<input type="text" placeholder="رقم الجوال" name="phone" value="<?php echo $row['std_phone']; ?>"/>
								<label style = "width:auto;margin:0p;padding:20px;">
									<?php
										//if($row['staff_job'] == 'JOB_03'){
											$sql = "SELECT pRequired From students WHERE std_id = '".$_GET['std_id']."'";
											$isTempRes = mysqli_query($conn,$sql);
											$isTempRow = mysqli_fetch_assoc($isTempRes);
											if($isTempRow['pRequired'] == 'YES'){
												echo '<input style = "width:auto;margin:0p;padding:20px;" type="checkbox" checked name="pRequired" value="YES">';
											}else{
												echo '<input style = "width:auto;margin:0p;padding:20px;" type="checkbox" name="pRequired" value="YES">';
											}
										
											echo 'يحتاج ولي أمر
										</label>';
										//}
								?>
								<p style="font-size: 12px;width: 100%;">آخر سورة يحفظها : </p>
								<input type="text" placeholder="آخر سورة يحفظها" name="last_sorah" value="<?php echo $row['std_last_sorah']; ?>"/>
								<p style="font-size: 12px;width: 100%;">الأجزاء التي تم اختبارها : </p>
								<input type="text" placeholder="الأجزاء التي تم اختبارها" name="tested" value="<?php echo $row['std_tested']; ?>"/>
								<p style="font-size: 12px;width: 100%;">الصورة الشخصية : </p>
								<input type="file" name="file" value="<?php echo $row['std_profile']; ?>"/>
								<p style="font-size: 12px;width: 100%;">الإيميل : </p>
								<input type="text" placeholder="الإيميل" name="email" value="<?php echo $row['email']; ?>"/>
								<p style="font-size: 12px;width: 100%;">كلمة المرور : </p>
								<input type="password" placeholder="كلمة المرور" name="pass" value="<?php echo $row['pass']; ?>"/>
								<button type="submit" name="add_std">تعديل</button>
							  </form>
						</div>
					</article>						
				</div>
				<?php } ?>
			</div>
			
		</div>
	</div>
</main>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
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
<?php
if(isset($_POST['add_std'])){
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

	// checking if the user selected a file
	if($fileName == ""){
		$sql = "SELECT std_profile FROM students WHERE std_id='".$_GET['std_id']."'";
		$img = mysqli_fetch_assoc(mysqli_query($conn,$sql))['std_profile'];
	}
	else{
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
		if ($didUpload) {
			$img = basename($fileName);
		}
	}
	$state = mysqli_fetch_assoc(mysqli_query($conn,"SELECT state FROM students WHERE std_id = '".$_GET['std_id']."'"))['state'];
	$sql = "UPDATE students 
			SET std_name = '".$name."', 
				std_lvl = '".$lvl."', 
				std_nat = '".$nat."', 
				std_id_num = '".$id."', 
				std_birth_date = '".$bd."', 
				std_birth_loc = '".$bloc."', 
				std_enroll_date = '".$enrollDate."', 
				std_phone = '".$phone."', 
				std_last_sorah = '".$last_sorah."', 
				std_tested = '".$tested."', 
				std_profile = '".$img."', 
				email = '".$email."', 
				pass = '".$pass."', 
				std_v_mem = '".$tested."', 
				state = '".$state."',
				pRequired = '".$pRequired."'  
				WHERE std_id = '".$_GET['std_id']."'";
	
		$result = mysqli_query($conn,$sql);
		$student_id = mysqli_insert_id($conn);
		if($result){
			//Clearing old courses
			$sqlRemoveCourses = "DELETE FROM student_courses WHERE student_id = '".$_GET['std_id']."'";
			mysqli_query($conn,$sqlRemoveCourses);
			if (!empty($courses) and $courses != "لا يوجد") {
				foreach ($courses as $course_id) {
					$sql = "INSERT INTO student_courses (student_id, course_id) VALUES ('".$_GET['std_id']."', '$course_id')";
					mysqli_query($conn, $sql);
				}
			}
			echo "<script>alert('تمت تعديل بيانات الطالب بنجاح');</script>";
			echo mysqli_error($conn);
			echo "<script>window.location.href='std_management.php';</script>";

		}else{
			echo "<script>alert('خطأ في تعديل البيانات');</script>";
			echo mysqli_error($conn);
		}
	}
?>