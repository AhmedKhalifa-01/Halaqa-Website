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
	if(isset($_POST['add_ring'])){
		$att = $_POST['att'];
		$sql = "INSERT INTO `staff_att`(`staff_id`, `date`, `state`) VALUES ('".$_GET['staff_id']."','".date('Y-m-d')."','".$att."')";
		
		if(mysqli_query($conn,$sql)){
			echo "<script>window.location.href='staff_management.php';</script>";
		}else{
			echo "<script>alert('خطأ في إضافة الحضور')</script>";
		}
	}
	if(isset($_GET['vec'])){
		$sql = "UPDATE staff SET status = 'إجازة' WHERE staff_id = '".$_GET['staff_id']."'";
		
		if(mysqli_query($conn,$sql)){
			echo "<script>window.location.href='man_man.php';</script>";
		}else{
			echo "<script>alert('خطأ في إضافة الحضور')</script>";
		}
	}
	if(isset($_GET['back'])){
		$sql = "UPDATE staff SET status = 'دوام' WHERE staff_id = '".$_GET['staff_id']."'";
		
		if(mysqli_query($conn,$sql)){
			echo "<script>window.location.href='man_man.php';</script>";
		}else{
			echo "<script>alert('خطأ في إضافة الحضور')</script>";
		}
	}


?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إدارة الإداريين</title>
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
						<a href="std_management.php" style="background-color:darkred; color:white;">إدارة الطلاب</a>
					<?php }else{?>
						<a href="std_management.php">إدارة الطلاب</a>
					<?php } ?>
					<?php if($_SESSION['staff_job'] != "JOB_03"){?>
						<a href="staff_management.php">إدارة المعلمين</a>
					<?php } ?>
					<?php if($_SESSION['staff_job'] == "JOB_01"){?>
						<a href="man_man.php" class="active">إدارة الإداريين</a>
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
					
					<a href="mton_man.php" >إدارة المتون</a>
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
				<h2>إدارة الإداريين</h2>
				<?php if($_SESSION['staff_job'] == 'JOB_01'){ ?>
				<center><h3 style="font-weight:bold;font-size:24px;">عدد الإداريين في المجمع :<?php 
														$res = mysqli_query($conn,"SELECT COUNT(staff_id) AS count FROM staff WHERE staff_job = 'JOB_02'"); 
														echo mysqli_fetch_assoc($res)['count']; 
													?>
						</h3>
				</center>
				<?php } ?>
			</div>
			<div class="content-header-actions">
				
				<?php
					if($_SESSION['staff_job'] == 'JOB_01'){
						echo '<a href="man_att_record.php" class="button">
								<span>عرض سجل الحضور</span>
							</a>';
					}
				?>
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
						<a href="std_management.php" style="background-color:darkred; color:white;">إدارة الطلاب</a>
					<?php }else{?>
						<a href="std_management.php">إدارة الطلاب</a>
					<?php } ?>
					<?php if($_SESSION['staff_job'] != "JOB_03"){?>
						<a href="staff_management.php">إدارة المعلمين</a>
					<?php } ?>
					<?php if($_SESSION['staff_job'] == "JOB_01"){?>
						<a href="man_man.php" class="active">إدارة الإداريين</a>
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
					
					<a href="mton_man.php" >إدارة المتون</a>	
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
			<div class="search">
					<form action="man_man.php?search=1" methode="get">
						<input type="text" placeholder="اكتب اسم الإداري" name = "search"/>
						<button type="submit">
							<i class="ph-magnifying-glass-bold"></i>
						</button>
					</form>
				</div>
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
					<?php
						$sql = "SELECT * FROM staff WHERE staff_job = 'JOB_02'";
						if(isset($_GET['search'])){
							$sql = "SELECT * FROM staff WHERE staff_job = 'JOB_02' AND staff_name LIKE '%".$_GET['search']."%'";
						}
						$result = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($result)){
							if($row['staff_name'] != 'admin'){
								echo '<article class="card">
										<div class="card-header">
											<div>';
											if($row['staff_job'] == 'JOB_02'){
												echo '<span><img src="imgs/icons/man.png"/></span>';
											}
											if($row['staff_job'] == 'JOB_03'){
												echo '<span><img src="imgs/icons/adult.png"/></span>';
											}
											if($row['isTemp'] == 'محتسب'){
												echo '<h3 id="test">'.$row['staff_name'].' - محتسب</h3>';
											}else{
												echo '<h3 id="test">'.$row['staff_name'].'</h3>';
											}
												echo '
											</div>

										</div>
										<div class="card-body">';
											if($row['status'] == 'إجازة'){
												echo '<p>حالة الدوام : <color style="color:darkred;">في إجازة</color></p>';
											}else{
												echo '<p>حالة الدوام : <color style="color:darkgreen;">مداوم</color></p>';
											}
											if($row['status'] != 'إجازة'){
												if($row['isTemp'] != 'محتسب'){
													$sql = "SELECT * FROM staff_att WHERE staff_id = '".$row['staff_id']."' ORDER BY id DESC LIMIT 1;";
													$lastAtt = mysqli_fetch_assoc(mysqli_query($conn,$sql))['date'];
													if($lastAtt != date('Y-m-d')){
														echo '
														<form class="login-form" action="staff_management.php?staff_id='.$row['staff_id'].'" method="post" >
															<label>
																اختر حالة الحضور اليوم : ';
																echo '</br>
																<input style="width:auto;margin:10px;" type="radio" name="att" value="حضور"> حضور 
																<input style="width:auto;margin:10px;" type="radio" name="att" value="غياب"> غياب
																<input style="width:auto;margin:10px;" type="radio" name="att" value="مستاذن"> مستاذن
															</label>
															<br>
															<button type="submit" name="add_ring">إرسال</button>
														</form>';
													}else{
														echo '<p> تم أخذ الحضور اليوم </p>';
													}
												}
											}
											echo '
										</div>
										<div class="card-footer">
											<a href="staff_more_details.php?id='.$row['staff_id'].'&type=manager">مزيد من التفاصيل</a>
										</div>
										<div class="card-footer">
											<a href="staff_change_details.php?staff_id='.$row['staff_id'].'&type=manager">تعديل البيانات</a>
										</div>';
										echo '<div class="card-footer">
													<a href="man_add_priv.php?staff_id='.$row['staff_id'].'">إدارة الصلاحيات</a>
												</div>';
										if($row['status'] == 'إجازة'){
											echo '<div class="card-footer">
													<a href="man_man.php?staff_id='.$row['staff_id'].'&back=1">عودة من الإجازة</a>
												</div>';
										}else{
											echo '<div class="card-footer">
													<a href="man_man.php?staff_id='.$row['staff_id'].'&vec=1">إجازة للإداري</a>
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
