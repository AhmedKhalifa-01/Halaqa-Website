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

/* changing password */
	if(isset($_POST['submit'])){
		$pass = $_POST['pass'];
		$rpass = $_POST['repass'];
		$oldpass = $_POST['oldpass'];
		$sql = "SELECT * FROM students WHERE std_id = '".$_SESSION['email']."'";
		$result = mysqli_query($conn,$sql);
		if($oldpass == mysqli_fetch_assoc($result)['pass']){
			if($pass == $rpass){
				$sql = "UPDATE `students` SET `pass`='".$pass."' WHERE std_id = '".$_SESSION['email']."'";
				$result = mysqli_query($conn,$sql);
				if($result){
					echo "<script>alert('تم تغيير كلمة المرور بنجاح')</script>";
					echo "<script>window.location.href='std_acc.php';</script>";
				}else{
					echo "<script>alert('خطأ في تغيير كلمة المرور ')</script>";
					echo "<script>window.location.href='std_acc.php';</script>";
				}
			}
			else{
				echo "<script>alert('كلمات المرور غير مطابقة !')</script>";
			}
		}else{
			echo "<script>alert('كلمة المرور القديمة غير مطابقة !')</script>";
			//echo "<script>window.location.href='new_acc.php';</script>";
		}
		
		
	}

?>

<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>تغيير كلمة المرور</title>
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
				<a href="std_acc.php">بياناتي الشخصية</a>
					<a href="std_all_myresults.php">نتائج الحفظ و المراجعة</a>
					<a href="std_my_mton_result.php">نتائج الحفظ و المراجعة للمتون</a>
					<a href="std_my_rewards.php">سجل المكافآت</a>
					<a href="std_my_cm.php">الدورات التي تم التحصل عليها</a>
					<a href="std_change_pwd.php"  class="active">تغيير كلمة المرور</a>
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
							echo '<a href="std_alon_exc.php?std_id='.$_SESSION['email'].'" target="_blank" onclick="return confirmOK()">طلب استئذان</a>';
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
				<h2>تغيير كلمة المرور</h2>
			</div>

		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					<a href="std_my_stat.php">الاحصائيات</a>
				<a href="std_acc.php">بياناتي الشخصية</a>
					<a href="std_all_myresults.php">نتائج الحفظ و المراجعة</a>
					<a href="std_my_mton_result.php">نتائج الحفظ و المراجعة للمتون</a>
					<a href="std_my_rewards.php">سجل المكافآت</a>
					<a href="std_my_cm.php">الدورات التي تم التحصل عليها</a>
					<a href="std_change_pwd.php"  class="active">تغيير كلمة المرور</a>
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
							echo '<a href="std_alon_exc.php?std_id='.$_SESSION['email'].'" target="_blank" onclick="return confirmOK()">طلب استئذان</a>';
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
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/quran.png" /></span>
								<h3>تغيير كلمة المرور</h3>
							</div>
						</div>
						<div class="card-body">
							<form class="login-form" action="std_change_pwd.php" method="post">
								<input type="text" placeholder="كلمة المرور القديمة" name="oldpass"/>
								<input type="text" placeholder="كلمة المرور" name="pass"/>
								<input type="text" placeholder="إعادة إدخال كلمة المرور" name="repass"/>
								<button type="submit" name="submit">تغيير</button>
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
	function confirmOK() {
		if (confirm("هل أنت متأكد من إرسال طلب استئذان ؟")) {
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
