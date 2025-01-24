<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "parent")) {
		if($_SESSION['staff_job'] != "parent"){
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
			<a href="parent_acc.php" class="active">تفاصيل الحساب</a>
					<a href="p_std_my_result.php">نتائج الحفظ و المراجعة للابن</a>
					<a href="p_std_my_mton_result.php">نتائج حفظ و مراجعة المتون للابن</a>
					<a href="p_std_my_rewards.php">سجل المكافآت الخاص بالابن</a>
					<a href="p_std_my_cm.php">الدورات التي تحصل الابن عليها</a>
					<a href="p_change_pwd.php">تغيير كلمة المرور</a>
					<a href="p_send.php">مراسلة المعلم</a>
					<?php
						$sql = "SELECT * FROM messages WHERE user_id = '".$_SESSION['email']."' AND user_type = 2 AND seen = 0";
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0)){
					?>
						<a href="p_msgs.php" style="background-color:darkred; color:white;" class="active">عرض رسائلي</a>
					<?php }else{?>
						<a href="p_msgs.php">عرض رسائلي</a>
					<?php } ?>
					<a href="p_std_exc.php">الاستئذان للابن</a>
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
					<a href="parent_acc.php" class="active">تفاصيل الحساب</a>
					<a href="p_std_my_result.php">نتائج الحفظ و المراجعة للابن</a>
					<a href="p_std_my_mton_result.php">نتائج حفظ و مراجعة المتون للابن</a>
					
					
					<a href="p_std_my_rewards.php">سجل المكافآت الخاص بالابن</a>
					<a href="p_std_my_cm.php">الدورات التي تحصل الابن عليها</a>
					<a href="p_change_pwd.php">تغيير كلمة المرور</a>
					<a href="p_send.php">مراسلة المعلم</a>
					<?php
						$sql = "SELECT * FROM messages WHERE user_id = '".$_SESSION['email']."' AND user_type = 2 AND seen = 0";
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0)){
					?>
						<a href="p_msgs.php" style="background-color:darkred; color:white;" class="active">عرض رسائلي</a>
					<?php }else{?>
						<a href="p_msgs.php">عرض رسائلي</a>
					<?php } ?>
					<a href="p_std_exc.php">الاستئذان للابن</a><div style="margin-bottom: 400px;">
</div>
				</div>
			</div>
			<div class="content-main">
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
				<?php
							
							$sql = "SELECT * FROM parent WHERE p_id = '".$_SESSION['email']."'";
							mysqli_query($conn,"UPDATE messages SET seen = 1 WHERE user_id = '".$_SESSION['email']."' AND user_type = 2");
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/adult.png" /></span>
												<h3>'.$row['p_name'].'</h3>
											</div>
										</div>
										<div class="card-body">';
										echo '<div class="info">';
											echo '<p> رقم الهوية : <color style= "color:red">'.$row['p_id_number'].'</color></p>';
											//if($_SESSION['staff_job'] == 'JOB_01'){
												echo '<p> كلمة المرور : <color style= "color:red">'.$row['pass'].'</color></p>';
											//}
											echo '<p> رقم الهاتف : <color>'.$row['p_phone'].'</color></p>';
											echo '<p> العنوان : <color>'.$row['p_address'].'</color></p>';

										echo '</div>';
										
											echo'
											
										</div>';
										echo '
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
