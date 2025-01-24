<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "student")) {
		if($_SESSION['staff_job'] != "student"){
			echo "<script>window.location.href='../../index.php';</script>";
		}
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title><?php
						if($_SESSION['staff_job'] == 'student'){
							$sql = "SELECT std_name as name FROM students WHERE std_id = '".$_SESSION['email']."'";
						}
						if($_SESSION['staff_job'] == 'parent'){
							$sql = "SELECT p_name as name FROM parent WHERE p_name = '".$_SESSION['email']."'";
						}
						echo mysqli_fetch_assoc(mysqli_query($conn,$sql))['name'];
					?></title>
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
			<a href="std_my_stat.php">الاحصائيات</a>
				<a href="std_acc.php" class="active">بياناتي الشخصية</a>
				<a href="std_all_myresults.php">نتائج الحفظ و المراجعة</a>
				<a href="std_my_mton_result.php">نتائج الحفظ و المراجعة للمتون</a>
				<a href="std_my_rewards.php">سجل المكافآت</a>
				<a href="std_my_cm.php">الدورات التي تم التحصل عليها</a>
				<a href="std_change_pwd.php">تغيير كلمة المرور</a>
				<?php
						$sql = "SELECT * FROM messages WHERE user_id = '".$_SESSION['email']."' AND user_type = 1 AND seen = 0";
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0)){
					?>
						<a href="my_msgs.php" style="background-color:darkred; color:white;" class="active">عرض رسائلي</a>
					<?php }else{?>
						<a href="my_msgs.php">عرض رسائلي</a>
					<?php } ?>
					<?php
						$sql = "SELECT pRequired FROM students WHERE std_id = '".$_SESSION['email']."'";
						$res = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($res);
						if($row['pRequired'] != 'YES'){
							echo '<a href="std_alon_exc.php?std_id='.$_SESSION['email'].'" target="_blank" onclick="return confirmReq()">طلب استئذان</a>';
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
				<h2><?php
						if($_SESSION['staff_job'] == 'student'){
							$sql = "SELECT std_name as name FROM students WHERE std_id = '".$_SESSION['email']."'";
						}
						if($_SESSION['staff_job'] == 'parent'){
							$sql = "SELECT p_name as name FROM parent WHERE p_name = '".$_SESSION['email']."'";
						}
						echo mysqli_fetch_assoc(mysqli_query($conn,$sql))['name'];
					?></h2>
			</div>
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
				<a href="std_my_stat.php">الاحصائيات</a>
					<a href="std_acc.php" class="active">بياناتي الشخصية</a>
					<a href="std_all_myresults.php">نتائج الحفظ و المراجعة</a>
					<a href="std_my_mton_result.php">نتائج الحفظ و المراجعة للمتون</a>
					<a href="std_my_rewards.php">سجل المكافآت</a>
					<a href="std_my_cm.php">الدورات التي تم التحصل عليها</a>
					<a href="std_change_pwd.php">تغيير كلمة المرور</a>
					<?php
						$sql = "SELECT * FROM messages WHERE user_id = '".$_SESSION['email']."' AND user_type = 1 AND seen = 0";
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0)){
					?>
						<a href="my_msgs.php" style="background-color:darkred; color:white;" class="active">عرض رسائلي</a>
					<?php }else{?>
						<a href="my_msgs.php">عرض رسائلي</a>
					<?php } ?>
					<?php
						$sql = "SELECT pRequired FROM students WHERE std_id = '".$_SESSION['email']."'";
						$res = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($res);
						if($row['pRequired'] != 'YES'){
							echo '<a href="std_alon_exc.php?std_id='.$_SESSION['email'].'" target="_blank" onclick="return confirmReq()">طلب استئذان</a>';
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
						$sql = "SELECT * FROM students
							 	LEFT JOIN ring ON ring.ring_id = students.ring_id
								WHERE std_id LIKE '".$_SESSION['email']."'";
						$result = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($result);
							echo '<article class="card">										
									
									<div class="card-header">
										<div>
											<span style="width:100%;height:100%;"><img src="imgs/'.$row['std_profile'].'" /></span>
										</div>';
									echo '
									</div>
									<div class="card-body">';
										$sql = "SELECT state FROM students WHERE std_id = '".$_SESSION['email']."'";
										$result = mysqli_query($conn,$sql);
										$roww = mysqli_fetch_assoc($result);
										if($roww['state'] == 'منتظم'){
											echo '<h2>حالة الطالب : <color style="color:darkgreen;">'.$roww['state'].'</color></h2>';
										}
										if($roww['state'] == 'متوقف'){
											echo '<h2>حالة الطالب : <color style="color:#2700ff;">'.$roww['state'].'</color></h2>';
										}
										if($roww['state'] == 'مفصول'){
											echo '<h2>حالة الطالب : <color style="color:#ff0000;">'.$roww['state'].'</color></h2>';
										}
										echo '<p> الاسم : '.$row['std_name'].'</p>
										<p> الجنسية : '.$row['std_nat'].'</p>';
										echo '<p> الحلقة : <a href="ring_man.php" style="text-decoration:none;">'.$row['ring_name'].'</a></p>';
										//if($_SESSION['staff_job'] == 'JOB_01'){
											echo '<p> كلمة المرور : <color style= "color:red">'.$row['pass'].'</color></p>';
										//}
										echo '<p>أولياء الأمور : </p>';
											$sql = "SELECT * FROM parent
													LEFT JOIN std_parent_rel ON parent.p_id = std_parent_rel.parent_id
													WHERE std_parent_rel.std_id = '".$row['std_id']."'
											";
											$ress = mysqli_query($conn,$sql);
											if(mysqli_num_rows($ress) > 0){
												echo '<ol style="list-style: arabic-indic;margin: -10px 50px 15px 0px;">';
												while($rw = mysqli_fetch_assoc($ress)){
													echo '<li style="padding:5px;font-size: 15px;">'.$rw['p_name'].'</li>';
												}
												echo '</ol>';
											}
										echo '
										<p> تاريخ الميلاد : '.$row['std_birth_date'].'</p>
										<p> مكان الميلاد : '.$row['std_birth_loc'].'</p>
										<p> المستوى التعليمي : '.$row['std_lvl'].'</p>
										<p> تاريخ الالتحاق بالمجمع : </br><center>'.$row['std_enroll_date'].'</center></p>
										<p> رقم الهاتف : '.$row['std_phone'].'</p>
										<p> آخر سورة تم حفظها : '.$row['std_last_sorah'].'</p>
										<p> الأجزاء التي تم اختبارها : '.$row['std_tested'].'</p>
										<p> الأجزاء التي حفظها : '.$row['std_v_mem'].'</p>
										<p> الإيميل : '.$row['email'].'</p>
									</div>';
									
									echo '
								</article>
							';
						
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
		function confirmReq() {
			if (confirm("هل أنت متأكد من الاستئذان ؟")) {
				return true;
			} else {
				return false;
			}
		}
	</script>
</html>
