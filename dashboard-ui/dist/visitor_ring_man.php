<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	
?>
<!DOCTYPE html>
<html lang="ar" >
<head>
<meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>عرض الحلقات</title>
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
				<h2>عرض الحلقات</h2>
				<?php if($_SESSION['staff_job'] == 'JOB_01'){ ?>
				<center><h3 style="font-weight:bold;font-size:24px;">عدد الحلقات في المجمع : <color style="color:#ffffff;"><?php 
														$res = mysqli_query($conn,"SELECT COUNT(ring_id) AS count FROM ring"); 
														echo mysqli_fetch_assoc($res)['count']; 
													?></color>
						</h3>
				</center>
				<?php } ?>
			</div>
			<div class="content-header-actions">
			
			</div>
			
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					<a href="visitor_acc.php" class="active">عرض الإحصائيات</a>
				</div>
			</div>
			<div class="content-main">
				<center style="margin-bottom:20px;"><a href="javascript:history.go(-1)" id="backbtn" class="button" style="width:100px;height:50px;">
					<span>رجوع</span>
				</a></center>
				<div class="card-grid">
				<?php 
							$sql = "SELECT ring.ring_id,ring.ring_name,t.staff_name AS teacher_name, s.staff_name AS supervisor_name, COUNT(students.std_id) AS student_count
									FROM ring
									LEFT JOIN students ON students.temp_ring_id = ring.ring_id
									LEFT JOIN staff t ON t.staff_id = ring.staff_id
									LEFT JOIN staff s ON s.staff_id = ring.ring_man
									
									GROUP BY ring.ring_id
									ORDER BY ring.ring_name";
							
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								$sql = "SELECT * FROM prev
										INNER JOIN privileges ON prev.prev_id = privileges.id
										WHERE prev.staff_id = '".$_SESSION['email']."'
										AND privileges.PREV = '".$row['ring_id']."'";
								if(mysqli_num_rows(mysqli_query($conn,$sql)) == 0)
									continue;
								echo '<article class="card">
										<div class="card-header">
											<div>
												<span><img src="imgs/icons/quran.png" /></span>
												<h3> اسم الحلقة : '.$row['ring_name'].'</h3>
											</div>
										</div>
										<div class="card-body">
										<p style="display: contents;"> اسم الاستاذ : '.$row['teacher_name'].' </p>';

												echo '<p> إداري الحلقة : '.$row['supervisor_name'].'</p>';											
											
											echo '<p> عدد الطلبة في الحلقة : '.$row['student_count'].'</p>											
										</div>
										';
									echo '
										<div class="card-footer">
											<a href="visitor_ring_det.php?ring_id='.$row['ring_id'].'" onclick="return allow('.$row['student_count'].');">التسميع</a>
										</div>';
										echo '
									</article>
								';
							}
						
					?>
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
		function confirmDelete() {
			if (confirm("هل أنت متأكد من حذف هذا الحساب ؟")) {
				return true;
			} else {
				return false;
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
		function confirmDel() {
			if (confirm("هل أنت متأكد من حذف الحلقة ؟")) {
				return true;
			} else {
				return false;
			}
		}
		function allow(count) {
			if (count > 0) {
				return true;
			} else {
				alert("لا يوجد طلبة في الحلقة");
				return false;
			}
		}
		function conf() {
			if (confirm("تسجيل غياب للمعلم ؟")) {
				return true;
			} else {
				return false;
			}
		}
		function confF() {
			if (confirm("تسجيل استئذان للمعلم ؟")) {
				return true;
			} else {
				return false;
			}
		}
	</script>
	</script>
</html>
