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
			$sql = "UPDATE mton_std_att SET state = '".$att."' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
			if(mysqli_query($conn,$sql)){
				$sql = "UPDATE mton_recite SET grade = '".$score1."' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
				//$sql = "INSERT INTO `recite`(`std_id`, `date`, `grade`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','".$score1."')";
				if(mysqli_query($conn,$sql)){
					$sql = "UPDATE mton_review SET grade='".$score2."' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
					if(mysqli_query($conn,$sql)){
						$sql = "UPDATE mton_std_on_plan SET onPlan='".$onPlan."' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
						//$sql = "INSERT INTO `std_on_plan`(`std_id`, `date`, `onPlan`) VALUES ('".$_GET['std_id']."','".date('Y-m-d')."','".$onPlan."')";
						if(mysqli_query($conn,$sql)){
							echo "<script>alert('".$onPlan."');</script>";
							if($score1 == 'ممتاز' and $score2 == 'ممتاز' and $onPlan == 'حسب الخطة'){
								// checking if the std is in a prize program
								echo "<script>alert('".$_GET['std_id']."')</script>";

								$sql = "SELECT * FROM students 
										INNER JOIN prize_participating_students ON prize_participating_students.std_id = students.std_id
										INNER JOIN prize ON prize_participating_students.prize_id = prize.prize_id
										WHERE students.std_id = '".$_GET['std_id']."'
										AND prize.state = 'مستمرة'";
								$pRes = mysqli_query($conn,$sql);
								if(mysqli_num_rows($pRes) > 0){
									echo "<script>alert('ok')</script>";
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
							//echo "<script>window.location.href='change_ring_results.php?staff_id=".$_GET['staff_id']."&std_id=".$_GET['std_id']."';</script>";
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
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>درجات الطالب</title>
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
			padding: 30px;
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
		thead {
			position: sticky;
			top: 0;
			z-index: 1;
		}
	</style>
</head>
<body>
<!-- partial:index.partial.html -->
<center style="margin-bottom:20px;"><a href="change_mton_res.php?ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
					<?php if(isset($_GET['calc_res'])){?>
						<form class="login-form" id="my-form" action="change_mton_results.php?review_date=<?php echo $_GET['review_date'];?>&ring_id=<?php echo $_GET['ring_id'];?>&std_id=<?php echo $_GET['std_id'];?>" method="post">
						<article class="card" style="width:300px;">
								<div class="card-header">
									<div>
										<span><img src="imgs/icons/quran.png" /></span>
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
										if(mysqli_num_rows($resultPlan) > 0){
											$rowPlan = mysqli_fetch_assoc($resultPlan);
											echo '<h1 style="font-size:19px;">خطة الحفظ : '.$rowPlan['amount'].'</h1></br>';
										}else{
											echo '<h1 style="font-size:19px;">الطالب ليس لديه خطة حفظ</h1></br>';
										}
										$sqlPlan = "SELECT * FROM mton_recite_plan WHERE std_id = '".$_GET['std_id']."'";
										$resultPlan = mysqli_query($conn,$sqlPlan);
										if(mysqli_num_rows($resultPlan) > 0){
											$rowPlan = mysqli_fetch_assoc($resultPlan);
											echo '<h1 style="font-size:19px;">خطة المراجعة : '.$rowPlan['amount'].'</h1></br>';
										}else{
											echo '<h1 style="font-size:19px;">الطالب ليس لديه خطة مراجعة</h1></br>';
										}
										echo '<h1 style="font-size:19px;">واجب الحفظ : </h1>';
										$sqlDatemton_review = "SELECT mh_date FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND mh_type='review' ORDER BY mh_date DESC LIMIT 1";
										$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDatemton_review));
										$sql = "SELECT * FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND mh_type='review' AND mh_date = '".$rowRDate['mh_date']."'";
												$rres = mysqli_query($conn,$sql);
												if(mysqli_num_rows($rres) > 0){
													echo '<center><ul style= "margin-bottom:10px;">';
													while($rrow = mysqli_fetch_assoc($rres)){
														if($rrow['mh_from'] == '-'){
															echo '<li style="font-size:18px;"> سورة '.$rrow['sora'].'</li>';
														}else{
															echo '<li style="font-size:18px;">'.$rrow['sora'].' من '.$rrow['mh_from'].' إلى '.$rrow['mh_to'].'</li>';
														}
														
													}
													echo '</ul></center>';
												}else{
													echo '<h1 style="font-size:18px;">الطالب ليس لديه واجب حفظ</h1></br>';
												}
												echo '<h1 style="font-size:19px;">واجب المراجعة : </h1>';
												$sqlDatemton_review = "SELECT mh_date FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND mh_type='recite' ORDER BY mh_date DESC LIMIT 1";
												$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDatemton_review));
												$sql = "SELECT * FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND mh_type='recite' AND mh_date = '".$rowRDate['mh_date']."'";												$rres = mysqli_query($conn,$sql);
														if(mysqli_num_rows($rres) > 0){
															echo '<center><ul style= "margin-bottom:10px;">';
															while($rrow = mysqli_fetch_assoc($rres)){
																if($rrow['mh_from'] == '-'){
																	echo '<li style="font-size:18px;"> سورة '.$rrow['sora'].'</li>';
																}else{
																	echo '<li style="font-size:18px;">'.$rrow['sora'].' من '.$rrow['mh_from'].' إلى '.$rrow['mh_to'].'</li>';
																}
																
															}
															echo '</ul></center>';
														}else{
															echo '<h1 style="font-size:18px;">الطالب ليس لديه واجب حفظ</h1></br>';
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
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="إعادة التسميع" id="grade4"> إعادة التسميع</br>
												<input style="width:auto;margin:10px;" type="radio" name="score1" value="لم يحفظ" id="grade5"> لم يحفظ
											</td>
											<td>
												<input style="width:auto;margin:10px;" type="radio" name="score2" value="ممتاز" id="grade6"> ممتاز</br>
												<input style="width:auto;margin:10px;" type="radio" name="score2" value="جيد جدا" id="grade7">جيد جدا </br>
												<input style="width:auto;margin:10px;" type="radio" name="score2" value="جيد" id="grade8"> جيد</br>
												<input style="width:auto;margin:10px;" type="radio" name="score2" value="إعادة التسميع" id="grade9"> إعادة التسميع</br>
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
							<div class="card-footer" id="send_btn" style="">
								<button type="submit" name="std_info" >تغيير الدرجة</button>
							</div>
						</article>
					</form>
					<?php }else{ ?>
						<div class="tt">
					<table>
					<thead>
						<tr>
							<th>اسم الطالب</th>
							<th>التاريخ</th>
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
						/*$sql = "SELECT students.std_name,students.std_id,students.std_v_mem,mton_review_plan.amount as rev_am,mton_recite_plan.amount as rec_am 
								FROM students
								INNER JOIN ring ON students.std_id = ring.std_id
								LEFT JOIN mton_review_plan ON mton_review_plan.std_id = ring.std_id
								LEFT JOIN mton_recite_plan ON mton_recite_plan.std_id = mton_review_plan.std_id
								WHERE ring.staff_id = '".$_GET['staff_id']."'
								AND students.std_id = '".$_GET['std_id']."'
								";*/
						$sql = "SELECT mton_review.date as rdate,mton_review.id as id1, mton_recite.id as id2,mton_review.date as rd,students.std_id,COALESCE(students.std_v_mem, '0') AS mem,COALESCE(mton_std_att.state, 'N/A') AS state,COALESCE(mton_std_on_plan.onPlan, 'N/A') AS onPlan,COALESCE(mton_review.grade, 'N/A') AS g1,COALESCE(mton_recite.grade, 'N/A') AS g2,students.std_name,students.std_id,ring.ring_id
								FROM students 
								INNER JOIN ring ON ring.ring_id = students.temp_ring_id 
								LEFT JOIN mton_review ON students.std_id = mton_review.std_id
								LEFT JOIN mton_recite ON students.std_id = mton_recite.std_id and mton_recite.std_id AND mton_review.date = mton_recite.date 
								LEFT JOIN mton_std_on_plan ON students.std_id = mton_std_on_plan.std_id and mton_review.date = mton_std_on_plan.date
								LEFT JOIN mton_std_att ON students.std_id = mton_std_att.std_id and mton_review.date = mton_std_att.date 
								WHERE students.temp_ring_id = '".$_GET['ring_id']."'
								AND students.std_id = '".$_GET['std_id']."'";
						$result = mysqli_query($conn,$sql);
						if($result){
							while($row = mysqli_fetch_assoc($result)){
								$std_date = mysqli_fetch_assoc(mysqli_query($conn,"SELECT date FROM mton_review WHERE std_id = '".$row['std_id']."' ORDER BY id DESC LIMIT 1;"))['date'];
								echo '<tr>
										<td>'.$row['std_name'].'</td>
										<td ><div style="max-width:400px;">'.$row['rd'].'</div></td>
										<td>'.$row['state'].'</td>
										<td>'.$row['g1'].'</td>
										<td>'.$row['g2'].'</td>
										<td>'.$row['onPlan'].'</td>
										<td>'.$row['mem'].'</td>';
										$sql = "SELECT * FROM mton_homework
												WHERE std_id = '".$row['std_id']."' AND mh_type = 'review' AND mh_date = '".$row['rd']."'
												ORDER BY mh_date DESC
												LIMIT 1;";
										$resu = mysqli_query($conn,$sql);
										$raw = mysqli_fetch_assoc($resu);
										if($raw['sora'] != ""){
											echo '<td><ul style="width:100px;">
													<li>'.$raw['sora'].'</li>
													<li>من '.$raw['mh_from'].'</li>
													<li>إلى '.$raw['mh_to'].'</li>
												</ul></td>';
										}else{
											echo '<td> - </td>';
										}
										
											// عرض واجب المراجعة
											$sql = "SELECT * FROM mton_homework
											WHERE std_id = '".$row['std_id']."' AND mh_type = 'recite' AND mh_date = '".$row['rd']."'
											ORDER BY mh_date DESC
											LIMIT 1;";
											$resu = mysqli_query($conn,$sql);
											$raw = mysqli_fetch_assoc($resu);
											if($raw['sora'] != ""){
												echo '<td><ul style="width:100px;">
														<li>'.$raw['sora'].'</li>
														<li>من '.$raw['mh_from'].'</li>
														<li>إلى '.$raw['mh_to'].'</li>
													</ul></td>';
											}else{
												echo '<td> - </td>';
											}
									echo '<td>
									<form class="login-form" action="change_mton_results.php?review_date='.$row['rdate'].'&calc_res=1&ring_id='.$_GET['ring_id'].'&std_id='.$row['std_id'].'" method="post">
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
			</div>
		</div>
	</div>
</main>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
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
		excused.addEventListener("click", function() {
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
