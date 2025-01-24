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

/* move std to other ring */

	if(isset($_POST['move_std'])){
		$students = $_POST['students'];
		$ring = $_POST['ring'];
		if (!empty($students)) {
			foreach ($students as $std_id) {
				$sql = "SELECT mton_ring_id,mton_ring_temp_id, mton_ring_id_02,mton_ring_temp_id_02, mton_ring_id_03,mton_ring_temp_id_03 FROM students WHERE std_id = '".$std_id."'";
				$result = mysqli_query($conn,$sql);
				$row = mysqli_fetch_assoc($result);
				if($row['mton_ring_id'] == $_GET['mton_ring_id']){

						mysqli_query($conn,"UPDATE students SET mton_ring_temp_id = '".$ring."' WHERE std_id = '".$std_id."'
											AND mton_ring_id_02 != '".$ring."' AND mton_ring_id_03 != '".$ring."'");

				}else if($row['mton_ring_id_02'] == $_GET['mton_ring_id']){

						mysqli_query($conn,"UPDATE students SET mton_ring_temp_id_02 = '".$ring."' WHERE std_id = '".$std_id."'
											AND mton_ring_id != '".$ring."' AND mton_ring_id_03 != '".$ring."'");
				}else if($row['mton_ring_id_03'] == $_GET['mton_ring_id']){

						mysqli_query($conn,"UPDATE students SET mton_ring_temp_id_03 = '".$ring."' WHERE std_id = '".$std_id."'
											AND mton_ring_id_02 != '".$ring."' AND mton_ring_id != '".$ring."'");
				}else{
					if($row['mton_ring_id'] == $ring){
						mysqli_query($conn,"UPDATE students SET mton_ring_temp_id = mton_ring_id WHERE std_id = '".$std_id."'");
					}else if($row['mton_ring_id_02'] == $ring){
						mysqli_query($conn,"UPDATE students SET mton_ring_temp_id_02 = mton_ring_id_02 WHERE std_id = '".$std_id."'");
					}else if($row['mton_ring_id_03'] == $ring){
						mysqli_query($conn,"UPDATE students SET mton_ring_temp_id_03 = mton_ring_id_03 WHERE std_id = '".$std_id."'");
					}else{
						if($row['mton_ring_temp_id'] == $_GET['mton_ring_id']){
							mysqli_query($conn,"UPDATE students SET mton_ring_temp_id = '".$ring."' WHERE std_id = '".$std_id."'
											AND mton_ring_id_02 != '".$ring."' AND mton_ring_id_03 != '".$ring."'");
						}else if($row['mton_ring_temp_id_02'] == $_GET['mton_ring_id']){
							mysqli_query($conn,"UPDATE students SET mton_ring_temp_id = '".$ring."' WHERE std_id = '".$std_id."'
												AND mton_ring_id != '".$ring."' AND mton_ring_id_03 != '".$ring."'");
						}else if($row['mton_ring_temp_id_03'] == $_GET['mton_ring_id']){
							mysqli_query($conn,"UPDATE students SET mton_ring_temp_id_03 = '".$ring."' WHERE std_id = '".$std_id."'
												AND mton_ring_id_02 != '".$ring."' AND mton_ring_id != '".$ring."'");
						}else{

						}
					}
				}
				echo "<script>alert('تمت عملية تحويل الطالب بنجاح');</script>";
				echo "<script>window.location.href='mton_man.php';</script>";				
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>تحويل الطلبة</title>
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
					
					
					<a href="mton_man.php" class="active">إدارة المتون</a>
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
				<h2>تحويل الطلبة</h2>
				
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
					<?php if($_SESSION['staff_job'] != "JOB_03"){?>
					
					<a href="mton_man.php" class="active">إدارة المتون</a>
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
				<center style="margin-bottom:20px;"><a href="mton_man.php" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/quran.png" /></span>
								<h3>تحويل الطلبة</h3>
							</div>
						</div>
						<div class="card-body">
							<form class="login-form" action="mton_ring_move_std.php?mton_ring_id=<?php echo $_GET['mton_ring_id']; ?>" method="post">
								<p>اختر حلقة المتون لتحويل الطلبة إليها</p>
								<select name="ring" id="staff-select">
									<?php
										$sql = "SELECT * FROM mton_ring WHERE mton_ring.mton_ring_id != ".$_GET['mton_ring_id']."";
										$result = mysqli_query($conn,$sql);
										while($row = mysqli_fetch_assoc($result)){
											echo '
												<option value="'.$row['mton_ring_id'].'" selected>'.$row['mton_ring_name'].'</option>
											';
										}
									?>
								</select>
								<p>اختر الطلبة لتحويلهم من الحلقة : </p>
								<ul>
									<?php
									// Retrieve the list of students from the database
									$sql = "SELECT students.std_id,students.mton_ring_id,students.mton_ring_temp_id, students.mton_ring_id_02,students.mton_ring_temp_id_02, students.mton_ring_id_03,students.mton_ring_temp_id_03, mton_ring.mton_ring_id,students.std_name FROM mton_ring 
											INNER JOIN students ON mton_ring.mton_ring_id = students.mton_ring_id
											WHERE students.mton_ring_temp_id = '".$_GET['mton_ring_id']."'
											OR students.mton_ring_temp_id_02 = '".$_GET['mton_ring_id']."'
											OR students.mton_ring_temp_id_03 = '".$_GET['mton_ring_id']."'
											ORDER BY std_name
									";
									$result = mysqli_query($conn, $sql);

									// Display the list of students as checkboxes
									if(mysqli_num_rows($result) > 0) {
										$count = 1;
										while($row = mysqli_fetch_assoc($result)) {
											if($_GET['mton_ring_id'] == $row['mton_ring_id'] and $row['mton_ring_id'] == $row['mton_ring_temp_id']){
												echo '<li><input style="width:auto;margin:10px;" type="checkbox" name="students[]" value="'. $row["std_id"] .'">'.$count.' - '. $row["std_name"] .'</li>';
											}else if($_GET['mton_ring_id'] == $row['mton_ring_id_02'] and $row['mton_ring_id_02'] == $row['mton_ring_temp_id_02']){
												echo '<li><input style="width:auto;margin:10px;" type="checkbox" name="students[]" value="'. $row["std_id"] .'">'.$count.' - '. $row["std_name"] .'</li>';
											}else if($_GET['mton_ring_id'] == $row['mton_ring_id_03'] and $row['mton_ring_id_03'] == $row['mton_ring_temp_id_03']){
												echo '<li><input style="width:auto;margin:10px;" type="checkbox" name="students[]" value="'. $row["std_id"] .'">'.$count.' - '. $row["std_name"] .'</li>';
											}else{
												echo '<li><input style="width:auto;margin:10px;" type="checkbox" name="students[]" value="'. $row["std_id"] .'">'.$count.' - '. $row["std_name"] .'   (طالب محول)</li>';
											}
											$count++;
										}
									}
									?>
								</ul>
								<button type="submit" name="move_std">تحويل</button>
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
