<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] == 'parent' and $_SESSION['staff_job'] == 'student'){
			//if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
			//}
		}
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}	
	if(isset($_POST['change_v_mem'])){
		$sql = "UPDATE students SET std_v_mem = '".$_POST['vmem']."' WHERE std_id = '".$_GET['std_id']."'";
		mysqli_query($conn,$sql);
	}
	if(isset($_POST['change_tested'])){
		$sql = "UPDATE students SET std_tested = '".$_POST['tested']."' WHERE std_id = '".$_GET['std_id']."'";
		mysqli_query($conn,$sql);
	}


?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>الحلقات</title>
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
	@media screen and (max-width: 768px) {
		.tc {
			position: fixed;
			
			transform: translate(-0%, -10%);
			width: 340px;
			height: 400px; /* Set a fixed height for the container */
			overflow: auto;
			max-width: 700px;
			}
		table {

		}
	}
		thead th {
			background-color: #f2f2f2;
			border: 1px solid #ddd;
			font-weight: bold;
			text-align: right;
		}

		tbody tr {
			border: 1px solid #ddd;
		}

		tbody td {
			font-size:14px;
			font-weight:bold;
			padding: 10px;
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
		/*input[type="text"],button, input[type="email"], input[type="submit"] {
			width: 50%;
			box-sizing: border-box;
			padding: 10px;
			margin-top: 10px;
			
		}
		input[type="text"]{

		}*/
		table td, th{
			font-size: 16px;
		}
		@media screen and (max-width: 400px) {
			table td, th{
				font-size: 12px;
			}
		}
		table {
			width:320px;;
			border-collapse: collapse;
		}
		
		thead {
			position: sticky;
			top: 0;
			z-index: 1;
		}
		
		tbody td {
			padding-top: 20px; /* Set padding-top to the height of the fixed header */
		}
		#stdname{
			white-space: normal;
			word-wrap: break-word;
			max-width: 150px;
		}
		.adjust{
			width: 100px;
		}
		@media screen and (min-width: 800px) {
			table{
				width: 600px;
			}
			#stdname{
				max-width: 300px;
			}
			tbody td {
				padding-top: 10px; /* Set padding-top to the height of the fixed header */
			}
			tbody td{
				font-size: 16px;
			}
		}
		
	</style>
</head>
<body>
<!-- partial:index.partial.html -->
<header class="header">
	<div class="header-content responsive-wrapper">
	<div class="header-logo">
			<div class="b_con"><button class="l-button">القائمة</button></div>

			<div class="list">
					<a href="visitor_acc.php" class="active">عرض الإحصائيات</a>
			<div style="margin-bottom: 100px;">
					</div>
</div>
		</div>
		<div class="header-navigation">
			<nav class="header-navigation-links">
			<?php
					include('headerlogo.php');
				?>
				
				
			<?php if($_SESSION['staff_job'] == 'JOB_04') {?>
				
				
						</div>
					<?php }else{ ?>
				
				
				<?php } ?>
				
			</nav>
			
		</div>
	</div>
