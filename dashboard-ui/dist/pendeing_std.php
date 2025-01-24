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
	if(isset($_GET['reject'])){
		if(mysqli_query($conn,"DELETE FROM pending_std WHERE std_id = '".$_GET['std_id']."'")){
			echo "<script>alert('تم حذف الطلب');</script>";
			echo "<script>window.location.href='std_management.php';</script>";
		}
	}
	if(isset($_GET['agree'])){
		$sql = "INSERT INTO students (`std_name`, `std_lvl`, `std_nat`, `std_id_num`, `std_birth_date`, `std_birth_loc`, `std_enroll_date`, `std_phone`,`std_last_sorah`, `std_tested`,`email`, `pass`,`std_v_mem`,`state`)
				SELECT `std_name`, `std_lvl`, `std_nat`, `std_id_num`, `std_birth_date`, `std_birth_loc`, `std_enroll_date`, `std_phone`,`std_last_sorah`, `std_tested`,`email`, `pass`,`std_v_mem`,`state`
				FROM pending_std
				WHERE pending_std.std_id = '".$_GET['std_id']."'";
		if(mysqli_query($conn,$sql)){
			mysqli_query($conn,"DELETE FROM pending_std WHERE std_id = '".$_GET['std_id']."'");
			echo "<script>alert('تمت إضافة الطالب');</script>";
			//echo "<script>window.location.href='std_management.php';</script>";
		}else{
			echo mysqli_error($conn);
		}
	}
	mysqli_query($conn,"UPDATE pending_std SET seen = 1");
?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إدارة الطلاب</title>
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
		<div class="main-header">
			
		</div>

		<div class="content-header">
			<div class="content-header-intro">
				<h2>طلبات الطلاب المعلقة</h2>
				
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
			<div class="content-header-actions">
				</div>
				<center style="margin-bottom:10px;"><div class="search">
					<form action="pendeing_std.php?search=1" methode="get">
						<input type="text" placeholder="اكتب اسم الطالب" name = "search"/>
						<button type="submit">
							<i class="ph-magnifying-glass-bold"></i>
						</button>
					</form>
				</div></center>
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
					<?php
						if(isset($_GET['search'])){
										$sql = "SELECT * FROM pending_std 
												WHERE pending_std.std_name LIKE '%".$_GET['search']."%'";
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/student.png" /></span>
												<h3>'.$row['std_name'].'</h3>
											</div>
										</div>
										<div class="card-body">
											<p> رقم الهوية : '.$row['std_id_num'].'</p>
											<p> كلمة المرور : '.$row['pass'].'</p>
											<p> الجنسية : '.$row['std_nat'].'</p>
											<p> المستوى التعليمي : '.$row['std_lvl'].'</p>
											<p> رقم الهاتف : '.$row['std_phone'].'</p>';
											
										echo '</div>
										<div class="card-footer">
											<a href="pendeing_std.php?agree=1&std_id='.$row['std_id'].'" onclick="return confirmOK()"">الموافقة على الطلب</a>
										</div>
										<div class="card-footer">
											<a href="pendeing_std.php?reject=1&std_id='.$row['std_id'].'" onclick="return confirmDelete()"">حذف الطلب</a>
										</div>
									</article>
								';
							}
						}else{
										$sql = "SELECT * FROM pending_std";
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/student.png" /></span>
												<h3>'.$row['std_name'].'</h3>
											</div>
										</div>
										<div class="card-body">
											<p> رقم الهوية : '.$row['std_id_num'].'</p>
											<p> كلمة المرور : '.$row['pass'].'</p>
											<p> الجنسية : '.$row['std_nat'].'</p>
											<p> المستوى التعليمي : '.$row['std_lvl'].'</p>
											<p> رقم الهاتف : '.$row['std_phone'].'</p>';
											
										echo '</div>
										<div class="card-footer">
											<a href="pendeing_std.php?agree=1&std_id='.$row['std_id'].'" onclick="return confirmOK()"">الموافقة على الطلب</a>
										</div>
										<div class="card-footer">
											<a href="pendeing_std.php?reject=1&std_id='.$row['std_id'].'" onclick="return confirmDelete()"">حذف الطلب</a>
										</div>
									</article>
								';
							}
						}	
					?>
					

					
					
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
	function confirmDelete() {
		if (confirm("هل أنت متأكد من رفض هذا الطلب ؟")) {
			return true;
		} else {
			return false;
		}
	}
	function confirmOK() {
		if (confirm("هل أنت متأكد من الموافقة على هذا الطلب ؟")) {
			return true;
		} else {
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
