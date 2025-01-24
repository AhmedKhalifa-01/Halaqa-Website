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
			//echo "<script>alert('تم نقل الطالب بنجاح');</script>";
			echo "<script>window.location.href='index.php';</script>";
		}

/* move std to other ring */

	if(isset($_POST['move_std'])){
		if(isset($_POST['students'])){
			$students = $_POST['students'];
		}
		//if(isset($_POST['t_id'])){
		$t_id = $_GET['t_id'];
		//}
		
		if (!empty($students)) {
			foreach ($students as $std_id) {
				echo $std_id." -- ".$t_id;
				mysqli_query($conn,"DELETE FROM tasheeh_std WHERE std_id = '".$std_id."' AND tasheeh_id = '".$t_id."'");
				echo "<script>alert('تم حذف الطالب بنجاح');</script>";
				//echo mysqli_error($conn);
				echo "<script>window.location.href='tasheeh_man.php';</script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>نقل الطلبة</title>
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
				<h2>نقل الطلبة</h2>
				
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
					<?php if($_SESSION['staff_job'] != "JOB_03"){?>
					
					<a href="mton_man.php">إدارة المتون</a>
					<a href="course_man.php" >إدارة الدورات</a>
					
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
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/quran.png" /></span>
								<h3>حذف الطلبة</h3>
							</div>
						</div>
						<div class="card-body">
							<form class="login-form" action="tasheeh_del_std.php?t_id=<?php echo $_GET['t_id']; ?>" method="post">
								
								<p>اختر الطلبة لحذفهم من الحلقة : </p>
								<ul>
									<?php
									// Retrieve the list of students from the database
									$sql = "SELECT * FROM students WHERE std_id IN (SELECT std_id FROM tasheeh_std WHERE tasheeh_std.tasheeh_id = '".$_GET['t_id']."')";
									$result = mysqli_query($conn, $sql);

									// Display the list of students as checkboxes
									if(mysqli_num_rows($result) > 0) {
										while($row = mysqli_fetch_assoc($result)) {
												
											echo '<li><input style="width:auto;margin:10px;" type="checkbox" name="students[]" value="'. $row["std_id"] .'">'. $row["std_name"] .'</li>';
												
												//echo '<li><input style="width:auto;margin:10px;" type="checkbox" name="students[]" value="'. $row["std_id"] .'">'. $row["std_name"] .'</li>';
											
										}
									}
									?>
								</ul>
								<button type="submit" name="move_std">حذف</button>
							  </form>
						</div>
					</article>					
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
