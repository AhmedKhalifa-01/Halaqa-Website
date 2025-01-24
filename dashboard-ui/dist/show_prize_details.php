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
	$sql = "SELECT * FROM prize WHERE prize_id = '".$_GET['prize_id']."'";
	if(mysqli_num_rows(mysqli_query($conn,$sql)) == 0){
		echo "<script>window.location.href='prize_man.php';</script>";
	}
	if(isset($_GET['ring_id'])){
		$res = false;
		$sql = "SELECT * FROM students WHERE ring_id = '".$_GET['ring_id']."'";
		$result = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$sql = "SELECT std_id FROM prize_participating_students WHERE std_id = '".$row['std_id']."' AND prize_id = '".$_GET['prize_id']."'";
			if(mysqli_num_rows(mysqli_query($conn,$sql)) == 0){
				$sql = "INSERT INTO `prize_participating_students`(`prize_id`,`std_id`,`ring_id`) VALUES ('".$_GET['prize_id']."','".$row['std_id']."','".$row['ring_id']."')";
				$res = mysqli_query($conn,$sql);
				if($res){
					$res = true;
					$sql = "UPDATE prize SET no_std = no_std+1 WHERE prize_id = '".$_GET['prize_id']."'";
					mysqli_query($conn,$sql);
				}
			}
		}
		if($res){
			echo "<script>alert('تمت اضافة الحلقة بنجاح')</script>";
		}else{
			echo "<script>alert('جميع طلاب هذه الحلقة تمت إضافتهم مسبقا')</script>";
		}
		echo "<script>window.location.href='prize_man.php';</script>";
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
				<h2>تفاصيل الطلبة في الجائزة</h2>
				
			</div>

		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
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
				<center style="margin-bottom:20px;"><a href="prize_details.php?prize_id=<?php echo $_GET['prize_id'];?>" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
				<?php 
							$sql = "SELECT ring.ring_id,ring.ring_name,t.staff_name AS teacher_name, s.staff_name AS supervisor_name, COUNT(students.std_id) AS student_count
									FROM ring
									LEFT JOIN students ON students.temp_ring_id = ring.ring_id
									LEFT JOIN staff t ON t.staff_id = ring.staff_id
									LEFT JOIN staff s ON s.staff_id = ring.ring_man
									WHERE students.std_id IN(SELECT std_id FROM prize_participating_students)
									GROUP BY ring.ring_id
									ORDER BY ring.ring_order";
							if(isset($_GET['search'])){
								$sql = "SELECT ring.ring_id,ring.ring_name,t.staff_name AS teacher_name, s.staff_name AS supervisor_name, COUNT(students.std_id) AS student_count
										FROM ring
										LEFT JOIN students ON students.temp_ring_id = ring.ring_id
										INNER JOIN staff t ON t.staff_id = ring.staff_id
										INNER JOIN staff s ON s.staff_id = ring.ring_man
										WHERE ring_name LIKE '%".$_GET['search']."%'
										GROUP BY ring.ring_id
										ORDER BY ring.ring_name
										";
							}

					
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								//if($row['student_count'] > 0){
									echo '<article class="card">
											<div class="card-header">
												<div>
													<span><img src="imgs/icons/quran.png" /></span>
													<h3> اسم الحلقة : '.$row['ring_name'].'</h3>
												</div>
											</div>
											<div class="card-body">';
												echo '<p> عدد الطلبة في الجائزة : '.$row['student_count'].'</p>											
											</div>
											<div class="card-footer">
												<a href="prize_std_details.php?ring_id='.$row['ring_id'].'&prize_id='.$_GET['prize_id'].'">عرض التفاصيل</a>
											</div>
											<div class="card-footer">
												<a href="star_results.php?ring_id='.$row['ring_id'].'&prize_id='.$_GET['prize_id'].'">التعديل على النجوم</a>
											</div>';
											echo '
										</article>
									';
								//}
								
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
		function confirmAdd() {
			if (confirm("هل أنت متأكد من إضافة الحلقة للجائزة ؟")) {
				return true;
			} else {
				return false;
			}
		}
	</script>
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
<?php 
	echo mysqli_error($conn);
?>