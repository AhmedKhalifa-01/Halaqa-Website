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

/* adding new ring */

	if(isset($_POST['add_ring'])){
		$ring_name = $_POST['ring_name'];
		$ring_man = $_POST['ring_man'];		
		if(isset($_POST['students'])){
			$students = $_POST['students'];
		}
		$staff = $_POST['staff'];
		if (!empty($students)) {
			// Insert the new ring into the rings table
			$sql = "INSERT INTO ring (ring_name, staff_id, ring_man) VALUES ('".$ring_name."','".$staff."','".$ring_man."')";
			if(mysqli_query($conn,$sql)){

				// Get the ring_id of the newly inserted ring
				$ringId = $conn->insert_id;

				//Update the ring_id column for each selected student
				foreach ($students as $std_id) {
					$sql = "UPDATE students SET ring_id = '".$ringId."', temp_ring_id = '".$ringId."' WHERE std_id = '".$std_id."'";
					if(!mysqli_query($conn,$sql)){
						echo "<script>alert('خطأ في إضافة الحلقة');</script>";
					}
				}
				echo "<script>alert('تمت إضافة الحلقة بنجاح');</script>";
				echo "<script>window.location.href='ring_man.php';</script>";
			}
			
		}else{
				$sql = "INSERT INTO ring (ring_name,staff_id,ring_man) VALUES ('$ring_name','$staff','".$ring_man."')";
				if(mysqli_query($conn, $sql)){
					echo "<script>alert('تمت إضافة الحلقة بنجاح');</script>";
					echo "<script>window.location.href='ring_man.php';</script>";
				}else{
					echo mysqli_error($conn);
					echo "<script>alert('تمت إضافة الحلقة');</script>";
				}
		}
	}

?>

<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إضافة منتج جديد </title>
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
<body style="direction:ltr">
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
			<a href="../../index.php" class="logo">
                    <img src="dash/logo.png" style="width: 80px; height: 80px;"/>
                </a>
				
				<a href="../../index.php" style="margin-left:50px;"> Home page </a>
			<?php if($_SESSION['staff_job'] == 'JOB_04') {?>
				
				<a href="../../logout.php" onclick="return confirmLogOut();"> Log out </a>
						</div>
					<?php }else{ ?>
				
				<a href="../../logout.php" onclick="return confirmLogOut();"> Log out </a>
				<?php } ?>
				
			</nav>
			
		</div>
	</div>
</header>
<main class="main">
	<div class="responsive-wrapper">
		

		<div class="content-header">
			<div class="content-header-intro">
				<h2>Modify product</h2>
				
			</div>
			
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					
					<a href="ring_man.php">Add new product</a>
					
					<a href="mton_man.php">List products</a>
					<a href="course_man.php" class="active">Modify products</a>
					
				</div>
			</div>
			<div class="content-main">
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>Return</span>
				</a></center>
				<div class="card-grid">
					<article class="card" style="margin-left:100px;">
						<div class="card-header">
							<div>
								<span><img src="dash/chair.png" /></span>
								<h3>Modify product</h3>
							</div>
						</div>
						<div class="card-body">
							<form class="login-form" action="new_ring.php" method="post">
								<p>Product's name</p>
								<input type="text" placeholder="Product's name" name="ring_name">
								<p>Product's type</p>
								<select name="ring_man" id="staff-select">
									
									<option value="" selected>Furniture</option>
									
								</select>
								<p>Product's quantity</p>
								<input type="text" placeholder="quantity" name="ring_name">

								<p>Product's price</p>
								<input type="text" placeholder="price $" name="ring_name">
								
								<button type="submit" name="add_ring">Add</button>
								
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
