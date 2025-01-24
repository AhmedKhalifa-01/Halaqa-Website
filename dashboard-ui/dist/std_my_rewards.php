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
					<a href="std_my_rewards.php" class = "active">سجل المكافآت</a>
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
					<a href="std_my_rewards.php" class = "active">سجل المكافآت</a>
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
							echo '<a href="std_alon_exc.php?std_id='.$_SESSION['email'].'" target="_blank" onclick="return confirmOK()">طلب استئذان</a>';
						}
					?><div style="margin-bottom: 400px;">
</div>
				</div>
			</div>
			<div class="content-main">
			<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<?php
					if(isset($_GET['prize_id'])){
				?>
				<center><table class="det_table" style="">
					<thead style="">
						<tr>
							<!--<th>اسم الطالب</th>-->
							<th>النجم البرونزي</th>
							<th>النجم الفضي</th>
							<th>النجم الذهبي</th>
							<!--<th>الإجمالي</th>-->
							<th>المستلم</th>
							<th>المتبقي</th>
						</tr>
					<thead>
					<tbody>
						<?php
							$sql = "SELECT * FROM prize WHERE prize_id = '".$_GET['prize_id']."'";
							$result = mysqli_query($conn,$sql);
							$row = mysqli_fetch_assoc($result);
							$p_amount = $row['pronze'];
							$s_amount = $row['silver'];
							$g_amount = $row['gold'];

							$sql = "SELECT students.std_name,students.std_id,students.status,students.state,
										COUNT(CASE WHEN prize_details.star = 'الذهبي' THEN prize_details.prize_details_id END) AS gold,
										COUNT(CASE WHEN prize_details.star = 'الفضي' THEN prize_details.prize_details_id END) AS silver,
										COUNT(CASE WHEN prize_details.star = 'البرونزي' THEN prize_details.prize_details_id END) AS pronze
									FROM students
									INNER JOIN prize_participating_students ON prize_participating_students.std_id = students.std_id
									LEFT JOIN prize_details ON students.std_id = prize_details.std_id
									WHERE prize_participating_students.prize_id = '".$_GET['prize_id']."' AND students.std_id = '".$_SESSION['email']."'
									GROUP BY students.std_id
									";
							$result = mysqli_query($conn,$sql);
							if($result){
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>';
										echo '<td style="white-space: normal;word-wrap: break-word;max-width: 150px;background-color:#CD7F32;color:black;">'.$row['pronze'].'</td>'; 
										echo '<td style="white-space: normal;word-wrap: break-word;max-width: 150px;background-color:#C0C0C0;color:black;">'.$row['silver'].'</td>'; 
										echo '<td style="white-space: normal;word-wrap: break-word;max-width: 150px;background-color:#FFD700;color:black;">'.$row['gold'].'</td>'; 
								}
							}
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
									WHERE prize_id = '".$_GET['prize_id']."' and students.std_id = '".$_SESSION['email']."'
									GROUP BY students.std_id
									";
							$result = mysqli_query($conn,$sql);
							if(mysqli_num_rows($result) > 0){
								while($row = mysqli_fetch_assoc($result)){
									$total = ($row['gold'] * $gold)+($row['silver'] * $silver)+($row['pronze'] * $pronze);
									$recived = mysqli_fetch_assoc(mysqli_query($conn,"SELECT recived FROM prize_gift WHERE std_id = '".$row['std_id']."' and prize_id = '".$_GET['prize_id']."'"))['recived'];
									echo '
											
											';
											if(mysqli_num_rows(mysqli_query($conn,"SELECT recived FROM prize_gift WHERE std_id = '".$row['std_id']."' and prize_id = '".$_GET['prize_id']."'")) > 0){
												echo '<td>'.$recived.'</td>';
												echo '<td>'.($total - $recived).'</td>';
												
											}else{
												echo '<td>0</td>';
												echo '<td>'.($total - $recived).'</td>';
											}										
										echo '</tr>';
								}
							}
						?>
					</tbody>
				</table></center>
				<?php }else{?>
					<div class="card-grid">
				<?php 
							$sql = "SELECT * FROM prize
									INNER JOIN prize_details ON prize.prize_id = prize_details.prize_id
									WHERE prize_details.std_id = '".$_SESSION['email']."'
									GROUP BY prize_details.std_id";
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								//if($row['student_count'] > 0){
									echo '<article class="card">
											<div class="card-header">
												<div>
													<span><img src="imgs/icons/quran.png" /></span>
													<h3> اسم الجائزة : '.$row['prize_name'].'</h3>
												</div>
											</div>
											<div class="card-footer">
												<a href="std_my_rewards.php?prize_id='.$row['prize_id'].'">عرض التفاصيل</a>
											</div>';
											
											echo '
										</article>
									';
								//}
								
							}
						
					?>
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
