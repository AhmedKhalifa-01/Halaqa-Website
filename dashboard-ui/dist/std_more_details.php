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

	if(isset($_GET['deactivate'])){
		$status = $_GET['deactivate'];
		if($status == 0){
			$sql = 'UPDATE `staff` SET `status`="Deactivated" WHERE staff_id = '.$_GET['id'].'';
			$result = mysqli_query($conn,$sql);
			if(!$result){
				echo "<script>alert('خطأ في إيقاف الحساب')</script>";
			}
		}
		if($status == 1){
			$sql = 'UPDATE `staff` SET `status`="Activated" WHERE staff_id = '.$_GET['id'].'';
			$result = mysqli_query($conn,$sql);
			if(!$result){
				echo "<script>alert('خطأ في تفعيل الحساب')</script>";
			}
		}
	}
	if(isset($_POST['add_parent'])){
		$p_id = $_POST['parent_select'];
		$sql = "INSERT INTO `std_parent_rel`(`parent_id`, `std_id`) VALUES ('".$p_id."','".$_GET['id']."')";
		if(mysqli_query($conn,$sql)){
			echo "<script>alert('تمت اضافة ولي الأمر بنجاح')</script>";
			echo "<script>window.location.href='std_management.php';</script>";
		}else{
			echo "<script>alert('خطأ في اضافة ولي الأمر')</script>";
		}
	}
	if(isset($_GET['state'])){
		$state = $_GET['state'];
		if($state == 1){
			$sql = "UPDATE students SET state = 'متوقف' WHERE std_id = '".$_GET['id']."'";
			if(mysqli_query($conn,$sql)){
				//echo "<script>window.location.href='std_more_details.php?id=".$_GET['id']."';</script>";
			}
		}
		if($state == 2){
			$sql = "UPDATE students SET state = 'مفصول', ring_id = NULL, temp_ring_id = NULL WHERE std_id = '".$_GET['id']."'";
			if(mysqli_query($conn,$sql)){
				//echo "<script>window.location.href='std_more_details.php?id=".$_GET['id']."';</script>";
			}
		}
		if($state == 3){
			$sql = "UPDATE students SET state = 'منتظم' WHERE std_id = '".$_GET['id']."'";
			if(mysqli_query($conn,$sql)){
				//echo "<script>window.location.href='std_more_details.php?id=".$_GET['id']."';</script>";
			}
		}
		if($state == 4){
			$ring_id = mysqli_fetch_assoc(mysqli_query($conn,"SELECT temp_ring_id FROM students WHERE std_id = ".$_GET['id'].""))['temp_ring_id'];
			header("Location: ring_details_more_std_details.php?std_id=".$_GET['id']."&ring_id=".$ring_id."");
		}
		
		
	}

	if(isset($_GET['vec'])){
		$sql = "UPDATE students SET status = 'إجازة' WHERE std_id = '".$_GET['id']."'";
		
		if(mysqli_query($conn,$sql)){
			echo "<script>window.location.href='std_more_details.php?id=".$_GET['id']."';</script>";
		}else{
			echo "<script>alert('خطأ في تعديل الاجازة')</script>";
		}
	}
	if(isset($_GET['back'])){
		$sql = "UPDATE students SET status = 'دوام' WHERE std_id = '".$_GET['id']."'";
		
		if(mysqli_query($conn,$sql)){
			echo "<script>window.location.href='std_more_details.php?id=".$_GET['id']."';</script>";
		}else{
			echo "<script>alert('خطأ في تعديل الاجازة')</script>";
		}
	}

	echo mysqli_error($conn);

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>تفاصيل الطالب</title>
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
			<?php
				/*if($_SESSION['staff_job'] == 'student'){
					$sql = "SELECT std_name FROM students WHERE std_id = '".$_SESSION['email']."'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
					echo "<h1>".$row['std_name']."</h1>";
				}
				if($_SESSION['staff_job'] == 'parent'){
					$sql = "SELECT p_name FROM parent WHERE p_id = '".$_SESSION['email']."'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
					echo "<h1>".$row['p_name']."</h1>";
				}
				if($_SESSION['staff_job'] == 'JOB_01' or $_SESSION['staff_job'] == 'JOB_02' or $_SESSION['staff_job'] == 'JOB_03'){
					$sql = "SELECT staff_name FROM staff WHERE staff_id = '".$_SESSION['email']."'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
					echo "<h1>".$row['staff_name']."</h1>";
				}*/
			?>
		</div>

		<div class="content-header">
			<div class="content-header-intro">
				<h2>تفاصيل الطالب</h2>
				
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
				<center style="margin-bottom:20px;"><a href="std_management.php" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
				<?php
						$sql = "SELECT * FROM students
							 	LEFT JOIN ring ON ring.ring_id = students.ring_id
								WHERE std_id LIKE '".$_GET['id']."'";
						$result = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($result);
							echo '<article class="card">
									<div class="card-header">
										<div>
											<span style="width:100%;height:100%;"><img src="imgs/'.$row['std_profile'].'" /></span>
										</div>';
										/*echo '<div class="card-footer">';
										if($_SESSION['staff_job'] == 'JOB_01'){
											if($row['status'] == "Activated"){
												if(isset($_GET['isCourse'])){
													echo '<a href="std_more_details.php?deactivate=0&id='.$row['std_id'].'&isCourse=1&c_id='.$_GET['c_id'].'">إيقاف الحساب</a>
													';
												}else{
													
														echo '<a href="std_more_details.php?deactivate=0&id='.$row['std_id'].'">إيقاف الحساب</a>
														';
												}											
											}
											else{
												if(isset($_GET['isCourse'])){
													echo '<a href="std_more_details.php?deactivate=1&id='.$row['std_id'].'&isCourse=1&c_id='.$_GET['c_id'].'">تفعيل الحساب</a>
													';
												}else{
													echo '<a href="std_more_details.php?deactivate=1&id='.$row['std_id'].'">تفعيل الحساب</a>
													';
												}
											}
										}*/
									echo '
									</div>
									<div class="card-body">
										<p> الاسم : '.$row['std_name'].'</p>
										<p> الجنسية : '.$row['std_nat'].'</p>
										<p> رقم الهوية : <color style= "color:red">'.$row['std_id_num'].'</color></p>';
										if($_SESSION['staff_job'] == 'JOB_01'){
											echo '<p> الحلقة : <a href="ring_man.php" style="text-decoration:none;">'.$row['ring_name'].'</a></p>';
										}
										if($_SESSION['staff_job'] == 'JOB_01'){
											echo '<p> كلمة المرور : <color style= "color:red">'.$row['pass'].'</color></p>';
										}
										echo '<p>أولياء الأمور : </p>';
											$sql = "SELECT * FROM parent
													LEFT JOIN std_parent_rel ON parent.p_id = std_parent_rel.parent_id
													WHERE std_parent_rel.std_id = '".$row['std_id']."'
											";
											$ress = mysqli_query($conn,$sql);
											if(mysqli_num_rows($ress) > 0){
												echo '<ol style="list-style: arabic-indic;margin: -10px 50px 15px 0px;">';
												while($rw = mysqli_fetch_assoc($ress)){
													echo '<li style="padding:5px;font-size: 15px;">'.$rw['p_name'].'</li>';
												}
												echo '</ol>';
											}
											if($_SESSION['staff_job'] == 'JOB_01'){
												echo '
												<p> تاريخ الميلاد : '.$row['std_birth_date'].'</p>
												<p> مكان الميلاد : '.$row['std_birth_loc'].'</p>
												<p> المستوى التعليمي : '.$row['std_lvl'].'</p>
												<p> تاريخ الالتحاق بالمجمع : </br><center>'.$row['std_enroll_date'].'</center></p>';
											}
											echo ' <p> رقم الهاتف : '.$row['std_phone'].'</p>';
											if($_SESSION['staff_job'] == 'JOB_01'){
												echo '
													<p> آخر سورة تم حفظها : '.$row['std_last_sorah'].'</p>
													<p> الأجزاء التي تم اختبارها : '.$row['std_tested'].'</p>
													<p> الأجزاء التي حفظها : '.$row['std_v_mem'].'</p>
													<p> الإيميل : '.$row['email'].'</p>';
											}
											echo'</div>';
									$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '2'")) > 0;
									if($_SESSION['staff_job'] == 'JOB_01' or $prev){
										if($row['pRequired'] == 'YES'){
											echo '<div class="card-footer">
												<p>إضافة ولي أمر : </p></br>
												<form class="login-form" action="std_more_details.php?id='.$row['std_id'].'" method="post">
													<select name="parent_select" id="parent_select" style = "width:100%;padding:15px;font-size:13px">';
													echo $row['std_id'];
													$sql = "SELECT * FROM parent WHERE p_id != 13 ORDER BY parent.p_name";
													$result = mysqli_query($conn,$sql);
													while($row2 = mysqli_fetch_assoc($result)){
														echo '
															<option value="'.$row2['p_id'].'" selected>'.$row2['p_name'].'</option>
														';
													}
													echo '
													</select>
													<button type="submit" name="add_parent">إضافة</button>
												</form>
											</div>';
											
										}
									}
									if($_SESSION['staff_job'] == 'JOB_01'){
									echo '<div class="card-footer">
											<a href="std_adjust_details.php?std_id='.$row['std_id'].'">تعديل البيانات</a>
										</div>
										<div class="card-footer">
											<a href="del_parent.php?std_id='.$row['std_id'].'">حذف ولي أمر</a>
										</div>';
										$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '1'")) > 0;
										if($_SESSION['staff_job'] == 'JOB_01' or $prev){
											if($row['status'] == 'إجازة'){
												echo '<div class="card-footer">
														<a href="std_more_details.php?id='.$_GET['id'].'&back=1">عودة من الإجازة</a>
													</div>';
											}else{
												echo '<div class="card-footer">
														<a href="std_more_details.php?id='.$_GET['id'].'&vec=1">إجازة للطالب</a>
													</div>';
											}
										}
									
									}
									if($_SESSION['staff_job'] == 'JOB_01'){
										echo '<div class="card-footer">
												<a href="del_acc.php?type=2&id='.$row['std_id'].'" onclick="return confirmDelete()">حذف الحساب</a>
											</div>';
											
										if($row['state'] == 'منتظم'){
											//ايقاف الطالب = 1
											// فصل الطالب = 2
											// انتظام الطالب = 3
											echo '<div class="card-footer">
												<a href="std_more_details.php?state=1&id='.$row['std_id'].'">إيقاف الطالب</a>
											</div>';
											echo '<div class="card-footer">
												<a href="std_more_details.php?state=2&id='.$row['std_id'].'">فصل الطالب</a>
											</div>';
											$sq = "SELECT date FROM std_att WHERE date = '".date('Y-m-d')."' AND std_id = '".$_GET['id']."'";
											if(mysqli_num_rows(mysqli_query($conn,$sq)) <= 0){
												echo '<div class="card-footer">
													<a href="std_more_details.php?state=4&id='.$row['std_id'].'">استاذان الطالب</a>
												</div>';
											}else{
												echo '<div class="card-footer">
														<p>تم تسجيل حضور الطالب مسبقا</p>
													</div>';
											}
										}
										if($row['state'] == 'متوقف'){
											echo '<div class="card-footer">
												<a href="std_more_details.php?state=3&id='.$row['std_id'].'">إعادة الطالب كمنتظم</a>
											</div>';
											echo '<div class="card-footer">
												<a href="std_more_details.php?state=2&id='.$row['std_id'].'">فصل الطالب</a>
											</div>';
											$sq = "SELECT date FROM std_att WHERE date = '".date('Y-m-d')."' AND std_id = '".$_GET['id']."'";
											if(mysqli_num_rows(mysqli_query($conn,$sq)) <= 0){
												echo '<div class="card-footer">
													<a href="std_more_details.php?state=4&id='.$row['std_id'].'">استاذان الطالب</a>
												</div>';
											}else{
												echo '<div class="card-footer">
														<p>تم تسجيل حضور الطالب مسبقا</p>
													</div>';
											}
										}
										if($row['state'] == 'مفصول'){
											echo '<center><p style="font-size:18px;margin-bottom:10px;">هذا الطالب مفصول</p></center>';
										}
										if($row['state'] == 'مستاذن'){
											echo '<div class="card-footer">
												<a href="std_more_details.php?state=3&id='.$row['std_id'].'">إعادة الطالب كمنتظم</a>
											</div>';
											echo '<div class="card-footer">
												<a href="std_more_details.php?state=2&id='.$row['std_id'].'">فصل الطالب</a>
											</div>';
											echo '<div class="card-footer">
												<a href="std_more_details.php?state=1&id='.$row['std_id'].'">إيقاف الطالب</a>
											</div>';
										}
									}
									echo'
								</article>
							';
						
					?>
				</div>
			</div>
		</div>
	</div>
</main>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script>
  <script  src="./script.js"></script>
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
	</script>
</html>
