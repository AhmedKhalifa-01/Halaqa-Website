<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
			if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
				//if($_SESSION['staff_job'] != 'JOB_03'){
					echo "<script>window.location.href='index.php';</script>";
				//}
			}			
		}else{
			echo "<script>window.location.href='index.php';</script>";
		}

/* adding new ring */

	if(isset($_POST['add_ring'])){
		$ring_name = $_POST['ring_name'];
		$ring_man = $_POST['ring_man'];		
		if(isset($_POST['students'])){
			$students = $_POST['students'];
		}
		if(isset($_POST['staff'])){
			$staff = $_POST['staff'];
		}
		
		if (!empty($students) and !empty($staff)) {
			// Insert the new ring into the rings table
			$sql = "INSERT INTO mton_ring (mton_ring_name, mton_ring_staff_man) VALUES ('".$ring_name."','".$ring_man."')";
			if(mysqli_query($conn,$sql)){

				// Get the ring_id of the newly inserted ring
				$ringId = $conn->insert_id;

				foreach ($staff as $st) {
					$sql = "INSERT INTO `mton_ring_teacher`(`mton_ring_id`, `staff_id`) VALUES ('".$ringId."','".$st."')";
					mysqli_query($conn,$sql);
				}

				//Update the ring_id column for each selected student
				foreach ($students as $std_id) {
					$sql = "SELECT std_name,mton_ring_id,mton_ring_id_02,mton_ring_id_03 FROM students WHERE std_id = ".$std_id."";
					$res = mysqli_query($conn,$sql);
					if(mysqli_fetch_assoc($res)['mton_ring_id'] == 0){
						$sql = "UPDATE students SET mton_ring_id = '".$ringId."', mton_ring_temp_id = '".$ringId."' WHERE std_id = '".$std_id."'";
						mysqli_query($conn,$sql);
					}else if(mysqli_fetch_assoc($res)['mton_ring_id_02'] == 0){
						$sql = "UPDATE students SET mton_ring_id_02 = '".$ringId."', mton_ring_temp_id_02 = '".$ringId."' WHERE std_id = '".$std_id."'";
						mysqli_query($conn,$sql);
					}else if(mysqli_fetch_assoc($res)['mton_ring_id_03'] == 0){
						$sql = "UPDATE students SET mton_ring_id_03 = '".$ringId."', mton_ring_temp_id_03 = '".$ringId."' WHERE std_id = '".$std_id."'";
						mysqli_query($conn,$sql);
					}else{
						echo "<script>alert('تجاوز الطالب : " . htmlspecialchars(json_encode(mysqli_fetch_assoc($res)['std_name']), ENT_QUOTES, 'UTF-8') . " العدد الاقصى من الحلقات للتسجيل فيها');</script>";
					}
				}
				echo "<script>alert('تمت إضافة حلقة المتون بنجاح');</script>";
				echo "<script>window.location.href='ring_man.php';</script>";
			}
			
		}else{
			echo "<script>alert('الرجاء التاكد من اختيار معلم و مشرف و طالب على الاقل لاضافة الحلقة')</script>";
		}
	}

?>

<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إضافة حلقة متون جديدة </title>
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
			<?php if($_SESSION['staff_job'] == "JOB_02" or $_SESSION['staff_job'] == "JOB_03"){?>
					<a href="staff_acc.php">الصفحة الشخصية</a>
				<?php } ?>
			<?php if($_SESSION['staff_job'] != "JOB_03"){?>
					<a href="new_acc.php">إضافة حساب</a>
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
					<a href="staff_management.php">إدارة المعلمين</a>
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
					<?php } ?>
					<a href="ring_man.php">إدارة الحلقات  التسميع</a>
					<a href="tasheeh_man.php">حلقة تصحيح التلاوة</a>
					
					
					<a href="mton_man.php" class="active">إدارة المتون</a>
					<a href="course_man.php" >إدارة الدورات</a>
					<?php if($_SESSION['staff_job'] != "JOB_03"){?>
					<a href="prize_man.php">إدارة الجوائز</a>
					<?php } ?>					<?php
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
				<h2>إضافة حلقة جديدة</h2>
				
			</div>
			
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					<?php if($_SESSION['staff_job'] == "JOB_02" or $_SESSION['staff_job'] == "JOB_03"){?>
						<a href="staff_acc.php">الصفحة الشخصية</a>
					<?php } ?>
					<a href="new_acc.php">إضافة حساب</a>
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
					
					<a href="mton_man.php" class="active">إدارة المتون</a>
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
					?><div style="margin-bottom: 400px;">
					</div>
				</div>
			</div>
			<div class="content-main">
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/quran.png" /></span>
								<h3>إضافة حلقة متون جديدة</h3>
							</div>
						</div>
						<div class="card-body">
							<form class="login-form" action="new_mton_ring.php" method="post">
								<p>اسم الحلقة</p>
								<input type="text" placeholder="اسم الحلقة" name="ring_name">
								<p>اختر المشرف على الحلقة</p>
								<select name="ring_man" id="staff-select">
									<?php
										$sql = "SELECT * FROM staff WHERE staff_job = 'JOB_02' ORDER BY staff_name";
										$result = mysqli_query($conn,$sql);
										while($row = mysqli_fetch_assoc($result)){
											echo '
												<option value="'.$row['staff_id'].'" selected>'.$row['staff_name'].'</option>
											';
										}
									?>
								</select>
								<p>اختر معلم/ي الحلقة</p>
								<?php
										$sql = "SELECT * FROM staff WHERE staff_job != 'JOB_01' AND staff_job != 'JOB_02' AND staff_job != 'JOB_04' ORDER BY staff_name";
										$result = mysqli_query($conn,$sql);
										while($row = mysqli_fetch_assoc($result)){
											echo '<li style="list-decoration:none;"><input style="width:auto;margin:10px;" type="checkbox" name="staff[]" value="'. $row["staff_id"] .'">'. $row["staff_name"] .'</li>';
											/*echo '
												<option value="'.$row['staff_id'].'" selected>'.$row['staff_name'].'</option>
											';*/
										}
									?>
								<p>اختر الطلبة المشاركين في الحلقة : </p>
								<ul>
									<?php
									// Retrieve the list of students from the database
									$sql = "SELECT * FROM students WHERE state != 'مفصول' ORDER BY std_name";
									$result = mysqli_query($conn, $sql);
									echo mysqli_error($conn);
									// Display the list of students as checkboxes
									if(mysqli_num_rows($result) > 0) {
										while($row = mysqli_fetch_assoc($result)) {
											echo '<li><input style="width:auto;margin:10px;" type="checkbox" name="students[]" value="'. $row["std_id"] .'">'. $row["std_name"] .'</li>';
										}
										echo '<button type="submit" name="add_ring">إضافة</button>';
									} else {
										echo "لا يوجد طلبة لإضافتهم للحلقة.";
										echo '<button type="submit" name="add_ring">إضافة</button>';
									}
									?>
								</ul>
								
							  </form>
						</div>
					</article>					
				</div>
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
