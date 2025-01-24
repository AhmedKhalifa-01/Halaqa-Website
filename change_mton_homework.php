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
	if(isset($_POST['ch'])){
		mysqli_query($conn,"DELETE FROM mton_homework WHERE std_id = '".$_GET['std_id']."'  AND mh_date = '".$_GET['date']."'");
		// check what type
		$courses = $_POST["courses"];
								$pages1 = $_POST["pages1"];
								$pages2 = $_POST["pages2"];

								// Loop through the selected courses and page ranges
								for ($i = 0; $i < count($courses); $i++) {
									$course = $conn->real_escape_string($courses[$i]);
									$page1_range = $conn->real_escape_string($pages1[$i]);
									$page2_range = $conn->real_escape_string($pages2[$i]);
									$sql = "INSERT INTO `mton_homework`(`std_id`, `sora`, `mh_from`, `mh_to`, `mh_date`,`mh_type`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','review')";
									$result = mysqli_query($conn,$sql);
									if(!$result){
										echo mysqli_error($conn);
									}
									//echo "<script>window.location.href='ring_man.php?';</script>";
									//echo "<script>window.location.href='ring_details.php?ring_id=".$_GET['ring_id']."';</script>";
								}
							

							//if($_POST['cdiv'] == "cay"){
								$ccourses = $_POST["ccourses"];
								$cpages1 = $_POST["cpages1"];
								$cpages2 = $_POST["cpages2"];

								// Loop through the selected courses and page ranges
								for ($i = 0; $i < count($ccourses); $i++) {
									$course = $conn->real_escape_string($ccourses[$i]);
									$page1_range = $conn->real_escape_string($cpages1[$i]);
									$page2_range = $conn->real_escape_string($cpages2[$i]);
									$sql = "INSERT INTO `mton_homework`(`std_id`, `sora`, `mh_from`, `mh_to`, `mh_date`,`mh_type`) VALUES ('".$_GET['std_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','recite')";
									$result = mysqli_query($conn,$sql);
									if(!$result){
										echo mysqli_error($conn);
									}
								}
		echo "<script>window.location.href='change_mton_homework.php?ring_id=".$_GET['ring_id']."&std_id=".$_GET['std_id']."';</script>";
	}
	
