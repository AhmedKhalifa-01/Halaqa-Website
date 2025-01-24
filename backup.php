<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
			if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
				//if($_SESSION['staff_job'] != 'JOB_03'){
					echo "<script>window.location.href='index.php';</script>";
				//}
			}			
		}else{
			echo "<script>window.location.href='index.php';</script>";
		}

/* adding new review plan */

	if(isset($_POST['add_review_plan'])){
		$type = $_POST['r_type'];
		if($type == 'option1'){
			if($_POST['from'] != "" and $_POST['to'] != ""){
				$from = $_POST['from'];
				$to = $_POST['to'];
				$so = $_POST['so'];
				$sql = "DELETE FROM review_plan WHERE std_id = '".$_GET['std_id']."'";
				mysqli_query($conn,$sql);
				$sql = "INSERT INTO `review_plan`(`std_id`, `type`,`a_from`, `a_to`,`sora`) VALUES ('".$_GET['std_id']."','1','".$from."','".$to."','".$so."')";
				if(mysqli_query($conn,$sql)){
					echo "<script>window.location.href='std_ring_plan.php?staff_id=".$_GET['staff_id']."';</script>";
				}
			}else{
				echo "<script>alert('الرجاء إضافة الآيات');</script>";
			}
			
		}
		if($type == 'option2'){
			if(isset($_POST['options'])){
				$options = $_POST['options'];
				$sql = "DELETE FROM std_sorahs WHERE std_id = '".$_GET['std_id']."'";
				mysqli_query($conn,$sql);
				foreach ($options as $option) {
					$sql = "INSERT INTO `std_sorahs`(`std_id`, `sorah`) VALUES ('".$_GET['std_id']."','".$option."')";
					mysqli_query($conn,$sql);
				}
				$sql = "DELETE FROM review_plan WHERE std_id = '".$_GET['std_id']."'";
				mysqli_query($conn,$sql);
				$sql = "INSERT INTO `review_plan`(`std_id`, `type`) VALUES ('".$_GET['std_id']."','2')";
				if(mysqli_query($conn,$sql)){
					echo "<script>window.location.href='std_ring_plan.php?staff_id=".$_GET['staff_id']."';</script>";
				}
			}else{
				echo "<script>alert('الرجاء إضافة السور');</script>";
			}
			
		}
		if($type == 'option3'){
			if($_POST['amount'] != ""){
				$amount = $_POST['amount'];
				$sql = "DELETE FROM review_plan WHERE std_id = '".$_GET['std_id']."'";
				mysqli_query($conn,$sql);
				$sql = "INSERT INTO `review_plan`(`std_id`, `type`,`amount`) VALUES ('".$_GET['std_id']."','3','".$amount."')";
				if(mysqli_query($conn,$sql)){
					echo "<script>window.location.href='std_ring_plan.php?staff_id=".$_GET['staff_id']."';</script>";
				}
			}else{
				echo "<script>alert('الرجاء إضافة الأوجه');</script>";
			}			
		}
	}


?>

<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>إضافة خطة حفظ </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<?php
		if($_SESSION['community'] == "4"){
			echo '<link rel="stylesheet" href="./style2.css?v=8">';
		}else{
			echo '<link rel="stylesheet" href="./style.css?v=8">';
		}
	?>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<!-- partial:index.partial.html -->
<header class="header">
	<div class="header-content responsive-wrapper">
		<div class="header-logo">
			<a href="../../index.php">
				<div>
					<img src="../../images/LOGO2.png" style="width:50px; height:50px;"/>
				</div>
			</a>
		</div>
		<div class="header-navigation">
			<nav class="header-navigation-links">
				<?php
					include('headerlogo.php');
				?>
				
				
				
				
			</nav>
			
		</div>
		
	</div>
