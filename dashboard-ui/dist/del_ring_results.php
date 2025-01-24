<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
			if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
			}
		}
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}	
	if($_GET['ring_id'] != $_SESSION['email']){
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
			echo "<script>window.location.href='../../index.php';</script>";
		}
	}
	if(isset($_POST['del'])){
		mysqli_query($conn,"DELETE FROM review WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."' AND id = '".$_GET['revid']."'");
		mysqli_query($conn,"DELETE FROM recite WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."' AND rev_id = '".$_GET['revid']."'");
		mysqli_query($conn,"DELETE FROM std_att WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."' AND rev_id = '".$_GET['revid']."'");
		mysqli_query($conn,"DELETE FROM std_on_plan WHERE std_id = '".$_GET['std_id']."' AND date = '".$_GET['review_date']."' AND rev_id = '".$_GET['revid']."'");
		mysqli_query($conn,"DELETE FROM std_homework_soras WHERE rev_id = '".$_GET['revid']."'");
		mysqli_query($conn,"DELETE FROM sora_face WHERE rev_id = '".$_GET['revid']."'");
		echo "<script>window.location.href='del_ring_results.php?std_id=".$_GET['std_id']."&ring_id=".$_GET['ring_id']."';</script>";
	}
	

	

?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>حذف الدرجات</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
	<?php
		if($_SESSION['community'] == "4"){
			echo '<link rel="stylesheet" href="./style2.css?v=8">';
		}else{
			echo '<link rel="stylesheet" href="./style.css?v=8">';
		}
	?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
		.tt table {
			border-collapse: collapse;
			max-width: auto;
			margin: 0 auto;
			margin-top: 50px;
		}
		.tt h1{
			margin-top:100px;
			font-size: 32px;
			font-weight: bold;
		}

		.tt thead th {
			background-color: #f2f2f2;
			border: 1px solid #ddd;
			font-weight: bold;
			padding: 10px;
			text-align: right;
		}

		.tt tbody tr {
			border: 1px solid #ddd;
		}

		.tt tbody td {
			font-size:16px;
			font-weight:bold;
			padding: 20px;
			text-align: right;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		.tt td:nth-child(even) {
			background-color: #f2f2f2;
		}
		.tt td:nth-child(even):hover {
			background-color: #f9f9f9;
		}

		.tt td:nth-child(odd) {
			background-color: #fff;
		}
		.tt td:nth-child(odd):hover {
			background-color: #f2f2f2;
		}
		thead {
			position: sticky;
			top: 0;
			z-index: 1;
		}
	</style>
</head>
<body>
<center style="margin-bottom:20px;"><a href="del_ring_res.php?ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
<!-- partial:index.partial.html -->
					<?php if(isset($_GET['calc_res'])){?>
						<form class="login-form" action="change_ring_results.php?review_date=<?php echo $_GET['review_date'];?>&ring_id=<?php echo $_GET['ring_id'];?>&std_id=<?php echo $_GET['std_id'];?>" method="post">
						<div class="card-grid" style="font-size:18px;" >

						<article class="card" style="width:300px;">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/quran.png" /></span>
									<?php
										$sql = "SELECT std_name from students WHERE std_id = '".$_GET['std_id']."'";
										$name = mysqli_fetch_assoc(mysqli_query($conn,$sql))['std_name'];
									?>	
									<h3><?php echo $name; ?></h3>
								</div>
							</div>
							<div class="card-body">
							<input style="width:auto;margin:10px;display:inline-block;" type="radio" name="att" value="حضور" id="present"><label for="present">حضور</label>
							<input style="width:auto;margin:10px;display:inline-block;" type="radio" name="att" value="غياب" id="disp"><label for="disp">غياب</label>
							<input style="width:auto;margin:10px;display:inline-block;" type="radio" name="att" value="مستاذن" id="disp2"><label for="disp2">مستاذن</label></br></br>
								<?php
									$sqlPlan = "SELECT * FROM review_plan WHERE std_id = '".$_GET['std_id']."'";
									$resultPlan = mysqli_query($conn,$sqlPlan);
									if(mysqli_num_rows($resultPlan) > 0){
										$rowPlan = mysqli_fetch_assoc($resultPlan);
										echo '<h1 style="font-size:19px;">خطة الحفظ : '.$rowPlan['amount'].'</h1></br>';
										$sqlPlan = "SELECT * FROM recite_plan WHERE std_id = '".$_GET['std_id']."'";
										//  خط الحفظ
										$resultPlan = mysqli_query($conn,$sqlPlan);
										if(mysqli_num_rows($resultPlan) > 0){
											$rowPlan = mysqli_fetch_assoc($resultPlan);
											echo '<h1 style="font-size:19px;">خطة المراجعة : '.$rowPlan['amount'].'</h1></br>';
										}else{
											echo '<h1 style="font-size:19px;">الطالب ليس لديه خطة مراجعة</h1></br>';
										}
									}else{
										echo '<h1 style="font-size:19px;">الطالب ليس لديه خطة حفظ</h1></br>';
									}
									echo '<h1 style="font-size:19px;">واجب الحفظ : </h1>';
									$sqlDateReview = "SELECT date FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='review' ORDER BY date DESC LIMIT 1";
						$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDateReview));
						$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='review' AND date = '".$rowRDate['date']."'";
						$rres = mysqli_query($conn,$sql);
						if(mysqli_num_rows($rres) > 0){
						echo '<center><table style="margin-bottom:10px;width:250px;border:1px solid black;"><tr>';
						$count = 0;
						while($rrow = mysqli_fetch_assoc($rres)){
						if($count % 3 == 0 && $count != 0){
						echo '</tr><tr>';
						}
						if($rrow['s_from'] == '-'){
						echo '<td style="font-size:12px; padding:5px;"> سورة '.$rrow['sora'].'</td>';
						}else{
						echo '<td style="font-size:12px; padding:5px;">'.$rrow['sora'].'</br> '.$rrow['s_from'].' - '.$rrow['s_to'].'</td>';
						}
						$count++;
						}
						echo '</tr></table></center>';
						}else{
						echo '<h1 style="font-size:18px;">الطالب ليس لديه واجب حفظ</h1></br>';
						}
											echo '<h1 style="font-size:19px;">واجب المراجعة : </h1>';
											$sqlDateReview = "SELECT date FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='recite' ORDER BY date DESC LIMIT 1";
						$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDateReview));
						$sql = "SELECT * FROM std_homework_soras WHERE std_id = '".$_GET['std_id']."' AND type='recite' AND date = '".$rowRDate['date']."'";
						$rres = mysqli_query($conn,$sql);
						if(mysqli_num_rows($rres) > 0){
						echo '<center><table style="margin-bottom:10px;width:250px;border:1px solid black;"><tr>';
						$count = 0;
						while($rrow = mysqli_fetch_assoc($rres)){
						if($count % 3 == 0 && $count != 0){
						echo '</tr><tr>';
						}
						if($rrow['s_from'] == '-'){
						echo '<td style="font-size:12px; padding:5px;width:30px;"> سورة '.$rrow['sora'].'</td>';
						}else{
						echo '<td style="font-size:12px; padding:5px;width:30px;">'.$rrow['sora'].'</br>'.$rrow['s_from'].' - '.$rrow['s_to'].'</td>';
						}
						$count++;
						}
						echo '</tr></table></center>';
						}else{
						echo '<h1 style="font-size:18px;">الطالب ليس لديه واجب حفظ</h1></br>';
						}
								?>
								<center><table id = "score_table">
								
								<tr>
									<th>درجة الحفظ</th>
									<th>درجة المراجعة</th>
								</tr>
								<?php
									$sql = "SELECT std_name from students WHERE std_id = '".$_GET['std_id']."'";
									$name = mysqli_fetch_assoc(mysqli_query($conn,$sql))['std_name'];
								?>	
								<tr>
									
										<!--<td style="white-space: normal;word-wrap: break-word;max-width: 60px;">
											<?php //echo $name ?>
										</td>-->
										
										<td>
											<input style="width:auto;margin:10px;" type="radio" name="score1" value="ممتاز" id="grade1"> ممتاز</br>
											<input style="width:auto;margin:10px;" type="radio" name="score1" value="جيد جدا" id="grade2">جيد جدا </br>
											<input style="width:auto;margin:10px;" type="radio" name="score1" value="جيد" id="grade3"> جيد</br>
											<input style="width:auto;margin:10px;" type="radio" name="score1" value="إعادة" id="grade4"> إعادة</br>
											<input style="width:auto;margin:10px;" type="radio" name="score1" value="لم يحفظ" id="grade5"> لم يحفظ</br>
											<input style="width:auto;margin:10px;" type="radio" name="score1" value="لم يسمع" id="grade6"> لم يسمع
										</td>
										<td>
											<input style="width:auto;margin:10px;" type="radio" name="score2" value="ممتاز" id="grade7"> ممتاز</br>
											<input style="width:auto;margin:10px;" type="radio" name="score2" value="جيد جدا" id="grade8">جيد جدا </br>
											<input style="width:auto;margin:10px;" type="radio" name="score2" value="جيد" id="grade9"> جيد</br>
											<input style="width:auto;margin:10px;" type="radio" name="score2" value="إعادة" id="grade10"> إعادة</br>
											<input style="width:auto;margin:10px;" type="radio" name="score2" value="لم يحفظ" id="grade11"> لم يحفظ</br>
											<input style="width:auto;margin:10px;" type="radio" name="score2" value="لم يسمع" id="grade12"> لم يسمع
										</td>
									</form>
									
								</tr>
							</table></center>
						</div>
						<div class="card-footer">
									<input style="width:auto;margin:10px;" type="checkbox" name="on_plan" value="حسب الخطة" id="onplan"> حسب الخطة
								</div>
							<div class="card-footer">
								<button type="submit" name="std_info">إرسال</button>
							</div>
						</artice>
					</form>
					<?php }else{ ?>
						<div class="tt">
					<table>
					<thead>
						<tr>
							<th>اسم الطالب</th>
							<th>التاريخ</th>
							<th>اليوم</th>
							<th>الحضور</th>
							<th>درجة الحفظ</th>
							<th>درجة المراجعة</th>
							<th>حالة الخطة</th>
							<th>الأجزاء المحفوظة</th>
							<th>واجب الحفظ</th>
							<th>واجب المراجعة</th>
							<th>تغيير</th>
						</tr>
					</thead>
					<tbody>
					<?php
						/*$sql = "SELECT students.std_name,students.std_id,students.std_v_mem,review_plan.amount as rev_am,recite_plan.amount as rec_am 
								FROM students
								INNER JOIN ring ON students.std_id = ring.std_id
								LEFT JOIN review_plan ON review_plan.std_id = ring.std_id
								LEFT JOIN recite_plan ON recite_plan.std_id = review_plan.std_id
								WHERE ring.ring_id = '".$_GET['ring_id']."'
								AND students.std_id = '".$_GET['std_id']."'
								";*/
						$sql = "SELECT DISTINCT review.date as rdate,review.id as revid,review.id as id1, recite.id as id2,review.date as rd,students.std_id,COALESCE(students.std_v_mem, '0') AS mem,COALESCE(std_att.state, 'N/A') AS state,COALESCE(std_on_plan.onPlan, 'N/A') AS onPlan,COALESCE(review.grade, 'N/A') AS g1,COALESCE(recite.grade, 'N/A') AS g2,students.std_name,students.std_id,ring.ring_id
								FROM students 
								INNER JOIN ring ON ring.ring_id = students.temp_ring_id 
								LEFT JOIN review ON students.std_id = review.std_id
								LEFT JOIN recite ON students.std_id = recite.std_id and recite.std_id AND review.date = recite.date AND recite.rev_id = review.id
								LEFT JOIN std_on_plan ON students.std_id = std_on_plan.std_id and review.date = std_on_plan.date AND std_on_plan.rev_id = review.id
								LEFT JOIN std_att ON students.std_id = std_att.std_id and review.date = std_att.date 
								WHERE students.temp_ring_id = '".$_GET['ring_id']."'
								AND students.std_id = '".$_GET['std_id']."'
								ORDER BY std_att.date DESC
								LIMIT 5";
						$result = mysqli_query($conn,$sql);
						if($result){
							while($row = mysqli_fetch_assoc($result)){
								$std_date = mysqli_fetch_assoc(mysqli_query($conn,"SELECT date FROM review WHERE std_id = '".$row['std_id']."' ORDER BY id DESC LIMIT 1;"))['date'];
								echo '<tr>
										<td style="white-space: normal;word-wrap: break-word;min-width: 100px;max-width:100px;">'.$row['std_name'].'</td>
										<td ><div style="max-width:400px;">'.$row['rd'].'</div></td>
										<td>'.getDayOfWeek($row['rd']).'</td>
										<td>'.$row['state'].'</td>
										<td>'.$row['g1'].'</td>
										<td>'.$row['g2'].'</td>
										<td>'.$row['onPlan'].'</td>
										<td>'.$row['mem'].'</td>';
										$sql = "SELECT * FROM std_homework_soras
												WHERE std_id = '".$row['std_id']."' AND type = 'review' AND date = '".$row['rdate']."'
												";
										$resu = mysqli_query($conn,$sql);
										echo '<td><ul style="width:100px;">';
										while($raw = mysqli_fetch_assoc($resu)){
											if($raw['s_from'] == "-"){
												echo '
												<li>سورة '.$raw['sora'].'</li>';
											}else if($raw['s_from'] == '*'){
												echo '<li> الجزء '.$raw['sora'].'</li>';
											}else{
												echo '
													<li>سورة '.$raw['sora'].'</li>
													<li>من '.$raw['s_from'].' إلى '.$raw['s_to'].'</li><div style="width:100%;margin: 10px 0;border-bottom:1px solid black;"></div>
												';
											}
										
										}
										echo '</ul></td>';
											// عرض واجب المراجعة
											$sql = "SELECT * FROM std_homework_soras
													WHERE std_id = '".$row['std_id']."' AND type = 'recite' AND date = '".$row['rdate']."'
													";
											$resu = mysqli_query($conn,$sql);
											echo '<td><ul style="width:100px;">';
											while($raw = mysqli_fetch_assoc($resu)){
												if($raw['s_from'] == "-"){
													echo '
													<li>سورة '.$raw['sora'].'</li>';
												}else if($raw['s_from'] == '*'){
													echo '<li> الجزء '.$raw['sora'].'</li>';
												}else{
													echo '
														<li>سورة '.$raw['sora'].'</li>
														<li>من '.$raw['s_from'].' إلى '.$raw['s_to'].'</li><div style="width:100%;margin: 10px 0;border-bottom:1px solid black;"></div>
													';
												}
											}
											echo '</ul></td>';
									echo '<td>
									<form class="login-form" action="del_ring_results.php?review_date='.$row['rdate'].'&calc_res=1&ring_id='.$_GET['ring_id'].'&std_id='.$row['std_id'].'&revid='.$row['revid'].'" method="post">
											<button type="submit" name="del" onclick="return confDel();">حذف</button>
										</form>
										</td></tr>';
								
							}
						}
					?>
					</tbody>
					</table>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</main>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
</body>
<script>
		function confirmLogOut() {
			if (confirm("هل أنت متأكد من تسجيل الخروج ؟")) {
				return true;
			} else {
				return false;
			}
		}
		function confDel() {
			if (confirm("هل أنت متأكد من حذف الدرجة ؟")) {
				return true;
			} else {
				return false;
			}
		}
	</script>
	<script>
		var option1 = document.getElementById("grade1");
		var option2 = document.getElementById("grade2");
		var option3 = document.getElementById("grade3");
		var option4 = document.getElementById("grade4");
		var option5 = document.getElementById("grade5");
		var option6 = document.getElementById("grade6");
		var option7 = document.getElementById("grade7");
		var option8 = document.getElementById("grade8");
		var option9 = document.getElementById("grade9");
		var option10 = document.getElementById("grade10");
		var option11 = document.getElementById("grade11");
		var option12 = document.getElementById("grade12");
		var onplan = document.getElementById("onplan");
		var absent = document.getElementById("disp");
		var excused = document.getElementById("disp2");
		var present = document.getElementById("present");
		var homework = document.getElementById("homework");
		var sendbtn = document.getElementById("send_btn");
		
		option1.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6.checked || option12.checked){
				onplan.disabled = true;
			}
		});
		option2.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6.checked || option12.checked){
				onplan.disabled = true;
			}
		});
		option3.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6.checked || option12.checked){
				onplan.disabled = true;
			}
		});
		option4.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6.checked || option12.checked){
				onplan.disabled = true;
			}
		});
		option5.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6.checked || option12.checked){
				onplan.disabled = true;
			}
		});
		option7.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6.checked || option12.checked){
				onplan.disabled = true;
			}
		});
		option8.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6.checked || option12.checked){
				onplan.disabled = true;
			}
		});
		option9.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6.checked || option12.checked){
				onplan.disabled = true;
			}
		});
		option10.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6.checked || option12.checked){
				onplan.disabled = true;
			}
		});
		option11.addEventListener("click", function() {
			onplan.disabled = false;
			if(option6.checked || option12.checked){
				onplan.disabled = true;
			}
		});


		option12.addEventListener("click", function() {
			onplan.disabled = true;
		});
		option6.addEventListener("click", function() {
			onplan.disabled = true;
		});

		absent.addEventListener("click", function() {
			option1.disabled = true;
			option2.disabled = true;
			option3.disabled = true;
			option4.disabled = true;
			option5.disabled = true;
			option6.disabled = true;
			option7.disabled = true;
			option8.disabled = true;
			option9.disabled = true;
			option10.disabled = true;
			onplan.disabled = true;
			homework.style.display = "none";
			sendbtn.style.display = "block";
		});
		

		present.addEventListener("click", function() {
			option1.disabled = false;
			option2.disabled = false;
			option3.disabled = false;
			option4.disabled = false;
			option5.disabled = false;
			option6.disabled = false;
			option7.disabled = false;
			option8.disabled = false;
			option9.disabled = false;
			option10.disabled = false;
			onplan.disabled = false;
			homework.style.display = "flex";
			sendbtn.style.display = "none";
		});
	</script>
		<script>
		window.addEventListener('scroll', function() {
			var header = document.querySelector('thead');
			var table = document.querySelector('table');
			var rect = table.getBoundingClientRect();
			var headerHeight = header.offsetHeight;
			if (rect.top < 0) {
				header.style.top = 0 + 'px';
			} else {
				header.style.top = '0';
			}

			
		});
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