?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>درجات</title>
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
		table {
			border-collapse: collapse;
			max-width: auto;
			margin: 0 auto;
			margin-top: 10px;
		}
		h1{
			
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
		@media screen and (min-width: 1200px) {
			article{
				width:500px;			
			}	
			.card-grid {
				grid-template-columns: repeat(2, 0fr);
				margin-right: 400px;
			}
		}
		thead {
			position: sticky;
			top: 0;
			z-index: 1;
		}
	</style>
</head>
<body>
<center style="margin-bottom:20px;"><a href="change_mton_res.php?ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
				<center>
				<?php if(isset($_GET['std_id']) and isset($_GET['date'])){?>
					<form class="login-form" id="myForm" action="change_mton_homework.php?ring_id=<?php echo $_GET['ring_id'];?>&std_id=<?php echo $_GET['std_id'];?>&date=<?php echo $_GET['date'];?>" method="post">

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
									<?php
										$sqlPlan = "SELECT * FROM mton_review_plan WHERE std_id = '".$_GET['std_id']."'";
										$resultPlan = mysqli_query($conn,$sqlPlan);
										if(mysqli_num_rows($resultPlan) > 0){
											$rowPlan = mysqli_fetch_assoc($resultPlan);
											echo '<h1 style="font-size:19px;">خطة الحفظ : '.$rowPlan['amount'].'</h1></br>';
											$sqlPlan = "SELECT * FROM mton_recite_plan WHERE std_id = '".$_GET['std_id']."'";
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
										echo '<h1 style="font-size:19px;">واجب الحفظ القديم : </h1>';
										$sqlDateReview = "SELECT mh_date FROM mton_homework WHERE std_id = '".$_GET['std_id']."' and mh_type='review' ORDER BY mh_date DESC LIMIT 1";
$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDateReview));
$sql = "SELECT * FROM mton_homework WHERE std_id = '".$_GET['std_id']."' and mh_type='review' AND mh_date = '".$rowRDate['mh_date']."'";
$rres = mysqli_query($conn,$sql);
if(mysqli_num_rows($rres) > 0){
    echo '<center><table style="margin-bottom:10px;width:250px;border:1px solid black;"><tr>';
    $count = 0;
    while($rrow = mysqli_fetch_assoc($rres)){
        if($count % 3 == 0 && $count != 0){
            echo '</tr><tr>';
        }
        if($rrow['mh_from'] == '-'){
            echo '<td style="font-size:12px; padding:5px;"> سورة '.$rrow['sora'].'</td>';
        }else{
            echo '<td style="font-size:12px; padding:5px;">'.$rrow['sora'].'</br> '.$rrow['mh_from'].' - '.$rrow['mh_to'].'</td>';
        }
        $count++;
    }
    echo '</tr></table></center>';
}else{
    echo '<h1 style="font-size:18px;">الطالب ليس لديه واجب حفظ</h1></br>';
}
												echo '<h1 style="font-size:19px;">واجب المراجعة القديم : </h1>';
												$sqlDateReview = "SELECT mh_date FROM mton_homework WHERE std_id = '".$_GET['std_id']."' and mh_type='recite' ORDER BY mh_date DESC LIMIT 1";
$rowRDate = mysqli_fetch_assoc(mysqli_query($conn,$sqlDateReview));
$sql = "SELECT * FROM mton_homework WHERE std_id = '".$_GET['std_id']."' and mh_type='recite' AND mh_date = '".$rowRDate['mh_date']."'";
$rres = mysqli_query($conn,$sql);
if(mysqli_num_rows($rres) > 0){
    echo '<center><table style="margin-bottom:10px;width:250px;border:1px solid black;"><tr>';
    $count = 0;
    while($rrow = mysqli_fetch_assoc($rres)){
        if($count % 3 == 0 && $count != 0){
            echo '</tr><tr>';
        }
        if($rrow['mh_from'] == '-'){
            echo '<td style="font-size:12px; padding:5px;width:30px;"> سورة '.$rrow['sora'].'</td>';
        }else{
            echo '<td style="font-size:12px; padding:5px;width:30px;">'.$rrow['sora'].'</br>'.$rrow['mh_from'].' - '.$rrow['mh_to'].'</td>';
        }
        $count++;
    }
    echo '</tr></table></center>';
}else{
    echo '<h1 style="font-size:18px;">الطالب ليس لديه واجب حفظ</h1></br>';
}
									?>
								
							</div>
						</article>

						
						<article class="card" id="homework" style="margin-top:10px">
							<div class="card-header">
								<div>
									<span><img src="imgs/icons/quran.png" /></span>
									<h3>تغيير الواجب</h3>
								</div>
							</div>
							<div class="card-body">
							<h2 style="font-weight:bold;">واجب الحفظ </h2>
								<center>
									<div id="div1" class="cont">
										<div id="course-container" style="margin-bottom:10px;">
											<div class="course-container" id="course1-container">
												<ul>
													<li style="display:inline;">
														<select style="width:40%;height:30px;" name="courses[]" id="course1">
															<option value="" selected></option>
															<?php
																$sql = "SELECT mton_name FROM mton";
																$rees = mysqli_query($conn,$sql);
																if(mysqli_num_rows($rees) > 0){
																	while($roow = mysqli_fetch_assoc($rees)){
																		echo '<option value="'.$roow['mton_name'].'">'.$roow['mton_name'].'</option>';
																	}
																}
															?>
														</select>
													</li>
													<li style="display:inline;"><input style="width:25.2%;height:30px;" type="text" placeholder="من" name="pages1[]" id="pages1" class="page-range"></li>
													<li style="display:inline;"><input style="width:25.2%;height:30px;" placeholder="إلى" type="text" name="pages2[]" id="pages2" class="page-range"></li>
												</ul>
											</div>
										</div>
										<!--<ul>
											<li style="display:inline;"><input style="width:43.3%;font-size:16px;" type="button" onclick="addCourse()" value="إضافة "></li>
											<li style="display:inline;"><input style="width:43.3%;font-size:16px;" type="button" onclick="removeLastCourse()" value="حذف سورة"></li>
										</ul>-->
									</div>
								</center>
								<!--<center><div id="div2" class="cont" style="display:none;">
									<div id="sora" style="margin-bottom:10px;">
										<div class="sora" id="sora1">
											<ul>
												<li style="display:inline;">
													<select style="width:70%;height:80px;margin-bottom:5px;" name="sora[]" id="s1" multiple>
														<option value="" selected></option>
														
													</select>
												</li>
											</ul>
										</div>
									</div>

								</div></center>-->
								<!-- واجب المراجعة -->
								<!-- واجب المراجعة -->
								<!-- واجب المراجعة -->
								<!-- واجب المراجعة -->
								<h2 style="font-weight:bold;">واجب المراجعة </h2>
								<!--<center>
									<label for="cdiv1-radio">آيات</label>
									<input style="width:auto;margin-left:10px;" type="radio" name="cdiv" id="cdiv1-radio" value="cay" onclick="showCDiv('cdiv1')" checked>
										
									<label for="cdiv2-radio">سور</label>
									<input style="width:auto;" type="radio" name="cdiv" id="cdiv2-radio" value="cso" onclick="showCDiv('cdiv2')">
										
								</center>-->
								<center><div id="cdiv1" class="ccont">
									<div id="ccourse-container" style="margin-bottom:10px;">
										<div class="ccourse-container" id="ccourse1-container">
											<ul>
												<li style="display:inline;">
													<select style="width:40%;height:30px;" name="ccourses[]" id="ccourse1">
													<option value="" selected></option>
													<?php
														$sql = "SELECT mton_name FROM mton";
														$rees = mysqli_query($conn,$sql);
														if(mysqli_num_rows($rees) > 0){
															while($roow = mysqli_fetch_assoc($rees)){
																echo '<option value="'.$roow['mton_name'].'">'.$roow['mton_name'].'</option>';
															}
														}
													?>
													</select>
												</li>
												<li style="display:inline;"><input style="width:25.2%;height:30px;" type="text" placeholder="من" name="cpages1[]" id="cpages1" class="page-range"></li>
												<li style="display:inline;"><input style="width:25.2%;height:30px;" placeholder="إلى" type="text" name="cpages2[]" id="cpages2" class="page-range"></li>
											</ul>
										</div>
									</div>
									<!--<ul>
										<li style="display:inline;"><input style="width:43.3%;font-size:16px;" type="button" onclick="addCCourse()" value="إضافة سورة"></li>
										<li style="display:inline;"><input style="width:43.3%;font-size:16px;" type="button" onclick="removeCLastCourse()" value="حذف سورة"></li>
									</ul>-->
								</div></center>
								<!--<center><div id="cdiv2" class="ccont" style="display:none;">
									<div id="csora" style="margin-bottom:10px;">
										<div class="csora" id="csora1">
											<ul>
												<li style="display:inline;">
													<select style="width:70%;height:80px;margin-bottom:5px;" name="csora[]" id="cs1" multiple>
														<option value="" selected></option>
														
													</select>
												</li>
											</ul>
										</div>
									</div>
								</div></center>-->
							</div>
							<div class="card-footer">
								<button type="submit" name="ch">تغيير الواجب</button>
							</div>
						</artice>
						
</div>
</form>
					<?php }else{?>
						<table>
							<thead>
								<tr>
									<th>اسم الطالب</th>
									<th>التاريخ</th>
									<th>اليوم</th>
									<th>واجب الحفظ</th>
									<th>واجب المراجعة</th>
									<th>تغيير</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$sql = "SELECT mh_date FROM mton_homework WHERE std_id = '".$_GET['std_id']."' ORDER BY mh_date DESC LIMIT 1";
									$res = mysqli_query($conn,$sql);
									$date = mysqli_fetch_assoc($res)['mh_date'];
									$sql = "SELECT * FROM students
											INNER JOIN ring ON ring.ring_id = students.temp_ring_id
											WHERE students.temp_ring_id = '".$_GET['ring_id']."'
											AND students.std_id = '".$_GET['std_id']."'
											";
											$result = mysqli_query($conn,$sql);
									if($result){
										while($row = mysqli_fetch_assoc($result)){
											echo '<tr>';
											echo '<td>'.$row['std_name'].'</td>';
											echo '<td>'.$date.'</td>';
											echo '<td>'.getDayOfWeek($date).'</td>';
											$sql = "SELECT COALESCE(mton_homework.sora,'لا توجد سورة') as sor,mh_from,mh_to,mh_date FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND mh_date = '".$date."' and mh_type='review'";
																	$rres = mysqli_query($conn,$sql);
																	if(mysqli_num_rows($rres) > 0){
																		echo '<td><ul>';
																		while($rrow = mysqli_fetch_assoc($rres)){
																			if($rrow['mh_from'] == '-'){
																				echo '<li> سورة '.$rrow['sor'].'</li>';
																			}else{
																				if($rrow['sor'] == ""){
																					echo " - ";
																				}else{
																					echo '<li>'.$rrow['sor'].' من '.$rrow['mh_from'].' إلى '.$rrow['mh_to'].'</li>';
																				}
																			}
																			
																			
																		}
																		echo '</ul></td>';
																	}else{
																		echo '<td>لم يتم تسجيل واجب</td>';
																	}
																	$sql = "SELECT * FROM mton_homework WHERE std_id = '".$_GET['std_id']."' AND mh_date = '".$date."' and mh_type='recite'";
																	$rres = mysqli_query($conn,$sql);
																	if(mysqli_num_rows($rres) > 0){
																		echo '<td><ul>';
																		while($rrow = mysqli_fetch_assoc($rres)){
																			if($rrow['mh_from'] == '-'){
																				echo '<li> سورة '.$rrow['sora'].'</li>';
																			}else{
																				if($rrow['sora'] == ""){
																					echo " - ";
																				}else{
																					echo '<li>'.$rrow['sora'].' من '.$rrow['mh_from'].' إلى '.$rrow['mh_to'].'</li>';
																				}
																			}
																			
																		}
																		echo '</ul></td>';
																	}else{
																		echo '<td>لم يتم تسجيل واجب</td>';
																	}
																	echo '<td>
																			<form class="login-form" action="change_mton_homework.php?ring_id='.$_GET['ring_id'].'&date='.$date.'&std_id='.$row['std_id'].'" method="post">
																					<button type="submit" name="change">تغيير الواجب</button>
																				</form>
																			</td>
																		</tr>';
										}
									}
								?>
							</tbody>
						</table>
							
					<?php }?>
				</div></form>
					</center>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
  <script>
	function addCourse(select) {
		if (select.value !== "") {
			// Create new course row
			var div = document.createElement("div");
			var select_copy = select.cloneNode(true);
			var input1 = document.createElement("input");
			var input2 = document.createElement("input");
			input1.type = "text";
			input1.name = "pages[]";
			input1.placeholder = "From page";
			input2.type = "text";
			input2.name = "pages[]";
			input2.placeholder = "To page";
			div.appendChild(select_copy);
			div.appendChild(input1);
			div.appendChild(input2);
			
			// Add new course row to list
			var course_list = document.getElementById("course-list");
			course_list.appendChild(div);
			
			// Disable selected course in other rows
			var all_selects = document.getElementsByTagName("select");
			for (var i = 0; i < all_selects.length; i++) {
				if (all_selects[i].value === select.value) {
					all_selects[i].disabled = true;
				}
			}
		}
	}
	</script>
	
