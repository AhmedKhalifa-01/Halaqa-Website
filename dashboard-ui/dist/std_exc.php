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
	mysqli_query($conn,"UPDATE std_exc SET seen = 1");
	if(isset($_GET['ag'])){
		$sq = "SELECT date FROM std_att WHERE date = '".date('Y-m-d')."' AND std_id = '".$_GET['std_id']."'";
		if(mysqli_num_rows(mysqli_query($conn,$sq)) > 0){
			$sql = "SELECT * FROM std_exc WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['std_id']."'";
			$rres = mysqli_query($conn,$sql);
			$row = mysqli_fetch_assoc($rres);
			if($row['std_id'] == $row['sender']){
				$sql = "INSERT INTO `messages`(`user_id`, `user_type`, `msg`, `date`) VALUES ('".$row['sender']."','1','تم تسجيل الحضور مسبقا','".date('Y-m-d')."')";
				if(!mysqli_query($conn,$sql)){
					echo "<script>alert('خطأ في إرسال الرسالة')</script>";
				}
			}else{
				$sql = "INSERT INTO `messages`(`user_id`, `user_type`, `msg`, `date`) VALUES ('".$row['sender']."','2','تم تسجيل الحضور مسبقا','".date('Y-m-d')."')";
				if(!mysqli_query($conn,$sql)){
					echo "<script>alert('خطأ في إرسال الرسالة')</script>";
				}
			}
			echo "<script>alert('تم تسجيل حضور هذا الطالب مسبقا')</script>";
			echo "<script>window.location.href='std_exc.php';</script>";
		}else{
			$sql1 = "INSERT INTO `review`(`std_id`, `date`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."')";
			mysqli_query($conn,$sql1);
			$last_inserted_id = mysqli_insert_id($conn);
			$sql2 = "INSERT INTO `recite`(`std_id`, `date`, rev_id) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','".$last_inserted_id."')";
			mysqli_query($conn,$sql2);
			$sql3 = "INSERT INTO `std_att`(`std_id`, `date`,`state`, rev_id) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','مستاذن','".$last_inserted_id."')";
			mysqli_query($conn,$sql3);
			$sql4 = "INSERT INTO `std_on_plan`(`std_id`, `date`,`onPlan`, rev_id) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','متأخر','".$last_inserted_id."')";
			mysqli_query($conn,$sql4);

	
			mysqli_query($conn,"UPDATE std_exc SET state = 'موافقة' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['date']."'");
			
			$sql = "SELECT * FROM std_exc WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['date']."'";
			$rres = mysqli_query($conn,$sql);
			$row = mysqli_fetch_assoc($rres);
			if($row['std_id'] == $row['sender']){
				echo $row['sender'];
				$sql = "INSERT INTO `messages`(`user_id`, `user_type`, `msg`, `date`) VALUES ('".$row['sender']."','1','تمت الموافقة على طلب الاستئذان','".date('Y-m-d')."')";
				if(!mysqli_query($conn,$sql)){
					echo "<script>alert('خطأ في إرسال الرسالة')</script>";
				}
			}else{
				$sql = "INSERT INTO `messages`(`user_id`, `user_type`, `msg`, `date`) VALUES ('".$row['sender']."','2','تمت الموافقة على طلب الاستئذان','".date('Y-m-d')."')";
				if(!mysqli_query($conn,$sql)){
					echo "<script>alert('خطأ في إرسال الرسالة')</script>";
				}
			}
			
			echo "<script>alert('تمت الموافقة على الطلب')</script>";
			echo "<script>window.location.href='std_exc.php';</script>";
		}

	}
	if(isset($_GET['rej'])){
		mysqli_query($conn,"UPDATE std_exc SET state = 'رفض' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['date']."'");
		$sql = "SELECT * FROM std_exc WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['date']."'";
		$rres = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($rres);
		if($row['std_id'] == $row['sender']){
			$sql = "INSERT INTO `messages`(`user_id`, `user_type`, `msg`, `date`) VALUES ('".$row['std_id']."','1','تم رفض طلب الاستئذان','".date('Y-m-d')."')";
			if(!mysqli_query($conn,$sql)){
				echo "<script>alert('خطأ في إرسال الرسالة')</script>";
			}
		}else{
			$sql = "INSERT INTO `messages`(`user_id`, `user_type`, `msg`, `date`) VALUES ('".$row['sender']."','2','تم رفض طلب الاستئذان','".date('Y-m-d')."')";
			if(!mysqli_query($conn,$sql)){
				echo "<script>alert('خطأ في إرسال الرسالة')</script>";
			}
		}
		echo "<script>alert('تم رفض الطلب')</script>";
		echo "<script>window.location.href='std_exc.php';</script>";
	}
?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>الاستئذان</title>
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
			
		</div>

		<div class="content-header">
			<div class="content-header-intro">
				<h2>طلبات الاستئذان</h2>
				
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
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
					<?php
						if(isset($_GET['search'])){
							$sql = "SELECT * FROM students
									INNER JOIN ring ON ring.ring_id = students.ring_id
									INNER JOIN staff ON staff.staff_id = ring.ring_man
									INNER JOIN std_exc ON std_exc.std_id = students.std_id
									WHERE ring.ring_man = '".$_SESSION['email']."' AND  students.std_name LIKE '%".$_GET['search']."%'";
									
									if($_SESSION['staff_job'] == 'JOB_01'){
										$sql = "SELECT *,std_exc.date FROM students 
												INNER JOIN std_exc ON std_exc.std_id = students.std_id
												WHERE students.std_name LIKE '%".$_GET['search']."%'";
									}
							//$sql = "SELECT * FROM students WHERE std_name LIKE '%".$_GET['search']."%'";
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/student.png" /></span>
												<h3>'.$row['std_name'].'</h3>
											</div>
										</div>
										<div class="card-body">
											<p>التاريخ :'.$row['date'].'</p>
										</div>
										<div class="card-footer">
											<a href="std_exc.php?std_id='.$row['std_id'].'&ag=1">الموفقة على الاستئذان</a>
										</div>
										<div class="card-footer">
											<a href="std_exc.php?std_id='.$row['std_id'].'&rej=1">رفض الاستئذان</a>
										</div>
									</article>
								';
							}
						}else{
							$sql = "SELECT * FROM students
									INNER JOIN ring ON ring.ring_id = students.ring_id
									INNER JOIN staff ON staff.staff_id = ring.ring_man
									INNER JOIN std_exc ON std_exc.std_id = students.std_id
									WHERE std_exc.state = 'انتظار' AND ring.ring_man = '".$_SESSION['email']."'";
									if($_SESSION['staff_job'] == 'JOB_01'){
										$sql = "SELECT * FROM students
												INNER JOIN std_exc ON std_exc.std_id = students.std_id
												WHERE std_exc.state = 'انتظار'
												";
									}
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/student.png" /></span>
												<h3>'.$row['std_name'].'</h3>
											</div>
										</div>
										<div class="card-body">
											<p>التاريخ : '.$row['date'].'</p>
										</div>
										<div class="card-footer">
											<a href="std_exc.php?date='.$row['date'].'&std_id='.$row['std_id'].'&ag=1" onclick="return confirmAg()">الموفقة على الاستئذان</a>
										</div>
										<div class="card-footer">
											<a href="std_exc.php?date='.$row['date'].'&std_id='.$row['std_id'].'&rej=1" onclick="return confirmRej()">رفض الاستئذان</a>
										</div>
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
		function confirmRej() {
			if (confirm("هل أنت متأكد من رفض طلب الاستئذان ؟")) {
				return true;
			} else {
				return false;
			}
		}
		function confirmAg() {
			if (confirm("هل أنت متأكد من الموافقة على طلب الاستئذان ؟")) {
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
