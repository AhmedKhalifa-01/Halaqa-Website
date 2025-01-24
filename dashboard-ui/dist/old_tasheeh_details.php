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
	<link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>بيانات تصحيح الطالب</title>
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
<center style="margin-bottom:20px;"><a href="tasheeh_det.php?t_id=<?php echo $_GET['t_id']; ?>" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
<!-- partial:index.partial.html -->
		<center><h1>بيانات تصحيح الطالب</h1></center>
			<table>
				<thead>
					<tr>
						<th rowspan="7">اسم الطالب</th>
						<th>التاريخ</th>
						<th>اليوم</th>
						<th>الحالة</th>
						<th>درجة التصحيح</th>
						<th>واجب التصحيح</th>
						<th>عدد الأوجه</th>
						<th>الملاحظات</th>
						<th>خطة التصحيح</th>
						<th>المعلم</th>
					</tr>
				</thead>
				<tbody>
				<?php
									//for ($i = 0; $i < count($dates); $i++) {
												//echo $dates[$i]. "</br> " ;
												$printedRev = array();
												
												if($_SESSION['staff_job'] == 'JOB_01'){
													$days = $_GET['days'];
												}else{
													$days = 7;
												}
												echo $days;
										$sql = "SELECT * FROM tasheeh_tasmee
												INNER JOIN students ON students.std_id = tasheeh_tasmee.std_id
												INNER JOIN tasheeh_att ON tasheeh_att.tasmee_id = tt_id
												WHERE tasheeh_tasmee.std_id = '".$_GET['std_id']."'
												ORDER BY tasheeh_tasmee.date DESC";
												
												$name = "null";
												$tas_id =  mysqli_fetch_assoc(mysqli_query($conn,$sql))['tt_id'];
												$result = mysqli_query($conn,$sql);
												if($result){
													if(mysqli_num_rows($result) > 0){
														while($row = mysqli_fetch_assoc($result)){
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
																		if($row['grade'] == ""){
																			echo '<td class="td"> - </td>';
																		}else{
																			if($row['grade'] == "إعادة التسميع" || $row['grade'] == "لم يحفظ" || $row['grade'] == "لم يسمع"){
																				echo '<td style="background-color:darkred;color:white">'.$row['grade'].'</td>';
																			}else{
																				echo '<td class="td">'.$row['grade'].'</td>';
																			}
																		}
																		
																		$sql = "SELECT * FROM tasheeh_homework WHERE tasmee_id = '".$row['tt_id']."'";
																		//echo $row['tt_id'];
																		$rres = mysqli_query($conn,$sql);

																		$sqlPlan = "SELECT * FROM tasheeh_plan WHERE tp_std_id = '".$_GET['std_id']."'";
																		$tasheehPlan = "no";
																		$resultPlan = mysqli_query($conn,$sqlPlan);
																		if(mysqli_num_rows($resultPlan) > 0){
																			$rowPlan = mysqli_fetch_assoc($resultPlan);
																			$tasheehPlan = $rowPlan['tp_plan'];
																			if($tasheehPlan == "0"){
																				$tasheehPlan = "no";
																			}
																		}else{
																			$tasheehPlan = "no";
																		}
																	if($tasheehPlan != "no"){
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
																			$sql = "SELECT * FROM tasheeh_homework_face WHERE tasmee_id = '".$row['tt_id']."' AND date = '".$row['date']."' AND std_id = '".$row['std_id']."'";
																			$rere = mysqli_query($conn,$sql);
																			echo '<td class="td">'.mysqli_fetch_assoc($rere)['face'].'</td>';
																		}else{
																		
																				echo '<td class="td">لم يتم تسجيل واجب</td>';
																				echo '<td class="td">لم يتم تسجيل واجب</td>';
																		}
																		$noteSQL = "SELECT notes.note AS stdNote, tasheeh_notes.* FROM tasheeh_notes
																					INNER JOIN notes ON notes.note_id = tasheeh_notes.note
																					WHERE tasheeh_notes.tasmee_id = '".$row['tt_id']."'";
																		$noteRes = mysqli_query($conn,$noteSQL);
																		echo mysqli_error($conn);
																		if(mysqli_num_rows($noteRes) > 0){
																			echo "<td class=\"td\"><ol>";
																			while($noteRow = mysqli_fetch_assoc($noteRes)){
																				echo "<li> - ".$noteRow['stdNote']."</li>";
																			}
																			echo "</ol></td>";
																		}else{
																			echo "<td class=\"td\">لا توجد ملاحظات</td>";
																		}
																		echo '<td class="td">'.$tasheehPlan.'</td>';
																		
																	}else{
																		echo '<td class="td">متوقف</td>';
																		echo '<td class="td">متوقف</td>';
																	}
																}
																else{
																	echo '
																	<tr>';
																		if($name == "null"){
																			$name = $row['std_name'];
																			echo '<td rowspan="'.$days.'" style = "width:400px;">'.$row['std_name'].'</td>';
																		}
																		echo '<td style = "width:600px;">'.$row['date'].'</td>
																		<td style = "width:600px;">'.getDayOfWeek($row['date']).'</td>';
																		if($row['state'] == 'غياب'){
																			echo '<td style="background-color:darkred;color:white">'.$row['state'].'</td>';
																		}else{
																			echo '<td>'.$row['state'].'</td>';
																		}
																		if($row['grade'] == ""){
																			echo '<td"> - </td>';
																		}else{
																			if($row['grade'] == "إعادة التسميع" || $row['grade'] == "لم يحفظ" || $row['grade'] == "لم يسمع"){
																				echo '<td style="background-color:darkred;color:white">'.$row['grade'].'</td>';
																			}else{
																				echo '<td>'.$row['grade'].'</td>';
																			}
																		}
																		
																			$sql = "SELECT * FROM tasheeh_homework WHERE tasmee_id = '".$row['tt_id']."'";
																		$rres = mysqli_query($conn,$sql);

																		$sqlPlan = "SELECT * FROM tasheeh_plan WHERE tp_std_id = '".$_GET['std_id']."'";
																			$tasheehPlan = "no";
																			$resultPlan = mysqli_query($conn,$sqlPlan);
																			if(mysqli_num_rows($resultPlan) > 0){
																				$rowPlan = mysqli_fetch_assoc($resultPlan);
																				$tasheehPlan = $rowPlan['tp_plan'];
																				if($tasheehPlan == "0"){
																					$tasheehPlan = "no";
																				}
																			}else{
																				$tasheehPlan = "no";
																			}
																	if($tasheehPlan != "no"){
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
																			$sql = "SELECT * FROM tasheeh_homework_face WHERE tasmee_id = '".$row['tt_id']."' AND std_id = '".$row['std_id']."'";
																			$rere = mysqli_query($conn,$sql);
																			echo '<td class="">'.mysqli_fetch_assoc($rere)['face'].'</td>';
																		}else{
																		
																				echo '<td>لم يتم تسجيل واجب</td>';
																				echo '<td>لم يتم تسجيل واجب</td>';
																		}
																		$noteSQL = "SELECT notes.note AS stdNote, tasheeh_notes.* FROM tasheeh_notes
																					INNER JOIN notes ON notes.note_id = tasheeh_notes.note
																					WHERE tasheeh_notes.tasmee_id = '".$row['tt_id']."'";
																		$noteRes = mysqli_query($conn,$noteSQL);
																		if(mysqli_num_rows($noteRes) > 0){
																			echo "<td><ol>";
																			while($noteRow = mysqli_fetch_assoc($noteRes)){
																				echo "<li> - ".$noteRow['stdNote']."</li>";
																			}
																			echo "</ol></td>";
																		}else{
																			echo "<td>لا توجد ملاحظات</td>";
																		}
																		echo '<td class="">'.$tasheehPlan.'</td>';
																	}else{
																		echo '<td>متوقف</td>';
																		echo '<td>متوقف</td>';
																	}

																		
																	}
																	$sql = "SELECT staff_name FROM staff WHERE staff_id = '".$row['staff_id']."'";
																		if(mysqli_num_rows(mysqli_query($conn,$sql)) > 0){
																			echo '<td>'.mysqli_fetch_assoc(mysqli_query($conn,$sql))['staff_name'].'</td>';
																		}else{
																			echo '<td>لم يتم تسجيل معلم</td>';
																		}
																	echo '</tr>
																';
																		
																}
															}
														}
													
												
											//}
								?>
					
				</tbody>
				</table>

				<a href="old_ring_details.php?std_id=<?php echo $_GET['std_id']; ?>&t_id=<?php echo $_GET['t_id']; ?>&days=<?php $days = $days+7; echo $days; ?>"
				style="background-color: #515151; /* Green */
						border: none;
						color: white;
						padding: 15px 32px;
						text-align: center;
						text-decoration: none;
						display: inline-block;
						font-size: 26px;
						margin-top: 10px;
						margin-right: 10px;">المزيد</a>

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