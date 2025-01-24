<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
			if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
			}
		}
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}	
	/*if($_GET['staff_id'] != $_SESSION['email']){
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
			echo "<script>window.location.href='../../index.php';</script>";
		}
	}*/
	if(isset($_POST['std_info'])){
		$canSkipCheck = false;
		if(isset($_POST['att'])){
			if($_POST['att'] == 'مستاذن' or $_POST['att'] == 'غياب'){
				$canSkipCheck = true;
			}
		}
		if((isset($_POST['att']) and isset($_POST['score1']) and isset($_POST['score2'])) or $canSkipCheck){
			$att = $_POST['att'];
			if(!$canSkipCheck){
				$score1 = $_POST['score1'];
				$score2 = $_POST['score2'];
			}else{
				$score1 = "-";
				$score2 = "-";
			}
			
			if(isset($_POST['on_plan'])){
				$onPlan = $_POST['on_plan'];
			}else{
				$onPlan = "متأخر";
			}
			$sql = "INSERT INTO `mton_review`(`std_id`, `date`, `grade`, `staff_id`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','".$score2."','".$_SESSION['email']."')";
			if(mysqli_query($conn,$sql)){
				$last_inserted_id = mysqli_insert_id($conn);
				$sql = "INSERT INTO `mton_std_att`(`std_id`, `date`, `state`, `rev_id`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','".$att."','".$last_inserted_id."')";
				if(mysqli_query($conn,$sql)){
					$sql = "INSERT INTO `mton_recite`(`std_id`, `date`, `grade`, `rev_id`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','".$score1."','".$last_inserted_id."')";
					if(mysqli_query($conn,$sql)){
						$sql = "INSERT INTO `mton_std_on_plan`(`std_id`, `date`, `onPlan`, `rev_id`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','".$onPlan."','".$last_inserted_id."')";
						if(mysqli_query($conn,$sql)){
							/*$sql = "SELECT * FROM ring_att
									INNER JOIN ring ON ring_att.ring_id = ring.ring_id
									WHERE ring.ring_id = '".$_GET['ring_id']."' AND ring_att.date = '".date('Y-m-d')."' AND type='2'";
							if(mysqli_num_rows(mysqli_query($conn,$sql)) == 0){
								$sql = "INSERT INTO `ring_att`(`ring_id`, `date`, `state`,`type`) VALUES ('".$_GET['ring_id']."','".date('Y-m-d')."','حضور','2')";
								mysqli_query($conn,$sql);
							}*/
							if($score1 == 'ممتاز' and $score2 == 'ممتاز' and $onPlan == 'حسب الخطة'){
								// checking if the std is in a prize program
								$sql = "SELECT * FROM prize_participating_students 
										INNER JOIN prize ON prize.prize_id = prize_participating_students.prize_id
										WHERE std_id = '".$_GET['std_id']."'
										AND prize.state = 'مستمرة'";
								$pRes = mysqli_query($conn,$sql);
								if(mysqli_num_rows($pRes) > 0){
									$rowPrize = mysqli_fetch_assoc($pRes); 
									// counting the stars 
									$sqlP = "SELECT star,COUNT(std_id) As total FROM prize_details WHERE prize_details.std_id = '".$_GET['std_id']."' GROUP BY star";
									$resultP = mysqli_query($conn,$sqlP);
									$hasPronze = false;
									while($rowP = mysqli_fetch_assoc($resultP)){
										//echo "<script>alert('".$rowP['star']."');</script>";
										if($rowP['star'] == 'البرونزية'){
											
											$hasPronze = true;
											if($rowP['total'] >= 2){
												$sql = "INSERT INTO `prize_details`(`std_id`, `date`, `star`,`prize_id`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','الفضية','".$rowPrize['prize_id']."')";
												$result = mysqli_query($conn,$sql);
												if($result){
													$sql = "DELETE FROM `prize_details` WHERE std_id = '".$_GET['std_id']."' AND star = 'البرونزية'";
													mysqli_query($conn,$sql);
													$sql = "SELECT star,COUNT(std_id) As total FROM prize_details WHERE prize_details.std_id = '".$_GET['std_id']."' AND star='الفضية' GROUP BY star ";
													$result = mysqli_query($conn,$sql);
													if(mysqli_num_rows($result) > 0){
														$row = mysqli_fetch_assoc($result);
														if($row['total'] > 2){
															$sql = "INSERT INTO `prize_details`(`std_id`, `date`, `star`,`prize_id`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','الذهبية','".$rowPrize['prize_id']."')";
															mysqli_query($conn,$sql);
															$sql = "DELETE FROM `prize_details` WHERE std_id = '".$_GET['std_id']."' AND star = 'الفضية'";
															mysqli_query($conn,$sql);
														}
													}
												}
											}else{
												$sql = "INSERT INTO `prize_details`(`std_id`, `date`, `star`,`prize_id`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','البرونزية','".$rowPrize['prize_id']."')";
												$result = mysqli_query($conn,$sql);
											}
										}
									}
									if(!$hasPronze){
										$sql = "INSERT INTO `prize_details`(`std_id`, `date`, `star`,`prize_id`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','البرونزية','".$rowPrize['prize_id']."')";
										mysqli_query($conn,$sql);
									} 
								}
							}
							$sqlDateReview = "SELECT date FROM mton_homework WHERE std_id = '".$_GET['std_id']."' ORDER BY date DESC LIMIT 1";
							$rDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDateReview))['date'];
							$sql = "UPDATE `mton_homework` SET `state`= 0 WHERE std_id = '".$_GET['std_id']."' AND date = '".$rDate."' ";
							mysqli_query($conn,$sql);
							// check what type
							//if($_POST['div'] == "ay"){
								$courses = $_POST["courses"];
								$pages1 = $_POST["pages1"];
								$pages2 = $_POST["pages2"];

								// Loop through the selected courses and page ranges
								for ($i = 0; $i < count($courses); $i++) {
									$course = $conn->real_escape_string($courses[$i]);
									$page1_range = $conn->real_escape_string($pages1[$i]);
									$page2_range = $conn->real_escape_string($pages2[$i]);
									$sql = "INSERT INTO `mton_homework`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','review','1','".$last_inserted_id."')";
									$result = mysqli_query($conn,$sql);
									if(!$result){
										echo mysqli_error($conn);
									}
									//echo "<script>window.location.href='ring_man.php?';</script>";
									//echo "<script>window.location.href='ring_details.php?ring_id=".$_GET['ring_id']."';</script>";
								}
								/*$sql = "INSERT INTO `mton_sora_face`(`std_id`, `face`, `type`, `date`, `rev_id`) VALUES ('".$_GET['std_id']."','".$val."','review','".date('Y-m-d')."','".$last_inserted_id."')";
								mysqli_query($conn,$sql);*/
							

							//if($_POST['cdiv'] == "cay"){
								$ccourses = $_POST["ccourses"];
								$cpages1 = $_POST["cpages1"];
								$cpages2 = $_POST["cpages2"];

								// Loop through the selected courses and page ranges
								for ($i = 0; $i < count($ccourses); $i++) {
									$course = $conn->real_escape_string($ccourses[$i]);
									$page1_range = $conn->real_escape_string($cpages1[$i]);
									$page2_range = $conn->real_escape_string($cpages2[$i]);
									$sql = "INSERT INTO `mton_homework`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`,`state`,`rev_id`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','recite','1','".$last_inserted_id."')";
									$result = mysqli_query($conn,$sql);
									if(!$result){
										echo mysqli_error($conn);
									}
									//echo "<script>window.location.href='ring_man.php?';</script>";
									//echo "<script>window.location.href='ring_details.php?ring_id=".$_GET['ring_id']."';</script>";
								}
							
							echo "<script>window.location.href='mton_ring_det.php?mton_ring_id=".$_GET['mton_ring_id']."';</script>";
						}else{
							echo "<script>alert('خطأ في إدخال درجة الخطة')</script>";
						}
					}else{
						echo "<script>alert('خطأ في إدخال درجات المراجعة')</script>";
					}
				}else{
					echo "<script>alert('خطأ في إدخال درجات التسميع')</script>";
				}
			}else{
				echo "<script>alert('خطأ في إدخال درجات الحضور')</script>";
			}
		}else{
			echo '<script>alert("الرجاء التأكد من اختيار جميع الدرجات")</script>';
		}
		

	}

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إدارة المتون </title>
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
		@media screen and (min-width: 900px) {
			article{
				width:500px;			
			}	
			.card-grid {
				grid-template-columns: repeat(2, 0fr);
				
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
					<a href="ring_man.php">إدارة المتون  التسميع</a>
					
					
					<a href="mton_man.php" class="active">إدارة المتون</a>
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
				<h2>
					<?php
						$rname = mysqli_fetch_assoc(mysqli_query($conn,"SELECT mton_ring_name FROM mton_ring WHERE mton_ring_id = '".$_GET['mton_ring_id']."'"))['mton_ring_name'];
						echo $rname;
					?>
				</h2>
				
			</div>
			
		</div>
		<div class="content">
			
			<div class="content-panel">
				<div class="vertical-tabs">
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
					<a href="ring_man.php">إدارة المتون  التسميع</a>
					
					
					<a href="mton_man.php" class="active">إدارة المتون</a>
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
					?><div style="margin-bottom: 400px;">
					</div>
				</div>
			</div>
			<div class="content-main">
			<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<form class="login-form" id="myForm" action="mton_details.php?mton_ring_id=<?php echo $_GET['mton_ring_id'];?>&std_id=<?php echo $_GET['std_id'];?>" method="post" onsubmit="return validateForm()">

				<div class="card-grid" style="font-size:18px;" >
					<?php if(isset($_GET['std_id'])){?>
							<article class="card" style="width:300px;">
								<div class="card-header">
									<div>
										<span><img src="imgs/icons/mton.png" /></span>
										<h3>درجات التسميع و الحضور</h3>
									</div>
								</div>
								<div class="card-body">
								<input style="width:auto;margin:10px;display:inline-block;" type="radio" name="att" value="حضور" id="present"><label for="present">حضور</label>
								<input style="width:auto;margin:10px;display:inline-block;" type="radio" name="att" value="غياب" id="disp"><label for="disp">غياب</label>
								<input style="width:auto;margin:10px;display:inline-block;" type="radio" name="att" value="مستاذن" id="disp2"><label for="disp2">مستاذن</label></br></br>
									<?php
										$sqlPlan = "SELECT * FROM mton_review_plan WHERE std_id = '".$_GET['std_id']."'";
										$resultPlan = mysqli_query($conn,$sqlPlan);
										$revPlan = "no";
										if(mysqli_num_rows($resultPlan) > 0){
											$rowPlan = mysqli_fetch_assoc($resultPlan);
											$revPlan = $rowPlan['amount'];
											if($revPlan == "0"){
												$revPlan = "no";
												echo '<h1 style="font-size:19px;">خطة الحفظ : <color style="color:#b40836">متوقف</color></h1></br>';

											}else{
												echo '<h1 style="font-size:19px;">خطة الحفظ : <color style="color:#b40836">'.$rowPlan['amount'].'</color></h1></br>';
											}
										}else{
											echo '<h1 style="font-size:19px;color:#b40836;">الطالب ليس لديه خطة حفظ</h1></br>';
										}
										echo "<p id='revPlan' style='display:none;'>$revPlan</p>";
										echo "<input id='revPlan' type= 'text' name='revPlan' style='display:none; value='.$revPlan.'/>";

										$sqlPlan = "SELECT * FROM mton_recite_plan WHERE std_id = '".$_GET['std_id']."'";
										$recPlan = "no";
										$resultPlan = mysqli_query($conn,$sqlPlan);
										if(mysqli_num_rows($resultPlan) > 0){
											$rowPlan = mysqli_fetch_assoc($resultPlan);
											$recPlan = $rowPlan['amount'];
											if($recPlan == "0"){
												$recPlan = "no";
											}
											echo '<h1 style="font-size:19px;">خطة المراجعة : <color style="color:#b40836">'.$rowPlan['amount'].'</color></h1></br>';
										}else{
											echo '<h1 style="font-size:19px;color:#b40836;">الطالب ليس لديه خطة مراجعة</h1></br>';
										}
										echo "<p id='recPlan' style='display:none;'>$recPlan</p>";
										echo "<input id='recPlan' type= 'text' name='recPlan' style='display:none; value='.$revPlan.'/>";
										
										echo '<h1 style="font-size:19px;">واجب الحفظ : </h1>';
										$sqlDatemton_review = "SELECT date FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND type='review' AND state = '1' ORDER BY date DESC LIMIT 1";
										$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDatemton_review));
										$sql = "SELECT * FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND type='review' AND date = '".$rowRDate['date']."' AND state = '1'";
												$rres = mysqli_query($conn,$sql);
												if(mysqli_num_rows($rres) > 0){
													echo '<center><ul style= "margin-bottom:10px;">';
													while($rrow = mysqli_fetch_assoc($rres)){
														if($rrow['s_from'] == '-'){
															echo '<li style="font-size:18px;"> سورة '.$rrow['sora'].'</li>';
														}else{
															echo '<li style="font-size:18px;color:#1c9300;">'.$rrow['sora'].' من '.$rrow['s_from'].' إلى '.$rrow['s_to'].'</li>';
														}
														
													}
													echo '</ul></center>';
												}else{
													echo '<h1 style="font-size:18px;color:#1c9300;">الطالب ليس لديه واجب حفظ</h1></br>';
												}
												echo '<h1 style="font-size:19px;">واجب المراجعة : </h1>';
												$sqlDatemton_review = "SELECT date FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND type='recite' AND state = '1' ORDER BY date DESC LIMIT 1";
												$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDatemton_review));
												$sql = "SELECT * FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND type='recite' AND date = '".$rowRDate['date']."' AND state = '1'";												$rres = mysqli_query($conn,$sql);
														if(mysqli_num_rows($rres) > 0){
															echo '<center><ul style= "margin-bottom:10px;">';
															while($rrow = mysqli_fetch_assoc($rres)){
																if($rrow['s_from'] == '-'){
																	echo '<li style="font-size:18px;"> سورة '.$rrow['sora'].'</li>';
																}else{
																	echo '<li style="font-size:18px;color:#1c9300;">'.$rrow['sora'].' من '.$rrow['s_from'].' إلى '.$rrow['s_to'].'</li>';
																}
																
															}
															echo '</ul></center>';
														}else{
															echo '<h1 style="font-size:18px;color:#1c9300;">الطالب ليس لديه واجب مراجعة</h1></br>';
														}
									?>
									<center><table id = "score_table">
									
									<tr>
										<th>درجة الحفظ</th>
										<th>درجة المراجعة</th>
									</tr>
									<!--<?php
										$sql = "SELECT std_name from students WHERE std_id = '".$_GET['std_id']."'";
										$name = mysqli_fetch_assoc(mysqli_query($conn,$sql))['std_name'];
									?>	-->
									<tr>

											<td>
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="ممتاز" id="grade1"> ممتاز</br>
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="جيد جدا" id="grade2">جيد جدا </br>
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="جيد" id="grade3"> جيد</br>
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="إعادة" id="grade4"> إعادة</br>
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="لم يحفظ" id="grade5"> لم يحفظ
											</td>
											<td>
												<input style="width:auto;margin:10px;" type="radio" name="score2" value="ممتاز" id="grade6"> ممتاز</br>
												<input style="width:auto;margin:10px;" type="radio" name="score2" value="جيد جدا" id="grade7">جيد جدا </br>
												<input style="width:auto;margin:10px;" type="radio" name="score2" value="جيد" id="grade8"> جيد</br>
												<input style="width:auto;margin:10px;" type="radio" name="score2" value="إعادة" id="grade9"> إعادة</br>
												<input style="width:auto;margin:10px;" type="radio" name="score2" value="لم يحفظ" id="grade10"> لم يحفظ
											</td>							
									</tr>
									
								</table></center>
							</div>
							<div class="card-footer">
								<div>
									<input style="width:auto;margin:10px;" type="checkbox" name="on_plan" value="حسب الخطة" id="onplan"> حسب الخطة
								</div>
							</div>
							<div class="card-footer" id="send_btn" style="display:none;">
								<button type="submit" name="std_info">انتهاء التسميع</button>
							</div>
						</article>
						
						<article class="card" id="homework" style="margin-top:10px">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/mton.png" /></span>
									<h3>تسجيل الواجب</h3>
								</div>
							</div>
							<div class="card-body">
								<!-- واجب الحفظ -->
								<!-- واجب الحفظ -->
								<!-- واجب الحفظ -->
								<!-- واجب الحفظ -->
								<!-- واجب الحفظ -->
								<?php
									if($revPlan == 'no'){
								?>
								<div id="review" style="display:none">
								<?php
									}else{
								?>
									<div id="review">
								<?php
									}
								?>
								<h2 style="font-weight:bold;">واجب الحفظ </h2>
								<center>
									<div id="div1" class="cont">
										<div id="course-container" style="margin-bottom:10px;">
											<div class="course-container" id="course1-container">
												<ul>
													<li style="display:inline;">
													
														<select style="width:40%;height:30px;" name="courses[]" id="course1">
															<option value="<?php
																				$rname = mysqli_fetch_assoc(mysqli_query($conn,"SELECT mton_ring_name FROM mton_ring WHERE mton_ring_id = '".$_GET['mton_ring_id']."'"))['mton_ring_name'];
																				echo $rname;
																			?>" selected>
															<?php
																/*$sql = "SELECT mton_name FROM mton";
																$rees = mysqli_query($conn,$sql);
																if(mysqli_num_rows($rees) > 0){
																	while($roow = mysqli_fetch_assoc($rees)){
																		echo '<option value="'.$roow['mton_name'].'">'.$roow['mton_name'].'</option>';
																	}
																}*/
																$rname = mysqli_fetch_assoc(mysqli_query($conn,"SELECT mton_ring_name FROM mton_ring WHERE mton_ring_id = '".$_GET['mton_ring_id']."'"))['mton_ring_name'];
																echo $rname;
															?>
															</option>
														</select>
													</li>
													<li style="display:inline;"><input style="width:25.2%;height:30px;" type="text" placeholder="من" name="pages1[]" id="pages1" class="page-range"></li>
													<li style="display:inline;"><input style="width:25.2%;height:30px;" placeholder="إلى" type="text" name="pages2[]" id="pages2" class="page-range"></li>
												</ul>
											</div>
										</div>
										<!--<ul>
											<li style="display:inline;"><input style="width:43.3%;font-size:16px;" type="button" onclick="addCourse()" value="إضافة "></li>
											<li style="display:inline;"><input style="width:43.3%;font-size:16px;" type="button" onclick="removeLastCourse()" value="حذف سورة"></li>
										</ul>-->
									</div>
								</center>
								</div>
								<!--<center><div id="div2" class="cont" style="display:none;">
									<div id="sora" style="margin-bottom:10px;">
										<div class="sora" id="sora1">
											<ul>
												<li style="display:inline;">
													<select style="width:70%;height:80px;margin-bottom:5px;" name="sora[]" id="s1" multiple>
														<option value="" selected></option>
														
													</select>
												</li>
											</ul>
										</div>
									</div>

								</div></center>-->
								<!-- واجب المراجعة -->
								<!-- واجب المراجعة -->
								<!-- واجب المراجعة -->
								<!-- واجب المراجعة -->
								<?php
									if($recPlan == 'no'){
								?>
								<div id="recite" style="display:none">
								<?php
									}else{
								?>
									<div id="recite">
								<?php
									}
								?>
								<h2 style="font-weight:bold;">واجب المراجعة </h2>
								<!--<center>
									<label for="cdiv1-radio">آيات</label>
									<input style="width:auto;margin-left:10px;" type="radio" name="cdiv" id="cdiv1-radio" value="cay" onclick="showCDiv('cdiv1')" checked>
										
									<label for="cdiv2-radio">سور</label>
									<input style="width:auto;" type="radio" name="cdiv" id="cdiv2-radio" value="cso" onclick="showCDiv('cdiv2')">
										
								</center>-->
								<center><div id="cdiv1" class="ccont">
									<div id="ccourse-container" style="margin-bottom:10px;">
										<div class="ccourse-container" id="ccourse1-container">
											<ul>
												<li style="display:inline;">
													<select style="width:40%;height:30px;" name="ccourses[]" id="ccourse1">
													<option value="<?php
																				$rname = mysqli_fetch_assoc(mysqli_query($conn,"SELECT mton_ring_name FROM mton_ring WHERE mton_ring_id = '".$_GET['mton_ring_id']."'"))['mton_ring_name'];
																				echo $rname;
																			?>" selected>
															<?php
																/*$sql = "SELECT mton_name FROM mton";
																$rees = mysqli_query($conn,$sql);
																if(mysqli_num_rows($rees) > 0){
																	while($roow = mysqli_fetch_assoc($rees)){
																		echo '<option value="'.$roow['mton_name'].'">'.$roow['mton_name'].'</option>';
																	}
																}*/
																$rname = mysqli_fetch_assoc(mysqli_query($conn,"SELECT mton_ring_name FROM mton_ring WHERE mton_ring_id = '".$_GET['mton_ring_id']."'"))['mton_ring_name'];
																echo $rname;
															?>
															</option>
													</select>
												</li>
												<li style="display:inline;"><input style="width:25.2%;height:30px;" type="text" placeholder="من" name="cpages1[]" id="cpages1" class="page-range"></li>
												<li style="display:inline;"><input style="width:25.2%;height:30px;" placeholder="إلى" type="text" name="cpages2[]" id="cpages2" class="page-range"></li>
											</ul>
										</div>
									</div>
									<!--<ul>
										<li style="display:inline;"><input style="width:43.3%;font-size:16px;" type="button" onclick="addCCourse()" value="إضافة سورة"></li>
										<li style="display:inline;"><input style="width:43.3%;font-size:16px;" type="button" onclick="removeCLastCourse()" value="حذف سورة"></li>
									</ul>-->
								</div></center>
								</div>
								<!--<center><div id="cdiv2" class="ccont" style="display:none;">
									<div id="csora" style="margin-bottom:10px;">
										<div class="csora" id="csora1">
											<ul>
												<li style="display:inline;">
													<select style="width:70%;height:80px;margin-bottom:5px;" name="csora[]" id="cs1" multiple>
														<option value="" selected></option>
														
													</select>
												</li>
											</ul>
										</div>
									</div>
								</div></center>-->
							</div>
							<div class="card-footer">
								<button type="submit" name="std_info">انتهاء التسميع</button>
							</div>
						</artice>
					<?php }?>
				</div>
				</form>
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
	function addCourse(select) {
		if (select.value !== "") {
			// Create new course row
			var div = document.createElement("div");
			var select_copy = select.cloneNode(true);
			var input1 = document.createElement("input");
			var input2 = document.createElement("input");
			input1.type = "text";
			input1.name = "pages[]";
			input1.placeholder = "From page";
			input2.type = "text";
			input2.name = "pages[]";
			input2.placeholder = "To page";
			div.appendChild(select_copy);
			div.appendChild(input1);
			div.appendChild(input2);
			
			// Add new course row to list
			var course_list = document.getElementById("course-list");
			course_list.appendChild(div);
			
			// Disable selected course in other rows
			var all_selects = document.getElementsByTagName("select");
			for (var i = 0; i < all_selects.length; i++) {
				if (all_selects[i].value === select.value) {
					all_selects[i].disabled = true;
				}
			}
		}
	}
	</script>
	<script>
		var option1 = document.getElementById("grade1");
		var option2 = document.getElementById("grade2");
		var option3 = document.getElementById("grade3");
		var option4 = document.getElementById("grade4");
		var option5 = document.getElementById("grade5");
		var option6 = document.getElementById("grade6");
		var option7 = document.getElementById("grade7");
		var option8 = document.getElementById("grade8");
		var option9 = document.getElementById("grade9");
		var option10 = document.getElementById("grade10");
		var onplan = document.getElementById("onplan");
		var absent = document.getElementById("disp");
		var excused = document.getElementById("disp2");
		var present = document.getElementById("present");
		var homework = document.getElementById("homework");
		var sendbtn = document.getElementById("send_btn");
		var review = document.getElementById("review");
		var recite = document.getElementById("recite");
		var revPlan = document.getElementById("revPlan");
		var recPlan = document.getElementById("recPlan");
		
		absent.addEventListener("click", function() {
			
			onplan.disabled = true;
			homework.style.display = "none";
			if(sendbtn)
				sendbtn.style.display = "block";
			
			if (option1) {
			option1.disabled = true;
			}
			
			if (option2) {
			option2.disabled = true;
			}
			if (option3) {
			option3.disabled = true;
			}
			if (option4) {
			option4.disabled = true;
			}
			if (option5) {
			option5.disabled = true;
			}
			if (option6) {
			option6.disabled = true;
			}
			if (option7) {
			option7.disabled = true;
			}
			if (option8) {
			option8.disabled = true;
			}
			if (option9) {
			option9.disabled = true;
			}
			if (option10) {
			option10.disabled = true;
			}
			

		});
		excused.addEventListener("click", function() {
			onplan.disabled = true;
			homework.style.display = "none";
			if(sendbtn)
				sendbtn.style.display = "block";
			if (option1) {
			option1.disabled = true;
			}
			if (option2) {
			option2.disabled = true;
			}
			if (option3) {
			option3.disabled = true;
			}
			if (option4) {
			option4.disabled = true;
			}
			if (option5) {
			option5.disabled = true;
			}
			if (option6) {
			option6.disabled = true;
			}
			if (option7) {
			option7.disabled = true;
			}
			if (option8) {
			option8.disabled = true;
			}
			if (option9) {
			option9.disabled = true;
			}
			if (option10) {
			option10.disabled = true;
			}
			

		});

		present.addEventListener("click", function() {
			if (option1) {
			option1.disabled = false;
			}
			if (option2) {
			option2.disabled = false;
			}
			if (option3) {
			option3.disabled = false;
			}
			if (option4) {
			option4.disabled = false;
			}
			if (option5) {
			option5.disabled = false;
			}
			if (option6) {
			option6.disabled = false;
			}
			if (option7) {
			option7.disabled = false;
			}
			if (option8) {
			option8.disabled = false;
			}
			if (option9) {
			option9.disabled = false;
			}
			if (option10) {
			option10.disabled = false;
			}
			
			onplan.disabled = false;
			homework.style.display = "flex";
			if(revPlan.innerHTML == "no"){
				revite.style.display = "none";
			}
			if(recPlan.innerHTML == "no"){
				recite.style.display = "none";
			}
			sendbtn.style.display = "none";
		});


		if(option1){
			option1.addEventListener("click", function() {
				onplan.disabled = false;
				if(option10){
					if (option10.checked) {
						onplan.disabled = true;
					}
				}
				if(option9){
					if (option9.checked) {
						onplan.disabled = true;
					}
				}
				
				if(revPlan.innerHTML == "no"){
					review.style.display = "none";
					homework.style.display = "none";
					
				}else{
					review.style.display = "block";
					homework.style.display = "flex";
				}
				sendbtn.style.display = "none";
			});
		}
		if(option2){
			option2.addEventListener("click", function() {
				onplan.disabled = false;
				if(option10){
					if (option10.checked) {
						onplan.disabled = true;
					}
				}
				if(option9){
					if (option9.checked) {
						onplan.disabled = true;
					}
				}
				
				if(revPlan.innerHTML == "no"){
					review.style.display = "none";
					homework.style.display = "none";
				}else{
					review.style.display = "block";
					homework.style.display = "flex";
				}
				sendbtn.style.display = "none";
			});
		}
		if(option3){
			option3.addEventListener("click", function() {
				onplan.disabled = false;
				if(option10){
					if (option10.checked) {
						onplan.disabled = true;
					}
				}
				if(option9){
					if (option9.checked) {
						onplan.disabled = true;
					}
				}
				
				if(revPlan.innerHTML == "no"){
					review.style.display = "none";
					homework.style.display = "none";
				}else{
					review.style.display = "block";
					homework.style.display = "flex";
				}
				sendbtn.style.display = "none";
			});
		}
		if(option4){
			option4.addEventListener("click", function() {
				onplan.disabled = false;
				if(option10){
					if (option10.checked) {
						onplan.disabled = true;
						homework.style.display = "none";
						sendbtn.style.display = "block";
					}
				}else{
					onplan.disabled = true;
				}
				if(option9){
					if (option9.checked) {
						onplan.disabled = true;
						homework.style.display = "none";
						sendbtn.style.display = "block";
					}
				}else{
					onplan.disabled = true;
				}
				onplan.disabled = true;
				review.style.display = "none";
				if(recPlan.innerHTML == "no"){
					sendbtn.style.display = "block";
					homework.style.display = "none";
				}
				
				
			});
		}
		if(option5){
			option5.addEventListener("click", function() {
				onplan.disabled = false;
				
				if(option10){
					if (option10.checked) {
						onplan.disabled = true;
						homework.style.display = "none";
						sendbtn.style.display = "block";
					}
				}else{
					onplan.disabled = true;
				}
				if(option9){
					if (option9.checked) {
						onplan.disabled = true;
						homework.style.display = "none";
						sendbtn.style.display = "block";
					}
				}else{
					onplan.disabled = true;
				}
				
				
				review.style.display = "none";
				if(recPlan.innerHTML == "no"){
					sendbtn.style.display = "block";
					homework.style.display = "none";
				}
				
			});
		}
		if(option6){
			option6.addEventListener("click", function() {
				onplan.disabled = false;
				if(option4){
					if (option4.checked) {
						onplan.disabled = true;
					}
				}
				if(option5){
					if (option5.checked) {
						onplan.disabled = true;
					}
				}
				
				if(recPlan.innerHTML == "no"){
					recite.style.display = "none";
				}else{
					recite.style.display = "block";
					homework.style.display = "flex";
				}
				sendbtn.style.display = "none";
			});
		}
		if(option7){
			option7.addEventListener("click", function() {
				onplan.disabled = false;
				if(option4){
					if (option4.checked) {
						onplan.disabled = true;
					}
				}
				if(option5){
					if (option5.checked) {
						onplan.disabled = true;
					}
				}
				
				if(recPlan.innerHTML == "no"){
					recite.style.display = "none";
				}else{
					recite.style.display = "block";
					homework.style.display = "flex";
				}
				sendbtn.style.display = "none";
			});
		}
		if(option8){
			option8.addEventListener("click", function() {
				onplan.disabled = false;
				if(option4){
					if (option4.checked) {
						onplan.disabled = true;
					}
				}
				if(option5){
					if (option5.checked) {
						onplan.disabled = true;
					}
				}
				
				if(recPlan.innerHTML == "no"){
					recite.style.display = "none";
				}else{
					recite.style.display = "block";
					homework.style.display = "flex";
				}
				sendbtn.style.display = "none";
			});
		}
		if(option9){
			option9.addEventListener("click", function() {
				onplan.disabled = false;
				
				if(option4){
					if (option4.checked) {
						onplan.disabled = true;
					}
				}
				if(option5){
					if (option5.checked) {
						onplan.disabled = true;
					}
				}
				
				recite.style.display = "none";
				if(option4){
					if (option4.checked) {
						onplan.disabled = true;
						homework.style.display = "none";
						sendbtn.style.display = "block";
					}
				}else{
					onplan.disabled = true;
				}
				if(option5){
					if (option5.checked) {
						onplan.disabled = true;
						homework.style.display = "none";
						sendbtn.style.display = "block";
					}
				}else{
					onplan.disabled = true;
				}
				onplan.disabled = true;
				if(revPlan.innerHTML == "no"){
					sendbtn.style.display = "block";
					homework.style.display = "none";
				}
			});
		}
		if(option10){
			option10.addEventListener("click", function() {
				onplan.disabled = false;
				
				if(option6){
					if (option6.checked) {
						onplan.disabled = true;
					}
				}
				
				recite.style.display = "none";
				if(option4){
					if (option4.checked) {
						onplan.disabled = true;
						homework.style.display = "none";
						sendbtn.style.display = "block";
					}
				}else{
					onplan.disabled = true;
				}
				if(option5){
					if (option5.checked) {
						onplan.disabled = true;
						homework.style.display = "none";
						sendbtn.style.display = "block";
					}
				}else{
					onplan.disabled = true;
				}
				if(option6){
					if (option6.checked) {
						onplan.disabled = true;
						homework.style.display = "none";
						sendbtn.style.display = "block";
					}
				}else{
					onplan.disabled = true;
				}
				onplan.disabled = true;
				if(revPlan.innerHTML == "no"){
					sendbtn.style.display = "block";
					homework.style.display = "none";
				}
			});
		}
	</script>
