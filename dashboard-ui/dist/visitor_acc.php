<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_04'){
			//	if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
		//	}
		}			
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}
?>
			<?php if($_SESSION['staff_job'] == "JOB_03"){echo "<script>window.location.href='../../index.php';</script>";}?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>احصائيات الطلاب</title>
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
			<div class="b_con"><button class="l-button">القائمة</button></div>

			<div class="list">
			<?php if($_SESSION['staff_job'] == 'JOB_04') {?>
						<a href="visitor_acc.php" class="active">عرض الإحصائيات</a>
					<?php } ?>
						
						</br></br>
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
		<div class="main-header">
			<?php
				/*if($_SESSION['staff_job'] == 'student'){
					$sql = "SELECT std_name FROM students WHERE std_id = '".$_SESSION['email']."'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
					echo "<h1>".$row['std_name']."</h1>";
				}
				if($_SESSION['staff_job'] == 'parent'){
					$sql = "SELECT p_name FROM parent WHERE p_id = '".$_SESSION['email']."'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
					echo "<h1>".$row['p_name']."</h1>";
				}
				if($_SESSION['staff_job'] == 'JOB_01' or $_SESSION['staff_job'] == 'JOB_02' or $_SESSION['staff_job'] == 'JOB_03'){
					$sql = "SELECT staff_name FROM staff WHERE staff_id = '".$_SESSION['email']."'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
					echo "<h1>".$row['staff_name']."</h1>";
				}*/
			?>
		</div>

		<div class="content-header">
			<div class="content-header-intro">
				<h2>احصائيات الطلاب</h2>
			</div>
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					<?php if($_SESSION['staff_job'] == 'JOB_04') {?>
						<a href="visitor_acc.php" class="active">عرض الإحصائيات</a>
						</div>
					<?php } ?>
						
			</div>
			<div class="content-main">
				
				<div class="card-grid">
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>الحلقات</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<a href="visitor_ring_man.php">مزيد من التفاصيل</a>
						</div>	
					</article> 
					<!--<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>نسب درجات الحفظ و المراجعة لكل حلقة</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<a href="chartr.php">مزيد من التفاصيل</a>
						</div>	
					</article> 
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>عدد أوجه الحفظ والمراجعة لكل حلقة</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<a href="rev_rec_face.php">مزيد من التفاصيل</a>
						</div>	
					</article> 
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>نسب الغياب و الاستئذان لكل حلقة</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<a href="ex_ab_stat.php">مزيد من التفاصيل</a>
						</div>	
					</article> 
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>احصائيات الدورات</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<a href="cm_stat.php">مزيد من التفاصيل</a>
						</div>	
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>احصائيات الحلقات</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<a href="ring_stat.php">مزيد من التفاصيل</a>
						</div>	
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>احصائيات المتون</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<a href="mton_stat.php">مزيد من التفاصيل</a>
						</div>	
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>تفاصيل الأجزاء المحفوظة</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<a href="verse_mem_record_table.php" target="_blank">مزيد من التفاصيل</a>
						</div>	
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>احصائيات النجوم</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<a href="star_stat.php">مزيد من التفاصيل</a>
						</div>	
					</article>-->
					<!--<article class="card">
						<div class="card-header">
							<div>
								<span><img src="imgs/icons/analysis.png" /></span>
								<h3>احصائيات عامة</h3>
							</div>
						</div>
						<div class="card-body">	
						</div>
						<div class="card-footer">
							<a href="all_stat.php">مزيد من التفاصيل</a>
						</div>	
					</article>	-->		
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
