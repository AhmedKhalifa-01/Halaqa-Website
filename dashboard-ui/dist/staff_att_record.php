<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
			//	if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
		//	}
		}			
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}

?>

<?php
	if($_SESSION['staff_job'] == "JOB_01"){
		date_default_timezone_set('Asia/Riyadh');
    	$currentTime = date('Y-m-d H:i:s');
        $current_time_timestamp = strtotime($currentTime);

		$sql = "SELECT * FROM teacher_session";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
			if($row['teacher_id'] == 26){
				continue;
			}
            $oldActivity = $row['last_activity_time'];
            $old_activity_timestamp = strtotime($oldActivity);
            $time_difference = $current_time_timestamp - $old_activity_timestamp;
            $time_difference_minutes = round($time_difference / 60);
            if ($time_difference_minutes > 5) {
                // Perform your action here
                $sql = "DELETE FROM teacher_session WHERE teacher_id = '".$row['teacher_id']."'";
                mysqli_query($conn,$sql);

                $tid = mysqli_num_rows(mysqli_query($conn,"SELECT teacher_id FROM lastlogout WHERE teacher_id = '".$row['teacher_id']."'"));
                if($tid > 0){
                    $sql = "UPDATE lastlogout SET last_log_out = '".$currentTime."' WHERE teacher_id = '".$row['teacher_id']."'";
                }else{
                    $sql = "INSERT INTO lastlogout (teacher_id, last_log_out)
                    VALUES ('".$teacher_id."', '".$currentTime."')";
                }
				mysqli_query($conn,$sql);
            }
        }
	}
?>

<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>سجل حضور المعلمين</title>
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
		table {
			border-collapse: collapse;
			max-width: auto;
			margin: 0 auto;
			margin-top: 10px;
		}
		h1{
			
			font-size: 32px;
			font-weight: bold;
		}

		 th {
			background-color: #f2f2f2;
			border: 1px solid #ddd;
			font-weight: bold;
			padding: 10px;
			text-align: right;
		}

		tbody tr {
			border: 1px solid #ddd;
		}

		tbody td {
			font-size:16px;
			font-weight:bold;
			padding: 20px;
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
		@media screen and (min-width: 1200px) {
			article{
				width:500px;			
			}	
			.card-grid {
				grid-template-columns: repeat(2, 0fr);
				margin-right: 200px;
			}
		}
	</style>
</head>
<body>
<!-- partial:index.partial.html -->
<header class="header">
	<div class="header-content responsive-wrapper">
		<div class="header-logo">
			 <a href="../../index.php">
				<div>
					<img src="../../images/LOGO2.png" style="width:50px; height:50px;"/>
				</div>
			</a>
		</div>
		<div class="header-navigation">
			<nav class="header-navigation-links">
				<?php
					include('headerlogo.php');
				?>
				
				
				
				
			</nav>
			
		</div>
		
	</div>
</header>
<main class="main">
	<div class="responsive-wrapper">
		

		<div class="content-header">
			<div class="content-header-intro">
				<h2>سجل حضور المعلمين</h2>
				
			</div>
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					<?php if($_SESSION['staff_job'] == "JOB_02" or $_SESSION['staff_job'] == "JOB_03"){?>
						<a href="staff_acc.php">الصفحة الشخصية</a>
					<?php } ?>
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
					<a href="staff_management.php"  class = "active">إدارة المعلمين</a>
					<?php } ?>
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
					<a href="ring_man.php">إدارة الحلقات  التسميع</a>
					<a href="tasheeh_man.php">حلقة تصحيح التلاوة</a>
					<a href="course_man.php" >إدارة الدورات</a>
					<a href="mton_man.php">إدارة المتون</a>
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
				</div>
			</div>
			<div class="content-main">
				<center style="margin-bottom:20px;">
					<div>
						<a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
							<span>رجوع</span>
						</a>

					</div>
				</center>
				<div class="card-grid">
				
				<table>
					<tr>
						<th>اسم المعلم</th>
						<th>آخر ظهور</th>
						<th>الحالة</th>
					</tr>
					
					<?php
						
						$sql = "SELECT staff_id,staff_name,last_activity_time FROM staff
								LEFT JOIN teacher_session ON staff.staff_id = teacher_session.teacher_id
								WHERE staff_name != 'admin'";
						$result = mysqli_query($conn,$sql);
						if($result){
							while($row = mysqli_fetch_assoc($result)){
								echo '<tr>
										<td>'.$row['staff_name'].'</td>';
										
										if($row['last_activity_time'] != null){
											
											echo '<td>'.$row['last_activity_time'].'</td>
												<td style = "background-color:darkgreen;color:white;">متصل</td>';
										}else{
											$lastlogin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT last_log_out FROM lastlogout WHERE teacher_id = '".$row['staff_id']."'"))['last_log_out'];
											
											echo '<td>'.$lastlogin.'</td>
												<td style = "background-color:darkred;color:white;">غير متصل</td>';
										}
										echo '
									</tr>
										';	
							}
						} 
					?>
				</table>
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
		setInterval(function() {
			var xhr = new XMLHttpRequest();
			xhr.open('GET', 'check_teacher_last_activity.php', true);
			xhr.send();
		}, 10000); // 1 minute interval
	</script>
</html>
