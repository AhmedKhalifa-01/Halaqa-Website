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
		@media (min-width: 1200px){
			.card-grid {
				grid-template-columns: repeat(1, 1fr);
			}
		}
		.td:nth-child(even) {
			background-color: #376024;
			color: #fff;
		}
		.td:nth-child(even):hover {
			background-color: #223d16;
			color: #fff;
		}

		.td:nth-child(odd) {
			background-color: #42978b;
			color: #fff;
		}
		.td:nth-child(odd):hover {
			background-color: #265a52;
			color: #fff;
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
				<a href="std_all_myresults.php" class = "active">نتائج الحفظ و المراجعة</a>
				<a href="std_my_mton_result.php">نتائج الحفظ و المراجعة للمتون</a>
				<a href="std_my_rewards.php">سجل المكافآت</a>
				<a href="std_my_cm.php">الدورات التي تم التحصل عليها</a>
				<a href="std_change_pwd.php">تغيير كلمة المرور</a>
				<a href="my_msgs.php">عرض رسائلي</a>
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
				<h2>
					<?php
						if($_SESSION['staff_job'] == 'student'){
							$sql = "SELECT std_name as name FROM students WHERE std_id = '".$_SESSION['email']."'";
						}
						if($_SESSION['staff_job'] == 'parent'){
							$sql = "SELECT p_name as name FROM parent WHERE p_name = '".$_SESSION['email']."'";
						}
						echo mysqli_fetch_assoc(mysqli_query($conn,$sql))['name'];
					?>
				</h2>
			</div>
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					<a href="std_my_stat.php">الاحصائيات</a>
				<a href="std_acc.php">بياناتي الشخصية</a>
					<a href="std_all_myresults.php" class = "active">نتائج الحفظ و المراجعة</a>
					<a href="std_my_mton_result.php">نتائج الحفظ و المراجعة للمتون</a>
					<a href="std_my_rewards.php">سجل المكافآت</a>
					<a href="std_my_cm.php">الدورات التي تم التحصل عليها</a>
					<a href="std_change_pwd.php">تغيير كلمة المرور</a>
				<a href="my_msgs.php">عرض رسائلي</a>
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
			<center style="margin-bottom:20px;"><div><a href="std_all_myresults.php" class="button" style="width:100px;height:50px;">
					<span>الرجوع</span>
				</a></div></center>
				<div class="card-grid">
				<center><table>
					<thead><tr>
						<th>التاريخ</th>
						<th>اليوم</th>
						<th>واجب الحفظ</th>
						<th>واجب المراجعة</th>
					</tr></thead>
					
					<?php
						$sql = "SELECT date FROM std_homework_soras GROUP BY date ORDER BY date DESC LIMIT 7";
						$result=mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($result)){
							if(date('Y-m-d') == $row['date']){
								echo "<tr>";
								$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date 
								FROM std_homework_soras 
								WHERE std_id = '".$_SESSION['email']."' AND type='review' AND date = '".$row['date']."'
								";
	
								$rres = mysqli_query($conn,$sql);
								if(mysqli_num_rows($rres) > 0){
									echo '<td class="td">'.$row['date'].'</td>';
								echo '<td class="td">'.getDayOfWeek($row['date']).'</td>';
									echo '<td class="td"><ul>';
									while($rrow = mysqli_fetch_assoc($rres)){
										if($rrow['s_from'] == '-'){
											echo '<li> سورة '.$rrow['sor'].'</li>';
										}else{
											if($rrow['s_from'] == '*'){
												echo '<li> الجزء '.$rrow['sor'].'</li>';
											}else{
												if($rrow['sor'] == ""){
													echo " - ";
												}else{
													echo '<li>'.$rrow['sor'].' من '.$rrow['s_from'].' إلى '.$rrow['s_to'].'</li>';
												}
											}
											
										}
									}
									echo '</ul></td>';
								}else{
									echo '<td class="td">لم يتم تسجيل واجب</td>';
								}
								$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date 
										FROM std_homework_soras 
										WHERE std_id = '".$_SESSION['email']."' AND type='recite' AND date = '".$row['date']."'
										";
								$rres = mysqli_query($conn,$sql);
								if(mysqli_num_rows($rres) > 0){
									echo '<td class="td"><ul>';
									while($rrow = mysqli_fetch_assoc($rres)){
										
										if($rrow['s_from'] == '-'){
											echo '<li> سورة '.$rrow['sor'].'</li>';
										}else{
											if($rrow['s_from'] == '*'){
												echo '<li> الجزء '.$rrow['sor'].'</li>';
											}else{
												if($rrow['sor'] == ""){
													echo " - ";
												}else{
													echo '<li>'.$rrow['sor'].' من '.$rrow['s_from'].' إلى '.$rrow['s_to'].'</li>';
												}
											}
											
										}			
									}
									echo '</ul></td>';
								}else{
									echo '<td class="td">لم يتم تسجيل واجب</td>';
								}
								
								echo "</tr>";
							}else{
								echo "<tr>";
								$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date 
								FROM std_homework_soras 
								WHERE std_id = '".$_SESSION['email']."' AND type='review' AND date = '".$row['date']."'
								";
								echo '<td>'.$row['date'].'</td>';
								echo '<td>'.getDayOfWeek($row['date']).'</td>';
								$rres = mysqli_query($conn,$sql);
								if(mysqli_num_rows($rres) > 0){
									echo '<td><ul>';
									while($rrow = mysqli_fetch_assoc($rres)){
										
										if($rrow['s_from'] == '-'){
											echo '<li> سورة '.$rrow['sor'].'</li>';
										}else{
											if($rrow['s_from'] == '*'){
												echo '<li> الجزء '.$rrow['sor'].'</li>';
											}else{
												if($rrow['sor'] == ""){
													echo " - ";
												}else{
													echo '<li>'.$rrow['sor'].' من '.$rrow['s_from'].' إلى '.$rrow['s_to'].'</li>';
												}
											}
											
										}
									}
									echo '</ul></td>';
								}else{
									echo '<td>لم يتم تسجيل واجب</td>';
								}
								$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date 
										FROM std_homework_soras 
										WHERE std_id = '".$_SESSION['email']."' AND type='recite' AND date = '".$row['date']."'
										";
								$rres = mysqli_query($conn,$sql);
								if(mysqli_num_rows($rres) > 0){
									echo '<td><ul>';
									while($rrow = mysqli_fetch_assoc($rres)){
										if($rrow['s_from'] == '-'){
											echo '<li> سورة '.$rrow['sor'].'</li>';
										}else{
											if($rrow['s_from'] == '*'){
												echo '<li> الجزء '.$rrow['sor'].'</li>';
											}else{
												if($rrow['sor'] == ""){
													echo " - ";
												}else{
													echo '<li>'.$rrow['sor'].' من '.$rrow['s_from'].' إلى '.$rrow['s_to'].'</li>';
												}
											}
											
										}			
									}
									echo '</ul></td>';
								}else{
									echo '<td>لم يتم تسجيل واجب</td>';
								}
								
								echo "</tr>";
							}
							
						}
						
					?>
				</table></center>
					
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
<?php
	function getDayOfWeek($dateString) {
		$myDate = new DateTime($dateString);
		$dayOfWeek = $myDate->format('w');
		$daysOfWeek = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
		return $daysOfWeek[$dayOfWeek];
	  }
?>