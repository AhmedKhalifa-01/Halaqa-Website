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

	if(isset($_GET['closeP'])){
		$sql = "UPDATE prize SET state = 'مغلقة' WHERE prize_id = '".$_GET['prize_id']."'";
		$result = mysqli_query($conn,$sql);
		if(!$result){
			echo "<script>alert('خطأ في إغلاق الجائزة')</script>";
		}
		echo "<script>window.location.href='prize_man.php';</script>";
	}
	if(isset($_GET['openP'])){
		$sql = "SELECT EXISTS (SELECT 1 FROM prize WHERE state = 'مستمرة') As ex;";
		$res = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($res);
		if($row['ex'] != 1){
			$sql = "UPDATE prize SET state = 'مستمرة' WHERE prize_id = '".$_GET['prize_id']."'";
			$result = mysqli_query($conn,$sql);
			if(!$result){
				echo "<script>alert('خطأ في فتح الجائزة')</script>";
			}
			echo "<script>window.location.href='prize_man.php';</script>";
		}else{
			echo "<script>alert('توجد جائزة مفتوحة قم باغلاقها أولا')</script>";
		}
	}
	if(isset($_GET['delP'])){
		
		$sql = "DELETE FROM prize WHERE prize_id = '".$_GET['prize_id']."'";
		mysqli_query($conn,$sql);
		echo mysqli_error($conn);
	}

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إدارة الجوائز</title>
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
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0  or mysqli_num_rows(mysqli_query($conn,$sql2)) > 0) and ($_SESSION['staff_job'] == 'JOB_01' or $_SESSION['staff_job'] == 'JOB_02')){
					?>
						<a href="std_management.php" style="background-color:darkred; color:white;">إدارة الطلاب</a>
					<?php }else{?>
						<a href="std_management.php">إدارة الطلاب</a>
					<?php } ?>
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
					<a href="course_man.php" >إدارة الدورات</a>
					<a href="mton_man.php">إدارة المتون</a>
					<?php if($_SESSION['staff_job'] != "JOB_03"){?>
					<a href="prize_man.php" class = "active">إدارة الجوائز</a>
					<?php } ?>				
					<?php
						if($_SESSION['staff_job'] == 'JOB_01'){
							echo ' <a href=".php">حلقة تصحيح التلاوة</a>
								   <a href="homepage_man.php">إدارة الصفحة الرئيسية</a>
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
			<?php if($_SESSION['staff_job'] == "JOB_03"){echo "<script>window.location.href='../../index.php';</script>";}?>
				<h2>إدارة الجوائز</h2>
				
			</div>
			
			<?php if($_SESSION['staff_job'] == 'JOB_01'){ ?>
				<div class="content-header-actions">
				
					<a href="new_prize.php" class="button">
						<i class="ph-plus-bold"></i>
						<span>إضافة جائزة جديدة</span>
					</a>
					<a href="star_stat.php" class="button">
						<i class="ph-plus-bold"></i>
						<span>احصائيات النجوم</span>
					</a>
				</div>
			<?php } ?>
			
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
					<a href="course_man.php" >إدارة الدورات</a>
					<a href="mton_man.php">إدارة المتون</a>
					<?php if($_SESSION['staff_job'] != "JOB_03"){?>
					<a href="prize_man.php" class = "active">إدارة الجوائز</a>
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
				
				<div class="card-grid">
					<?php
						$sql = "SELECT *,prize.prize_id AS prize_id, count(prize_participating_students.std_id) as count FROM prize
								LEFT JOIN prize_participating_students ON prize_participating_students.prize_id = prize.prize_id
								GROUP BY prize.prize_id
								";
						$result = mysqli_query($conn,$sql);
						if(mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_assoc($result)){
								if($row['prize_id'] == NULL){
									continue;
								}
									echo '<article class="card">
											<div class="card-header">
												<div>
													<span><img src="imgs/icons/trophy.png" /></span>
													<h3 id="test">'.$row['prize_name'].'</h3>
												</div>

											</div>
											<div class="card-body">
												<p> تاريخ البدء : '.$row['start_date'].'</p>
												<p> تاريخ الانتهاء  : '.$row['end_date'].'</p>
												<p> عدد الطلبة المشاركين في الجائزة  : '.$row['count'].'</p>
												<p> الحالة : '.$row['state'].'</p>
											</div>
											
											<div class="card-footer">
												<a href="prize_details.php?prize_id='.$row['prize_id'].'">مزيد من التفاصيل</a>
											</div>';
											//if($_SESSION['staff_job'] == 'JOB_01'){
												if($row['state'] != 'مغلقة'){
													$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '6'")) > 0;
													if($_SESSION['staff_job'] == 'JOB_01' or $prev){
													echo '<div class="card-footer">
															<a href="prize_man.php?prize_id='.$row['prize_id'].'&closeP=1">إغلاق الجائزة</a>
														</div>'
														;
													}
													$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '7'")) > 0;
													if($_SESSION['staff_job'] == 'JOB_01' or $prev){
														echo '<div class="card-footer">
															<a href="show_prize_details.php?prize_id='.$row['prize_id'].'">نتائج الجائزة</a>
														</div>';
													}
													$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '8'")) > 0;
													if($_SESSION['staff_job'] == 'JOB_01' or $prev){
														echo '<div class="card-footer">
															<a href="prize_gift.php?prize_id='.$row['prize_id'].'">توزيع الجوائز</a>
														</div>'
														;
													}
													$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '9'")) > 0;
													if($_SESSION['staff_job'] == 'JOB_01' or $prev){
														echo '<div class="card-footer">
																<a href="change_prize_date.php?id='.$row['prize_id'].'">تعديل الزمن</a>
														</div>';
														echo '<div class="card-footer">
																<a href="prize_change_value.php?prize_id='.$row['prize_id'].'">تعديل قيمة الجوائز</a>
														</div>';
													}
												}else{
													$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '10'")) > 0;
													if($_SESSION['staff_job'] == 'JOB_01' or $prev){
													echo '<div class="card-footer"><p style="color:red;font-size: 16px;width: 100%;">الجائزة مغلقة</p></div>
													<div class="card-footer">
															<a href="prize_man.php?prize_id='.$row['prize_id'].'&openP=1">إعادة فتح الجائزة</a>
													</div>';
													}
													$prev = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM prev WHERE staff_id = '".$_SESSION['email']."' AND prev_id = '11'")) > 0;
													if($_SESSION['staff_job'] == 'JOB_01' or $prev){
													echo '<div class="card-footer">
																<a href="prize_man.php?prize_id='.$row['prize_id'].'&delP=1" onclick="return confirmDelete()">حذف الجائزة</a>
														</div>';
													}
													if($_SESSION['staff_job']){
														echo '<div class="card-footer">
																<a href="change_prize_date.php?id='.$row['prize_id'].'&delP=1">تغيير الزمن</a>
														</div>';
													}
												}
											//}
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
  <script>
		function confirmDelete() {
			if (confirm("هل أنت متأكد من حذف هذه الجائزة ؟")) {
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
