<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_GET['std_id'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
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
<?php if($_SESSION['staff_job'] == "JOB_04"){ ?>
<center style="margin-bottom:20px;"><a href="visitor_std_single_stat_select_date.php?type=2&std_id=<?php echo $_GET['std_id']; ?>&ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="margin-top:100px;width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
<?php }else { ?>
	<center style="margin-bottom:20px;"><a href="std_single_stat_select_date.php?type=2&std_id=<?php echo $_GET['std_id']; ?>&ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="margin-top:100px;width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
				<?php } ?>
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
					 if(isset($_POST['day'])){
						$sql = "SELECT SUM(face) as su FROM `sora_face`
								INNER JOIN review ON review.id = sora_face.rev_id
								WHERE review.std_id = '".$_GET['std_id']."' and type = 'review'
								AND sora_face.date = CURDATE()
								AND review.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
					 }else  if(isset($_POST['week'])){
						$sql = "SELECT SUM(face) as su FROM `sora_face`
								INNER JOIN review ON review.id = sora_face.rev_id
								WHERE review.std_id = '".$_GET['std_id']."' and type = 'review'
								AND sora_face.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()
								AND review.grade IN ('ممتاز', 'جيد جدا', 'جيد');";
					 }else  if(isset($_POST['month'])){
						$sql = "SELECT SUM(face) as su FROM `sora_face`
								INNER JOIN review ON review.id = sora_face.rev_id
								WHERE review.std_id = '".$_GET['std_id']."' and type = 'review'
								AND sora_face.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()
								AND review.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
					 }else{
						$sql = "SELECT SUM(face) as su FROM `sora_face`
								INNER JOIN review ON review.id = sora_face.rev_id
								WHERE review.std_id = '".$_GET['std_id']."' and type = 'review'
								AND DATE(sora_face.date) BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'
								AND review.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
					 }
						
						$res = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($res);
						$std_name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT std_name FROM students WHERE std_id = '".$_GET['std_id']."'"))['std_name'];
						echo "<tr><td>".$std_name."</td>";
						echo "<td>".$row['su']."</td>";
						if(isset($_POST['day'])){
							$sql = "SELECT SUM(face) as su FROM `sora_face`
									INNER JOIN recite ON recite.rev_id = sora_face.rev_id
									WHERE recite.std_id = '".$_GET['std_id']."' and type = 'recite'
									AND sora_face.date = CURDATE()
									AND recite.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
						 }else  if(isset($_POST['week'])){
							$sql = "SELECT SUM(face) as su FROM `sora_face`
									INNER JOIN recite ON recite.rev_id = sora_face.rev_id
									WHERE recite.std_id = '".$_GET['std_id']."' and type = 'recite'
									AND sora_face.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()
									AND recite.grade IN ('ممتاز', 'جيد جدا', 'جيد');";
						 }else  if(isset($_POST['month'])){
							$sql = "SELECT SUM(face) as su FROM `sora_face`
									INNER JOIN recite ON recite.rev_id = sora_face.rev_id
									WHERE recite.std_id = '".$_GET['std_id']."' and type = 'recite'
									AND sora_face.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()
									AND recite.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
						 }else{
							$sql = "SELECT SUM(face) as su FROM `sora_face`
									INNER JOIN recite ON recite.rev_id = sora_face.rev_id
									WHERE recite.std_id = '".$_GET['std_id']."' and type = 'recite'
									AND DATE(sora_face.date) BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'
									AND recite.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
						 }
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
