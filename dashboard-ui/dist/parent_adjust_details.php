<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01'&& $_SESSION['staff_job'] != 'JOB_02'){
			//	if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
		//	}
		}
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}

/* modefying parent accout */

	if(isset($_POST['adj_parent'])){
		$name = $_POST['name'];
		$num = $_POST['id_num'];
		$phone = $_POST['phone'];
		$address = $_POST['add'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$sql = "UPDATE `parent`
		SET `p_name` = '".$name."',
			`p_id_number` = '".$num."',
			`p_phone` = '".$phone."',
			`p_address` = '".$address."',
			`email` = '".$email."',
			`pass` = '".$pass."'
			WHERE `p_id` = '".$_GET['id']."'";
		$result = mysqli_query($conn,$sql);
		if($result){
			echo "<script>alert('تم تعديل بيانات ولي الأمر بنجاح');</script>";
			echo "<script>window.location.href='parents_man.php';</script>";
		}else{
			echo "<script>alert('خطأ في تعديل بيانات ولي الأمر')</script>";
		}
	}

?>

<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>تعديل بيانات ولي الأمر</title>
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
					<a href="parents_man.php" class="active">إدارة أولياء الأمور</a>
					<a href="ring_man.php">إدارة الحلقات  التسميع</a>
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
				<?php if($_SESSION['staff_job'] == 'JOB_01' or $_SESSION['staff_job'] == 'JOB_02' or $_SESSION['staff_job'] == 'JOB_03'){
					$sql = "SELECT staff_name FROM staff WHERE staff_id = '".$_SESSION['email']."'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
					echo '<div class="main-header"><h1>'.$row['staff_name'].'</h1></div>';
				}?>
			<?php if($_SESSION['staff_job'] != "JOB_03"){?>
				<h2>تعديل بيانات ولي الأمر</h2>
				
			<?php }else{?>
				<h2>الوصول للحسابات مصرح للمدير و الإداريين فقط</h2>
			<?php } ?>
			</div>
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					<?php if($_SESSION['staff_job'] == "JOB_02" or $_SESSION['staff_job'] == "JOB_03"){?>
						<a href="staff_acc.php">الصفحة الشخصية</a>
					<?php } ?>
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
					<a href="parents_man.php" class="active">إدارة أولياء الأمور</a>
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
				<?php if($_SESSION['staff_job'] != "JOB_03"){
					$sql = "SELECT * FROM parent WHERE p_id = '".$_GET['p_id']."'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
				?>
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/parent.png"/></span>
								<h3>تعديل بيانات ولي الأمر</h3>
							</div>
						</div>
						<div class="card-body">
							<form class="login-form" action="parent_adjust_details.php?id=<?php echo $row['p_id']; ?>" method="post" enctype="multipart/form-data">
								<p style="font-size: 12px;width: 100%;">اسم ولي الأمر : </p>
								<input type="text" placeholder="اسم ولي الأمر" name="name" value="<?php echo $row['p_name']; ?>"/>
								
								<p style="font-size: 12px;width: 100%;">رقم الهوية : </p>
								<input type="text" placeholder="رقم الهوية" name="id_num" value="<?php echo $row['p_id_number']; ?>"/>
								<p style="font-size: 12px;width: 100%;">رقم الهاتف : </p>
								<input type="text" placeholder="رقم الجوال" name="phone" value="<?php echo $row['p_phone']; ?>"/>
								
								<p style="font-size: 12px;width: 100%;">العنوان : </p>
								<input type="text" placeholder="العنوان" name="add" value="<?php echo $row['p_address']; ?>"/>

								<p style="font-size: 12px;width: 100%;">الإيميل : </p>
								<input type="text" placeholder="الإيميل" name="email" value="<?php echo $row['email']; ?>"/>
								<p style="font-size: 12px;width: 100%;">كلمة المرور : </p>
								<input type="password" placeholder="كلمة المرور" name="pass" value="<?php echo $row['pass']; ?>"/>
								<button type="submit" name="adj_parent">تعديل</button>
							  </form>
						</div>
					</article>						
				</div>
				<?php } ?>
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
