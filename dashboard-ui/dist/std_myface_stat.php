<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_04'){
			//if($_SESSION['staff_job'] != 'JOB_03'){
				//echo "<script>window.location.href='index.php';</script>";
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
	<link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>احصائيات الأوجه</title>
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
<center style="margin-bottom:20px;"><a href="std_my_stat.php" class="button" style="margin-top:100px;width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
		<center><h1>احصائيات الأوجه</h1></center>
		<center><h3>احصائيات الأوجه : يتم حساب الدرجات الآتية فقط : ممتاز - جيد جدا - جيد.</h3></center>
			<table>
				<thead>
					<tr>
						<th>اسم الطالب</th>
						<th>عدد أوجه الحفظ</th>
						<th>عدد أوجه المراجعة</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sql = "SELECT students.ring_id,students.std_name,SUM(sora_face.face) as su
						FROM sora_face 
						INNER JOIN students ON students.std_id = sora_face.std_id 
						WHERE students.std_id = '".$_SESSION['email']."' AND sora_face.type = 'review'
						AND sora_face.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
						$res = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($res);
						echo "<tr><td>".$row['std_name']."</td>";
						echo "<td>".$row['su']."</td>";
						$sql = "SELECT students.ring_id,students.std_name,SUM(sora_face.face) as su
								FROM sora_face 
								INNER JOIN students ON students.std_id = sora_face.std_id 
								WHERE students.std_id = '".$_SESSION['email']."' AND sora_face.type = 'recite'
								AND sora_face.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
						$res = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($res);
						echo "<td>".$row['su']."</td>";
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
