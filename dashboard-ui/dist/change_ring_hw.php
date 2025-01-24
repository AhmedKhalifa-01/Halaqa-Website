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
	if($_GET['ring_id'] != $_SESSION['email']){
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
			echo "<script>window.location.href='../../index.php';</script>";
		}
	}
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
			$sql = "UPDATE std_att SET state = '".$att."' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
			if(mysqli_query($conn,$sql)){
				$sql = "UPDATE recite SET grade = '".$score1."' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
				//$sql = "INSERT INTO `recite`(`std_id`, `date`, `grade`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','".$score1."')";
				if(mysqli_query($conn,$sql)){
					$sql = "UPDATE review SET grade='".$score2."' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
					if(mysqli_query($conn,$sql)){
						$sql = "UPDATE std_on_plan SET onPlan='".$onPlan."' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
						//$sql = "INSERT INTO `std_on_plan`(`std_id`, `date`, `onPlan`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','".$onPlan."')";
						if(mysqli_query($conn,$sql)){
							echo "<script>alert('".$onPlan."');</script>";
							if($score1 == 'ممتاز' and $score2 == 'ممتاز' and $onPlan == 'حسب الخطة'){
								// checking if the std is in a prize program
								$sql = "SELECT * FROM students 
										INNER JOIN prize_participating_students ON prize_participating_students.std_id = students.std_id
										INNER JOIN prize ON prize_participating_students.prize_id = prize.prize_id
										WHERE students.std_id = '".$_GET['std_id']."'
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
							//echo "<script>window.location.href='change_ring_results.php?ring_id=".$_GET['ring_id']."&std_id=".$_GET['std_id']."';</script>";
						}else{
							echo "<script>alert('خطأ في تعديل درجة الخطة')</script>";
						}
					}else{
						echo "<script>alert('خطأ في تعديل درجات المراجعة')</script>";
					}
				}else{
					echo "<script>alert('خطأ في تعديل درجات التسميع')</script>";
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
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>درجات</title>
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
		.tt table {
			border-collapse: collapse;
			max-width: auto;
			margin: 0 auto;
			margin-top: 50px;
		}
		.tt h1{
			margin-top:100px;
			font-size: 32px;
			font-weight: bold;
		}

		.tt thead th {
			background-color: #f2f2f2;
			border: 1px solid #ddd;
			font-weight: bold;
			padding: 10px;
			text-align: right;
		}

		.tt tbody tr {
			border: 1px solid #ddd;
		}

		.tt tbody td {
			font-size:16px;
			font-weight:bold;
			padding: 20px;
			text-align: right;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		.tt td:nth-child(even) {
			background-color: #f2f2f2;
		}
		.tt td:nth-child(even):hover {
			background-color: #f9f9f9;
		}

		.tt td:nth-child(odd) {
			background-color: #fff;
		}
		.tt td:nth-child(odd):hover {
			background-color: #f2f2f2;
		}
	</style>
</head>
<body>
<center style="margin-bottom:20px;"><a href="ring_man.php" class="button" style="width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
<!-- partial:index.partial.html -->
					<?php if(isset($_GET['calc_res'])){?>
						<form class="login-form" action="change_ring_results.php?review_date=<?php echo $_GET['review_date'];?>&ring_id=<?php echo $_GET['ring_id'];?>&std_id=<?php echo $_GET['std_id'];?>" method="post">
							<article class="card" style="width:400px;padding:5px;height:fit-content;">
								<div class="card-header">
									<div>
										<span><img src="imgs/icons/quran.png" /></span>
										<h3>درجات التسميع و الحضور</h3>
									</div>
								</div>
								<div class="card-body">
									<?php
										$sqlPlan = "SELECT * FROM review_plan WHERE std_id = '".$_GET['std_id']."'";
										$resultPlan = mysqli_query($conn,$sqlPlan);
										if(mysqli_num_rows($resultPlan) > 0){
											$rowPlan = mysqli_fetch_assoc($resultPlan);
											echo '<h1 style="font-size:19px;">خطة الحفظ : '.$rowPlan['amount'].'</h1></br>';
										}else{
											echo '<h1 style="font-size:19px;">الطالب ليس لديه خطة حفظ</h1></br>';
										}
										$sql = "SELECT * FROM std_homework_soras
												WHERE std_id = '".$_GET['std_id']."' AND type = 'review' AND date = '".$_GET['review_date']."';";
										$re = mysqli_query($conn,$sql);
										if(mysqli_num_rows($re) > 0){
											echo '<p><color style="color:darkgreen">واجب الحفظ</color>';
											while($rowres = mysqli_fetch_assoc($re)){
												if($rowres['s_from'] == "-"){
													echo '<h2 style="font-size:18px;"> :  سورة '.$rowres['sora'].'</h2>';
												}else{
													echo '<h2 style="font-size:18px;"> :  سورة '.$rowres['sora'].' من آية '.$rowres['s_from'].' إلى آية '.$rowres['s_to'].'</h2>';
												}
											}
											echo '</p>';
										}else{
											echo '<h1 style="font-size:18px;">الطالب ليس لديه واجب حفظ</h1></br>';
										}
									?>
									<center><table id = "score_table">
									
									<tr>
										<th>اسم الطالب</th>
										<th>حالة الحضور اليوم</th>
										<th>الدرجة</th>
									</tr>
									<?php
										$sql = "SELECT std_name from students WHERE std_id = '".$_GET['std_id']."'";
										$name = mysqli_fetch_assoc(mysqli_query($conn,$sql))['std_name'];
									?>	
									<tr>
										
											<td style="white-space: normal;word-wrap: break-word;max-width: 150px;">
												<?php echo $name ?>
											</td>
											<td style="width:120px;margin:10px;">
												<input style="width:auto;margin:10px;" type="radio" name="att" value="حضور" id="present">حضور </br>
												<input style="width:auto;margin:10px;" type="radio" name="att" value="غياب" id="disp"> غياب</br>
											</td>
											<td style="width:150px;margin:10px;">
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="ممتاز" id="grade1"> ممتاز</br>
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="جيد جدا" id="grade2">جيد جدا </br>
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="جيد" id="grade3"> جيد</br>
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="إعادة" id="grade4"> إعادة</br>
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="لم يحفظ" id="grade5"> لم يحفظ
											</td>
											
										</form>
										
									</tr>
								</table></center>
							</div>
						</artice>
						<article class="card" style="width:400px;height:fit-content;">
								<div class="card-header">
									<div>
										<span><img src="imgs/icons/quran.png" /></span>
										<h3>درجات المراجعة </h3>
									</div>
									<div>
										<input style="width:auto;margin:10px;" type="checkbox" name="on_plan" value="حسب الخطة" id="onplan"> حسب الخطة
									</div>
								</div>
								<div class="card-body">
									<?php
										$sqlPlan = "SELECT * FROM recite_plan WHERE std_id = '".$_GET['std_id']."'";
										$resultPlan = mysqli_query($conn,$sqlPlan);
										if(mysqli_num_rows($resultPlan) > 0){
											$rowPlan = mysqli_fetch_assoc($resultPlan);
											echo '<h1 style="font-size:19px;">خطة المراجعة : '.$rowPlan['amount'].'</h1></br>';
										}else{
											echo '<h1 style="font-size:19px;">الطالب ليس لديه خطة مراجعة</h1></br>';
										}
										$sql = "SELECT * FROM std_homework_soras
												WHERE std_id = '".$_GET['std_id']."' AND type = 'recite' AND date = '".$_GET['review_date']."'";
										$re = mysqli_query($conn,$sql);
										if(mysqli_num_rows($re) > 0){
											echo '<p>  <color style="color:darkblue">واجب المراجعة</color>';
											while($rowres = mysqli_fetch_assoc($re)){
												if($rowres['s_from'] == "-"){
													echo '<h2 style="font-size:18px;"> :  سورة '.$rowres['sora'].'</h2>';
												}else{
													echo '<h2 style="font-size:18px;"> :  سورة '.$rowres['sora'].' من آية '.$rowres['s_from'].' إلى آية '.$rowres['s_to'].'</h2>';
												}
											}
											echo '</p>';
										}else{
											echo '<h1 style="font-size:18px;">الطالب ليس لديه واجب مراجعة</h1></br>';
										}
									?>
									<center><table id = "score_table">
									
									<tr>
										<th>اسم الطالب</th>
										<th>الدرجة</th>
									</tr>
									<?php
										$sql = "SELECT std_name from students WHERE std_id = '".$_GET['std_id']."'";
										$name = mysqli_fetch_assoc(mysqli_query($conn,$sql))['std_name'];
									?>	
									<tr>
											<td style="white-space: normal;word-wrap: break-word;max-width: 60px;">
												<?php echo $name ?>
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
								<button type="submit" name="std_info">إرسال</button>
							</div>
						</artice>
					</form>
					<?php }else{ ?>
						<div class="tt">
					<table>
					<thead>
						<tr>
							<th>اسم الطالب</th>
							<th>التاريخ</th>
							<th>اليوم</th>
							<th>الحضور</th>
							<th>درجة الحفظ</th>
							<th>درجة المراجعة</th>
							<th>حالة الخطة</th>
							<th>الأجزاء المحفوظة</th>
							<th>واجب الحفظ</th>
							<th>واجب المراجعة</th>
							<th>تغيير</th>
						</tr>
					</thead>
					<tbody>
					<?php
						/*$sql = "SELECT students.std_name,students.std_id,students.std_v_mem,review_plan.amount as rev_am,recite_plan.amount as rec_am 
								FROM students
								INNER JOIN ring ON students.std_id = ring.std_id
								LEFT JOIN review_plan ON review_plan.std_id = ring.std_id
								LEFT JOIN recite_plan ON recite_plan.std_id = review_plan.std_id
								WHERE ring.ring_id = '".$_GET['ring_id']."'
								AND students.std_id = '".$_GET['std_id']."'
								";*/
						$sql = "SELECT review.date as rdate,review.id as id1, recite.id as id2,review.date as rd,students.std_id,COALESCE(students.std_v_mem, '0') AS mem,COALESCE(std_att.state, 'N/A') AS state,COALESCE(std_on_plan.onPlan, 'N/A') AS onPlan,COALESCE(review.grade, 'N/A') AS g1,COALESCE(recite.grade, 'N/A') AS g2,students.std_name,students.std_id,ring.ring_id
								FROM students 
								INNER JOIN ring ON ring.ring_id = students.temp_ring_id 
								LEFT JOIN review ON students.std_id = review.std_id
								LEFT JOIN recite ON students.std_id = recite.std_id and recite.std_id AND review.date = recite.date 
								LEFT JOIN std_on_plan ON students.std_id = std_on_plan.std_id and review.date = std_on_plan.date
								LEFT JOIN std_att ON students.std_id = std_att.std_id and review.date = std_att.date 
								WHERE students.temp_ring_id = '".$_GET['ring_id']."'
								AND students.std_id = '".$_GET['std_id']."'
								LIMIT 5";
						$result = mysqli_query($conn,$sql);
						if($result){
							while($row = mysqli_fetch_assoc($result)){
								$std_date = mysqli_fetch_assoc(mysqli_query($conn,"SELECT date FROM review WHERE std_id = '".$row['std_id']."' ORDER BY id DESC LIMIT 1;"))['date'];
								echo '<tr>
										<td>'.$row['std_id'].'</td>
										<td ><div style="max-width:400px;">'.$row['rd'].'</div></td>
										<td>'.getDayOfWeek($row['rd']).'</td>
										<td>'.$row['state'].'</td>
										<td>'.$row['g1'].'</td>
										<td>'.$row['g2'].'</td>
										<td>'.$row['onPlan'].'</td>
										<td>'.$row['mem'].'</td>';
										$sql = "SELECT * FROM std_homework_soras
												WHERE std_id = '".$row['std_id']."' AND type = 'review' AND date = '".$row['rdate']."'
												";
										$resu = mysqli_query($conn,$sql);
										echo '<td><ul style="width:100px;">';
										while($raw = mysqli_fetch_assoc($resu)){
											if($raw['s_from'] == "-"){
												echo '
												<li>سورة '.$raw['sora'].'</li>';
											}else{
												echo '
													<li>سورة '.$raw['sora'].'</li>
													<li>من '.$raw['s_from'].' إلى '.$raw['s_to'].'</li><div style="width:100%;margin: 10px 0;border-bottom:1px solid black;"></div>
												';
											}
										
										}
										echo '</ul></td>';
											// عرض واجب المراجعة
											$sql = "SELECT * FROM std_homework_soras
													WHERE std_id = '".$row['std_id']."' AND type = 'recite' AND date = '".$row['rdate']."'
													";
											$resu = mysqli_query($conn,$sql);
											echo '<td><ul style="width:100px;">';
											while($raw = mysqli_fetch_assoc($resu)){
												if($raw['s_from'] == "-"){
													echo '
													<li>سورة '.$raw['sora'].'</li>';
												}else{
													echo '
														<li>سورة '.$raw['sora'].'</li>
														<li>من '.$raw['s_from'].' إلى '.$raw['s_to'].'</li><div style="width:100%;margin: 10px 0;border-bottom:1px solid black;"></div>
													';
												}
											}
											echo '</ul></td>';
									echo '<td>
									<form class="login-form" action="change_ring_results.php?review_date='.$row['rdate'].'&calc_res=1&ring_id='.$_GET['ring_id'].'&std_id='.$row['std_id'].'" method="post">
											<button type="submit" name="change">تغيير الدرجة</button>
										</form>
									</tr></td>';
								
							}
						}
					?>
					</tbody>
					</table>
					</div>
					<?php }?>
				</div>

<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
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
		
		absent.addEventListener("click", function() {
			option1.disabled = true;
			option2.disabled = true;
			option3.disabled = true;
			option4.disabled = true;
			option5.disabled = true;
			option6.disabled = true;
			option7.disabled = true;
			option8.disabled = true;
			option9.disabled = true;
			option10.disabled = true;
			onplan.disabled = true;
			homework.style.display = "none";
			sendbtn.style.display = "block";
		});
		

		present.addEventListener("click", function() {
			option1.disabled = false;
			option2.disabled = false;
			option3.disabled = false;
			option4.disabled = false;
			option5.disabled = false;
			option6.disabled = false;
			option7.disabled = false;
			option8.disabled = false;
			option9.disabled = false;
			option10.disabled = false;
			onplan.disabled = false;
			homework.style.display = "flex";
			sendbtn.style.display = "none";
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