</header>
<main class="main">
	<div class="responsive-wrapper">
		<div class="content-header">
			<div class="content-header-intro">
				<h2>التسميع اليومي</h2>
				
			</div>
			
		</div>
		<div class="content">
			
			<div class="content-panel">
			<div class="vertical-tabs">
					<a href="visitor_acc.php" class="active">عرض الإحصائيات</a>
				</div>
			</div>
			<div class="content-main">
			<center style="margin-bottom:20px;">
			<a href="visitor_ring_man.php" class="button" style="margin-left:10px;width:100px;height:50px;">
					<span>رجوع</span>
				</a></br></br>
				<a href="ring_chartr_select_date.php?ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="margin-right:10px;width:100px;height:50px;">
					<span>عرض احصائيات الدرجات</span>
				</a>
				<a href="ring_ex_ab_select_date.php?ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="margin-right:10px;width:100px;height:50px;">
					<span>عرض احصائيات الحضور</span>
				</a>
			</center>
				<center><table style="">
					<thead style="">
						<tr>
							<th>اسم الطالب</th>
							<th>حالة التسميع اليوم</th>
							<th>التسميع القديم</th>
							<th>الأجزاء المحفوظة</th>
							<th>الأجزاء المختبرة</th>
						</tr>
					<thead>
					<tbody>
						<?php
							$sql = "SELECT students.state,students.std_v_mem,students.std_tested,students.temp_ring_id,students.std_name,students.std_id,students.status, review_plan.amount as rev_am, recite_plan.amount as rec_am
									FROM students
									INNER JOIN ring ON students.temp_ring_id = ring.ring_id
									LEFT JOIN review_plan ON review_plan.std_id = students.std_id
									LEFT JOIN recite_plan ON recite_plan.std_id = students.std_id
									WHERE ring.ring_id = '".$_GET['ring_id']."'
									ORDER BY students.std_name
									";
							$result = mysqli_query($conn,$sql);
							if($result){
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>';
										echo '<td style="white-space: normal;word-wrap: break-word;max-width: 150px;background-color: #2d4650;color:#fff;"><div onclick="location.href=\'std_single_state.php?std_id='.$row['std_id'].'&ring_id='.$_GET['ring_id'].'\'" style="cursor:pointer;"><p style="font-size:14px;">'.$row['std_name'].'</p></div></td>';

										$std_date = mysqli_fetch_assoc(mysqli_query($conn,"SELECT date FROM review WHERE std_id = '".$row['std_id']."' ORDER BY id DESC LIMIT 1;"))['date'];
										if($row['status'] != 'إجازة'){
											if($row['state'] == "متوقف"){
												echo '<td style="background-color: #f70c0c96;color:#fff;">الطالب متوقف</td>';
											}else if($row['state'] == "مفصول"){
												echo '<td style="background-color: orange;color:#fff;">الطالب مفصول</td>';
											}else{
												$canDo = true;
												$sql = "SELECT state FROM std_att WHERE (state = 'غياب' OR state = 'مستاذن') AND date = '".date('Y-m-d')."' AND std_id = '".$row['std_id']."'";
												$resa = mysqli_query($conn,$sql);
												if(mysqli_num_rows($resa) > 0){
													$st = mysqli_fetch_assoc($resa)['state'];
													//if(mysqli_fetch_assoc($resa)['state'] == 'مستاذن' or mysqli_fetch_assoc($resa)['state'] == 'غياب'){
														if($st == 'غياب'){
															echo '<td style= "background-color: #460c11;color:#fff;white-space: normal;word-wrap: break-word;max-width: 150px;">'.$st.'</td>';

														}
														if($st == 'مستاذن'){
															echo '<td style= "background-color: #917d1fb8;color:#fff;white-space: normal;word-wrap: break-word;max-width: 150px;">'.$st.'</td>';

														}
														$canDo = false;
													//}
												}
												$sql = "SELECT COUNT(std_id) AS num FROM review WHERE std_id = '".$row['std_id']."' AND date = '".date('Y-m-d')."'";
												$amountRev = mysqli_fetch_assoc(mysqli_query($conn,$sql))['num'];
												if($canDo){										
													switch ($amountRev) {
														case 0:
															echo '<td style= "background-color: #280950;color:#fff;white-space: normal;word-wrap: break-word;max-width: 150px;"><a href="visitor_ring_details.php?std_id='.$row['std_id'].'&ring_id='.$_GET['ring_id'].'" style="color:#fff;text-decoration:none;">التسميع</a></td>';
															break;
													case 1:
														echo '<td style="white-space: normal;word-wrap: break-word;max-width: 150px;background-color: #34758f;color:#fff;"><div onclick="location.href=\'visitor_ring_details.php?std_id='.$row['std_id'].'&ring_id='.$_GET['ring_id'].'\'" style="cursor:pointer;"><p style="font-size:14px;">تم التسميع، </br> اضغط للتسميع للمرة الثانية</p></div></td>';
														break;
													case 2:
														echo '<td style="white-space: normal;word-wrap: break-word;max-width: 150px;background-color: orange;color:#fff;"><div onclick="location.href=\'visitor_ring_details.php?std_id='.$row['std_id'].'&ring_id='.$_GET['ring_id'].'\'" style="cursor:pointer;"><p style="font-size:14px;">تم التسميع، </br> اضغط للتسميع للمرة الثالثة</p></div></td>';
														break;
													case 3:
														echo '<td style="white-space: normal;word-wrap: break-word;max-width: 150px;background-color: purple;color:#fff;"><div onclick="location.href=\'visitor_ring_details.php?std_id='.$row['std_id'].'&ring_id='.$_GET['ring_id'].'\'" style="cursor:pointer;"><p style="font-size:14px;">تم التسميع، </br> اضغط للتسميع للمرة الرابعة</p></div></td>';
														break;
													case 4:
														echo '<td style="white-space: normal;word-wrap: break-word;max-width: 150px;background-color: blue;color:#fff;"><div onclick="location.href=\'visitor_ring_details.php?std_id='.$row['std_id'].'&ring_id='.$_GET['ring_id'].'\'" style="cursor:pointer;"><p style="font-size:14px;">تم التسميع، </br> اضغط للتسميع للمرة الخامسة</p></div></td>';
														break;
													case 5:
														echo '<td style="white-space: normal;word-wrap: break-word;max-width: 150px;background-color: darkblue;color:#fff;"><div onclick="location.href=\'visitor_ring_details.php?std_id='.$row['std_id'].'&ring_id='.$_GET['ring_id'].'\'" style="cursor:pointer;"><p style="font-size:14px;">تم التسميع، </br> اضغط للتسميع مرة أخيرة</p></div></td>';
														break;
													default:
														echo '<td style="white-space: normal;word-wrap: break-word;max-width: 150px;background-color: darkgreen;color:#fff;"><div><p style="font-size:14px;">تم الانتهاء من التسميع</p></div></td>';
													}
												}


												
											}
										}else{
											
											echo '<td style="background-color: #70b70a;color:#fff;">الطالب في اجازة</td>';
										}
										echo '<td style="white-space: normal;word-wrap: break-word;max-width: 150px;background-color: #742942;color:#fff;">
												<div onclick="location.href=\'old_ring_details.php?std_id='.$row['std_id'].'&ring_id='.$_GET['ring_id'].'\'" style="cursor:pointer;">
													<p style="font-size:14px;">التسميع القديم</p>
												</div>
											</td>'; 
										echo '<td class="adjust">
												<ul>
													<li>
														'.$row['std_v_mem'].'
													</li>
													
												</ul>
											</td>';
											echo '<td  class="adjust">
												<ul>
													<li>
														'.$row['std_tested'].'
													</li>
													
												</ul>
											</td>';
									echo '</tr>';
								}
							}
						?>
					</tbody>
				</table></center>
			</div>
		</div>
	</div>
