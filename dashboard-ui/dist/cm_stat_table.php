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
	<link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>احصائيات الدورات</title>
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
		<center><h1>احصائيات الدورات</h1></center>
			<table>
				<thead>
					<tr>
						<th>اسم الدورة</th>
						<th>تاريخ البدء</th>
						<th>تاريخ الانتهاء</th>
						<th>الحالة</th>
						<th>الاستاذ</th>
						<th>عدد الطلبة</th>
						<th>إجمالي الدرجات</th>
						<th>متوسط الدرجات</th>
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
										$sql = "SELECT course.c_id,course.c_name,course.c_start_date,course.c_end_date,course.status,staff.staff_name,COUNT(course_details.std_id) AS total FROM `course` 
												LEFT JOIN course_details ON course.c_id = course_details.course_id 
												INNER JOIN staff ON course.staff_id = staff.staff_id
												WHERE course.c_start_date = '".$dates[$i]."'
												GROUP BY course.c_id";
												$result = mysqli_query($conn,$sql);
												if(mysqli_num_rows($result) > 0){
													while($row = mysqli_fetch_assoc($result)){
														$sql = "SELECT SUM(mark) as sum, AVG(mark) as avg FROM `course_results_details` WHERE c_id = '".$row['c_id']."'";
														$rr = mysqli_query($conn,$sql);
														$rrr = mysqli_fetch_assoc($rr);
														echo '
															<tr>
																<td>'.$row['c_name'].'</td>
																<td>'.$row['c_start_date'].'</td>
																<td>'.$row['c_end_date'].'</td>
																<td>'.$row['status'].'</td>
																<td>'.$row['staff_name'].'</td>
																<td>'.$row['total'].'</td>
																<td>'.$rrr['sum'].'</td>
																<td>'.number_format($rrr['avg'],1).'</td>
															</tr>
														';
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
