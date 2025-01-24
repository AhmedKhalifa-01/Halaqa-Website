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
	$sql = "INSERT INTO `is_p_following`(`p_id`, `date`) VALUES ('".$_SESSION['email']."','".date('Y-m-d')."')";
	mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>نتائج تسميع الأبناء</title>
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
		<div class="main-header">
		</div>

		<div class="content-header">
			<div class="content-header-intro">
				<h2>نتائج تسميع الأبناء</h2>
			</div>

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
				<div class="card-grid">
				<?php
						$sql = "SELECT students.*, review_plan.amount as a1, recite_plan.amount as a2
								FROM students
								LEFT JOIN std_parent_rel ON std_parent_rel.std_id = students.std_id
								LEFT JOIN parent ON std_parent_rel.parent_id = parent.p_id and students.std_id = std_parent_rel.std_id
								LEFT JOIN review_plan ON review_plan.std_id = students.std_id
								LEFT JOIN recite_plan ON recite_plan.std_id = review_plan.std_id 
								WHERE parent.p_id ='".$_SESSION['email']."'
								GROUP BY students.std_id;";
						$result = mysqli_query($conn,$sql);
						if(mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_assoc($result)){
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/student.png" /></span>
												<h3>'.$row['std_name'].'</h3>
											</div>
										</div>
										<div class="card-body">
											<h2 style="font-size:16px;">خطة الحفظ : '.$row['a1'].'</h2>
											<h2 style="font-size:16px;">خطة المراجعة : '.$row['a2'].'</h2>
											<h2 style="font-size:16px;">حالة الابن : '.$row['state'].'</h2>
										</div>
										<div class="card-footer">
											<a href="p_std_all_myresults.php?std_id='.$row['std_id'].'">الحفظ و المراجعة</a>
										</div>
										<div class="card-footer">
											<a href="p_std_single_state.php?std_id='.$row['std_id'].'">عرض الإحصائيات</a>
										</div>
									</article>
								';
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</main>
<style>
	@media (min-width: 600px) {
		table {
			
		}
	}
</style>
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
<?php
	function getDayOfWeek($dateString) {
		$myDate = new DateTime($dateString);
		$dayOfWeek = $myDate->format('w');
		$daysOfWeek = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
		return $daysOfWeek[$dayOfWeek];
	  }
?>