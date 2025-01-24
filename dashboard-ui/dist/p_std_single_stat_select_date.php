<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_04'){
			//	if($_SESSION['staff_job'] != 'JOB_03'){
				//echo "<script>window.location.href='index.php';</script>";
		//	}
		}			
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}
?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إحصائيات الحلقة</title>
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
			<a href="parent_acc.php">تفاصيل الحساب</a>
					<a href="p_std_my_result.php" class="active">نتائج الحفظ و المراجعة للابن</a>
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
				<?php
					$stdName = mysqli_fetch_assoc(mysqli_query($conn,"SELECT std_name FROM students WHERE std_id = '".$_GET['std_id']."'"))['std_name'];
					echo "<h2>".$stdName."</h2>";
				?>
			</div>
			<?php if(isset($_GET['hide'])){?>
					<div class="content-header-actions">
						<a href="#" class="button">
							<i class="ph-faders-bold"></i>
							<span>Filters</span>
						</a>
					</div>
				<?php } ?>
		</div>
		<div class="content">
		<div class="content-panel">
		<div class="vertical-tabs">
		<a href="parent_acc.php">تفاصيل الحساب</a>
					<a href="p_std_my_result.php" class="active">نتائج الحفظ و المراجعة للابن</a>
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
					<a href="p_std_exc.php">الاستئذان للابن</a><div style="margin-bottom: 400px;"></div>
				</div>
			</div>
			<div class="content-main">
				<center style="margin-bottom:20px;"><a href="p_std_single_state.php?std_id=<?php echo $_GET['std_id']; ?>" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
				<article class="card" style="width:300px;">
								<div class="card-header">
									<div>
										<span><img src="imgs/icons/quran.png" /></span>
										<h3>احصائية بين فترتين</h3>
									</div>
								</div>
								
								<div class="card-body">	
									<form class="login-form" action = <?php if($_GET['type'] == "1"){
										echo "p_std_chartr.php?std_id=".$_GET['std_id']."";
									}else if($_GET['type'] == "2"){
										echo "std_rev_rec_face.php?std_id=".$_GET['std_id']."";
									}else if($_GET['type'] == "3"){
										echo "std_ex_ab_stat.php?std_id=".$_GET['std_id']."";
									}else{
										echo "none.php";
									}?>
									method = "post">
									<div id="other">
										<button type="submit" name="day">يوم</button>
										<button type="submit" name="week">أسبوع</button>
										<button type="submit" name="month">شهر</button>
									</div>
									<button type="button" name="2dates" id="2dates">بين تاريخين</button>
										<div id="twodates" style="display:none;">
											<input type="date" placeholder="" name="start_date"/>
											<input type="date" placeholder="" name="end_date"/>
											<button type="submit" name="twodates">إدخال</button>
										</div>
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

	document.getElementById("2dates").addEventListener("click", function() {
	var other = document.getElementById("other");
	var div = document.getElementById("twodates");
	if (div.style.display === "none") {
		div.style.display = "block";
		other.style.display = "none";
	} else {
		div.style.display = "none";
		other.style.display = "block";
	}
	});

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
