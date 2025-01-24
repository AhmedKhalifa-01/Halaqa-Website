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
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>الدورات</title>
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
	@media screen and (max-width: 768px) {
		.tc {
			position: fixed;
			
			transform: translate(-0%, -10%);
			width: 340px;
			height: 400px; /* Set a fixed height for the container */
			overflow: auto;
			max-width: 700px;
			}
		table {

		}
	}
		thead th {
			background-color: #f2f2f2;
			border: 1px solid #ddd;
			font-weight: bold;
			text-align: right;
		}

		tbody tr {
			border: 1px solid #ddd;
		}

		tbody td {
			font-size:14px;
			font-weight:bold;
			padding: 10px;
			text-align: right;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		td:nth-child(even) {
			background-color: #f2f2f2;
		}
		td:nth-child(even):hover {
			background-color: #f9f9f9;
		}

		td:nth-child(odd) {
			background-color: #fff;
		}
		td:nth-child(odd):hover {
			background-color: #f2f2f2;
		}
		/*input[type="text"],button, input[type="email"], input[type="submit"] {
			width: 50%;
			box-sizing: border-box;
			padding: 10px;
			margin-top: 10px;
			
		}
		input[type="text"]{

		}*/
		table td, th{
			font-size: 16px;
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
		@media screen and (min-width: 800px) {
			table{
				width: 600px;
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
			<a href="std_my_stat.php">الاحصائيات</a>
				<a href="std_acc.php">بياناتي الشخصية</a>
					<a href="std_all_myresults.php">نتائج الحفظ و المراجعة</a>
					<a href="std_my_mton_result.php">نتائج الحفظ و المراجعة للمتون</a>
					<a href="std_my_rewards.php">سجل المكافآت</a>
					<a href="std_my_cm.php"  class = "active">الدورات التي تم التحصل عليها</a>
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
				<a href="std_acc.php">بياناتي الشخصية</a>
					<a href="std_all_myresults.php">نتائج الحفظ و المراجعة</a>
					<a href="std_my_mton_result.php">نتائج الحفظ و المراجعة للمتون</a>
					<a href="std_my_rewards.php">سجل المكافآت</a>
					<a href="std_my_cm.php"  class = "active">الدورات التي تم التحصل عليها</a>
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
				<center><table>
					<thead><tr>
						<th>اسم الدورة </th>
						<th>معلم الدورة </th>
						<th>الدرجة</th>
						<th>النتيجة</th>
					</tr></thead>
					
					<?php
						$sql = "SELECT DISTINCT course.c_name, staff.staff_name,course_results.total_mark,course_results.result
								FROM course 
								INNER JOIN course_details ON course.c_id = course_details.course_id 
								INNER JOIN students ON course_details.std_id = students.std_id 
								INNER JOIN staff ON course.staff_id = staff.staff_id
								LEFT JOIN course_results ON course_results.course_id = course_details.course_id
								WHERE course_details.std_id = '".$_SESSION['email']."'";
						
						$result = mysqli_query($conn, $sql);
						if ($result) {
							while ($row = mysqli_fetch_assoc($result)) {
								echo '<tr>
										<td>'.$row['c_name'].'</td>
										<td>'.$row['staff_name'].'</td>
										<td>'.$row['total_mark'].'</td>
										<td>'.$row['result'].'</td>
									</tr>';	
							}
						}
					?>
				</table></thead>
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
		<script>
		window.addEventListener('scroll', function() {
			var header = document.querySelector('thead');
			var table = document.querySelector('table');
			var rect = table.getBoundingClientRect();
			var headerHeight = header.offsetHeight;
			if (rect.top < 0) {
				header.style.top = 75 + 'px';
			} else {
				header.style.top = '0';
			}

			
		});
	</script>
</html>
