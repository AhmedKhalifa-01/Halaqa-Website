<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_04'){
			//if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
			//}
		}			
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}
?>
<!DOCTYPE html>
<html lang="ar" >
	<head>
	<meta charset="UTF-8">
	<link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>احصائيات الحلقات</title>
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
<body>
<!-- partial:index.partial.html -->
		<center><h1>احصائيات الحلقات</h1></center>
			<table>
				<thead>
					<tr>
						<th>اسم الطالب</th>
						<th>اسم المعلم</th>
						<th>التاريخ</th>
						<th>حالة الحضور</th>
						<th>درجة الحفظ</th>
						<th>درجة المراجعة</th>
						<th>حالة الخطة</th>
					</tr>
				</thead>
				<tbody>
				<?php
									$start_date = new DateTime($_POST['start_date']);
									$end_date = new DateTime($_POST['end_date']);
													
									$interval = new DateInterval('P1D'); // 1 day interval
					
									$dates = array();
									$current_date = clone $start_date;
									while ($current_date <= $end_date) {
										$dates[] = $current_date->format('Y-m-d');
										$current_date->add($interval);
									}
									for ($i = 0; $i < count($dates); $i++) {
												//echo $dates[$i]. "</br> " ;
										$sql = "SELECT DISTINCT students.std_name,students.std_id,staff.staff_name,review.date,std_att.state,review.grade as g1,recite.grade as g2,std_on_plan.onPlan as sta FROM ring
												INNER JOIN students ON ring.ring_id = students.ring_id
												INNER JOIN staff ON ring.staff_id = staff.staff_id
												LEFT JOIN recite ON students.std_id = recite.std_id
												LEFT JOIN review ON students.std_id = review.std_id and review.date = recite.date
												LEFT JOIN std_att ON students.std_id = std_att.std_id and std_att.date = review.date
												LEFT JOIN std_on_plan ON students.std_id = std_on_plan.std_id and std_on_plan.date = review.date
												WHERE ring.ring_id = '".$_GET['ring_id']."' AND review.date = '".$dates[$i]."'
												ORDER BY students.std_id";
												$result = mysqli_query($conn,$sql);
												if($result){
													if(mysqli_num_rows($result) > 0){
														while($row = mysqli_fetch_assoc($result)){
															echo '
																<tr>
																	<td style = "width:400px;">'.$row['std_name'].'</td>
																	<td style = "width:600px;">'.$row['staff_name'].'</td>
																	<td style = "width:600px;">'.$row['date'].'</td>
																	<td>'.$row['state'].'</td>
																	<td>'.$row['g1'].'</td>
																	<td>'.$row['g2'].'</td>
																	<td>'.$row['sta'].'</td>
																</tr>
															';
														}
													}
												}
											}
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
