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
	/*if(isset($_GET['vec'])){
		$sql = "UPDATE students SET status = 'إجازة' WHERE std_id = '".$_GET['std_id']."'";
		
		if(mysqli_query($conn,$sql)){
			echo "<script>window.location.href='std_management.php';</script>";
		}else{
			echo "<script>alert('خطأ في إضافة الحضور')</script>";
		}
	}
	if(isset($_GET['back'])){
		$sql = "UPDATE students SET status = 'دوام' WHERE std_id = '".$_GET['std_id']."'";
		
		if(mysqli_query($conn,$sql)){
			echo "<script>window.location.href='std_management.php';</script>";
		}else{
			echo "<script>alert('خطأ في إضافة الحضور')</script>";
		}
	}*/
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
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0  or mysqli_num_rows(mysqli_query($conn,$sql2)) > 0) and ($_SESSION['staff_job'] == 'JOB_01' or $_SESSION['staff_job'] == 'JOB_02')){
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
				<h2 >إدارة الطلاب</h2>
				<?php if($_SESSION['staff_job'] == 'JOB_01'){ ?>
				<h3 style="font-weight:bold;font-size:24px;">عدد الطلاب المنتظمين : <?php 
														$res = mysqli_query($conn,"SELECT COUNT(std_id) AS count FROM students WHERE state != 'مفصول' ");
														echo mysqli_fetch_assoc($res)['count']; 
													?>
						</h3>
				<h3 style="font-weight:bold;font-size:24px;">عدد الطلاب المفصولين : <?php 
														$res = mysqli_query($conn,"SELECT COUNT(std_id) AS count FROM students WHERE state = 'مفصول' ");
														echo mysqli_fetch_assoc($res)['count']; 
													?>
						</h3>
				
				<h3 style="font-weight:bold;font-size:24px;">عدد الطلاب في المجمع : <?php 
														$res = mysqli_query($conn,"SELECT COUNT(std_id) AS count FROM students	");
														echo mysqli_fetch_assoc($res)['count']; 
													?>
						</h3>
				
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
					<?php if($_SESSION['staff_job'] == "JOB_01"){?>
						
					<?php } ?>
					<?php
						$sql = "SELECT * FROM std_exc WHERE seen = 0";
						$sql2 = "SELECT * FROM pending_std WHERE seen = 0"; 
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0  or mysqli_num_rows(mysqli_query($conn,$sql2)) > 0) and ($_SESSION['staff_job'] == 'JOB_01' or $_SESSION['staff_job'] == 'JOB_02')){
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
			<center style="margin-bottom:10px;"><div class="content-header-actions">
					<?php
						if($_SESSION['staff_job'] == 'JOB_01'){
							$sql2 = "SELECT * FROM pending_std WHERE seen = 0"; 
							if(mysqli_num_rows(mysqli_query($conn,$sql2)) > 0){
								echo '<a href="pendeing_std.php" class="button" style="background-color:darkred; color:white;">
										<span>الطلبات المعلقة</span>
									</a>';
							}else{
								echo '<a href="pendeing_std.php" class="button">
										<span>الطلبات المعلقة</span>
									</a>';
							}
							
						}
					?>
					<?php
						$sql = "SELECT * FROM std_exc WHERE seen = 0";
						
						if(mysqli_num_rows(mysqli_query($conn,$sql)) > 0 and $_SESSION['staff_job'] == 'JOB_01' ){
							echo '<a href="std_exc.php" class="button" style="background-color:darkred; color:white;">
										<span>طلبات الاستئذان</span>
									</a>';
									echo '<a href="std_info.php" class="button" style="margin-right: 10px;">
										<span>سجلات الطلاب</span>
									</a>';
						}else{
							echo '<a href="std_exc.php" class="button">
										<span>طلبات الاستئذان</span>
									</a>';
									echo '<a href="std_info.php" class="button" style="">
										<span>سجلات الطلاب</span>
									</a>';
						}
						echo '<a href="std_management_fired.php" class="button"style="margin-right:5px;">
								<span>أرشيف الطلاب المفصولين</span>
							</a>';
					?>
					
				</div></center>
				
				<center style="margin-bottom:10px;"><div class="search">
					<form action="std_management.php?search=1" methode="get">
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
							
							$sql = "SELECT * FROM students
									INNER JOIN ring ON students.ring_id = ring.ring_id
									INNER JOIN ring_admins ON ring_admins.ring_id = ring.ring_id
									WHERE ring_admins.staff_id = '".$_SESSION['email']."' AND students.std_name LIKE '%".$_GET['search']."%'
									ORDER BY students.std_name
									";
									if($_SESSION['staff_job'] == 'JOB_01'){
										$sql = "SELECT * FROM students
												WHERE students.std_name LIKE '%".$_GET['search']."%'";
									}
							//$sql = "SELECT * FROM students WHERE std_name LIKE '%".$_GET['search']."%'";
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								if($row['state'] == 'مفصول'){
									continue;
								}
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/student.png" /></span>
												<h3>'.$row['std_name'].'</h3>
											</div>
										</div>
										<div class="card-body">';
											echo '<p> حالة الطالب : '.$row['state'].'</p>';
											if($row['state'] == 'مفصول'){
												echo '<p>حالة الدوام : <color style="color:darkred;">مفصول</color></p>';
											}else{
												if($row['status'] == 'إجازة'){
													echo '<p>حالة الدوام : <color style="color:darkred;">في إجازة</color></p>';
												}else{
													echo '<p>حالة الدوام : <color style="color:darkgreen;">مداوم</color></p>';
												}
											}
											
											$sql = "SELECT * FROM ring WHERE ring_id = '".$row['ring_id']."'";
											$r = mysqli_query($conn,$sql);
											$rRow = mysqli_fetch_assoc($r);
											echo '<p> الحلقة : <a href="ring_man.php" style="text-decoration:none;">'.$rRow['ring_name'].'</a></p>';
										echo '</div>';
										$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '15'")) > 0;
										if($_SESSION['staff_job'] == 'JOB_01' or $prev){
											echo '<div class="card-footer">
												<a href="std_more_details.php?id='.$row['std_id'].'">مزيد من التفاصيل</a>
											</div>';
										}
										echo '
									</article>
								';
							}
						}else{
							$sql = "SELECT * FROM students
									INNER JOIN ring ON students.ring_id = ring.ring_id
									INNER JOIN ring_admins ON ring_admins.ring_id = ring.ring_id
									WHERE ring_admins.staff_id = '".$_SESSION['email']."'
									ORDER BY students.std_name
									";
									if($_SESSION['staff_job'] == 'JOB_01'){
										$sql = "SELECT * FROM students ORDER BY students.std_name";
									}
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								if($row['state'] == 'مفصول'){
									continue;
								}
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/student.png"/></span>
												<h3>'.$row['std_name'].'</h3>
											</div>
										</div>
										<div class="card-body">';
											echo '<p> حالة الطالب : '.$row['state'].'</p>';
											if($row['state'] == 'مفصول'){
												echo '<p>حالة الدوام : <color style="color:darkred;">مفصول</color></p>';
											}else{
												if($row['status'] == 'إجازة'){
													echo '<p>حالة الدوام : <color style="color:darkred;">في إجازة</color></p>';
												}else{
													echo '<p>حالة الدوام : <color style="color:darkgreen;">مداوم</color></p>';
												}
											}
											$sql = "SELECT * FROM ring WHERE ring_id = '".$row['ring_id']."'";
											$r = mysqli_query($conn,$sql);
											$rRow = mysqli_fetch_assoc($r);
											echo '<p> الحلقة : <a href="ring_man.php" style="text-decoration:none;">'.$rRow['ring_name'].'</a></p>';
										echo '</div>';
										$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '15'")) > 0;
										if($_SESSION['staff_job'] == 'JOB_01' or $prev){
											echo '<div class="card-footer">
													<a href="std_more_details.php?id='.$row['std_id'].'">مزيد من التفاصيل</a>
												</div>';
										}
										
										echo '
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