</header>
<main class="main">
	<div class="responsive-wrapper">
		

		<div class="content-header">
			<div class="content-header-intro">
				<h2>إضافة خطة حفظ</h2>
				
			</div>
			
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					<?php if($_SESSION['staff_job'] == "JOB_02" or $_SESSION['staff_job'] == "JOB_03"){?>
						<a href="staff_acc.php">الصفحة الشخصية</a>
					<?php } ?>
					<a href="new_acc.php">إضافة حساب</a>
					<?php if($_SESSION['staff_job'] == "JOB_01"){?>
						
					<?php } ?>
					<?php
						$sql = "SELECT * FROM std_exc WHERE seen = 0";
						$sql2 = "SELECT * FROM pending_std WHERE seen = 0"; 
						if((mysqli_num_rows(mysqli_query($conn,$sql)) > 0  or mysqli_num_rows(mysqli_query($conn,$sql2)) > 0) and $_SESSION['staff_job'] == 'JOB_01'){
					?>
						<a href="std_management.php" style="background-color:darkred; color:white;">إدارة الطلاب</a>
					<?php }else{?>
						<a href="std_management.php">إدارة الطلاب</a>
					<?php } ?>
					<?php if($_SESSION['staff_job'] != "JOB_03"){?>
					<a href="staff_management.php">إدارة المعلمين</a>
					<?php } ?>
					<?php if($_SESSION['staff_job'] == "JOB_01"){?>
						<a href="man_man.php">إدارة الإداريين</a>
					<?php } ?>
					<?php
						$sql = "SELECT * FROM pending_parent WHERE seen = 0";
						if(mysqli_num_rows(mysqli_query($conn,$sql)) > 0 and ($_SESSION['staff_job'] == 'JOB_01' and $_SESSION['staff_job'] == 'JOB_02') ){
					?>
					<a href="parents_man.php" style="background-color:darkred; color:white;">إدارة أولياء الأمور</a>
					<?php }else{?>
					<a href="parents_man.php">إدارة أولياء الأمور</a>
					<?php } ?>
					<a href="ring_man.php" class="active">إدارة الحلقات  التسميع</a>
					<a href="tasheeh_man.php">حلقة تصحيح التلاوة</a>
					
					<a href="mton_man.php">إدارة المتون</a>
					<a href="course_man.php" >إدارة الدورات</a>
					<?php if($_SESSION['staff_job'] != "JOB_03"){?>
					<a href="prize_man.php">إدارة الجوائز</a>
					<?php } ?>					
									
				
					<?php
						if($_SESSION['staff_job'] == 'JOB_01'){
							echo '<a href="homepage_man.php">إدارة الصفحة الرئيسية</a>
									<a href="message_details.php" target="_blank">عرض الرسائل</a>';
						}
					?>
					<a href="change_pwd.php">تغيير كلمة المرور</a>
					<?php
						if($_SESSION['staff_job'] == 'JOB_01'){
							echo '<a href="send_msg.php">إرسال رسالة</a>';
							echo '<a href=" visitor_man.php">إدارة الزوار</a>';
						}else{
							echo '<a href="my_msgs.php" target="_blank">عرض رسائلي</a>';
						}
					?>
				</div>
			</div>
			<div class="content-main">
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
				<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/quran.png" /></span>
								<h3>إضافة خطة حفظ</h3>
							</div>
						</div>
						<div class="card-body">
							<form class="login-form" action="new_review_plan.php?std_id=<?php echo $_GET['std_id']; ?>&staff_id=<?php echo $_GET['staff_id']; ?>" method="post">
								<p>اختر نوع الخطة</p>
								<input class = "display" style="width:auto;margin:10px;" type="radio" name="r_type" value="option1" checked> آيات
								<input class = "display" style="width:auto;margin:10px;" type="radio" name="r_type" value="option2"> سور
								<input class = "display" style="width:auto;margin:10px;" type="radio" name="r_type" value="option3"> أوجه	
								<div id = "aya">
								<select style = "padding:10px;width:100%;height:50px;;font-size:18px;" name="so">
										<?php
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
												"114"=>"الناس");
												foreach ($soras as $key => $sora) {
													echo '<option value="'.$sora.'">'.$sora.'</option>';
												}
										?>
									</select>
									<input style="width:100px;margin:10px;" type="text" placeholder = "من آية..." name="from">	
									<input style="width:100px;margin:10px;" type="text" placeholder = "إلى آية..." name="to">
								</div>
								<div id = "sorah" style="display:none">
									<p>اضغط باستمرار على CTRL لاختيار أكثر من سورة</p>
									<select style = "padding:10px;width:100%;height:200px;;font-size:18px;" name="options[]" multiple>
										<?php
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
												"114"=>"الناس");
												foreach ($soras as $key => $sora) {
													echo '<option value="'.$sora.'">'.$sora.'</option>';
												}
										?>
									</select>
								</div>
								<div id="face" style="display:none">
									<input style="width:auto;margin:10px;" type="text" placeholder = "عدد الأوجه" name="amount">
								</div>		
								<button type="submit" name="add_review_plan">إضافة الخطة</button>					
							  </form>
						</div>
					</article>	
									
				</div>
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
		var radios = document.getElementsByClassName('display');
		for (var i = 0; i < radios.length; i++) {
		radios[i].addEventListener('change', function() {
			
			var selectedOption = this.value;
			var option1 = document.getElementById('aya');
			var option2 = document.getElementById('sorah');
			var option3 = document.getElementById('face');
			if (selectedOption === 'option1') {
				option1.style.display = 'block';
				option2.style.display = 'none';
				option3.style.display = 'none';
			} else if (selectedOption === 'option2') {
				option1.style.display = 'none';
				option2.style.display = 'block';
				option3.style.display = 'none';
			} else if (selectedOption === 'option3') {
				option1.style.display = 'none';
				option2.style.display = 'none';
				option3.style.display = 'block';
			}
		});
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
</html>
