<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_04'){
			if($_SESSION['staff_job'] != 'JOB_03'){
				//echo "<script>window.location.href='index.php';</script>";
			}
		}			
	}else{
		//echo "<script>window.location.href='index.php';</script>";
	}
?>
<!DOCTYPE html>
<html lang="ar" >
	<head>
	<meta charset="UTF-8">
	<link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>احصائيات الطالب</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
		<?php
		if($_SESSION['community'] == "4"){
			echo '<link rel="stylesheet" href="./style2.css?v=8">';
		}else{
			echo '<link rel="stylesheet" href="./style.css?v=8">';
		}
	?>
	</head>
	<style>
		table {
			border-collapse: collapse;
			max-width: auto;
			margin: 0 auto;
			margin-top: 50px;
		}
		h1{
			margin-top:100px;
			font-size: 32px;
			font-weight: bold;
		}

		thead th {
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
		
	</style>
<body style="padding-top:100px;">
<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
<!-- partial:index.partial.html -->
		<center><h1>احصائيات الطالب</h1></center>
			<table>
				<thead>
					<tr>
						<th rowspan="5">اسم الطالب</th>
						<th>التاريخ</th>
						<th>اليوم</th>
						<th>حالة الحضور</th>
						<th>درجة الحفظ</th>
						<th>درجة المراجعة</th>
						<th>حالة الخطة</th>
						<th>واجب الحفظ</th>
						<!--<th>عدد الأوجه</th>-->
						<th>واجب المراجعة</th>
						<!--<th>عدد الأوجه</th>-->
						<th>خطة الحفظ</th>
						<th>خطة المراجعة</th>
						<th>المعلم</th>

					</tr>
				</thead>
				<tbody>
				<?php
									//for ($i = 0; $i < count($dates); $i++) {
												//echo $dates[$i]. "</br> " ;
												$printedRev = array();
										$sql = "SELECT DISTINCT mton_review.staff_id as teacher,mton_recite.rev_id,mton_review.id,students.std_id, COALESCE(mton_review_plan.amount,'لا توجد خطة') as rpm, COALESCE(mton_recite_plan.amount,'لا توجد خطة') as rpm2, students.std_name,mton_review.date,mton_std_att.state,mton_review.grade as g1,mton_recite.grade as g2,mton_std_on_plan.onPlan as sta FROM mton_ring
												INNER JOIN students ON mton_ring.mton_ring_id = students.mton_ring_temp_id OR mton_ring.mton_ring_id = students.mton_ring_temp_id_02 OR mton_ring.mton_ring_id = students.mton_ring_temp_id_03
												LEFT JOIN mton_review ON students.std_id = mton_review.std_id
												LEFT JOIN mton_recite ON mton_recite.rev_id = mton_review.id
												LEFT JOIN mton_review_plan ON mton_review_plan.std_id = students.std_id
												LEFT JOIN mton_recite_plan ON mton_recite_plan.std_id = students.std_id
												LEFT JOIN mton_std_att ON students.std_id = mton_std_att.std_id and mton_std_att.date = mton_review.date and mton_std_att.rev_id = mton_review.id
												LEFT JOIN mton_std_on_plan ON students.std_id = mton_std_on_plan.std_id and mton_std_on_plan.date = mton_review.date and mton_std_on_plan.rev_id = mton_review.id
												WHERE mton_ring.mton_ring_id = '".$_GET['mton_ring_id']."' AND students.std_id = '".$_GET['std_id']."'
												ORDER BY id DESC
												LIMIT 7";
												$name = "null";
												$rev_id =  mysqli_fetch_assoc(mysqli_query($conn,$sql))['rev_id'];
												echo mysqli_error($conn);
												$result = mysqli_query($conn,$sql);
												if($result){
													if(mysqli_num_rows($result) > 0){
														while($row = mysqli_fetch_assoc($result)){
															
															/*if($row['rev_id'] == NULL){
																$sql = "SELECT DISTINCT mton_review.id  as revId,students.std_id, COALESCE(mton_review_plan.amount,'لا توجد خطة') as rpm, COALESCE(mton_recite_plan.amount,'لا توجد خطة') as rpm2, students.std_name,mton_review.date,mton_std_att.state,review.grade as g1,recite.grade as g2,std_on_plan.onPlan as sta 
																		FROM students
																		INNER JOIN mton_ring ON ring.ring_id = students.ring_id
																		LEFT JOIN mton_review ON review.std_id = students.std_id AND review.date = '".$row['date']."'
																		LEFT JOIN mton_recite ON recite.std_id = students.std_id AND recite.date = review.date AND recite.date = '".$row['date']."'
																		LEFT JOIN mton_std_att ON std_att.std_id = students.std_id AND std_att.date = review.date AND std_att.date = '".$row['date']."'
																		LEFT JOIN mton_std_on_plan ON std_on_plan.std_id = students.std_id AND std_on_plan.date = review.date AND std_on_plan.date = '".$row['date']."'
																		LEFT JOIN mton_review_plan ON review_plan.std_id = students.std_id
																		LEFT JOIN mton_recite_plan ON recite_plan.std_id = students.std_id
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
																					if($name == "null"){
																						$name = $row2['std_name'];
																						echo '<td rowspan="7" style = "width:400px;">'.$row2['std_name'].'</td>';
																					}
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
																					$sql = "SELECT COALESCE(mton_homework.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND date = '".$row2['date']."' and type='review'";
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
																					$sql = "SELECT * FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND date = '".$row2['date']."' and type='recite'";
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
															}else{*/
																if(date('Y-m-d') == $row['date']){
																	echo '
																	<tr>
																		<td class="td" style = "width:400px;">'.$row['std_name'].'</td>
																		<td class="td" style = "width:600px;">'.$row['date'].'</td>
																		<td class="td" style = "width:600px;">'.getDayOfWeek($row['date']).'</td>';
																		
																		if($row['state'] == 'غياب'){
																			echo '<td style="background-color:darkred;color:white">'.$row['state'].'</td>';
																		}else{
																			echo '<td class="td">'.$row['state'].'</td>';
																		}
																		if($row['g1'] == ""){
																			echo '<td class="td"> - </td>';
																		}else{
																			if($row['g1'] == "إعادة التسميع" || $row['g1'] == "لم يحفظ" || $row['g1'] == "لم يسمع"){
																				echo '<td style="background-color:darkred;color:white">'.$row['g1'].'</td>';
																			}else{
																				echo '<td class="td">'.$row['g1'].'</td>';
																			}
																		}
																		
																		if($row['g2'] == ""){
																			echo '<td class="td"> - </td>';
																		}else{
																			if($row['g2'] == "إعادة التسميع" || $row['g2'] == "لم يحفظ" || $row['g2'] == "لم يسمع"){
																				echo '<td style="background-color:darkred;color:white">'.$row['g2'].'</td>';
																			}else{
																				echo '<td class="td">'.$row['g2'].'</td>';
																			}
																		}
																		echo '<td class="td">'.$row['sta'].'</td>';
																		$sql = "SELECT COALESCE(mton_homework.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM mton_homework 
																				WHERE rev_id = '".$row['id']."' AND std_id = '".$_GET['std_id']."' AND date = '".$row['date']."' and type='review'";
																		$rres = mysqli_query($conn,$sql);

																		$sqlPlan = "SELECT * FROM mton_review_plan WHERE std_id = '".$_GET['std_id']."'";
																		$revPlan = "no";
																		$resultPlan = mysqli_query($conn,$sqlPlan);
																		if(mysqli_num_rows($resultPlan) > 0){
																			$rowPlan = mysqli_fetch_assoc($resultPlan);
																			$revPlan = $rowPlan['amount'];
																			if($revPlan == "0"){
																				$revPlan = "no";
																			}
																		}else{
																			$revPlan = "no";
																		}
																		
																	if($revPlan != "no"){
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
																			echo mysqli_error($conn);
																				echo '<td class="td">لم يتم تسجيل واجب</td>';
																				
																		}
																	}else{
																		echo '<td class="td">متوقف</td>';
																	}

																	$sqlPlan = "SELECT * FROM mton_recite_plan WHERE std_id = '".$_GET['std_id']."'";
																			$recPlan = "no";
																			$resultPlan = mysqli_query($conn,$sqlPlan);
																			if(mysqli_num_rows($resultPlan) > 0){
																				$rowPlan = mysqli_fetch_assoc($resultPlan);
																				$recPlan = $rowPlan['amount'];
																				if($recPlan == "0"){
																					$recPlan = "no";
																					echo "fsdfsdfsdfsdf";
																				}
																			}else{
																				$recPlan = "no";
																			}
																	if($recPlan != "no"){
																		$sql = "SELECT * FROM mton_homework WHERE rev_id = '".$row['id']."' AND std_id = '".$_GET['std_id']."' AND date = '".$row['date']."' and type='recite'";
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
																			
																		}else{
																				echo '<td class="td">لم يتم تسجيل واجب</td>';
																		}
																	}else{
																			echo '<td class="td">متوقف</td>';
																	}
																		echo '<td class="td" style = "width:600px;">'.$row['rpm'].'</td>';
																		echo '<td class="td" style = "width:600px;">'.$row['rpm2'].'</td>';
																		$sql = "SELECT staff_name FROM staff WHERE staff_id = '".$row['teacher']."'";
																		if(mysqli_num_rows(mysqli_query($conn,$sql)) > 0){
																			echo '<td>'.mysqli_fetch_assoc(mysqli_query($conn,$sql))['staff_name'].'</td>';
																		}else{
																			echo '<td>لم يتم تسجيل معلم</td>';
																		}
																	echo '</tr>
																';
																}
																else{
																	echo '
																	<tr>';
																		if($name == "null"){
																			$name = $row['std_name'];
																			echo '<td rowspan="7" style = "width:400px;">'.$row['std_name'].'</td>';
																		}
																		echo '<td style = "width:600px;">'.$row['date'].'</td>
																		<td style = "width:600px;">'.getDayOfWeek($row['date']).'</td>';
																		if($row['state'] == 'غياب'){
																			echo '<td style="background-color:darkred;color:white">'.$row['state'].'</td>';
																		}else{
																			echo '<td>'.$row['state'].'</td>';
																		}
																		if($row['g1'] == ""){
																			echo '<td"> - </td>';
																		}else{
																			if($row['g1'] == "إعادة التسميع" || $row['g1'] == "لم يحفظ" || $row['g1'] == "لم يسمع"){
																				echo '<td style="background-color:darkred;color:white">'.$row['g1'].'</td>';
																			}else{
																				echo '<td>'.$row['g1'].'</td>';
																			}
																		}
																		
																		if($row['g2'] == ""){
																			echo '<td> - </td>';
																		}else{
																			if($row['g2'] == "إعادة التسميع" || $row['g2'] == "لم يحفظ" || $row['g2'] == "لم يسمع"){
																				echo '<td style="background-color:darkred;color:white">'.$row['g2'].'</td>';
																			}else{
																				echo '<td>'.$row['g2'].'</td>';
																			}
																		}
																		
																		$sql = "SELECT COALESCE(mton_homework.sora,'لا توجد سورة') as sor,s_from,s_to,date FROM mton_homework WHERE rev_id = '".$row['id']."' AND std_id = '".$_GET['std_id']."' and type='review'";
																		$rres = mysqli_query($conn,$sql);

																		$sqlPlan = "SELECT * FROM mton_review_plan WHERE std_id = '".$_GET['std_id']."'";
																			$revPlan = "no";
																			$resultPlan = mysqli_query($conn,$sqlPlan);
																			if(mysqli_num_rows($resultPlan) > 0){
																				$rowPlan = mysqli_fetch_assoc($resultPlan);
																				$revPlan = $rowPlan['amount'];
																				if($revPlan == "0"){
																					$revPlan = "no";
																				}
																			}else{
																				$revPlan = "no";
																			}
																	if($revPlan != "no"){
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
																	}else{
																		echo '<td>متوقف</td>';
																	}

																	$sqlPlan = "SELECT * FROM mton_recite_plan WHERE std_id = '".$_GET['std_id']."'";
																			$recPlan = "no";
																			$resultPlan = mysqli_query($conn,$sqlPlan);
																			if(mysqli_num_rows($resultPlan) > 0){
																				$rowPlan = mysqli_fetch_assoc($resultPlan);
																				$recPlan = $rowPlan['amount'];
																				if($recPlan == "0"){
																					$recPlan = "no";
																				}
																			}else{
																				$recPlan = "no";
																			}
																	if($recPlan != "no"){
																		$sql = "SELECT * FROM mton_homework WHERE rev_id = '".$row['id']."' AND std_id = '".$_GET['std_id']."' and type='recite'";
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
																			
																		}else{
																		
																					echo '<td>لم يتم تسجيل واجب</td>';
																				//}
																			}
																		}else{
																		echo '<td>متوقف</td>';
																	}
																			echo '<td style = "width:600px;">'.$row['rpm'].'</td>';
																		echo '<td style = "width:600px;">'.$row['rpm2'].'</td>';
																		$sql = "SELECT staff_name FROM staff WHERE staff_id = '".$row['teacher']."'";
																		if(mysqli_num_rows(mysqli_query($conn,$sql)) > 0){
																			echo '<td>'.mysqli_fetch_assoc(mysqli_query($conn,$sql))['staff_name'].'</td>';
																		}else{
																			echo '<td>لم يتم تسجيل معلم</td>';
																		}
																	echo '</tr>
																';
																		}
																		
																}
															//}
														}
													}
												
											//}
								?>
					
				</tbody>
				</table>

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