</body>

	<script>
        function addCourse() {
            // Get the container element
            var container = document.getElementById("course-container");

            // Clone the original course container
            var originalContainer = document.getElementById("course1-container");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            var newInput = newContainer.querySelector("input");
            newInput.value = "";

            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeLastCourse() {
			// Get the container element
			var container = document.getElementById("course-container");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		// adding sora
		function addSora() {
            // Get the container element
            var container = document.getElementById("sora");

            // Clone the original course container
            var originalContainer = document.getElementById("sora1");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeLastSora() {
			// Get the container element
			var container = document.getElementById("sora");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		//showing the type
		function showDiv(divId) {
			var divs = document.querySelectorAll('.cont');
			for (var i = 0; i < divs.length; i++) {
				if (divs[i].id === divId) {
				divs[i].style.display = "block";
				} else {
				divs[i].style.display = "none";
				}
			}
		}




		function addCCourse() {
            // Get the container element
            var container = document.getElementById("ccourse-container");

            // Clone the original course container
            var originalContainer = document.getElementById("ccourse1-container");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            var newInput = newContainer.querySelector("input");
            newInput.value = "";

            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeCLastCourse() {
			// Get the container element
			var container = document.getElementById("ccourse-container");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		// adding sora
		function addCSora() {
            // Get the container element
            var container = document.getElementById("csora");

            // Clone the original course container
            var originalContainer = document.getElementById("csora1");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
		function removeCLastSora() {
			// Get the container element
			var container = document.getElementById("csora");

			if (container.childElementCount > 1) {
				// Get the last course container
				var lastContainer = container.lastElementChild;

				// Remove the last course container
				container.removeChild(lastContainer);
			}
		}
		//showing the type
		function showCDiv(divId) {
			var divs = document.querySelectorAll('.ccont');
			for (var i = 0; i < divs.length; i++) {
				if (divs[i].id === divId) {
				divs[i].style.display = "block";
				} else {
				divs[i].style.display = "none";
				}
			}
		}
    </script>
	<script>
		// Get a reference to the form element
		var form = document.getElementById("myForm");

		// Attach an event listener to the form's submit event
		form.addEventListener("submit", function(event) {
			// Get a reference to the text boxes
			// CODE FOR THE REVIEW HOMEWORK
			// CODE FOR THE REVIEW HOMEWORK

			var rad1 = document.getElementById("div1-radio");
			var rad2 = document.getElementById("div2-radio");
			var disp = document.getElementById("disp");
			var disp2 = document.getElementById("disp2");

			if(rad1.checked){
				var pages1 = document.getElementById("pages1");
				var pages2 = document.getElementById("pages2");
				var course = document.getElementById("course1");
				// Check if the text boxes are empty
				if (pages1.value === "" || pages2.value === "" || course.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						//event.preventDefault();
						//alert("الرجاء اختيار السورة والآيات للحفظ");
					}
				}
			}
			if(rad2.checked){
				var sora = document.getElementById("s1");
				// Check if the text boxes are empty
				if (sora.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						//event.preventDefault();
						//alert("الرجاء اختيار السورة للحفظ");
					}
				}
			}

			// CODE FOR THE RECITE HOMEWORK
			// CODE FOR THE RECITE HOMEWORK

			var rad1 = document.getElementById("cdiv1-radio");
			var rad2 = document.getElementById("cdiv2-radio");

			if(rad1.checked){
				var pages1 = document.getElementById("cpages1");
				var pages2 = document.getElementById("cpages2");
				var course = document.getElementById("ccourse1");
				// Check if the text boxes are empty
				if (pages1.value === "" || pages2.value === "" || course.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						//event.preventDefault();
						//alert("الرجاء اختيار السورة والآيات للمراجعة");
					}
				}
			}
			if(rad2.checked){
				var sora = document.getElementById("cs1");
				// Check if the text boxes are empty
				if (sora.value === "") {
					if(!disp.checked && !disp2.checked){
						// Prevent the form from submitting
						//event.preventDefault();
						//alert("الرجاء اختيار السورة للمراجعة");
					}
				}
			}

			
		});
	</script>
</html>


<?php
    function generateOptions() {
        // List of courses
        $soras = array(
                "1"=>"الفاتحة",
                "2"=>"البقرة",
                "3"=>"آل عمران",
                "4"=>"النساء",
                "5"=>"المائدة",
                "6"=>"الأنعام",
                "7"=>"الأعراف",
                "8"=>"الأنفال",
                "9"=>"التوبة",
                "10"=>"يونس",
                "11"=>"هود",
                "12"=>"يوسف",
                "13"=>"الرعد",
                "14"=>"ابراهيم",
                "15"=>"الحجر",
                "16"=>"النحل",
                "17"=>"الإسراء",
                "18"=>"الكهف",
                "19"=>"مريم",
                "20"=>"طه",
                "21"=>"الأنبياء",
                "22"=>"الحج",
                "23"=>"المؤمنون",
                "24"=>"النور",
                "25"=>"الفرقان",
                "26"=>"الشعراء",
                "27"=>"النمل",
                "28"=>"القصص",
                "29"=>"العنكبوت",
                "30"=>"الروم",
                "31"=>"لقمان",
                "32"=>"السجدة",
                "33"=>"الأحزاب",
                "34"=>"سبإ",
                "35"=>"فاطر",
                "36"=>"يس",
                "37"=>"الصافات",
                "38"=>"ص",
                "39"=>"الزمر",
                "40"=>"غافر",
                "41"=>"فصلت",
                "42"=>"الشورى",
                "43"=>"الزخرف",
                "44"=>"الدخان",
                "45"=>"الجاثية",
                "46"=>"الأحقاف",
                "47"=>"محمد",
                "48"=>"الفتح",
                "49"=>"الحجرات",
                "50"=>"ق",
                "51"=>"الذاريات",
                "52"=>"الطور",
                "53"=>"النجم",
                "54"=>"القمر",
                "55"=>"الرحمن",
                "56"=>"الواقعة",
                "57"=>"الحديد",
                "58"=>"المجادلة",
                "59"=>"الحشر",
                "60"=>"الممتحنة",
                "61"=>"الصف",
                "62"=>"الجمعة",
                "63"=>"المنافقون",
                "64"=>"التغابن",
                "65"=>"الطلاق",
                "66"=>"التحريم",
                "67"=>"الملك",
                "68"=>"القلم",
                "69"=>"الحاقة",
                "70"=>"المعارج",
                "71"=>"نوح",
                "72"=>"الجن",
                "73"=>"المزمل",
                "74"=>"المدثر",
                "75"=>"القيامة",
                "76"=>"الانسان",
                "77"=>"المرسلات",
                "78"=>"النبإ",
                "79"=>"النازعات",
                "80"=>"عبس",
                "81"=>"التكوير",
                "82"=>"الإنفطار",
                "83"=>"المطففين",
                "84"=>"الإنشقاق",
                "85"=>"البروج",
                "86"=>"الطارق",
                "87"=>"الأعلى",
                "88"=>"الغاشية",
                "89"=>"الفجر",
                "90"=>"البلد",
                "91"=>"الشمس",
                "92"=>"الليل",
                "93"=>"الضحى",
                "94"=>"الشرح",
                "95"=>"التين",
                "96"=>"العلق",
                "97"=>"القدر",
                "98"=>"البينة",
                "99"=>"الزلزلة",
                "100"=>"العاديات",
                "101"=>"القارعة",
                "102"=>"التكاثر",
                "103"=>"العصر",
                "104"=>"الهمزة",
                "105"=>"الفيل",
                "106"=>"قريش",
                "107"=>"الماعون",
                "108"=>"الكوثر",
                "109"=>"الكافرون",
                "110"=>"النصر",
                "111"=>"المسد",
                "112"=>"الإخلاص",
                "113"=>"الفلق",
                "114"=>"الناس"
        );
    
        // Loop through the courses and create an option element for each one
        $options = "";
        foreach ($soras as $value => $sora) {
            $options .= "<option value=\"$sora\">$sora</option>";
        }
    
        return $options;
    }
?>
<?php
	function getDayOfWeek($dateString) {
		$myDate = new DateTime($dateString);
		$dayOfWeek = $myDate->format('w');
		$daysOfWeek = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
		return $daysOfWeek[$dayOfWeek];
	  }
?>
