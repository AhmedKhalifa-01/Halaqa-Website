<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_04'){
			if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
			}
		}			
	}else{
		echo "<script>window.location.href='index.php';</script>";
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
	</style>
<body style="padding-top:50px;">
<!-- partial:index.partial.html -->
<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
		<center><h1>احصائيات الطالب</h1></center>
			<table>
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
						<th>واجب المراجعة</th>
						<th>خطة الحفظ</th>
						<th>خطة المراجعة</th>

					</tr>
				</thead>
				<tbody>
				<?php
									//for ($i = 0; $i < count($dates); $i++) {
												//echo $dates[$i]. "</br> " ;
										$sql = "SELECT DISTINCT COALESCE(mton_review_plan.amount,'لا توجد خطة') as rpm, COALESCE(mton_recite_plan.amount,'لا توجد خطة') as rpm2, students.std_name,mton_review.date,mton_std_att.state,mton_review.grade as g1,mton_recite.grade as g2,mton_std_on_plan.onPlan as sta FROM ring
												INNER JOIN students ON ring.ring_id = students.ring_id
												LEFT JOIN mton_recite ON students.std_id = mton_recite.std_id
												LEFT JOIN mton_review_plan ON mton_review_plan.std_id = students.std_id
												LEFT JOIN mton_recite_plan ON mton_recite_plan.std_id = students.std_id
												LEFT JOIN mton_review ON students.std_id = mton_review.std_id and mton_review.date = mton_recite.date
												LEFT JOIN mton_std_att ON students.std_id = mton_std_att.std_id and mton_std_att.date = mton_review.date
												LEFT JOIN mton_std_on_plan ON students.std_id = mton_std_on_plan.std_id and mton_std_on_plan.date = mton_review.date
												WHERE ring.ring_id = '".$_GET['ring_id']."' AND students.std_id = '".$_GET['std_id']."'
												ORDER BY mton_review.date DESC
												LIMIT 10";
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
																	$sql = "SELECT COALESCE(mton_homework.sora,'لا توجد سورة') as sor,mh_from,mh_to,mh_date FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND mh_date = '".$row['date']."' and mh_type='review'";
																	$rres = mysqli_query($conn,$sql);
																	if(mysqli_num_rows($rres) > 0){
																		echo '<td><ul>';
																		while($rrow = mysqli_fetch_assoc($rres)){
																			if($rrow['mh_from'] == '-'){
																				echo '<li> سورة '.$rrow['sor'].'</li>';
																			}else{
																				if($rrow['sor'] == ""){
																					echo " - ";
																				}else{
																					echo '<li>'.$rrow['sor'].' من '.$rrow['mh_from'].' إلى '.$rrow['mh_to'].'</li>';
																				}
																			}
																			
																			
																		}
																		echo '</ul></td>';
																	}else{
																		echo '<td>لم يتم تسجيل واجب</td>';
																	}
																	$sql = "SELECT * FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND mh_date = '".$row['date']."' and mh_type='recite'";
																	$rres = mysqli_query($conn,$sql);
																	if(mysqli_num_rows($rres) > 0){
																		echo '<td><ul>';
																		while($rrow = mysqli_fetch_assoc($rres)){
																			if($rrow['mh_from'] == '-'){
																				echo '<li> سورة '.$rrow['sora'].'</li>';
																			}else{
																				if($rrow['sora'] == ""){
																					echo " - ";
																				}else{
																					echo '<li>'.$rrow['sora'].' من '.$rrow['mh_from'].' إلى '.$rrow['mh_to'].'</li>';
																				}
																			}
																			
																		}
																		echo '</ul></td>';
																	}else{
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