<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		//if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_04'){
			//	if($_SESSION['staff_job'] != 'JOB_03'){
				//echo "<script>window.location.href='index.php';</script>";
		//	}
		//}			
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}
?>
			<?php if($_SESSION['staff_job'] == "JOB_03"){echo "<script>window.location.href='../../index.php';</script>";}?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>احصائيات الطلاب</title>
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
			<?php if($_SESSION['staff_job'] == 'JOB_04') {?>
						
					<?php }else{ ?>
						<a href="new_acc.php">إضافة حساب</a>
						
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
					<?php
						$sql = "SELECT * FROM pending_parent WHERE seen = 0";
						if(mysqli_num_rows(mysqli_query($conn,$sql)) > 0 and ($_SESSION['staff_job'] == 'JOB_01' and $_SESSION['staff_job'] == 'JOB_02') ){
					?>
					<a href="parents_man.php" style="background-color:darkred; color:white;">إدارة أولياء الأمور</a>
					<?php }else{?>
					<a href="parents_man.php">إدارة أولياء الأمور</a>
					<?php } ?>
						<a href="ring_man.php" class="active">إدارة الحلقات  التسميع</a>
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
						<div style="margin-bottom: 10px;">
							<!-- content above the link -->
						</div>
				<?php } ?>
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
				<h2>
					<?php
						$rname = mysqli_fetch_assoc(mysqli_query($conn,"SELECT ring_name FROM ring WHERE ring_id = '".$_GET['ring_id']."'"))['ring_name'];
						echo $rname;
						$std_name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT std_name FROM students WHERE std_id = '".$_GET['std_id']."'"))['std_name'];
						echo " - ".$std_name;
					?>
					- إحصائيات الطلاب
				</h2>
				
			</div>
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					<?php if($_SESSION['staff_job'] == 'JOB_04') {?>
						
						</div>
					<?php }else{ ?>
						<a href="new_acc.php">إضافة حساب</a>
						
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
					<?php
						$sql = "SELECT * FROM pending_parent WHERE seen = 0";
						if(mysqli_num_rows(mysqli_query($conn,$sql)) > 0 and ($_SESSION['staff_job'] == 'JOB_01' and $_SESSION['staff_job'] == 'JOB_02') ){
					?>
					<a href="parents_man.php" style="background-color:darkred; color:white;">إدارة أولياء الأمور</a>
					<?php }else{?>
					<a href="parents_man.php">إدارة أولياء الأمور</a>
					<?php } ?>
						<a href="ring_man.php" class="active">إدارة الحلقات  التسميع</a>
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
								<div style="margin-bottom: 400px;">
									<!-- content above the link -->
								</div>';
							}else{
								echo '<a href="my_msgs.php" target="_blank">عرض رسائلي</a>';
							}
						?>
					</div>
				<?php } ?>
			</div>
			<div class="content-main">
				<?php if($_SESSION['staff_job'] == 'JOB_04'){ ?>
					<center style="margin-bottom:20px;"><a href="visitor_ring_det.php?ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<?php }else{ ?>
					<center style="margin-bottom:20px;"><a href="ring_det.php?ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<?php } ?>
				<div class="card-grid">
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>احصائيات الطالب</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<?php if($_SESSION['staff_job'] == "JOB_04"){ ?>
								<a href="visitor_std_single_stat_select_date.php?type=1&std_id=<?php echo $_GET['std_id']; ?>&ring_id=<?php echo $_GET['ring_id']; ?>">مزيد من التفاصيل</a>
							<?php }else{ ?>
								<a href="std_single_stat_select_date.php?type=1&std_id=<?php echo $_GET['std_id']; ?>&ring_id=<?php echo $_GET['ring_id']; ?>">مزيد من التفاصيل</a>
							<?php } ?>
						</div>	
					</article> 
					<!--<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>عدد أوجه الحفظ والمراجعة للطالب</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<?php if($_SESSION['staff_job'] == "JOB_04"){ ?>
								<a href="visitor_std_single_stat_select_date.php?type=2&std_id=<?php echo $_GET['std_id']; ?>&ring_id=<?php echo $_GET['ring_id']; ?>">مزيد من التفاصيل</a>
							<?php }else{ ?>
								<a href="std_single_stat_select_date.php?type=2&std_id=<?php echo $_GET['std_id']; ?>&ring_id=<?php echo $_GET['ring_id']; ?>">مزيد من التفاصيل</a>
							<?php } ?>						</div>	
					</article> 
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>نسب الغياب و الاستئذان للطالب</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<?php if($_SESSION['staff_job'] == "JOB_04"){ ?>
								<a href="visitor_std_single_stat_select_date.php?type=3&std_id=<?php echo $_GET['std_id']; ?>&ring_id=<?php echo $_GET['ring_id']; ?>">مزيد من التفاصيل</a>
							<?php }else{ ?>
								<a href="std_single_stat_select_date.php?type=3&std_id=<?php echo $_GET['std_id']; ?>&ring_id=<?php echo $_GET['ring_id']; ?>">مزيد من التفاصيل</a>
							<?php } ?>						</div>	
					</article> -->
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