</body>
<script>
	function validateForm() {
		var option1 = document.getElementById("grade1");
		var option2 = document.getElementById("grade2");
		var option3 = document.getElementById("grade3");
		var option4 = document.getElementById("grade4");
		var option5 = document.getElementById("grade5");
		var option6 = document.getElementById("grade6");
		var option7 = document.getElementById("grade7");
		var option8 = document.getElementById("grade8");
		var option9 = document.getElementById("grade9");
		var option10 = document.getElementById("grade10");
	
		var revPlan = document.getElementById("revPlan");
		var recPlan = document.getElementById("recPlan");

		var disp = document.getElementById("disp");
		var disp2 = document.getElementById("disp2");

		if(!disp.checked && !disp2.checked){
			if(revPlan.innerHTML != "no"){
				if (!option1.checked && !option2.checked 
					&& !option3.checked && !option4.checked 
					&& !option5.checked){
						event.preventDefault();
					alert("الرجاء اختيار درجة الحفظ");
				}
			}
			if(recPlan.innerHTML != "no"){
				if (!option6.checked && !option7.checked 
					&& !option8.checked && !option9.checked 
					&& !option10.checked) {
						event.preventDefault();
					alert("الرجاء اختيار درجة المراجعة");
				}
			}
		}

		var pages1 = document.getElementById("pages1");
		var pages2 = document.getElementById("pages2");
		var course = document.getElementById("course1");

		// Check if the text boxes are empty
		if (pages1.value === "" || pages2.value === "" || course.value === "") {
			// Prevent the form from submitting
			event.preventDefault();
			alert("الرجاء اختيار السورة والآيات للحفظ");
		}

		var Cpages1 = document.getElementById("cpages1");
		var Cpages2 = document.getElementById("cpages2");
		var Ccourse = document.getElementById("ccourse1");

		// Check if the text boxes are empty
		if (Cpages1.value === "" || Cpages2.value === "" || Ccourse.value === "") {
			// Prevent the form from submitting
			event.preventDefault();
			alert("الرجاء اختيار السورة والآيات للمراجعة");
		}

	}
		function confirmLogOut() {
			if (confirm("هل أنت متأكد من تسجيل الخروج ؟")) {
				return true;
			} else {
				return false;
			}
		}
	</script>
	<script>
        function addCourse() {
            // Get the container element
            var container = document.getElementById("course-container");

            // Clone the original course container
            var originalContainer = document.getElementById("course1-container");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            var newInput = newContainer.querySelector("input");
            newInput.value = "";

            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeLastCourse() {
			// Get the container element
			var container = document.getElementById("course-container");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		// adding sora
		function addSora() {
            // Get the container element
            var container = document.getElementById("sora");

            // Clone the original course container
            var originalContainer = document.getElementById("sora1");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeLastSora() {
			// Get the container element
			var container = document.getElementById("sora");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		//showing the type
		function showDiv(divId) {
			var divs = document.querySelectorAll('.cont');
			for (var i = 0; i < divs.length; i++) {
				if (divs[i].id === divId) {
				divs[i].style.display = "block";
				} else {
				divs[i].style.display = "none";
				}
			}
		}




		function addCCourse() {
            // Get the container element
            var container = document.getElementById("ccourse-container");

            // Clone the original course container
            var originalContainer = document.getElementById("ccourse1-container");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            var newInput = newContainer.querySelector("input");
            newInput.value = "";

            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeCLastCourse() {
			// Get the container element
			var container = document.getElementById("ccourse-container");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		// adding sora
		function addCSora() {
            // Get the container element
            var container = document.getElementById("csora");

            // Clone the original course container
            var originalContainer = document.getElementById("csora1");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeCLastSora() {
			// Get the container element
			var container = document.getElementById("csora");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		//showing the type
		function showCDiv(divId) {
			var divs = document.querySelectorAll('.ccont');
			for (var i = 0; i < divs.length; i++) {
				if (divs[i].id === divId) {
				divs[i].style.display = "block";
				} else {
				divs[i].style.display = "none";
				}
			}
		}
    </script>
	<script>
		// Get a reference to the form element
		var form = document.getElementById("myForm");

		// Attach an event listener to the form's submit event
		form.addEventListener("submit", function(event) {
			// Get a reference to the text boxes
			// CODE FOR THE mton_review HOMEWORK
			// CODE FOR THE mton_review HOMEWORK

			var option1 = document.getElementById("grade1");
			var option2 = document.getElementById("grade2");
			var option3 = document.getElementById("grade3");
			var option4 = document.getElementById("grade4");
			var option5 = document.getElementById("grade5");
			var option6 = document.getElementById("grade6");
			var option7 = document.getElementById("grade7");
			var option8 = document.getElementById("grade8");
			var option9 = document.getElementById("grade9");
			var option10 = document.getElementById("grade10");
			var option11 = document.getElementById("grade11");
			var option12 = document.getElementById("grade12");
			var onplan = document.getElementById("onplan");
			var absent = document.getElementById("disp");
			var excused = document.getElementById("disp2");
			var present = document.getElementById("present");
			var homework = document.getElementById("homework");
			var sendbtn = document.getElementById("send_btn");



			var rad1 = document.getElementById("div1-radio");
			var rad2 = document.getElementById("div2-radio");
			var disp = document.getElementById("disp");
			var disp2 = document.getElementById("disp2");

			if(rad1.checked){
				var pages1 = document.getElementById("pages1");
				var pages2 = document.getElementById("pages2");
				var course = document.getElementById("course1");
				// Check if the text boxes are empty
				if (pages1.value === "" || pages2.value === "" || course.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						event.preventDefault();
						alert("الرجاء اختيار السورة والآيات للحفظ");
					}
				}
			}
			if(rad2.checked){
				var sora = document.getElementById("s1");
				// Check if the text boxes are empty
				if (sora.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						event.preventDefault();
						alert("الرجاء اختيار السورة للحفظ");
					}
				}
			}

			// CODE FOR THE mton_recite HOMEWORK
			// CODE FOR THE mton_recite HOMEWORK

			var rad1 = document.getElementById("cdiv1-radio");
			var rad2 = document.getElementById("cdiv2-radio");

			if(rad1.checked){
				var pages1 = document.getElementById("cpages1");
				var pages2 = document.getElementById("cpages2");
				var course = document.getElementById("ccourse1");
				// Check if the text boxes are empty
				if (pages1.value === "" || pages2.value === "" || course.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						event.preventDefault();
						alert("الرجاء اختيار السورة والآيات للمراجعة");
					}
				}
			}
			if(rad2.checked){
				var sora = document.getElementById("cs1");
				// Check if the text boxes are empty
				if (sora.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						event.preventDefault();
						alert("الرجاء اختيار السورة للمراجعة");
					}
				}
			}

			
		});
	</script>
	<script>
		setInterval(function() {
			var xhr = new XMLHttpRequest();
			xhr.open('GET', 'check_activity.php', true);
			xhr.send();
		}, 32000); // 1 minute interval
	</script>
</html>