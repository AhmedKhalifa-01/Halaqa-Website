<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		// if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_04'){
		// 	//if($_SESSION['staff_job'] != 'JOB_03'){
		// 		echo "<script>window.location.href='index.php';</script>";
		// 	//}
		// }			
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}
?>
<!DOCTYPE html>
<html lang="ar" >
	<head>
	<meta charset="UTF-8">
	<link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>حضور المتون</title>
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
		<center><h1>حضور المتون</h1></center>
			<table>
				<thead>
					<tr>
						<th>الاسم</th>
						<th>التاريخ</th>
						<th>اليوم</th>
						<th>الحالة</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sql = "SELECT *
								FROM students 
								INNER JOIN ring ON ring.ring_id = students.temp_ring_id 
								LEFT JOIN mton_std_att ON students.std_id = mton_std_att.std_id 
								WHERE ring.ring_id = '".$_GET['ring_id']."'";
						$result = mysqli_query($conn,$sql);
						if($result){
							while($row = mysqli_fetch_assoc($result)){
								echo '<tr>
										<td>'.$row['std_name'].'</td>
										<td>'.$row['date'].'</td>
										<td>'.getDayOfWeek($row['date']).'</td>
										<td>'.$row['state'].'</td>
									</tr>
										';	
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
<?php
	function getDayOfWeek($dateString) {
		$myDate = new DateTime($dateString);
		$dayOfWeek = $myDate->format('w');
		$daysOfWeek = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
		return $daysOfWeek[$dayOfWeek];
	  }
?>
