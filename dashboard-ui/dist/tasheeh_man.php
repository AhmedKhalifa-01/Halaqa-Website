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
	

	if(isset($_GET['del'])){
		if(mysqli_query($conn,"DELETE FROM tasheeh WHERE id = '".$_GET['t_id']."'")){
			mysqli_query($conn,"DELETE FROM tasheeh_teacher WHERE tasheeh_id = '".$_GET['t_id']."'");
			mysqli_query($conn,"DELETE FROM tasheeh_std WHERE tasheeh_id = '".$_GET['t_id']."'");
			echo "<script>alert('تم حذف الحلقة')</script>";
		}
	}

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>تصحيح التلاوة</title>
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
					<a href="tasheeh_man.php" class="active">حلقة تصحيح التلاوة</a>
					
					
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
				<h2>حلقات تصحيح التلاوة</h2>
				<?php if($_SESSION['staff_job'] == 'JOB_01'){ ?>
				<center><h3 style="font-weight:bold;font-size:24px;">عدد حلقات التصحيح في المجمع : <color style="color:#ffffff;"><?php 
														$res = mysqli_query($conn,"SELECT COUNT(id) AS count FROM tasheeh"); 
														echo mysqli_fetch_assoc($res)['count']; 
													?></color>
						</h3>
				</center>
				<?php } ?>
			</div>
			<div class="content-header-actions">
				
				<?php if($_SESSION['staff_job'] == 'JOB_01'){?>
				<a href="new_tasheeh_ring.php" class="button">
					<i class="ph-plus-bold"></i>
					<span>إضافة حلقة جديدة  </span>
				</a>
				<?php } ?>
			</div>
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
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
					<a href="tasheeh_man.php" class="active">حلقة تصحيح التلاوة</a>
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
					?><div style="margin-bottom: 400px;">
					</div>

				</div>
			</div>
			<div class="content-main">
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
				<?php 
							$sql = "SELECT tasheeh.id AS t_id, tasheeh.t_name,super.staff_name AS s_name FROM tasheeh
									INNER JOIN staff AS super ON super.staff_id = tasheeh.t_super";
							if($_SESSION['staff_job'] == "JOB_03"){
								$sql = "SELECT tasheeh.id AS t_id, tasheeh.t_name,super.staff_name AS s_name FROM tasheeh
										INNER JOIN staff AS super ON super.staff_id = tasheeh.t_super
										INNER JOIN tasheeh_teacher ON tasheeh_teacher.tasheeh_id = tasheeh.id
										WHERE tasheeh_teacher.teacher_id = '".$_SESSION['email']."'
										";

							}
							if($_SESSION['staff_job'] == "JOB_02"){
								$sql = "SELECT tasheeh.id AS t_id, tasheeh.t_name,super.staff_name AS s_name FROM tasheeh
										INNER JOIN staff AS super ON super.staff_id = tasheeh.t_super
										WHERE tasheeh.t_super = '".$_SESSION['email']."'";
							}
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/quran.png" /></span>
												<h3> اسم الحلقة : '.$row['t_name'].'</h3>
											</div>
										</div>
										<div class="card-body">
										<form class="login-form" action="ring_man.php?t_id='.$row['t_id'].'" method="post">';
											$sql = "SELECT * FROM tasheeh_teacher
													INNER JOIN tasheeh ON tasheeh.id = tasheeh_teacher.tasheeh_id
													INNER JOIN staff ON staff.staff_id = tasheeh_teacher.teacher_id
													WHERE tasheeh_teacher.tasheeh_id = '".$row['t_id']."'";
											$re = mysqli_query($conn,$sql);
											echo '<h2>أسماء المعلمين</h2></br>';
											while($row3 = mysqli_fetch_assoc($re)){
												echo '<h3 style="margin-right: 40px;"> - '.$row3['staff_name'].' </br></h3>';
											}
											
											/*$sql = "SELECT * FROM ring_att WHERE t_id = '".$row['t_id']."' AND date = '".date('Y-m-d')."' AND type='1'";
											if(mysqli_num_rows(mysqli_query($conn,$sql)) == 0 and $_SESSION['staff_job'] != 'JOB_03'){
												echo '</br><center><input name="att" style="padding:5px;display:inline;width:fit-content;height:30px;margin-right: 50px;" type="submit" value="تسجيل غياب" onclick="return conf();"/></center>';
												echo '<center><input name="attF" style="padding:5px;display:inline;width:fit-content;height:30px;margin-right: 50px;" type="submit" value="تسجيل استئذان" onclick="return confF();"/></center>';
											}*/
										echo '</form>
											';
											if($_SESSION['staff_job'] == 'JOB_01'){
												echo '<p> إداري الحلقة : '.$row['s_name'].'</p>';											
											}
											$sql = "SELECT COUNT(std_id) AS std_count FROM tasheeh_std WHERE tasheeh_id = '".$row['t_id']."'";
											$re = mysqli_query($conn,$sql);
											$row4 = mysqli_fetch_assoc($re);
											echo '<p> عدد الطلبة في الحلقة : '.$row4['std_count'].'</p>											
										</div>
										';
									echo '
										<div class="card-footer">
											<a href="tasheeh_det.php?t_id='.$row['t_id'].'" onclick="return allow('.$row4['std_count'].');">التسميع</a>
										</div>';
										if($_SESSION['staff_job'] == "JOB_01" and $row['s_name'] == NULL){
											echo '<div class="card-footer">
													<a href="ring_add_supervisor.php?t_id='.$row['t_id'].'">إضافة مشرف</a>
												</div>';
										}
										if($_SESSION['staff_job'] == "JOB_01" or $_SESSION['staff_job'] == "JOB_02"){	
											echo '<div class="card-footer">
													<a href="add_teacher_existing_tasheeh.php?t_id='.$row['t_id'].'">إضافة معلم للحلقة</a>
												</div>';
											echo '<div class="card-footer">
												<a href="remove_teacher_existing_tasheeh.php?t_id='.$row['t_id'].'">حذف معلم من الحلقة</a>
											</div>';
											echo '<div class="card-footer">
													<a href="add_to_existing_tasheeh.php?t_id='.$row['t_id'].'">إضافة طلبة للحلقة</a>
												</div>';
											/*echo '<div class="card-footer">
													<a href="ring_move_std.php?t_id='.$row['t_id'].'">تحويل الطلبة لحلقة أخرى</a>
												</div>';*/
												/*$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '3'")) > 0;
												if($_SESSION['staff_job'] == 'JOB_01' or $prev){
													echo '<div class="card-footer">
														<a href="ring_final_move_std.php?t_id='.$row['t_id'].'">نقل الطلبة لحلقة أخرى</a>
													</div>';
												}*/
												$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '4'")) > 0;
												if($_SESSION['staff_job'] == 'JOB_01' or $prev){
													echo '<div class="card-footer">
														<a href="tasheeh_del_std.php?t_id='.$row['t_id'].'">حذف طالب من الحلقة</a>
													</div>';
													echo '<div class="card-footer">
														<a href="tasheeh_plan.php?t_id='.$row['t_id'].'">الخطة</a>
													</div>';
												}
												/*echo '<div class="card-footer">
													<a href="std_ring_plan.php?t_id='.$row['t_id'].'">عرض خطط الطلبة</a>
												</div>';*/
												 
										}
										$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '5'")) > 0;
										if($_SESSION['staff_job'] == 'JOB_01' or $prev){
										/*echo '<div class="card-footer">
												<a style= "color:red;" href="change_ring_res.php?t_id='.$row['t_id'].'">تغيير درجة التسميع / الواجب</a>
											</div>';*/
										}else{
											if($_SESSION['staff_job'] == 'JOB_02'){
												/*echo '<div class="card-footer">
														<a style= "color:red;" href="change_ring_res.php?t_id='.$row['t_id'].'">تغيير درجة الواجب</a>
													</div>';
													echo '<div class="card-footer">
														<a style= "color:red;" href="ring_chartr.php?t_id='.$row['t_id'].'">احصائيات الدرجات </a>
													</div>';
													echo '<div class="card-footer">
														<a style= "color:red;" href="ring_ex_ab_stat.php?t_id='.$row['t_id'].'">احصائيات الحضور والغياب </a>
													</div>';*/
											}
										}
										if($_SESSION['staff_job'] == "JOB_01"){
											/*echo '<div class="card-footer">
													<a style= "color:red;" href="del_ring_res.php?&t_id='.$row['t_id'].'">حذف الدرجات</a>
												</div>';*/
										}
										if($_SESSION['staff_job'] == "JOB_01"){
											echo '<div class="card-footer">
													<a style= "color:red;" href="tasheeh_man.php?del=1&t_id='.$row['t_id'].'" onclick="return confirmDel();">حذف الحلقة</a>
												</div>';
										}
										echo '
									</article>
								';
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
  <script>
		function confirmDelete() {
			if (confirm("هل أنت متأكد من حذف هذا الحساب ؟")) {
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
		function confirmDel() {
			if (confirm("هل أنت متأكد من حذف الحلقة ؟")) {
				return true;
			} else {
				return false;
			}
		}
		function allow(count) {
			if (count > 0) {
				return true;
			} else {
				alert("لا يوجد طلبة في الحلقة");
				return false;
			}
		}
		function conf() {
			if (confirm("تسجيل غياب للمعلم ؟")) {
				return true;
			} else {
				return false;
			}
		}
		function confF() {
			if (confirm("تسجيل استئذان للمعلم ؟")) {
				return true;
			} else {
				return false;
			}
		}
	</script>
	</script>
	<script>
		setInterval(function() {
			var xhr = new XMLHttpRequest();
			xhr.open('GET', 'check_activity.php', true);
			xhr.send();
		}, 32000); // 1 minute interval
	</script>
</html>
