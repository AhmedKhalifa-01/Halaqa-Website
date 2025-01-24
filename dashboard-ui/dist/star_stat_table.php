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
	<link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>احصائيات النجوم</title>
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
<body style="padding-top:0px;">
<!-- partial:index.partial.html -->
<center style="margin-bottom:20px;"><a href="star_stat.php" class="button" style="margin-top:100px;width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
		<center><h1>احصائيات النجوم</h1></center>
		
			<table>
				<thead>
					<tr>
						<th>اسم الطالب</th>
						<th>النجمة الذهبية</th>
						<th>النجمة الفضية</th>
						<th>النجمة البرونزية</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(isset($_POST['day'])){
							$sql = "SELECT students.std_name,
										COUNT(CASE WHEN prize_details.star = 'الذهبية' THEN prize_details.prize_details_id END) AS gold,
										COUNT(CASE WHEN prize_details.star = 'الفضية' THEN prize_details.prize_details_id END) AS silver,
										COUNT(CASE WHEN prize_details.star = 'البرونزية' THEN prize_details.prize_details_id END) AS pronz
									FROM prize_details
									INNER JOIN students ON students.std_id = prize_details.std_id
									WHERE (prize_details.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE())
									GROUP BY students.std_id
								";
						}else if(isset($_POST['week'])){
							$sql = "SELECT students.std_name,
										COUNT(CASE WHEN prize_details.star = 'الذهبية' THEN prize_details.prize_details_id END) AS gold,
										COUNT(CASE WHEN prize_details.star = 'الفضية' THEN prize_details.prize_details_id END) AS silver,
										COUNT(CASE WHEN prize_details.star = 'البرونزية' THEN prize_details.prize_details_id END) AS pronz
									FROM prize_details
									INNER JOIN students ON students.std_id = prize_details.std_id
									WHERE (prize_details.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE())
									GROUP BY students.std_id
								";
						}else if(isset($_POST['month'])){
							$sql = "SELECT students.std_name,
										COUNT(CASE WHEN prize_details.star = 'الذهبية' THEN prize_details.prize_details_id END) AS gold,
										COUNT(CASE WHEN prize_details.star = 'الفضية' THEN prize_details.prize_details_id END) AS silver,
										COUNT(CASE WHEN prize_details.star = 'البرونزية' THEN prize_details.prize_details_id END) AS pronz
									FROM prize_details
									INNER JOIN students ON students.std_id = prize_details.std_id
									WHERE (prize_details.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())
									GROUP BY students.std_id
								";
						}else{
							$sql = "SELECT students.std_name,
										COUNT(CASE WHEN prize_details.star = 'الذهبية' THEN prize_details.prize_details_id END) AS gold,
										COUNT(CASE WHEN prize_details.star = 'الفضية' THEN prize_details.prize_details_id END) AS silver,
										COUNT(CASE WHEN prize_details.star = 'البرونزية' THEN prize_details.prize_details_id END) AS pronz
									FROM prize_details
									INNER JOIN students ON students.std_id = prize_details.std_id
									WHERE prize_details.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'
									GROUP BY students.std_id
								";
						}
						$res = mysqli_query($conn, $sql);
						while($row = mysqli_fetch_assoc($res)){
							echo "<tr><td>".$row['std_name']."</td>";
							echo "<td>".$row['gold']."</td>";
							echo "<td>".$row['silver']."</td>";
							echo "<td>".$row['pronz']."</td>";
							echo "</tr>";
						}
						echo mysqli_error($conn);
						
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
