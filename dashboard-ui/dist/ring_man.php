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
	
	/*$sql = "SELECT date FROM ring
			ORDER BY date DESC
			LIMIT 1;";
	$row = mysqli_fetch_assoc(mysqli_query($conn,$sql));
	if($row['date'] != date('Y-m-d')){
		if(mysqli_query($conn,"UPDATE ring SET isTemp = '0' ,temp_staff_id = staff_id")){
			//echo "<script>alert('تم إعاد جميع الطلبة لحلقاتهم الأصلية')</script>";
		}
	}*/

	if(isset($_GET['del'])){
		if(mysqli_query($conn,"DELETE FROM ring WHERE ring_id = '".$_GET['ring_id']."'")){
			echo "<script>alert('تم حذف الحلقة')</script>";
		}
	}

	if(isset($_POST['att'])){
		if(mysqli_query($conn,"INSERT INTO `ring_att`(`ring_id`, `date`, `state`, `type`) VALUES ('".$_GET['ring_id']."','".date('Y-m-d')."','غياب','1')")){
			echo "<script>alert(تم تسجيل المعلم غياب)</script>";
		}
	}
	if(isset($_POST['attF'])){
		if(mysqli_query($conn,"INSERT INTO `ring_att`(`ring_id`, `date`, `state`, `type`) VALUES ('".$_GET['ring_id']."','".date('Y-m-d')."','مستاذن','1')")){
			echo "<script>alert(تم تسجيل المعلم غياب)</script>";
		}
	}

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إدارة الحلقات</title>
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
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0  or mysqli_num_rows(mysqli_query($conn,$sql2)) > 0) and ($_SESSION['staff_job'] == 'JOB_01' or $_SESSION['staff_job'] == 'JOB_02')){
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
					<a href="ring_man.php" class="active">إدارة الحلقات  التسميع</a>
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
				<h2>إدارة الحلقات</h2>
				<?php if($_SESSION['staff_job'] == 'JOB_01'){ ?>
				<center><h3 style="font-weight:bold;font-size:24px;">عدد الحلقات في المجمع : <color style="color:#ffffff;"><?php 
														$res = mysqli_query($conn,"SELECT COUNT(ring_id) AS count FROM ring"); 
														echo mysqli_fetch_assoc($res)['count']; 
													?></color>
						</h3>
				</center>
				<?php } ?>
			</div>
			<div class="content-header-actions">
				
				<?php if($_SESSION['staff_job'] == 'JOB_01'){?>
				<a href="new_ring.php" class="button">
					<i class="ph-plus-bold"></i>
					<span>إضافة حلقة جديدة  </span>
				</a>
				<?php } ?>
			</div>
			<div class="search" style= "margin-top:10px;">
					<form action="ring_man.php?search=1" methode="get">
						<input type="text" placeholder="اكتب اسم الحلقة" name = "search"/>
						<button type="submit">
							<i class="ph-magnifying-glass-bold"></i>
						</button>
					</form>
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
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0  or mysqli_num_rows(mysqli_query($conn,$sql2)) > 0) and ($_SESSION['staff_job'] == 'JOB_01' or $_SESSION['staff_job'] == 'JOB_02')){
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
					<a href="ring_man.php" class="active">إدارة الحلقات  التسميع</a>
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
							$sql = "SELECT ring.ring_id,ring.ring_name,t.staff_name AS teacher_name, s.staff_name AS supervisor_name, COUNT(students.std_id) AS student_count
									FROM ring
									LEFT JOIN students ON students.temp_ring_id = ring.ring_id
									LEFT JOIN staff t ON t.staff_id = ring.staff_id
									LEFT JOIN staff s ON s.staff_id = ring.ring_man
									GROUP BY ring.ring_id
									ORDER BY ring.ring_order";
							if(isset($_GET['search'])){
								$sql = "SELECT ring.ring_id,ring.ring_name,t.staff_name AS teacher_name, s.staff_name AS supervisor_name, COUNT(students.std_id) AS student_count
										FROM ring
										LEFT JOIN students ON students.temp_ring_id = ring.ring_id
										LEFT JOIN staff t ON t.staff_id = ring.staff_id
										LEFT JOIN staff s ON s.staff_id = ring.ring_man
										WHERE ring_name LIKE '%".$_GET['search']."%'
										GROUP BY ring.ring_id
										ORDER BY ring.ring_order
										";
							}

							if($_SESSION['staff_job'] == "JOB_03"){
								$sql = "SELECT ring.ring_id,ring.ring_name,t.staff_name AS teacher_name, s.staff_name AS supervisor_name, COUNT(students.std_id) AS student_count
										FROM ring
										LEFT JOIN students ON students.temp_ring_id = ring.ring_id
										LEFT JOIN staff t ON t.staff_id = ring.staff_id
										LEFT JOIN staff s ON s.staff_id = ring.ring_man
										INNER JOIN teacher_ring ON teacher_ring.ring_id = ring.ring_id 
										WHERE teacher_ring.teacher_id = '".$_SESSION['email']."'
										GROUP BY ring.ring_id
										ORDER BY ring.ring_order
										";
								/*$sql = "SELECT ring.ring_id, ring.ring_name, s.staff_name AS supervisor_name, COUNT(students.std_id) AS student_count
										FROM ring
										INNER JOIN teacher_ring ON teacher_ring.ring_id =
										LEFT JOIN students ON students.temp_ring_id = ring.ring_id
										LEFT JOIN staff s ON s.staff_id = ring.ring_man
										";*/
										if(isset($_GET['search'])){
											$sql = "SELECT ring.ring_id,ring.ring_name,t.staff_name AS teacher_name, s.staff_name AS supervisor_name, COUNT(students.std_id) AS student_count
													FROM ring
													LEFT JOIN students ON students.temp_ring_id = ring.ring_id
													LEFT JOIN staff t ON t.staff_id = ring.staff_id
													LEFT JOIN staff s ON s.staff_id = ring.ring_man
													WHERE ring_name LIKE '%".$_GET['search']."%' AND ring.staff_id = '".$_SESSION['email']."'
													GROUP BY ring.ring_id
													ORDER BY ring.ring_order
													";
										}
							}
							if($_SESSION['staff_job'] == "JOB_02"){
								
								/*$sql = "SELECT ring.ring_id,ring.ring_name,t.staff_name AS teacher_name, s.staff_name AS supervisor_name, COUNT(students.std_id) AS student_count
										FROM ring
										LEFT JOIN students ON students.temp_ring_id = ring.ring_id
										LEFT JOIN staff t ON t.staff_id = ring.staff_id
										LEFT JOIN staff s ON s.staff_id = ring.ring_man
										WHERE ring.ring_man = '".$_SESSION['email']."'
										GROUP BY ring.ring_id
										ORDER BY ring.ring_order";
										if(isset($_GET['search'])){
											$sql = "SELECT ring.ring_id,ring.ring_name,t.staff_name AS teacher_name, s.staff_name AS supervisor_name, COUNT(students.std_id) AS student_count
													FROM ring
													LEFT JOIN students ON students.temp_ring_id = ring.ring_id
													LEFT JOIN staff t ON t.staff_id = ring.staff_id
													LEFT JOIN staff s ON s.staff_id = ring.ring_man
													WHERE ring.ring_man = '%".$_GET['search']."%' AND ring.ring_man = '".$_SESSION['email']."'
													GROUP BY ring.ring_id
													ORDER BY ring.ring_order";
										}*/
										$sql ="SELECT ring.ring_id,ring.ring_name,COUNT(students.std_id) AS student_count FROM ring
												INNER JOIN ring_admins ON ring.ring_id = ring_admins.ring_id
												LEFT JOIN students ON students.temp_ring_id = ring.ring_id
												WHERE ring_admins.staff_id = '".$_SESSION['email']."'
												GROUP BY ring.ring_id";
							}
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/quran.png" /></span>
												<h3> اسم الحلقة : '.$row['ring_name'].'</h3>
											</div>
										</div>
										<div class="card-body">
										<form class="login-form" action="ring_man.php?ring_id='.$row['ring_id'].'" method="post">';
											$sql = "SELECT * FROM teacher_ring
													INNER JOIN ring ON ring.ring_id = teacher_ring.ring_id
													INNER JOIN staff ON staff.staff_id = teacher_ring.teacher_id
													WHERE teacher_ring.ring_id = '".$row['ring_id']."'";
											$re = mysqli_query($conn,$sql);
											echo '<h2>أسماء المعلمين</h2>';
											while($row3 = mysqli_fetch_assoc($re)){
												echo '<h3 style="margin-right: 40px;"> - '.$row3['staff_name'].' </br></h3>';
											}
											
											/*$sql = "SELECT * FROM ring_att WHERE ring_id = '".$row['ring_id']."' AND date = '".date('Y-m-d')."' AND type='1'";
											if(mysqli_num_rows(mysqli_query($conn,$sql)) == 0 and $_SESSION['staff_job'] != 'JOB_03'){
												echo '</br><center><input name="att" style="padding:5px;display:inline;width:fit-content;height:30px;margin-right: 50px;" type="submit" value="تسجيل غياب" onclick="return conf();"/></center>';
												echo '<center><input name="attF" style="padding:5px;display:inline;width:fit-content;height:30px;margin-right: 50px;" type="submit" value="تسجيل استئذان" onclick="return confF();"/></center>';
											}*/
										echo '</form>
										</br>
											';
											if($_SESSION['staff_job'] == 'JOB_01'){
												$sql = "SELECT * FROM ring_admins
														INNER JOIN ring ON ring.ring_id = ring_admins.ring_id
														INNER JOIN staff ON staff.staff_id = ring_admins.staff_id
														WHERE ring_admins.ring_id = '".$row['ring_id']."'";
												$re = mysqli_query($conn,$sql);
												echo '<h2>أسماء الإداريين</h2>';
												while($row3 = mysqli_fetch_assoc($re)){
													echo '<h3 style="margin-right: 40px;"> - '.$row3['staff_name'].' </br></h3>';
												}										
											}
											echo '</br><p> عدد الطلبة في الحلقة : '.$row['student_count'].'</p>											
										</div>
										';
									echo '
										<div class="card-footer">
											<a href="ring_det.php?ring_id='.$row['ring_id'].'" onclick="return allow('.$row['student_count'].');">التسميع</a>
										</div>';
										if($_SESSION['staff_job'] == "JOB_01"){
											echo '<div class="card-footer">
												<a href="adj_ring.php?ring_id='.$row['ring_id'].'">التعديل على الحلقة</a>
											</div>';
											echo '<div class="card-footer">
													<a href="ring_add_supervisor.php?ring_id='.$row['ring_id'].'">التعديل على الإداريين</a>
												</div>';
										}
										if($_SESSION['staff_job'] == "JOB_01" or $_SESSION['staff_job'] == "JOB_02"){	
											echo '<div class="card-footer">
													<a href="add_teacher_existing_ring.php?ring_id='.$row['ring_id'].'">إضافة معلم للحلقة</a>
												</div>';
											echo '<div class="card-footer">
												<a href="remove_teacher_existing_ring.php?ring_id='.$row['ring_id'].'">حذف معلم من الحلقة</a>
											</div>';
											echo '<div class="card-footer">
													<a href="add_to_existing_ring.php?ring_id='.$row['ring_id'].'">إضافة طلبة للحلقة</a>
												</div>';
											echo '<div class="card-footer">
													<a href="ring_move_std.php?ring_id='.$row['ring_id'].'">تحويل الطلبة لحلقة أخرى</a>
												</div>';
												$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '3'")) > 0;
												if($_SESSION['staff_job'] == 'JOB_01' or $prev){
													echo '<div class="card-footer">
														<a href="ring_final_move_std.php?ring_id='.$row['ring_id'].'">نقل الطلبة لحلقة أخرى</a>
													</div>';
												}
												$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '4'")) > 0;
												if($_SESSION['staff_job'] == 'JOB_01' or $prev){
													echo '<div class="card-footer">
														<a href="ring_del_std.php?ring_id='.$row['ring_id'].'">حذف طالب من الحلقة</a>
													</div>';
												}
												echo '<div class="card-footer">
													<a href="std_ring_plan.php?ring_id='.$row['ring_id'].'">عرض خطط الطلبة</a>
												</div>';
												 
										}
										$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '5'")) > 0;
										if($_SESSION['staff_job'] == 'JOB_01' or $prev){
										echo '<div class="card-footer">
												<a style= "color:red;" href="change_ring_res.php?ring_id='.$row['ring_id'].'">تغيير درجة التسميع / الواجب</a>
											</div>';
										}else{
											if($_SESSION['staff_job'] == 'JOB_02'){
												echo '<div class="card-footer">
														<a style= "color:red;" href="change_ring_res.php?ring_id='.$row['ring_id'].'">تغيير درجة الواجب</a>
													</div>';
													echo '<div class="card-footer">
														<a style= "color:red;" href="ring_chartr.php?ring_id='.$row['ring_id'].'">احصائيات الدرجات </a>
													</div>';
													echo '<div class="card-footer">
														<a style= "color:red;" href="ring_ex_ab_stat.php?ring_id='.$row['ring_id'].'">احصائيات الحضور والغياب </a>
													</div>';
											}
										}
										if($_SESSION['staff_job'] == "JOB_01"){
											echo '<div class="card-footer">
													<a style= "color:red;" href="del_ring_res.php?&ring_id='.$row['ring_id'].'">حذف الدرجات</a>
												</div>';
										}
										if($_SESSION['staff_job'] == "JOB_01"){
											echo '<div class="card-footer">
													<a style= "color:red;" href="ring_man.php?del=1&ring_id='.$row['ring_id'].'" onclick="return confirmDel();">حذف الحلقة</a>
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
