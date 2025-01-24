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

	if(isset($_POST['recive'])){
		$r_amount = $_POST['r_amount'];

		// الحصول على قيمة اي واحدةمن النجوم لهذه الجائزة
		$sql = "SELECT gold, silver, pronze FROM prize WHERE prize_id = '".$_GET['prize_id']."'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		$gold = $row['gold'];
		$pronze = $row['pronze'];
		$silver = $row['silver'];

		$sql = "SELECT students.std_name,students.std_id,students.status,students.state,
										COUNT(CASE WHEN prize_details.star = 'الذهبي' THEN prize_details.prize_details_id END) AS gold,
										COUNT(CASE WHEN prize_details.star = 'الفضي' THEN prize_details.prize_details_id END) AS silver,
										COUNT(CASE WHEN prize_details.star = 'البرونزي' THEN prize_details.prize_details_id END) AS pronze
									FROM prize_details
									INNER JOIN students ON students.std_id = prize_details.std_id
									WHERE prize_id = '".$_GET['prize_id']."' AND students.std_id = '".$_GET['std_id']."'
									GROUP BY students.std_id
									";
		$res = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($res);
		//echo mysqli_error($conn);
		$tot = ($row['gold'] * $gold)+($row['silver'] * $silver)+($row['pronze'] * $pronze);
		if(mysqli_num_rows(mysqli_query($conn,"SELECT recived FROM prize_gift WHERE std_id = '".$row['std_id']."' and prize_id = '".$_GET['prize_id']."'")) > 0){
			$recived = mysqli_fetch_assoc(mysqli_query($conn,"SELECT recived FROM prize_gift WHERE std_id = '".$row['std_id']."' and prize_id = '".$_GET['prize_id']."'"))['recived'];
		}else{
			$recived = 0;
		}
		$remain = $tot - $recived;
		if($r_amount > $tot){
			echo "<script>alert('خطأ : المبلغ المدخل أكثر من القيمة الإجمالية !')</script>";
		}else if($r_amount <= 0){
			echo "<script>alert('خطأ : المبلغ المدخل يجب أن يكون أكبر من صفر !')</script>";
		}else if($r_amount > $remain){
			echo "<script>alert('خطأ : المبلغ المدخل أكبر من الجائزة المتبقية !')</script>";
		}else{
			$newRecived = $recived + $r_amount;
			if($recived > 0){
				$sql = "UPDATE prize_gift SET `recived` = '".$newRecived."' WHERE std_id = '".$_GET['std_id']."'";
			}else{
				$sql = "INSERT INTO `prize_gift`(`prize_id`, `std_id`, `amount`, `recived`) VALUES ('".$_GET['prize_id']."','".$_GET['std_id']."','".$tot."','".$r_amount."')";
			}
			mysqli_query($conn,$sql);
		}
		//echo "<script>window.location.href='prize_man.php';</script>";
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
	<style>
		table td, th{
			font-size: 16px;
			margin:center;
		}
		@media screen and (max-width: 400px) {
			table td, th{
				font-size: 12px;
			}
		}
		table {
			
			width:320px;;
			border-collapse: collapse;
		}
		
		thead {
			position: sticky;
			top: 0;
			z-index: 1;
		}
		
		tbody td {
			padding-top: 20px; /* Set padding-top to the height of the fixed header */
		}
		#stdname{
			white-space: normal;
			word-wrap: break-word;
			max-width: 150px;
		}
		.adjust{
			width: 100px;
		}
		table td:first-child {
			width: 50%;
		}
		table td:nth-child(2),
		table td:nth-child(3) {
			width:20%;
		}
		@media screen and (min-width: 800px) {
			table{
				width: 90%;
			}
			#stdname{
				max-width: 300px;
			}
			tbody td {
				padding-top: 10px; /* Set padding-top to the height of the fixed header */
			}
			tbody td{
				font-size: 16px;
			}
		}
	</style>
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
			<?php if($_SESSION['staff_job'] == "JOB_03"){echo "<script>window.location.href='../../index.php';</script>";}?>
				<h2>إضافة و تعديل جميع البيانات</h2>
				
			</div>
			</div>
			<?php
				$sql = "SELECT EXISTS (SELECT 1 FROM prize WHERE state = 'مستمرة') As ex;";
				$res = mysqli_query($conn,$sql);
				$row = mysqli_fetch_assoc($res);
				if($row['ex'] != 1){
			?>
			<div class="content-header-actions">
				
				<a href="new_prize.php" class="button">
					<i class="ph-plus-bold"></i>
					<span>إضافة جائزة جديدة</span>
				</a>
			</div>
			<?php } ?>
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
				<center style="margin-bottom:20px;"><a href="prize_man.php" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<center>
					<table class="tt" style="">
					<thead>
						<tr>
							<th>اسم الطالب</th>
							<th>الاجمالي</th>
							<th>المستلم</th>
							<th>المتبقي</th>
							<th>استلام</th>
						</tr>
					</thead>
						<?php
							// الحصول على قيمة اي واحدةمن النجوم لهذه الجائزة
							$sql = "SELECT gold, silver, pronze FROM prize WHERE prize_id = '".$_GET['prize_id']."'";
							$result = mysqli_query($conn,$sql);
							$row = mysqli_fetch_assoc($result);
							$gold = $row['gold'];
							$pronze = $row['pronze'];
							$silver = $row['silver'];

							$sql = "SELECT students.std_name,students.std_id,students.status,students.state,
										COUNT(CASE WHEN prize_details.star = 'الذهبي' THEN prize_details.prize_details_id END) AS gold,
										COUNT(CASE WHEN prize_details.star = 'الفضي' THEN prize_details.prize_details_id END) AS silver,
										COUNT(CASE WHEN prize_details.star = 'البرونزي' THEN prize_details.prize_details_id END) AS pronze
									FROM prize_details
									INNER JOIN students ON students.std_id = prize_details.std_id
									WHERE prize_id = '".$_GET['prize_id']."'
									GROUP BY students.std_id
									ORDER BY std_name
									";
							$result = mysqli_query($conn,$sql);
							if(mysqli_num_rows($result) > 0){
								while($row = mysqli_fetch_assoc($result)){
									$total = ($row['gold'] * $gold)+($row['silver'] * $silver)+($row['pronze'] * $pronze);
									$recived = mysqli_fetch_assoc(mysqli_query($conn,"SELECT recived FROM prize_gift WHERE std_id = '".$row['std_id']."' and prize_id = '".$_GET['prize_id']."'"))['recived'];
									echo '<tr>
											<td id="stdname"style="padding:5px;white-space: normal;word-wrap: break-word;max-width: 150px;">'.$row['std_name'].'</td>
											<td>'.$total.'</td>
											';
											if(mysqli_num_rows(mysqli_query($conn,"SELECT recived FROM prize_gift WHERE std_id = '".$row['std_id']."' and prize_id = '".$_GET['prize_id']."'")) > 0){
												echo '<td>'.$recived.'</td>';
												echo '<td>'.($total - $recived).'</td>';
												
											}else{
												echo '<td>0</td>';
												echo '<td>'.$total.'</td>';
											}
											$remaining = $total - $recived;
											if($total > 0 and $remaining > 0){
												echo '<td>
														<form class="" action="prize_gift.php?std_id='.$row['std_id'].'&prize_id='.$_GET['prize_id'].'" method="post">
															<input name="r_amount" style="width:50px;" type="text" placeholder="ادخل المبلغ"/>
															<button type="submit" name="recive">استلام</button>
														</form>
													</td>';
											}else{
												echo '<td>لا يمكن استلام جائزة</td>';
											}											
										echo '</tr>';
								}
							}
						?>
					</table>
						</center>
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
