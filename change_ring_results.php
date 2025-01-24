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
		if((isset($_POST['att'])) or $canSkipCheck){			
			$att = $_POST['att'];
			if(!$canSkipCheck){
				if(isset($_POST['score1'])){
					$score1 = $_POST['score1'];
				}else{
					$score1 = "-";
				}
				if(isset($_POST['score2'])){
					$score2 = $_POST['score2'];
				}else{
					$score2 = "-";
				}
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
			if(isset($_GET['rev_id'])){
				$sql = "UPDATE std_att SET state = '".$att."' WHERE rev_id = '".$_GET['rev_id']."' AND std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
			}
			if(mysqli_query($conn,$sql)){
				$sql = "UPDATE recite SET grade = '".$score2."' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
				if(isset($_GET['rev_id'])){
					$sql = "UPDATE recite SET grade = '".$score2."' WHERE rev_id = '".$_GET['rev_id']."' AND std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
				}				
				if(mysqli_query($conn,$sql)){
					$sql = "UPDATE review SET grade='".$score1."' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
					if(isset($_GET['rev_id'])){
						$sql = "UPDATE review SET grade='".$score1."' WHERE id = '".$_GET['rev_id']."' AND std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
					}	
					if(mysqli_query($conn,$sql)){
						$sql = "UPDATE std_on_plan SET onPlan='".$onPlan."' WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
						if(isset($_GET['rev_id'])){
							$sql = "UPDATE std_on_plan SET onPlan='".$onPlan."' WHERE rev_id = '".$_GET['rev_id']."' AND std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."'";
						}
						if(mysqli_query($conn,$sql)){
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
		thead {
			position: sticky;
			top: 0;
			z-index: 1;
		}
	</style>
</head>
<body>
<center style="margin-bottom:20px;"><a href="change_ring_res.php?ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
<!-- partial:index.partial.html -->
					<?php if(isset($_GET['calc_res'])){?>
						<?php if(isset($_GET['rev_id'])){ ?>
							<form class="login-form" action="change_ring_results.php?rev_id=<?php echo $_GET['rev_id'];?>&review_date=<?php echo $_GET['review_date'];?>&ring_id=<?php echo $_GET['ring_id'];?>&std_id=<?php echo $_GET['std_id'];?>" method="post">
						<?php }else{ ?>
							<form class="login-form" action="change_ring_results.php?review_date=<?php echo $_GET['review_date'];?>&ring_id=<?php echo $_GET['ring_id'];?>&std_id=<?php echo $_GET['std_id'];?>" method="post">
						<?php }?>
						<div class="card-grid" style="font-size:18px;" >

						<article class="card" style="width:300px;">
								<div class="card-header">
									<div>
										<span><img src="imgs/icons/quran.png" /></span>
										<?php
											$sql = "SELECT std_name from students WHERE std_id = '".$_GET['std_id']."'";
											$name = mysqli_fetch_assoc(mysqli_query($conn,$sql))['std_name'];
										?>	
										<h3><?php echo $name; ?></h3>
									</div>
								</div>
								<div class="card-body">
								<input style="width:auto;margin:10px;display:inline-block;" type="radio" name="att" value="حضور" id="present" checked><label for="present">حضور</label>
								<input style="width:auto;margin:10px;display:inline-block;" type="radio" name="att" value="غياب" id="disp"><label for="disp">غياب</label>
								<input style="width:auto;margin:10px;display:inline-block;" type="radio" name="att" value="مستاذن" id="disp2"><label for="disp2">مستاذن</label></br></br>
									<?php
										$sqlPlan = "SELECT * FROM review_plan WHERE std_id = '".$_GET['std_id']."'";
										$resultPlan = mysqli_query($conn,$sqlPlan);
										$revPlan = "no";
										if(mysqli_num_rows($resultPlan) > 0){
											$rowPlan = mysqli_fetch_assoc($resultPlan);
											$revPlan = $rowPlan['amount'];
											if($revPlan == "0"){
												$revPlan = "no";
											}
											echo '<h1 style="font-size:19px;">خطة الحفظ : <color style="color:#b40836">'.$rowPlan['amount'].'</color></h1></br>';
											//  خط الحفظ
										}else{
											
											echo '<h1 style="font-size:19px;color:#b40836;">الطالب ليس لديه خطة حفظ</h1></br>';
										}
										echo "<p id='revPlan' style='display:none;'>$revPlan</p>";
										echo "<input id='revPlan' type= 'text' name='revPlan' style='display:none; value='.$revPlan.'/>";
										
										$sqlPlan = "SELECT * FROM recite_plan WHERE std_id = '".$_GET['std_id']."'";
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
										$sqlDateReview = "SELECT date FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='review' ORDER BY date DESC LIMIT 1";
$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDateReview));

$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='review' AND date = '".$rowRDate['date']."'";
if(isset($_GET['rev_id'])){
	$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='review' AND date = '".$rowRDate['date']."' AND rev_id = '".$_GET['rev_id']."'";
}
$rres = mysqli_query($conn,$sql);
if(mysqli_num_rows($rres) > 0){
    echo '<center><table style="margin-bottom:10px;width:250px;border:1px solid black;"><tr>';
    $count = 0;
    while($rrow = mysqli_fetch_assoc($rres)){
        if($count % 3 == 0 && $count != 0){
            echo '</tr><tr>';
        }
        if($rrow['s_from'] == '-'){
            echo '<td style="font-size:12px; padding:5px;color:#1c9300;"> سورة '.$rrow['sora'].'</td>';
        }else{
			if($rrow['s_from'] == '*'){
				echo '<td style="font-size:12px; padding:5px;color:#1c9300;"> الجزء '.$rrow['sora'].'</td>';
			}else{
				echo '<td style="font-size:12px; padding:5px;color:#1c9300;">'.$rrow['sora'].'</br> '.$rrow['s_from'].' - '.$rrow['s_to'].'</td>';
			}
        }
        $count++;
    }
    echo '</tr></table></center>';
}else{
    echo '<h1 style="font-size:18px;color:#1c9300;">الطالب ليس لديه واجب حفظ</h1></br>';
}
												echo '<h1 style="font-size:19px;">واجب المراجعة : </h1>';
												$sqlDateReview = "SELECT date FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='recite' ORDER BY date DESC LIMIT 1";
$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDateReview));
$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='recite' AND date = '".$rowRDate['date']."'";
if(isset($_GET['rev_id'])){
	$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='recite' AND date = '".$rowRDate['date']."' AND rev_id = '".$_GET['rev_id']."'";
}
$rres = mysqli_query($conn,$sql);
if(mysqli_num_rows($rres) > 0){
    echo '<center><table style="margin-bottom:10px;width:250px;border:1px solid black;"><tr>';
    $count = 0;
    while($rrow = mysqli_fetch_assoc($rres)){
        if($count % 3 == 0 && $count != 0){
            echo '</tr><tr>';
        }
        if($rrow['s_from'] == '-'){
            echo '<td style="font-size:12px; padding:5px;width:30px;color:#1c9300;"> سورة '.$rrow['sora'].'</td>';
        }else{
			if($rrow['s_from'] == '*'){
				echo '<td style="font-size:12px; padding:5px;color:#1c9300;"> الجزء '.$rrow['sora'].'</td>';
			}else{
				echo '<td style="font-size:12px; padding:5px;color:#1c9300;">'.$rrow['sora'].'</br> '.$rrow['s_from'].' - '.$rrow['s_to'].'</td>';
			}
		}
        $count++;
    }
    echo '</tr></table></center>';
}else{
    echo '<h1 style="font-size:18px;color:#1c9300;">الطالب ليس لديه واجب مراجعة</h1></br>';
}
									?>
									<center><table id = "score_table">

									<tr>
										<th>درجة الحفظ</th>
										<th>درجة المراجعة</th>
									</tr>
									<?php
										$sql = "SELECT std_name from students WHERE std_id = '".$_GET['std_id']."'";
										$name = mysqli_fetch_assoc(mysqli_query($conn,$sql))['std_name'];
									?>	
									<tr>
										
											<!--<td style="white-space: normal;word-wrap: break-word;max-width: 60px;">
												<?php //echo $name ?>
											</td>-->
											<?php
												if($revPlan == 'no'){
											?>
												<td span=5>لا توجد خطة للحفظ</td>
											<?php
												}else{
											?>
												<td>
													<input style="width:auto;margin:10px;" type="radio" name="score1" value="ممتاز" id="grade1"> ممتاز</br>
													<input style="width:auto;margin:10px;" type="radio" name="score1" value="جيد جدا" id="grade2">جيد جدا </br>
													<input style="width:auto;margin:10px;" type="radio" name="score1" value="جيد" id="grade3"> جيد</br>
													<input style="width:auto;margin:10px;" type="radio" name="score1" value="إعادة" id="grade4"> إعادة</br>
													<input style="width:auto;margin:10px;" type="radio" name="score1" value="لم يحفظ" id="grade5"> لم يحفظ</br>
													<input style="width:auto;margin:10px;" type="radio" name="score1" value="لم يسمع" id="grade6"> لم يسمع
												</td>
											<?php
												}
											?>

											<?php
												if($recPlan == 'no'){
											?>
												<td span=5>لا توجد خطة للمراجعة</td>
												<td style="display:none;">
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="ممتاز" id="grade7"> ممتاز</br>
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="جيد جدا" id="grade8">جيد جدا </br>
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="جيد" id="grade9"> جيد</br>
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="إعادة" id="grade10"> إعادة</br>
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="لم يحفظ" id="grade11"> لم يحفظ</br>
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="لم يسمع" id="grade12"> لم يسمع
												</td>
											<?php
												}else{
											?>
												<td>
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="ممتاز" id="grade7"> ممتاز</br>
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="جيد جدا" id="grade8">جيد جدا </br>
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="جيد" id="grade9"> جيد</br>
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="إعادة" id="grade10"> إعادة</br>
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="لم يحفظ" id="grade11"> لم يحفظ</br>
													<input style="width:auto;margin:10px;" type="radio" name="score2" value="لم يسمع" id="grade12"> لم يسمع
												</td>
											<?php
												}
											?>
											
										
										
									</tr>
								</table></center>
							</div>
							<div class="card-footer">
								<input style="width:auto;margin:10px;" type="checkbox" name="on_plan" value="حسب الخطة" id="onplan"> حسب الخطة
							</div>
							<?php
								if($revPlan == 'no' and $recPlan == 'no'){
							?>
							<?php
								}else{
							?>
								<div class="card-footer" id="send_btn">
									<button type="submit" name="std_info">انتهاء التسميع</button>
								</div>
							<?php
								}
							?>
							
						</article>
					</form>
					<?php }else{ ?>
						<div class="tt">
			<table>
				<thead>
					<tr>
						<th>تغيير الدرجة</th>
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
												$printedRev = array();
										$sql = "SELECT DISTINCT recite.rev_id,review.id,students.std_id, COALESCE(review_plan.amount,'لا توجد خطة') as rpm, COALESCE(recite_plan.amount,'لا توجد خطة') as rpm2, students.std_name,review.date,std_att.state,review.grade as g1,recite.grade as g2,std_on_plan.onPlan as sta FROM ring
												INNER JOIN students ON ring.ring_id = students.temp_ring_id
												LEFT JOIN review ON students.std_id = review.std_id
												LEFT JOIN recite ON recite.rev_id = review.id
												LEFT JOIN review_plan ON review_plan.std_id = students.std_id
												LEFT JOIN recite_plan ON recite_plan.std_id = students.std_id
												LEFT JOIN std_att ON students.std_id = std_att.std_id and std_att.date = review.date and std_att.rev_id = review.id
												LEFT JOIN std_on_plan ON students.std_id = std_on_plan.std_id and std_on_plan.date = review.date and std_on_plan.rev_id = review.id
												WHERE ring.ring_id = '".$_GET['ring_id']."' AND students.std_id = '".$_GET['std_id']."'
												ORDER BY id DESC
												LIMIT 7";
												$name = "null";
												$rev_id =  mysqli_fetch_assoc(mysqli_query($conn,$sql))['rev_id'];
												$result = mysqli_query($conn,$sql);
												if($result){
													if(mysqli_num_rows($result) > 0){
														while($row = mysqli_fetch_assoc($result)){
															
															if($row['rev_id'] == NULL){
																$sql = "SELECT DISTINCT review.id  as revId,students.std_id, COALESCE(review_plan.amount,'لا توجد خطة') as rpm, COALESCE(recite_plan.amount,'لا توجد خطة') as rpm2, students.std_name,review.date,std_att.state,review.grade as g1,recite.grade as g2,std_on_plan.onPlan as sta 
																		FROM students
																		INNER JOIN ring ON ring.ring_id = students.ring_id
																		LEFT JOIN review ON review.std_id = students.std_id AND review.date = '".$row['date']."'
																		LEFT JOIN recite ON recite.std_id = students.std_id AND recite.date = review.date AND recite.date = '".$row['date']."'
																		LEFT JOIN std_att ON std_att.std_id = students.std_id AND std_att.date = review.date AND std_att.date = '".$row['date']."'
																		LEFT JOIN std_on_plan ON std_on_plan.std_id = students.std_id AND std_on_plan.date = review.date AND std_on_plan.date = '".$row['date']."'
																		LEFT JOIN review_plan ON review_plan.std_id = students.std_id
																		LEFT JOIN recite_plan ON recite_plan.std_id = students.std_id
																		WHERE students.std_id = '".$_GET['std_id']."' AND ring.ring_id = '".$_GET['ring_id']."'
																		ORDER BY review.date DESC
																		LIMIT 7";
																$result2 = mysqli_query($conn,$sql);
																if($result2){
																	if(mysqli_num_rows($result2) > 0){
																		$row2 = mysqli_fetch_assoc($result2);
																			
																			if (in_array($row2['revId'], $printedRev)) {
																				continue;
																			}
																			echo '
																				<tr>';
																			echo '<td>
																			<form class="login-form" action="change_ring_results.php?review_date='.$row['date'].'&calc_res=1&ring_id='.$_GET['ring_id'].'&std_id='.$row['std_id'].'" method="post">
																					<button type="submit" name="change">تغيير الدرجة</button>
																				</form>
																				</td>';
																				
																					//if($name == "null"){
																						$name = $row2['std_name'];
																						echo '<td  style = "width:400px;">'.$row2['std_name'].'</td>';
																					//}
																					echo '<td style = "width:600px;">'.$row2['date'].'</td>
																					<td style = "width:600px;">'.getDayOfWeek($row2['date']).'</td>
																					<td>'.$row2['state'].'</td>';
																					if($row2['g1'] == ""){
																						echo '<td> - </td>';
																					}else{
																						echo '<td>'.$row2['g1'].'</td>';
																					}
																					
																					if($row2['g2'] == ""){
																						echo '<td> - </td>';
																					}else{
																						echo '<td>'.$row2['g2'].'</td>';
																					}
																					echo '<td>'.$row2['sta'].'</td>';
																					$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND date = '".$row2['date']."' and type='review'";
																					$rres = mysqli_query($conn,$sql);
																					if(mysqli_num_rows($rres) > 0){
																						echo '<td><ul>';
																						while($rrow2 = mysqli_fetch_assoc($rres)){
																							if($rrow2['s_from'] == '-'){
																								echo '<li> سورة '.$rrow2['sor'].'</li>';
																							}else{
																								if($rrow2['s_from'] == '*'){
																									echo '<li> الجزء '.$rrow2['sor'].'</li>';
																								}else{
																									if($rrow2['sor'] == ""){
																										echo " - ";
																									}else{
																										echo '<li>'.$rrow2['sor'].' من '.$rrow2['s_from'].' إلى '.$rrow2['s_to'].'</li>';
																									}
																								}
																								
																							}
																							
																							
																						}
																						echo '</ul></td>';
																						$sql = "SELECT * FROM sora_face WHERE date = '".$row2['date']."' AND std_id = '".$row2['std_id']."' AND type= 'review'";
																						$rere = mysqli_query($conn,$sql);
																						echo '<td>'.mysqli_fetch_assoc($rere)['face'].'</td>';
																					}else{
																						
																							echo '<td>لم يتم تسجيل واجب</td>';
																							echo '<td>لم يتم تسجيل واجب</td>';
																						
																					}
																					$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND date = '".$row2['date']."' and type='recite'";
																					$rres = mysqli_query($conn,$sql);
																					if(mysqli_num_rows($rres) > 0){
																						echo '<td><ul>';
																						while($rrow2 = mysqli_fetch_assoc($rres)){
																							if($rrow2['s_from'] == '-'){
																								echo '<li> سورة '.$rrow2['sora'].'</li>';
																							}else{
																								if($rrow2['s_from'] == '*'){
																									echo '<li> الجزء '.$rrow2['sora'].'</li>';
																								}else{
																									if($rrow2['sora'] == ""){
																										echo " - ";
																									}else{
																										echo '<li>'.$rrow2['sora'].' من '.$rrow2['s_from'].' إلى '.$rrow2['s_to'].'</li>';
																									}
																								}
																							}
																						}
																						echo '</ul></td>';
																						$sql = "SELECT * FROM sora_face WHERE date = '".$row2['date']."' AND std_id = '".$row2['std_id']."' AND type= 'recite'";
																						$rere = mysqli_query($conn,$sql);
																						echo '<td>'.mysqli_fetch_assoc($rere)['face'].'</td>';
																					}else{
																						
																							echo '<td>لم يتم تسجيل واجب</td>';
																							echo '<td>لم يتم تسجيل واجب</td>';
																						
																					}
																					echo '<td style = "width:600px;">'.$row2['rpm'].'</td>';
																					echo '<td style = "width:600px;">'.$row2['rpm2'].'</td>
																					
																				</tr>
																			';
																			array_push($printedRev,$row2['revId']);
																			
																			
																	}
																}
															}else{
																if(date('Y-m-d') == $row['date']){
																	echo '
																				<tr>';
																			echo '<td>
																			<form class="login-form" action="change_ring_results.php?review_date='.$row['date'].'&rev_id='.$row['rev_id'].'&calc_res=1&ring_id='.$_GET['ring_id'].'&std_id='.$row['std_id'].'" method="post">
																					<button type="submit" name="change">تغيير الدرجة</button>
																				</form>
																				</td>';
																	echo '
																	
																		<td class="td" style = "width:400px;">'.$row['std_name'].'</td>
																		<td class="td" style = "width:600px;">'.$row['date'].'</td>
																		<td class="td" style = "width:600px;">'.getDayOfWeek($row['date']).'</td>
																		<td class="td">'.$row['state'].'</td>';
																		if($row['g1'] == ""){
																			echo '<td class="td"> - </td>';
																		}else{
																			echo '<td class="td">'.$row['g1'].'</td>';
																		}
																		
																		if($row['g2'] == ""){
																			echo '<td class="td"> - </td>';
																		}else{
																			echo '<td class="td">'.$row['g2'].'</td>';
																		}
																		echo '<td class="td">'.$row['sta'].'</td>';
																		$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM std_homework_soras 
																				WHERE rev_id = '".$row['id']."' AND std_id = '".$_GET['std_id']."' AND date = '".$row['date']."' and type='review'";
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
																			$sql = "SELECT * FROM sora_face WHERE rev_id = '".$row['id']."' AND date = '".$row['date']."' AND std_id = '".$row['std_id']."' AND type= 'review'";
																			$rere = mysqli_query($conn,$sql);
																			echo '<td class="td">'.mysqli_fetch_assoc($rere)['face'].'</td>';
																		}else{
																		
																				echo '<td class="td">لم يتم تسجيل واجب</td>';
																				echo '<td class="td">لم يتم تسجيل واجب</td>';
																		}
																		$sql = "SELECT * FROM std_homework_soras WHERE rev_id = '".$row['id']."' AND std_id = '".$_GET['std_id']."' AND date = '".$row['date']."' and type='recite'";
																		$rres = mysqli_query($conn,$sql);
																		if(mysqli_num_rows($rres) > 0){
																			echo '<td class="td"><ul>';
																			while($rrow = mysqli_fetch_assoc($rres)){
																				if($rrow['s_from'] == '-'){
																					echo '<li> سورة '.$rrow['sora'].'</li>';
																				}else{
																					if($rrow['s_from'] == '*'){
																						echo '<li> الجزء '.$rrow['sora'].'</li>';
																					}else{
																						if($rrow['sora'] == ""){
																							echo " - ";
																						}else{
																							echo '<li>'.$rrow['sora'].' من '.$rrow['s_from'].' إلى '.$rrow['s_to'].'</li>';
																						}
																					}
																				}
																			}
																			echo '</ul></td>';
																			$sql = "SELECT * FROM sora_face WHERE rev_id = '".$row['id']."' AND date = '".$row['date']."' AND std_id = '".$row['std_id']."' AND type= 'recite'";
																			$rere = mysqli_query($conn,$sql);
																			echo '<td class="td">'.mysqli_fetch_assoc($rere)['face'].'</td>';
																		}else{
																			$sql = "SELECT date FROM std_homework_soras WHERE rev_id = '".$row['id']."' AND sora != '' AND sora != ' ' AND std_id = '".$_GET['std_id']."'
																					ORDER BY DATE DESC";
																			$ddate = mysqli_fetch_assoc(mysqli_query($conn,$sql))['date'];
																			
																			$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM std_homework_soras WHERE rev_id = '".$row['id']."' AND std_id = '".$_GET['std_id']."' AND date = '".$ddate."' and type='recite'";
																			$resu = mysqli_query($conn,$sql);
																			if(mysqli_num_rows($resu) > 0){
																				echo '<td class="td"><ul>';
																				while($rowa = mysqli_fetch_assoc($resu)){
																					if($rowa['s_from'] == '-'){
																						echo '<li> سورة '.$rowa['sor'].'</li>';
																					}else{
																						if($rowa['s_from'] == '*'){
																							echo '<li> الجزء '.$rowa['sor'].'</li>';
																						}else{
																							if($rowa['sor'] == ""){
																								echo "  ";
																							}else{
																								echo '<li>'.$rowa['sor'].' من '.$rowa['s_from'].' إلى '.$rowa['s_to'].'</li>';
																							}
																						}
																						
																					}
																					
																					
																				}
																				echo '</ul></td>';
																				$sql = "SELECT * FROM sora_face WHERE rev_id = '".$row['id']."' AND date = '".$ddate."' AND std_id = '".$row['std_id']."' AND type= 'recite'";
																				$rere = mysqli_query($conn,$sql);
																				echo '<td class="td">'.mysqli_fetch_assoc($rere)['face'].'</td>';
																			}else{
																				echo '<td class="td">لم يتم تسجيل واجب</td>';
																				echo '<td class="td">لم يتم تسجيل واجب</td>';
																			}
																		}
																		echo '<td class="td" style = "width:600px;">'.$row['rpm'].'</td>';
																		echo '<td class="td" style = "width:600px;">'.$row['rpm2'].'</td>
																		
																	</tr>
																';
																}
																else{
																	echo '
																				<tr>';
																			echo '<td>
																			<form class="login-form" action="change_ring_results.php?review_date='.$row['date'].'&rev_id='.$row['rev_id'].'&calc_res=1&ring_id='.$_GET['ring_id'].'&std_id='.$row['std_id'].'" method="post">
																					<button type="submit" name="change">تغيير الدرجة</button>
																				</form>
																				</td>';
																		//if($name == "null"){
																			$name = $row['std_name'];
																			echo '<td  style = "width:400px;">'.$row['std_name'].'</td>';
																		//}
																		echo '<td style = "width:600px;">'.$row['date'].'</td>
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
																		$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM std_homework_soras WHERE rev_id = '".$row['id']."' AND std_id = '".$_GET['std_id']."' and type='review'";
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
																			$sql = "SELECT * FROM sora_face WHERE rev_id = '".$row['id']."' AND date = '".$row['date']."' AND std_id = '".$row['std_id']."' AND type= 'review'";
																			$rere = mysqli_query($conn,$sql);
																			echo '<td>'.mysqli_fetch_assoc($rere)['face'].'</td>';
																		}else{
																			/*$sql = "SELECT date FROM std_homework_soras WHERE sora != '' AND sora != ' ' AND std_id = '".$_GET['std_id']."'
																					ORDER BY DATE DESC";
																			$ddate = mysqli_fetch_assoc(mysqli_query($conn,$sql))['date'];
																			$date1 = new DateTime($row['date']);
																			$date2 = new DateTime($ddate);

																			if ($date2->format('Y-m-d') < $date1->format('Y-m-d')) {
																				
																				$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM std_homework_soras WHERE rev_id = '".$row['id']."' AND std_id = '".$_GET['std_id']."' AND date = '".$ddate."' and type='review'";
																				$resu = mysqli_query($conn,$sql);
																				if(mysqli_num_rows($resu) > 0){
																					echo '<td><ul>';
																					while($rowa = mysqli_fetch_assoc($resu)){
																						if($rowa['s_from'] == '-'){
																							echo '<li> سورة '.$rowa['sor'].'</li>';
																						}else{
																							if($rowa['s_from'] == '*'){
																								echo '<li> الجزء '.$rowa['sor'].'</li>';
																							}else{
																								if($rowa['sor'] == ""){
																									echo " - ";
																								}else{
																									echo '<li>'.$rowa['sor'].' من '.$rowa['s_from'].' إلى '.$rowa['s_to'].'</li>';
																								}
																							}
																							
																						}
																						
																						
																					}
																					echo '</ul></td>';
																					$sql = "SELECT * FROM sora_face WHERE rev_id = '".$row['id']."' AND date = '".$ddate."' AND std_id = '".$row['std_id']."' AND type= 'review'";
																					$rere = mysqli_query($conn,$sql);
																					echo '<td>'.mysqli_fetch_assoc($rere)['face'].'</td>';
																				}else{
																					echo '<td>لم يتم تسجيل واجب</td>';
																					echo '<td>لم يتم تسجيل واجب</td>';
																				}
																			}else{*/
																				echo '<td>لم يتم تسجيل واجب</td>';
																				echo '<td>لم يتم تسجيل واجب</td>';
																		}
																		$sql = "SELECT * FROM std_homework_soras WHERE rev_id = '".$row['id']."' AND std_id = '".$_GET['std_id']."' and type='recite'";
																		$rres = mysqli_query($conn,$sql);
																		if(mysqli_num_rows($rres) > 0){
																			echo '<td><ul>';
																			while($rrow = mysqli_fetch_assoc($rres)){
																				if($rrow['s_from'] == '-'){
																					echo '<li> سورة '.$rrow['sora'].'</li>';
																				}else{
																					if($rrow['s_from'] == '*'){
																						echo '<li> الجزء '.$rrow['sora'].'</li>';
																					}else{
																						if($rrow['sora'] == ""){
																							echo " - ";
																						}else{
																							echo '<li>'.$rrow['sora'].' من '.$rrow['s_from'].' إلى '.$rrow['s_to'].'</li>';
																						}
																					}
																				}
																			}
																			echo '</ul></td>';
																			$sql = "SELECT * FROM sora_face WHERE rev_id = '".$row['id']."' AND date = '".$row['date']."' AND std_id = '".$row['std_id']."' AND type= 'recite'";
																			$rere = mysqli_query($conn,$sql);
																			echo '<td>'.mysqli_fetch_assoc($rere)['face'].'</td>';
																		}else{
																			/*$sql = "SELECT date FROM std_homework_soras WHERE sora != '' AND sora != ' ' AND std_id = '".$_GET['std_id']."'
																					ORDER BY DATE DESC";
																			$ddate = mysqli_fetch_assoc(mysqli_query($conn,$sql))['date'];
																			
																			$sql = "SELECT COALESCE(std_homework_soras.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM std_homework_soras WHERE rev_id = '".$row['id']."' AND std_id = '".$_GET['std_id']."' AND date = '".$ddate."' and type='recite'";
																			$resu = mysqli_query($conn,$sql);
																			if(mysqli_num_rows($resu) > 0){
																				echo '<td><ul>';
																				while($rowa = mysqli_fetch_assoc($resu)){
																					if($rowa['s_from'] == '-'){
																						echo '<li> سورة '.$rowa['sor'].'</li>';
																					}else{
																						if($rowa['s_from'] == '*'){
																							echo '<li> الجزء '.$rowa['sor'].'</li>';
																						}else{
																							if($rowa['sor'] == ""){
																								echo "  ";
																							}else{
																								echo '<li>'.$rowa['sor'].' من '.$rowa['s_from'].' إلى '.$rowa['s_to'].'</li>';
																							}
																						}
																						
																					}
																					
																					
																				}
																				echo '</ul></td>';
																				$sql = "SELECT * FROM sora_face WHERE rev_id = '".$row['id']."' AND date = '".$ddate."' AND std_id = '".$row['std_id']."' AND type= 'recite'";
																				$rere = mysqli_query($conn,$sql);
																				echo '<td>'.mysqli_fetch_assoc($rere)['face'].'</td>';
																			}else{
																				$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND date = '".$row['date']."' and type='recite'";
																				$rres = mysqli_query($conn,$sql);
																				if(mysqli_num_rows($rres) > 0){
																					echo '<td><ul>';
																					while($rrow = mysqli_fetch_assoc($rres)){
																						if($rrow['s_from'] == '-'){
																							echo '<li> سورة '.$rrow['sora'].'</li>';
																						}else{
																							if($rrow['s_from'] == '*'){
																								echo '<li> الجزء '.$rrow['sora'].'</li>';
																							}else{
																								if($rrow['sora'] == ""){
																									echo " - ";
																								}else{
																									echo '<li>'.$rrow['sora'].' من '.$rrow['s_from'].' إلى '.$rrow['s_to'].'</li>';
																								}
																							}
																						}
																					}
																					echo '</ul></td>';
																					$sql = "SELECT * FROM sora_face WHERE rev_id = '".$row['id']."' AND date = '".$row['date']."' AND std_id = '".$row['std_id']."' AND type= 'recite'";
																					$rere = mysqli_query($conn,$sql);
																					echo '<td>'.mysqli_fetch_assoc($rere)['face'].'</td>';
																				}else{*/
																					echo '<td>لم يتم تسجيل واجب</td>';
																					echo '<td>لم يتم تسجيل واجب</td>';
																				//}
																			}
																			echo '<td style = "width:600px;">'.$row['rpm'].'</td>';
																		echo '<td style = "width:600px;">'.$row['rpm2'].'</td>
																		
																	</tr>
																';
																		}
																		
																}
															}
														}
													}
												
											//}
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
		var option11 = document.getElementById("grade11");
		var option12 = document.getElementById("grade12");
		var onplan = document.getElementById("onplan");
		var absent = document.getElementById("disp");
		var excused = document.getElementById("disp2");
		var present = document.getElementById("present");
		var sendbtn = document.getElementById("send_btn");

		var revPlan = document.getElementById("revPlan");
		var recPlan = document.getElementById("recPlan");
		option1.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6){
				if (option6.checked) {
					onplan.disabled = true;
				}
			}
			if(option12){
				if (option12.checked) {
					onplan.disabled = true;
				}
			}
			
		});
		option2.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6){
				if (option6.checked) {
					onplan.disabled = true;
				}
			}
			if(option12){
				if (option12.checked) {
					onplan.disabled = true;
				}
			}
			
		});
		option3.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6){
				if (option6.checked) {
					onplan.disabled = true;
				}
			}
			if(option12){
				if (option12.checked) {
					onplan.disabled = true;
				}
			}
			
		});
		option4.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6){
				if (option6.checked) {
					onplan.disabled = true;
				}
			}
			if(option12){
				if (option12.checked) {
					onplan.disabled = true;
				}
			}
			
		});
		option5.addEventListener("click", function() {
			onplan.disabled = false;
			
			
			if(option11){
				if (option11.checked) {
					onplan.disabled = true;
				}
			}
			if(option12){
				if (option12.checked) {
					onplan.disabled = true;
				}
			}
			
			if(option11.checked || option12.checked){
				
				sendbtn.style.display = "block";
				onplan.disabled = true;
			}
		});
		option7.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6){
				if (option6.checked) {
					onplan.disabled = true;
				}
			}
			if(option12){
				if (option12.checked) {
					onplan.disabled = true;
				}
			}
			
		});
		option8.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6){
				if (option6.checked) {
					onplan.disabled = true;
				}
			}
			if(option12){
				if (option12.checked) {
					onplan.disabled = true;
				}
			}
			
		});
		option9.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6){
				if (option6.checked) {
					onplan.disabled = true;
				}
			}
			if(option12){
				if (option12.checked) {
					onplan.disabled = true;
				}
			}
			
		});
		option10.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6){
				if (option6.checked) {
					onplan.disabled = true;
				}
			}
			if(option12){
				if (option12.checked) {
					onplan.disabled = true;
				}
			}
			
		});
		option11.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6){
				if (option6.checked) {
					onplan.disabled = true;
				}
			}
			if(option12){
				if (option12.checked) {
					onplan.disabled = true;
				}
			}
			
			if(option5.checked || option6.checked){
				
				sendbtn.style.display = "block";
				onplan.disabled = true;
			}
		});


		option12.addEventListener("click", function() {
			onplan.disabled = true;
			
			if(option6.checked || option5.checked){
				
				sendbtn.style.display = "block";
			}
		});
		option6.addEventListener("click", function() {
			
			
			onplan.disabled = true;
			
			if(option12.checked || option11.checked){
				
				sendbtn.style.display = "block";
			}
		});

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
			option11.disabled = true;
			option12.disabled = true;
			onplan.disabled = true;
			
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
			option11.disabled = true;
			option12.disabled = true;
			onplan.disabled = true;
			
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
			option11.disabled = false;
			option12.disabled = false;
			onplan.disabled = false;
			
		});
		
	</script>
		<script>

		function validateForm() {
			/*const sselectedNumber = document.getElementById("snumberSelector").value;
			const sselectedQuarterHalf = document.getElementById("squarterHalfSelector").value;

			const cselectedNumber = document.getElementById("cnumberSelector").value;
			const cselectedQuarterHalf = document.getElementById("cquarterHalfSelector").value;

			const csselectedNumber = document.getElementById("csnumberSelector").value;
			const csselectedQuarterHalf = document.getElementById("csquarterHalfSelector").value;*/
			
			var rad1 = document.getElementById("div1-radio");
			var rad2 = document.getElementById("div2-radio");
			var rad3 = document.getElementById("div3-radio");

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

			var revPlan = document.getElementById("revPlan");
			var recPlan = document.getElementById("recPlan");
			if(revPlan.innerHTML != "no"){
				if (!option1.checked && !option2.checked 
					&& !option3.checked && !option4.checked 
					&& !option5.checked && !option6.checked){
						event.preventDefault();
					alert("الرجاء اختيار درجة الحفظ");
				}
			}
			if(recPlan.innerHTML != "no"){
				if (!option7.checked && !option8.checked 
					&& !option9.checked && !option10.checked 
					&& !option11.checked && !option12.checked) {
						event.preventDefault();
					alert("الرجاء اختيار درجة المراجعة");
				}
			}

			// var crad1 = document.getElementById("cdiv1-radio");
			// var crad2 = document.getElementById("cdiv2-radio");
			// var ok = true;

			if(rad1.checked){
				var pages1 = document.getElementById("pages1");
				var pages2 = document.getElementById("pages2");
				var course = document.getElementById("course1");
				var selectedNumber = document.getElementById("numberSelector");
				var selectedQuarterHalf = document.getElementById("quarterHalfSelector");
				// Check if the text boxes are empty
				if (pages1.value === "" || pages2.value === "" || course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار السورة والآيات للحفظ");
				}
				if (selectedNumber.value === "" || selectedQuarterHalf.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للحفظ");
				}
			}
			if(rad2.checked){
				var course = document.getElementById("s1");
				var selectedNumber = document.getElementById("numberSelector");
				var selectedQuarterHalf = document.getElementById("quarterHalfSelector");
				// Check if the text boxes are empty
				if (course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار السور للحفظ");
				}
				if (selectedNumber.value === "" || selectedQuarterHalf.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للحفظ");
				}
			}
			if(rad3.checked){
				var course = document.getElementById("p1");
				var selectedNumber = document.getElementById("numberSelector");
				var selectedQuarterHalf = document.getElementById("quarterHalfSelector");
				// Check if the text boxes are empty
				if (course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار الأجزاء للحفظ");
				}
				if (selectedNumber.value === "" || selectedQuarterHalf.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للحفظ");
				}
			}

			var rad1 = document.getElementById("cdiv1-radio");
			var rad2 = document.getElementById("cdiv2-radio");
			var rad3 = document.getElementById("cdiv3-radio");

			if(rad1.checked){
				var pages1 = document.getElementById("cpages1");
				var pages2 = document.getElementById("cpages2");
				var course = document.getElementById("ccourse1");
				var selectedNumber = document.getElementById("snumberSelector");
				var selectedQuarterHalf = document.getElementById("squarterHalfSelector");
				// Check if the text boxes are empty
				if (pages1.value === "" || pages2.value === "" || course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار السورة والآيات للمراجعة");
				}
				if (selectedNumber.value === "" || selectedQuarterHalf.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للمراجعة");
				}
			}
			if(rad2.checked){
				var course = document.getElementById("cs1");
				var selectedNumber = document.getElementById("snumberSelector");
				var selectedQuarterHalf = document.getElementById("squarterHalfSelector");
				// Check if the text boxes are empty
				if (course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار السور للمراجعة");
				}
				if (selectedNumber.value === "" || selectedQuarterHalf.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للمراجعة");
				}
			}
			if(rad3.checked){
				var course = document.getElementById("cp1");
				var selectedNumber = document.getElementById("snumberSelector");
				var selectedQuarterHalf = document.getElementById("squarterHalfSelector");
				// Check if the text boxes are empty
				if (course.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار الأجزاء للمراجعة");
				}
				if (selectedNumber.value === "" || selectedQuarterHalf.value === "") {
					// Prevent the form from submitting
					event.preventDefault();
					alert("الرجاء اختيار عدد الأوجه للمراجعة");
				}
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
