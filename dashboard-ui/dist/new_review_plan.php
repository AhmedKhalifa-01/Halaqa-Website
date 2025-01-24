<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
			if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
				//if($_SESSION['staff_job'] != 'JOB_03'){
					echo "<script>window.location.href='index.php';</script>";
				//}
			}			
		}else{
			echo "<script>window.location.href='index.php';</script>";
		}

/* adding new review plan */

	if(isset($_POST['add_review_plan'])){
		/*$type = $_POST['r_type'];
		if($type == 'option1'){
			if($_POST['from'] != "" and $_POST['to'] != ""){
				$from = $_POST['from'];
				$to = $_POST['to'];
				$so = $_POST['so'];
				$sql = "DELETE FROM review_plan WHERE std_id = '".$_GET['std_id']."'";
				mysqli_query($conn,$sql);
				$sql = "INSERT INTO `review_plan`(`std_id`, `type`,`a_from`, `a_to`,`sora`) VALUES ('".$_GET['std_id']."','1','".$from."','".$to."','".$so."')";
				if(mysqli_query($conn,$sql)){
					echo "<script>window.location.href='std_ring_plan.php?staff_id=".$_GET['staff_id']."';</script>";
				}
			}else{
				echo "<script>alert('الرجاء إضافة الآيات');</script>";
			}
			
		}
		if($type == 'option2'){
			if(isset($_POST['options'])){
				$options = $_POST['options'];
				$sql = "DELETE FROM std_sorahs WHERE std_id = '".$_GET['std_id']."'";
				mysqli_query($conn,$sql);
				foreach ($options as $option) {
					$sql = "INSERT INTO `std_sorahs`(`std_id`, `sorah`) VALUES ('".$_GET['std_id']."','".$option."')";
					mysqli_query($conn,$sql);
				}
				$sql = "DELETE FROM review_plan WHERE std_id = '".$_GET['std_id']."'";
				mysqli_query($conn,$sql);
				$sql = "INSERT INTO `review_plan`(`std_id`, `type`) VALUES ('".$_GET['std_id']."','2')";
				if(mysqli_query($conn,$sql)){
					echo "<script>window.location.href='std_ring_plan.php?staff_id=".$_GET['staff_id']."';</script>";
				}
			}else{
				echo "<script>alert('الرجاء إضافة السور');</script>";
			}
			
		}*/
		//if($type == 'option3'){
			if($_POST['amount'] != ""){
				$amount = $_POST['amount'];
				$sql = "DELETE FROM review_plan WHERE std_id = '".$_GET['std_id']."'";
				mysqli_query($conn,$sql);
				$sql = "INSERT INTO `review_plan`(`std_id`, `type`,`amount`) VALUES ('".$_GET['std_id']."','3','".$amount."')";
				if(mysqli_query($conn,$sql)){
					echo "<script>window.location.href='std_ring_plan.php?ring_id=".$_GET['ring_id']."';</script>";
				}
			}else{
				echo "<script>alert('الرجاء إضافة الأوجه');</script>";
			}			
		//}
	}


?>

<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إضافة خطة حفظ </title>
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
					<a href="ring_man.php" class="active">إدارة الحلقات  التسميع</a>
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
		

		<div class="content-header">
			<div class="content-header-intro">
				<h2>إضافة خطة حفظ</h2>
				
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
								<h3>إضافة خطة حفظ</h3>
							</div>
						</div>
						<div class="card-body">
							<form class="login-form" action="new_review_plan.php?std_id=<?php echo $_GET['std_id']; ?>&ring_id=<?php echo $_GET['ring_id']; ?>" method="post">
								
								<div id="face">
									<p>يمكن كتابتها نصا، مثل : وجه  نصف </p>
									<input style="width:100%;" type="text" placeholder = "عدد الأوجه" name="amount">
								</div>		
								<button type="submit" name="add_review_plan">إضافة الخطة</button>					
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
	<script>
		var radios = document.getElementsByClassName('display');
		for (var i = 0; i < radios.length; i++) {
		radios[i].addEventListener('change', function() {
			
			var selectedOption = this.value;
			var option1 = document.getElementById('aya');
			var option2 = document.getElementById('sorah');
			var option3 = document.getElementById('face');
			if (selectedOption === 'option1') {
				option1.style.display = 'block';
				option2.style.display = 'none';
				option3.style.display = 'none';
			} else if (selectedOption === 'option2') {
				option1.style.display = 'none';
				option2.style.display = 'block';
				option3.style.display = 'none';
			} else if (selectedOption === 'option3') {
				option1.style.display = 'none';
				option2.style.display = 'none';
				option3.style.display = 'block';
			}
		});
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
