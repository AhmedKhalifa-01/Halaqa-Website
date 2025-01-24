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
<link rel="stylesheet" href="./style.css?v=9">
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
			background-color: #602424;
			color: #fff;
		}
		.td:nth-child(even):hover {
			background-color: #2e1111;
			color: #fff;
		}

		.td:nth-child(odd) {
			background-color: #974242;
			color: #fff;
		}
		.td:nth-child(odd):hover {
			background-color: #7b0d0d;
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
				<center style="margin-bottom:20px;"><div><a href="std_my_homework.php" class="button" style="width:100px;height:50px;">
					<span>الواجب</span>
				</a></div></center>
				<div class="card-grid">
				<?php
					$sql = "SELECT review_plan.amount as a1,recite_plan.amount as a2 from review_plan
							LEFT JOIN recite_plan ON review_plan.std_id = recite_plan.std_id
							WHERE review_plan.std_id = '".$_SESSION['email']."'";
					$result = mysqli_query($conn,$sql);
					if(mysqli_num_rows($result) > 0){
						$row = mysqli_fetch_assoc($result);
						echo '<article class="card" style="width:200px;">
								<div class="card-body">
									<h1 style= "font-size:17px">خطة الحفظ : '.$row['a1'].'</h1></br>
									<h1 style= "font-size:17px">خطة المراجعة : '.$row['a2'].'</h1>
								</div>
							</article>';
					}else{
						echo '<article class="card" style="width:200px;">
									<div class="card-body">
										<h1 style= "font-size:17px">لا توجد خطة</h1></br>
									</div>
								</article>';
					}
				?>
				
				<center><table>
				<thead>
					<tr>
						<th>اسم الطالب</th>
						<th>التاريخ</th>
						<th>اليوم</th>
						<th>حالة الحضور</th>
						<th>درجة الحفظ</th>
						<th>درجة المراجعة</th>
						<th>حالة الخطة</th>
						<th>واجب الحفظ</th>
						<th>عدد الأوجه</th>
						<th>واجب المراجعة</th>
						<th>عدد الأوجه</th>
						<th>خطة الحفظ</th>
						<th>خطة المراجعة</th>
					</tr>
				</thead>
				<tbody>
				<?php
									//for ($i = 0; $i < count($dates); $i++) {
												//echo $dates[$i]. "</br> " ;
										$sql = "SELECT DISTINCT students.std_id, COALESCE(review_plan.amount,'لا توجد خطة') as rpm, COALESCE(recite_plan.amount,'لا توجد خطة') as rpm2, students.std_name,review.date,std_att.state,review.grade as g1,recite.grade as g2,std_on_plan.onPlan as sta FROM ring
												LEFT JOIN recite ON students.std_id = recite.std_id
												LEFT JOIN review_plan ON review_plan.std_id = students.std_id
												LEFT JOIN recite_plan ON recite_plan.std_id = students.std_id
												LEFT JOIN review ON students.std_id = review.std_id and review.date = recite.date
												LEFT JOIN std_att ON students.std_id = std_att.std_id and std_att.date = review.date
												LEFT JOIN std_on_plan ON students.std_id = std_on_plan.std_id and std_on_plan.date = review.date
												students.std_id = '".$_SESSION['email']."'
												ORDER BY review.date DESC
												LIMIT 1";
												$result = mysqli_query($conn,$sql);
												if($result){
													if(mysqli_num_rows($result) > 0){
														while($row = mysqli_fetch_assoc($result)){
															echo '
																<tr>
																	<td style = "width:400px;">'.$row['std_name'].'</td>
																	<td style = "width:600px;">'.$row['date'].'</td>
																	<td style = "width:600px;">'.getDayOfWeek($row['date']).'</td>
																	<td>'.$row['state'].'</td>';
																	if($row['g1'] == ""){
																		echo '<td> - </td>';
																	}else{
																		echo '<td>'.$row['g1'].'</td>';
																	}
																	
																	if($row['g2'] == ""){
																		echo '<td> - </td>';
																	}else{
																		echo '<td>'.$row['g2'].'</td>';
																	}
																	echo '<td>'.$row['sta'].'</td>';
																	$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM std_homework_soras WHERE std_id = '".$_SESSION['email']."' AND date = '".$row['date']."' and type='review'";
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
																		$sql = "SELECT * FROM sora_face WHERE date = '".$row['date']."' AND std_id = '".$row['std_id']."' AND type= 'review'";
																		$rere = mysqli_query($conn,$sql);
																		echo '<td>'.mysqli_fetch_assoc($rere)['face'].'</td>';
																	}else{
																		
																			echo '<td>لم يتم تسجيل واجب</td>';
																			echo '<td>لم يتم تسجيل واجب</td>';
																		
																	}
																	$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM std_homework_soras WHERE std_id = '".$_SESSION['email']."' AND date = '".$row['date']."' and type='recite'";
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
																		$sql = "SELECT * FROM sora_face WHERE date = '".$row['date']."' AND std_id = '".$row['std_id']."' AND type= 'recite'";
																		$rere = mysqli_query($conn,$sql);
																		echo '<td>'.mysqli_fetch_assoc($rere)['face'].'</td>';
																	}else{
																		
																			echo '<td>لم يتم تسجيل واجب</td>';
																			echo '<td>لم يتم تسجيل واجب</td>';
																		
																	}
																	echo '<td style = "width:600px;">'.$row['rpm'].'</td>';
																	echo '<td style = "width:600px;">'.$row['rpm2'].'</td>
																	
																</tr>
															';
														}
													}
												}
											//}
								?>
					
				</tbody>
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