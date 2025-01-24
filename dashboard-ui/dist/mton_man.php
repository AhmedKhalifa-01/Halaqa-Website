<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
	if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_03'){
		//	if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
		//	}
		}			
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}
	if(isset($_POST['att'])){
		if(mysqli_query($conn,"INSERT INTO `ring_att`(`ring_id`, `date`, `state`, `type`) VALUES ('".$_GET['ring_id']."','".date('Y-m-d')."','غياب','2')")){
			echo "<script>alert(تم تسجيل المعلم غياب)</script>";
		}
	}
	if(isset($_POST['attF'])){
		if(mysqli_query($conn,"INSERT INTO `ring_att`(`ring_id`, `date`, `state`, `type`) VALUES ('".$_GET['ring_id']."','".date('Y-m-d')."','مستاذن','2')")){
			echo "<script>alert(تم تسجيل المعلم غياب)</script>";
		}
	}
	if(isset($_GET['del'])){
		if(mysqli_query($conn,"DELETE FROM mton_ring WHERE mton_ring_id = '".$_GET['mton_ring_id']."'")){
			echo "<script>alert('تم حذف الحلقة')</script>";
		}
	}

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إدارة المتون</title>
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
					<a href="course_man.php" >إدارة الدورات</a>
					<a href="mton_man.php" class="active">إدارة المتون</a>					
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
				<h2>إدارة المتون</h2>
				
			</div>
			<div class="content-header-actions">
				
				<?php
					if($_SESSION['staff_job'] == 'JOB_01'){
						echo '<a href="new_mton.php" class="button">
								<i class="ph-plus-bold"></i>
								<span>إضافة متون جديدة</span>
							</a>';
							echo '<a href="new_mton_ring.php" style="margin-right:30px;" class="button">
								<i class="ph-plus-bold"></i>
								<span>إضافة حلقة متون جديدة</span>
							</a>';
					}
				?>
				</div>
				<div class="search" style= "margin-top:10px;">
					<form action="mton_man.php?search=1" methode="get">
						<input type="text" placeholder="اكتب اسم حلقة المتون" name = "search"/>
						<button type="submit">
							<i class="ph-magnifying-glass-bold"></i>
						</button>
					</form>
				</div>
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
					<a href="tasheeh_man.php">حلقة تصحيح التلاوة</a>
					<a href="course_man.php" >إدارة الدورات</a>
					<a href="mton_man.php" class="active">إدارة المتون</a>					
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
				<center style="margin-bottom:20px;"><a href="mton_details.php?ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
				<?php
							$sql = "SELECT mton_ring.mton_ring_id,mton_ring.mton_ring_name,s.staff_name AS supervisor_name
									FROM mton_ring
									INNER JOIN mton_ring_teacher ON mton_ring_teacher.mton_ring_id = mton_ring.mton_ring_id
									INNER JOIN staff s ON s.staff_id = mton_ring.mton_ring_staff_man
									GROUP BY mton_ring.mton_ring_id
									";
							if(isset($_GET['search'])){
								$sql = "SELECT ring.ring_id,ring.ring_name,t.staff_name AS teacher_name, s.staff_name AS supervisor_name, COUNT(students.std_id) AS student_count
										FROM ring
										LEFT JOIN students ON students.mton_temp_ring_id = mton_ring.mton_ring_id
										INNER JOIN staff t ON t.staff_id = ring.staff_id
										INNER JOIN staff s ON s.staff_id = ring.ring_man
										WHERE ring_name LIKE '%".$_GET['search']."%'
										GROUP BY ring.ring_id
										ORDER BY ring.ring_name
										";
							}

							if($_SESSION['staff_job'] == "JOB_03"){
								$sql = "SELECT mton_ring.mton_ring_id,mton_ring.mton_ring_name,s.staff_name AS supervisor_name
										FROM mton_ring
										INNER JOIN mton_ring_teacher ON mton_ring_teacher.mton_ring_id = mton_ring.mton_ring_id AND mton_ring_teacher.staff_id = '".$_SESSION['email']."'
										INNER JOIN staff s ON s.staff_id = mton_ring.mton_ring_staff_man
										GROUP BY mton_ring.mton_ring_id
										";
							}
							if($_SESSION['staff_job'] == "JOB_02"){
								$sql = "SELECT mton_ring.mton_ring_id,mton_ring.mton_ring_name,s.staff_name AS supervisor_name
										FROM mton_ring
										INNER JOIN mton_ring_teacher ON mton_ring_teacher.mton_ring_id = mton_ring.mton_ring_id
										INNER JOIN staff s ON s.staff_id = mton_ring.mton_ring_staff_man
										WHERE mton_ring.mton_ring_staff_man = '".$_SESSION['email']."'
										GROUP BY mton_ring.mton_ring_id
										";
							}
							$result = mysqli_query($conn,$sql);
							echo mysqli_error($conn);
							while($row = mysqli_fetch_assoc($result)){
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/mton.png" /></span>
												<h3> اسم المتن : '.$row['mton_ring_name'].'</h3>
											</div>
										</div>
										<div class="card-body">';
												$sql = "SELECT staff_name FROM staff
														INNER JOIN mton_ring_teacher ON mton_ring_teacher.staff_id = staff.staff_id
														WHERE mton_ring_teacher.mton_ring_id = ".$row['mton_ring_id']."";
														$res = mysqli_query($conn,$sql);
														echo '<p style="display: contents;"> اسماء المعلمين :  </p></br>';
														while($row2 = mysqli_fetch_assoc($res)){
															echo '<p style="display: contents;">'.$row2['staff_name'].' </p></br>';
														}
												
											if($_SESSION['staff_job'] == 'JOB_01'){
												echo '<p> إداري الحلقة : '.$row['supervisor_name'].'</p>';											
											}
											$std_num = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(std_id) AS stdnum FROM students WHERE mton_ring_temp_id = ".$row['mton_ring_id']." OR mton_ring_temp_id_02 = ".$row['mton_ring_id']." OR mton_ring_temp_id_03 = ".$row['mton_ring_id'].""))['stdnum'];
											echo '<p> عدد الطلبة في الحلقة : '.$std_num.'</p>											
										</div>
										<div class="card-footer">
											<a href="mton_ring_det.php?mton_ring_id='.$row['mton_ring_id'].'">التسميع</a>
										</div>';
										if($_SESSION['staff_job'] == "JOB_01" or $_SESSION['staff_job'] == "JOB_02"){	
												
												echo '<div class="card-footer">
													<a href="std_mton_plan.php?mton_ring_id='.$row['mton_ring_id'].'">عرض خطط الطلبة</a>
												</div>';
												echo '<div class="card-footer">
													<a href="add_to_existing_mton_ring.php?mton_ring_id='.$row['mton_ring_id'].'">إضافة طلبة للحلقة</a>
												</div>';
												echo '<div class="card-footer">
													<a href="mton_ring_del_std.php?mton_ring_id='.$row['mton_ring_id'].'">حذف طلبة من الحلقة</a>
												</div>';
											echo '<div class="card-footer">
													<a href="mton_ring_move_std.php?mton_ring_id='.$row['mton_ring_id'].'">تحويل الطلبة لحلقة أخرى</a>
												</div>';
												echo '<div class="card-footer">
														<a href="mton_ring_final_move_std.php?mton_ring_id='.$row['mton_ring_id'].'">نقل الطلبة لحلقة أخرى</a>
													</div>';
													echo '<div class="card-footer">
														<a href="mton_man.php?del=1&mton_ring_id='.$row['mton_ring_id'].'" onclick="return confirmDel();">حذف الحلقة</a>
													</div>';
												
												/*if($_SESSION['staff_job'] == 'JOB_01'){
													echo '<div class="card-footer">
															<a style= "color:red;" href="change_mton_res.php?mton_ring_id='.$row['mton_ring_id'].'">تغيير درجة التسميع / الواجب</a>
														</div>';
													}else{
														echo '<div class="card-footer">
																<a style= "color:red;" href="change_mton_res.php?mton_ring_id='.$row['mton_ring_id'].'">تغيير درجة التسميع</a>
															</div>';
													}*/
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

	function confirmDel() {
		if (confirm("هل أنت متأكد من حذف الحلقة ؟")) {
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
	<script>
		setInterval(function() {
			var xhr = new XMLHttpRequest();
			xhr.open('GET', 'check_activity.php', true);
			xhr.send();
		}, 32000); // 1 minute interval
	</script>
</html>
