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
	
	if(isset($_POST['submit'])){
		
		$mark = floatval($_POST['mark']);
		if($mark > 10 or $mark < 0){
			echo "<script>alert('الرجاء إدخال درجة ما بين 0 و 10')</script>";
		}else{
			$sql = "INSERT INTO `course_results_details`(`c_id`, `std_id`, `date`, `mark`) VALUES ('".$_GET['c_id']."','".$_GET['std_id']."','".date('Y-m-d')."','".$mark."')";
			$result = mysqli_query($conn,$sql);
			if(!$result){
				echo "<script>alert('خطأ في إدخال الدرجة')</script>";
			}else{
				$sql = "SELECT * FROM course_attendance WHERE std_id = '".$_GET['std_id']."' AND date = '".date('Y-m-d')."' AND course_id = '".$_GET['c_id']."'";
				if(mysqli_num_rows(mysqli_query($conn,$sql)) == 0){
					$sql = "INSERT INTO `course_attendance`(`course_id`, `std_id`, `date`, `state`) VALUES ('".$_GET['c_id']."','".$_GET['std_id']."','".date('Y-m-d')."','حضور')";
					mysqli_query($conn,$sql);
				}else{
					echo mysqli_error($conn);
				}
				echo "<script>alert('تم ادخال الدرجة بنجاح')</script>";

			}
			echo "<script>window.location.href='course_std_details.php?c_id=".$_GET['c_id']."';</script>";
		}
		
	}

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إدخال درجات الكورس</title>
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
		

		<div class="content-header">
			<div class="content-header-intro">
				<h2>إدخال درجات الكورس</h2>
				
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
					<a href="std_management.php" >إدارة الطلاب</a>
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
					<?php 
						$sql = "SELECT type FROM course WHERE c_id = '".$_GET['c_id']."'";
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
					
					<?php
						$sql = "SELECT * FROM (course_details INNER JOIN course ON course_details.course_id = course.c_id) WHERE course_id = ".$_GET['c_id']."";
						$result = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($result);
							$sqlStd = "SELECT * FROM students WHERE std_id = ".$_GET['std_id']."";
							$resultStd = mysqli_query($conn,$sqlStd);
							$rowStd = mysqli_fetch_assoc($resultStd);
							//SELECTING the students grade for this course
							echo '
							<article class="card">
									<div class="card-header">
										<div>
											<span><img src="imgs/icons/quran.png" /></span>
											<h3>'.$rowStd['std_name'].'</h3>
										</div>
									</div>
									<div class="card-body">
										<p> اسم الدورة : '.$row['c_name'].'</p>
										<p> التاريخ : '.date('Y-m-d').'</p>
										<p> كيفية حساب الدرجات : </p>
										<ul>
											<li>9، 9.5، 10 = ممتاز</li>
											<li>8، 8.5 = جيد جدا</li>
											<li>7، 7.5 = جيد</li>
											<li>6، 6.5 = إعادة</li>
											<li>أقل من 6 = لم يحفظ</li>
										</ul>
										';							
										echo'

									</div>
									<div class="card-footer">
										<form class="login-form" action = "course_std_calc_result.php?std_id='.$_GET['std_id'].'&c_id='.$_GET['c_id'].'" method = "post">
											<input type = "text" placeholder="إدخال درجة الكورس" name="mark"/>
											<button type="submit" name="submit">إدخال</button>
										</form>
										</div>
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
