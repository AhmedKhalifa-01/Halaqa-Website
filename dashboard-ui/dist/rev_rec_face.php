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
<center style="margin-bottom:20px;"><a href="std_stat.php" class="button" style="margin-top:100px;width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
		<center><h1>احصائيات أوجه الحفظ و المراجعة</h1></center>
		<center><h3>ملاحظة : يتم حساب الدرجات الآتية فقط : ممتاز - جيد جدا - جيد.</h3></center>
			<table>
				<thead>
					<tr>
						<th>اسم الحلقة</th>
						<th>عدد أوجه الحفظ</th>
						<th>عدد أوجه المراجعة</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sql = "SELECT students.ring_id,SUM(face) as co FROM sora_face
								LEFT JOIN review ON review.id = sora_face.rev_id
								LEFT JOIN students ON students.std_id = review.std_id
								WHERE review.grade = 'ممتاز' OR review.grade = 'جيد جدا' OR review.grade = 'جيد'
								AND sora_face.type = 'review'
								GROUP BY students.ring_id
								";
						$sql = "SELECT DISTINCT * FROM ring
								";
						$res = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($res)){
							echo "<tr><td>".$row['ring_name']."</td>";
							$sql = "SELECT SUM(face) as su FROM sora_face
									INNER JOIN students ON students.std_id = sora_face.std_id AND students.ring_id = '".$row['ring_id']."'
									LEFT JOIN review ON review.id = sora_face.rev_id AND students.std_id = review.std_id 
									WHERE sora_face.type = 'review' AND review.grade = 'ممتاز' OR review.grade = 'جيد جدا' OR review.grade = 'جيد'
									GROUP BY students.ring_id";
							$sum = mysqli_fetch_assoc(mysqli_query($conn,$sql))['su'];
							if($sum == NULL)
								echo "<td>0</td>";
							else
								echo "<td>".$sum."</td>";
							$sql = "SELECT SUM(face) as su FROM sora_face
								INNER JOIN students ON students.std_id = sora_face.std_id AND students.ring_id = '".$row['ring_id']."'
								LEFT JOIN recite ON recite.rev_id = sora_face.rev_id AND students.std_id = recite.std_id 
								WHERE sora_face.type = 'recite' AND recite.grade = 'ممتاز' OR recite.grade = 'جيد جدا' OR recite.grade = 'جيد'
								GROUP BY students.ring_id";
								$sum = mysqli_fetch_assoc(mysqli_query($conn,$sql))['su'];
								if($sum == NULL)
									echo "<td>0</td>";
								else
									echo "<td>".$sum."</td></tr>";
							
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
