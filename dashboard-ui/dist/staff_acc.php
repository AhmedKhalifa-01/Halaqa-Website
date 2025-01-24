<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "student")) {
		
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title><?php
						if($_SESSION['staff_job'] == 'student'){
							$sql = "SELECT std_name as name FROM students WHERE std_id = '".$_SESSION['email']."'";
						}
						if($_SESSION['staff_job'] == 'parent'){
							$sql = "SELECT p_name as name FROM parent WHERE p_name = '".$_SESSION['email']."'";
						}
						echo mysqli_fetch_assoc(mysqli_query($conn,$sql))['name'];
					?></title>
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
					<a href="staff_acc.php" class="active">الصفحة الشخصية</a>
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
					
					
					<a href="mton_man.php">إدارة المتون</a>
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
			</div>
		</div>
		<div class="content">
			<div class="content-panel">
			<div class="vertical-tabs">
				<?php if($_SESSION['staff_job'] == "JOB_02" or $_SESSION['staff_job'] == "JOB_03"){?>
					<a href="staff_acc.php" class="active">الصفحة الشخصية</a>
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
					
					
					<a href="mton_man.php">إدارة المتون</a>
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
			<div class="content-main">
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
					<?php
						$sql = "SELECT * FROM staff WHERE staff_id LIKE '".$_SESSION['email']."'";
						$result = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($result);
							echo '<article class="card">
									<div class="card-header">
										<div>
											<span style="width:100%;height:100%;"><img src="imgs/'.$row['staff_profile'].'" /></span>
											
										</div>
									</div>
									<div class="card-body">
										<p> الاسم : '.$row['staff_name'].'</p>										
										<p> الجنسية : '.$row['staff_nat'].'</p>
										<p> رقم الهوية : <color style= "color:red">'.$row['staff_id_num'].'</color></p>';
										if($_SESSION['staff_job'] == 'JOB_01'){
											echo '<p> كلمة المرور : <color style= "color:red">'.$row['pass'].'</color></p>';
										}
										echo '
										<p> تاريخ الميلاد : '.$row['staff_birthday'].'</p>
										<p> المستوى التعليمي : '.$row['staff_lvl'].'</p>
										<p> تاريخ الالتحاق بالمجمع : '.$row['staff_enroll'].'</p>
										<p> رقم الهاتف : '.$row['staff_phone'].'</p>
										<p> رقم هاتف إضافي : '.$row['staff_extraphone'].'</p>
										<p> العنوان : '.$row['staff_address'].'</p>';
										if($row['staff_job'] == 'JOB_02'){
											echo '<p> الوظيفية في المجمع : إداري</p>';
										}
										if($row['staff_job'] == 'JOB_03'){
											if($row['isTemp'] == 'محتسب'){
												echo '<p> الوظيفية في المجمع : معلم محتسب</p>';
											}else{
												echo '<p> الوظيفية في المجمع : معلم</p>';
											}
											
										}
										if($row['status'] == 'إجازة'){
											echo '<p>حالة الدوام : <color style="color:darkred;">في إجازة</color></p>';
										}else{
											echo '<p>حالة الدوام : <color style="color:darkgreen;">مداوم</color></p>';
										}
										echo '
										<p>الحلقات : </p>
										';
										$sql = "SELECT ring_name,ring_id FROM ring WHERE staff_id = '".$row['staff_id']."' GROUP BY ring_name";
										$re = mysqli_query($conn,$sql);
										if(mysqli_num_rows($re) > 0){
											echo '<ol style="list-style: arabic-indic;margin: -10px 50px 15px 0px;">';
											while($rrow = mysqli_fetch_assoc($re)){
												$sql = "SELECT COUNT(std_id) as co FROM staff 
												INNER JOIN ring ON ring.staff_id = staff.staff_id
												INNER JOIN students ON students.ring_id = ring.ring_id
												WHERE staff.staff_id = '".$row['staff_id']."' AND ring.ring_id = '".$rrow['ring_id']."'";
												$rees = mysqli_query($conn,$sql);
												
												echo '<li style="padding:5px;font-size: 15px;">'.$rrow['ring_name'].' - '.mysqli_fetch_assoc($rees)['co'].'</li>';
											}
											echo '</ol>';
										}
										
										echo '
										<p> الإيميل : '.$row['email'].'</p>
									</div>';
									if($_SESSION['staff_job'] == 'JOB_01'){
										echo '<div class="card-footer">
												<a href="del_acc.php?type=1&id='.$row['staff_id'].'" onclick="return confirmDelete()">حذف الحساب</a>
											</div>';
									}
									echo '
									
								</article>
							';
						
					?>
				</div>
			</div>
		</div>
	</div>
</main>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
  <script>
		setInterval(function() {
			var xhr = new XMLHttpRequest();
			xhr.open('GET', 'check_activity.php', true);
			xhr.send();
		}, 6000); // 1 minute interval
	</script>
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
<!-- Include your JavaScript code -->

<script>
		function confirmLogOut() {
			if (confirm("هل أنت متأكد من تسجيل الخروج ؟")) {
				return true;
			} else {
				return false;
			}
		}
		function confirmReq() {
			if (confirm("هل أنت متأكد من الاستئذان ؟")) {
				return true;
			} else {
				return false;
			}
		}
	</script>
	
</html>