</main>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
  <script>
	var button = document.querySelector('.l-button');
	var list = document.querySelector('.list');

	button.addEventListener('click', function() {
	list.classList.toggle('show');
	});

	var header = document.querySelector('.header');
	var nav = document.querySelector('.vertical-tabs');

	window.addEventListener('scroll', function() {
	var headerHeight = header.offsetHeight;
	var scrollTop = window.scrollY;

	if (scrollTop > headerHeight) {
		nav.style.top = 90+'px';
	} else {
		nav.style.top = headerHeight - scrollTop +192+ 'px';
	}
	});
	document.addEventListener('click', function(event) {
		if (!list.contains(event.target) && !button.contains(event.target)) {
			list.classList.remove('show');
		}
	});

  </script>
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
		function confirmLogOut() {
			if (confirm("هل أنت متأكد من تسجيل الخروج ؟")) {
				return true;
			} else {
				return false;
			}
		}
	</script>
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
    </script>
	<script>
		// Get all the buttons with the class "vmem_btn"
		const buttons = document.querySelectorAll('.vmem_btn');
		// Loop through each button
		buttons.forEach(button => {
		// Add a click event listener to the button
		button.addEventListener('click', function() {
			// Get the associated div with the class "change_vmem"
			const div = button.parentElement.nextElementSibling;
			// Toggle the display of the div
			div.style.display = div.style.display === "none" ? "block" : "none";
		});
		});
		
		function validateForm(form) {
			// Get all the input fields with the name "vmem" in the form
			const inputs = form.querySelectorAll('[name="vmem"]');
			// Loop through each input field
			for (let i = 0; i < inputs.length; i++) {
				// Check if the input field is empty
				if (inputs[i].value.trim() === "") {
				// Display an error message or do something else to notify the user
				alert("يرجى إدخال قيمة لحقل الأجزاء المحفوظة");
				// Return false to prevent the form from being submitted
				return false;
				}
			}
			// Return true to allow the form to be submitted
			return true;
		}
	</script>
	<script>
		window.addEventListener('scroll', function() {
			var header = document.querySelector('thead');
			var table = document.querySelector('table');
			var rect = table.getBoundingClientRect();
			var headerHeight = header.offsetHeight;
			if (rect.top < 0) {
				header.style.top = 75 + 'px';
			} else {
				header.style.top = '0';
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
    if(isset($_POST['add_sora'])){
        $courses = $_POST["courses"];
        $pages1 = $_POST["pages1"];
        $pages2 = $_POST["pages2"];


        // Loop through the selected courses and page ranges
        for ($i = 0; $i < count($courses); $i++) {
            $course = $conn->real_escape_string($courses[$i]);
            $page1_range = $conn->real_escape_string($pages1[$i]);
			$page2_range = $conn->real_escape_string($pages2[$i]);
			$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`) VALUES ('".$_GET['stud_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','review')";
            $result = mysqli_query($conn,$sql);
			if(!$result){
				echo mysqli_error($conn);
			}
            echo "<script>window.location.href='visitor_ring_details.php?ring_id=".$_GET['ring_id']."';</script>";
        }
    }
	// recite std_homework_soras
	if(isset($_POST['add_sora_rec'])){
        $courses = $_POST["courses"];
        $pages1 = $_POST["pages1"];
        $pages2 = $_POST["pages2"];


        // Loop through the selected courses and page ranges
        for ($i = 0; $i < count($courses); $i++) {
            $course = $conn->real_escape_string($courses[$i]);
            $page1_range = $conn->real_escape_string($pages1[$i]);
			$page2_range = $conn->real_escape_string($pages2[$i]);
			$sql = "INSERT INTO `std_homework_soras`(`std_id`, `sora`, `s_from`, `s_to`, `date`,`type`) VALUES ('".$_GET['stud_id']."','".$course."','".$page1_range."','".$page2_range."','".date('Y-m-d')."','recite')";
            $result = mysqli_query($conn,$sql);
			if(!$result){
				echo mysqli_error($conn);
			}
            echo "<script>window.location.href='visitor_ring_details.php?ring_id=".$_GET['ring_id']."';</script>";
        }
    }
?>