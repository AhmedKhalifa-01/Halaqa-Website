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
		if(mysqli_query($conn,"DELETE FROM pending_parent WHERE p_id_number = '".$_GET['p_id_number']."'")){
			echo "<script>alert('تم حذف الطلب');</script>";
			echo "<script>window.location.href='parents_man.php';</script>";
		}
	}
	if(isset($_GET['agree'])){
		$sql = "INSERT INTO parent (`p_name`, `p_id_number`, `p_phone`, `p_address`, `email`, `pass`)
				SELECT `p_name`, `p_id_number`, `p_phone`, `p_address`, `email`, `pass`
				FROM pending_parent
				WHERE pending_parent.p_id_number = '".$_GET['p_id_number']."'";
		if(mysqli_query($conn,$sql)){
			mysqli_query($conn,"DELETE FROM pending_parent WHERE p_id_number = '".$_GET['p_id_number']."'");
			echo "<script>alert('تمت إضافة ولي الأمر');</script>";
			echo "<script>window.location.href='parents_man.php';</script>";
		}else{
			echo mysqli_error($conn);
		}
	}
	mysqli_query($conn,"UPDATE pending_parent SET seen = 1");

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>الطلبات المعلقة</title>
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
						<a href="man_man.php">إدارة الإداريين</a>
					<?php } ?>
					<a href="parents_man.php" class="active">إدارة أولياء الأمور</a>
					<a href="ring_man.php">إدارة الحلقات  التسميع</a>
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
		<div class="main-header">
			
		</div>

		<div class="content-header">
			<div class="content-header-intro">
				<h2>طلبات أولياء الأمور المعلقة</h2>
				
			</div>
			<div class="content-header-actions">
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
						<a href="man_man.php">إدارة الإداريين</a>
					<?php } ?>
					<a href="parents_man.php" class="active">إدارة أولياء الأمور</a>
					<a href="ring_man.php">إدارة الحلقات  التسميع</a>
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
					<div style="margin-bottom: 400px;">
					</div>
				</div>
			</div>
			<div class="content-main">
			<div class="search">
					<form action="pending_parent.php?search=1" methode="get">
						<input type="text" placeholder="اكتب اسم لي الأمر" name = "search"/>
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
							
							$sql = "SELECT * FROM pending_parent";
							if(isset($_GET['search'])){
								$sql = "SELECT * FROM pending_parent WHERE p_name LIKE '%".$_GET['search']."%'";
							}
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/parent.png" /></span>
												<h3>'.$row['p_name'].'</h3>
											</div>
										</div>
										<div class="card-body">';
											if($_SESSION['staff_job'] == 'JOB_01'){
												echo '<p> كلمة المرور : <color style= "color:red">'.$row['pass'].'</color></p>';
											}
											echo '
											<p> رقم الهاتف : '.$row['p_phone'].'</p>
											';
											echo'
											
										</div>
										<div class="card-footer">
											<a href="pending_parent.php?agree=1&p_id_number='.$row['p_id_number'].'" onclick="return confirmOK()"">الموافقة على الطلب</a>
										</div>
										<div class="card-footer">
											<a href="pending_parent.php?reject=1&p_id_number='.$row['p_id_number'].'" onclick="return confirmDelete()"">حذف الطلب</a>
										</div>
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
	<!-- Script to confirm the delete -->
	<script>
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
