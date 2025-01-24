<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_04'){
			// if($_SESSION['staff_job'] != 'JOB_03'){
			// 	echo "<script>window.location.href='index.php';</script>";
			// }
		}			
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}
	if(isset($_POST['del_msg'])){
		$sql = "SELECT * FROM messages";
		$result= mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($result)){
			if(isset($_POST[$row['msg_id']])){
				mysqli_query($conn,"DELETE FROM messages WHERE msg_id = '".$row['msg_id']."'");
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="ar" >
	<head>
	<meta charset="UTF-8">
	<link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>تفاصيل الرسائل</title>
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
<body style="padding-top:100px;">
<!-- partial:index.partial.html -->
	<form action="p_msgs.php" method="post" style="margin-right:100px;">		
		<center><div style="display:position:fixed;margin-auto;width:100%;">
			<h1 style="display:contents">تفاصيل الرسائل</h1>
				
				<input id="btn" type="submit" value="حذف" style="padding:10px;margin-right:10px;font-size:20px;" onclick="return showChk()">
				<input id="del" type="submit" name="del_msg" value="حذف الرسائل المحددة" style="margin-right:10px;padding:10px;font-size:20px;display:none;" onclick="return checkMsg()">
		</div></center>
			<table>
				<thead>
					<tr>
						<th>الرسالة</th>
						<th>التاريخ</th>
						<th id="chk_th" style="display:none">حذف</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sql = "SELECT * FROM messages WHERE user_id = '".$_SESSION['email']."' AND user_type = 2 ORDER BY msg_id DESC";

						$result = mysqli_query($conn,$sql);
						if($result){
							while($row = mysqli_fetch_assoc($result)){
								echo '<tr>
										<td>'.$row['msg'].'</td>
										<td>'.$row['date'].'</td>
										<td class="chk" style="display:none;width:20px;"><input class="chk_box" name = "'.$row['msg_id'].'" type="checkbox" value="'.$row['msg_id'].'"></td>

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
		function showChk(){
			var chk_th = document.getElementById("chk_th");
			var elements = document.getElementsByClassName("chk");
			var btn = document.getElementById("btn");
			var del = document.getElementById("del");
			
			if(chk_th.style.display == "none"){
				chk_th.style.display = "block";
				btn.style.display = "none";
				del.style.display = "inline-block";
				for (var i = 0; i < elements.length; i++) {
					elements[i].style.display = 'block';
				}
			}
			return false;
		}
		function checkMsg(){
			var check_boxes = document.getElementsByClassName("chk_box");
			var found = false;
			for (var i = 0; i < check_boxes.length; i++) {
				if(check_boxes[i].checked){
					found = true;
					break;
				}
			}
			if (confirm("هل أنت متأكد من حذف الرسائل المحددة ؟")) {
				if(found){
					return true;
				}else{
					alert("قم بتحديد الرسائل المراد مسحها");
					return false;
				}
			}else{
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