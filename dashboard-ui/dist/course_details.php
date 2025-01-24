<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_03'){
			//if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
			//}
		}	}else{
		echo "<script>window.location.href='index.php';</script>";
	}
	if(isset($_GET['closeCourse'])){
		$sql = "UPDATE course SET status = 'مغلقة' WHERE c_id = ".$_GET['id']."";
		$result = mysqli_query($conn,$sql);
		if(!$result){
			echo "<script>alert('خطأ في إغلاق الدورة')</script>";
			echo "<script>window.location.href='course_man.php';</script>";
		}else{
			$sql = "SELECT *,AVG(course_results_details.mark) AS mark FROM course_results_details
					INNER JOIN students ON course_results_details.std_id = students.std_id
					WHERE c_id = '".$_GET['id']."' GROUP BY course_results_details.std_id
					;";		
			
			$resultt = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($resultt)){
				$totalMark = $row['mark'];
				$result = "";
				if($totalMark >= 9){
					$result = "ممتاز";
				}else if($totalMark >= 8 and $totalMark < 9){
					$result = "جيد جدا";
				}else if($totalMark >= 7 and $totalMark < 8){
					$result = "جيد";
				}else if($totalMark >= 6 and $totalMark < 7){
					$result = "إعادة";
				}else if($totalMark < 6){
					$result = "لم يحفظ";
				}

				$sqlAtt = "SELECT COUNT(std_id) as total FROM `course_attendance` WHERE course_id = '".$_GET['id']."' AND std_id = '".$row['std_id']."' AND state = 'حضور';";
				$resultAtt = mysqli_query($conn,$sqlAtt);
				$daysAtt = mysqli_fetch_assoc($resultAtt)['total'];

				$sqlRes = "SELECT * FROM course WHERE c_id = '".$_GET['id']."'";
				$resultRes = mysqli_query($conn,$sqlRes);
				$rowRes = mysqli_fetch_assoc($resultRes);
				$start_date = new DateTime($rowRes['c_start_date']);
				$end_date = new DateTime($rowRes['c_end_date']);

				$interval = $start_date->diff($end_date);

				$days_diff = $interval->days;

				$percentage = ($daysAtt / $days_diff) * 100;

				if($percentage < 50){
					$result = "لم يجتاز الدورة";
				}else{
					$sql = "INSERT INTO `student_courses`(`student_id`, `course_id`) VALUES ('".$row['std_id']."','".$_GET['id']."')";
					mysqli_query($conn,$sql);
				}

				$sqlR = "INSERT INTO `course_results`(`course_id`, `std_id`, `total_mark`, `result`) VALUES ('".$_GET['id']."','".$row['std_id']."','".$totalMark."','".$result."')";
				$r = mysqli_query($conn,$sqlR);
			}
			$sql = "SELECT type FROM course WHERE c_id = '".$_GET['id']."'";
			$result = mysqli_query($conn,$sql);
			if(mysqli_fetch_assoc($result)['type'] == 0){
				//echo "<script>window.location.href='course_man.php';</script>";
			}else{
				//echo "<script>window.location.href='mton_man.php';</script>";
			}
		}
	}

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>تفاصيل الدورات</title>
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
					<a href="course_man.php" class="active">إدارة الدورات</a>
					<a href="mton_man.php">إدارة المتون</a>
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
		<div class="main-header">
			<h1>تفاصيل الدورات</h1>
			
		</div>

		<div class="content-header">
			<div class="content-header-intro">
				<h2>إدارة الدورات</h2>
				
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
					<?php 
						$sql = "SELECT type FROM course WHERE c_id = '".$_GET['id']."'";
						$result = mysqli_query($conn,$sql);
						if(mysqli_fetch_assoc($result)['type'] == 0){
							echo '<a href="course_man.php" class="active">إدارة الدورات</a>';
							echo '<a href="mton_man.php">إدارة المتون</a>
					<a href="course_man.php" >إدارة الدورات</a>';
						}else{
							echo '';
							echo '<a href="mton_man.php" class="active">إدارة المتون</a>';
						}
					?>
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
				<center style="margin-bottom:20px;"><a href="course_man.php" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
					<?php
						$sql = "SELECT * FROM course WHERE c_id = ".$_GET['id']."";
						$result = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($result);
						// Getting the course info, teacher and students
						$sqlInfo = "SELECT * FROM course_details WHERE course_id = ".$_GET['id']."";
						$resultInfo = mysqli_query($conn,$sqlInfo);
						$rowInfo = mysqli_fetch_assoc($resultInfo);
						// Getting the teacher name 
						$sqlStaff = "SELECT staff_name FROM staff
									 INNER JOIN course_teachers ON staff.staff_id = course_teachers.teacher_id
									 INNER JOIN course ON course.c_id = course_teachers.COURSE_ID
									 WHERE course.c_id = ".$_GET['id']."";
						$resultStaff = mysqli_query($conn,$sqlStaff);
						 
						$sqlCount = "SELECT COUNT(*)  as total from course_details where course_id = ".$_GET['id']."";
						
						
						$resultCount = mysqli_query($conn,$sqlCount);
						$rowCount = mysqli_fetch_assoc($resultCount);
						$std_count = $rowCount['total'];
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/course.png" /></span>
												<h3 id="test">'.$row['c_name'].'</h3>
											</div>

										</div>
										<div class="card-body">
											<p> تاريخ البدء : '.$row['c_start_date'].'</p>
											<p> تاريخ الانتهاء  : '.$row['c_end_date'].'</p>
											<p>اسماء معلمي الدورة : </p>';
											while($rowStaff = mysqli_fetch_assoc($resultStaff)){
												echo '<p>'.$rowStaff['staff_name'].'</p>';
											}
											echo '<p> عدد الطلبة في الدورة : '.$std_count.'</p>
										</div>
										';
										if($std_count == "" and $_SESSION['staff_job'] != "JOB_03"){
											echo '<a href="add_course_std.php?c_id='.$row['c_id'].'"> اضافة طلبة للدورة</a>';
											echo '<div class="card-footer">
													<a href="add_course_ring.php?c_id='.$row['c_id'].'"> اضافة حلقة للدورة</a>
												</div>';
												echo '<div class="card-footer">
															<a href="del_course_std.php?c_id='.$row['c_id'].'"> حذف طالب من الدورة</a>
														</div>';
										}else{
											if($row['status'] == 'مفتوحة'){
												echo '<div class="card-footer"><a href="course_std_details.php?c_id='.$row['c_id'].'">إدخال الدرجات</a></div>';

												if($_SESSION['staff_job'] != "JOB_03"){
													echo '<div class="card-footer">
															<a href="add_course_std.php?c_id='.$row['c_id'].'"> اضافة طلبة للدورة</a>
														</div>';
														echo '<div class="card-footer">
															<a href="add_course_ring.php?c_id='.$row['c_id'].'"> اضافة حلقة للدورة</a>
														</div>';
														echo '<div class="card-footer">
															<a href="del_course_std.php?c_id='.$row['c_id'].'"> حذف طالب من الدورة</a>
														</div>';
												}
												
													if($_SESSION['staff_job'] == 'JOB_01'){
														echo '<div class="card-footer"><a href="course_details.php?closeCourse=1&id='.$row['c_id'].'" onclick="return confirmClose()">إغلاق الدورة</a></div>';
														echo '<div class="card-footer">
																<a href="change_course_end.php?id='.$row['c_id'].'">تغيير المدة</a>
															</div>';
													}
												if($row['status'] == 'مغلقة'){
													echo '<div class="card-footer">
														<a href="course_result_details.php?c_id='.$row['c_id'].'" target="_blank">تفاصيل النتيجة</a>
													</div>';
												}else{
													echo '<div class="card-footer">
															<p">يمكن عرض تفاصيل النتيجة فقط عند إغلاق الدورة</p>
														</div>';
													echo '<div class="card-footer">
													<a href="course_man.php">الرجوع</a>
												</div>';
												}
												
											}else{
												echo '<div class="card-footer">';
												
													echo '<p">الدورة مغلقة</p></div>';
												echo '<div class="card-footer">
													<a href="course_result_details.php?c_id='.$row['c_id'].'" target="_blank">تفاصيل النتيجة</a>
												</div>';
												echo '<div class="card-footer">
													<a href="course_man.php">الرجوع</a>
												</div>';
												
											}	
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
		function confirmClose() {
			if (confirm("هل أنت متأكد من إغلاق الدورة ؟")) {
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
