<?php

	if (isset($_COOKIE['email']) and isset($_COOKIE['job'])) {
		$tid = mysqli_num_rows(mysqli_query($conn,"SELECT teacher_id FROM teacher_session WHERE teacher_id = '".$_COOKIE['email']."'"));
		if($tid > 0){
			$cookieValue1 = $_COOKIE['email'];
			$cookieValue2 = $_COOKIE['job'];
			$_SESSION['email'] = $cookieValue1;
			$_SESSION['staff_job'] = $cookieValue2;
		}else{
			// Logout code
			setcookie('email', '', time() - 3600, '/');
			setcookie('job', '', time() - 3600, '/');
			setcookie('sesId', '', time() - 3600, '/');
		}
	} else {
		
		if(isset($_COOKIE['sesId'])){
			
			$teacher_id = mysqli_fetch_assoc(mysqli_query($conn,"SELECT teacher_id FROM teacher_session WHERE session_id = '".$_COOKIE['sesId']."'"))['teacher_id'];

			$sql = "DELETE FROM teacher_session WHERE session_id = '".$_COOKIE['sesId']."'";
			mysqli_query($conn,$sql);

			$tid = mysqli_num_rows(mysqli_query($conn,"SELECT teacher_id FROM lastlogout WHERE teacher_id = '".$teacher_id."'"));
			if($tid > 0){
				$sql = "UPDATE lastlogout SET last_log_out = '".date('Y-m-d H:i:s')."' WHERE teacher_id = '".$teacher_id."'";
			}else{
				$sql = "INSERT INTO lastlogout (teacher_id, last_log_out)
				VALUES ('".$teacher_id."', '".date('Y-m-d H:i:s')."')";
			}

			mysqli_query($conn,$sql);

			setcookie('sesId', '', time() - 3600, '/');
		}
		if(isset($_SESSION['staff_job'])){
			if($_SESSION['staff_job'] == 'job_03'){
				$_SESSION['email'] = null;
				$_SESSION['staff_job'] = null;
			}
		}
		
	}

?>
<style>
 nav a:hover {
    background-color : #4a4661;
}
</style>
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.php?change=1" class="logo">
						<?php
							if($_SESSION['community'] == "4"){
								echo '<img src="images/nazeem.png" style="width: 100px; height: 100px;"/>';
							}else{
								echo '<img src="images/LOGO2.png" style="width: 80px; height: 80px;"/>';
							}
						?>
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav" style="padding-top: 33px; padding-right: 20px;">
                      <li class="scroll-to-section"><a href="index.php">الصفحة الرئيسية</a></li>
                      <li class="scroll-to-section"><a href="quran.php">القرآن الكريم</a></li>
                      <li class="scroll-to-section"><a href="comunity.php">نبذة عن المجمع</a></li>
                      <li class="scroll-to-section"><a href="tajweeh.php">نبذة عن التجويد</a></li>
                      <li class="scroll-to-section"><a href="contact_us.php">التسجيل في المجمع</a></li>
					  <?php 
                      
							if(!isset($_SESSION['email']) or !isset($_SESSION['staff_job'])) {
						?>
							<li><a href="log-in.php" id="fullwidthnav">تسجيل الدخول</a></li>	
						<?php 
							} else {
						?>
							<?php 
								if(($_SESSION['staff_job'] == "JOB_01")){	
							?>
								<li><a href="dashboard-ui/dist/new_acc.php" class="scroll-to-section">لوحة التحكم</a></li>	
							<?php 
								}else if(($_SESSION['staff_job'] == "JOB_02")){ 
							?>
                            	<li><a href="dashboard-ui/dist/std_management.php" class="scroll-to-section">لوحة التحكم</a></li>	
							<?php 
								}else if(($_SESSION['staff_job'] == "JOB_03")){
							?>
                                <li><a href="dashboard-ui/dist/ring_man.php" class="scroll-to-section">لوحة التحكم</a></li>
                            <?php 
								}else if(($_SESSION['staff_job'] == "JOB_04")){
							?>
                                <li><a href="dashboard-ui/dist/visitor_acc.php" class="scroll-to-section">لوحة التحكم</a></li>	
							<?php
								}else{
                                    if($_SESSION['staff_job'] == 'student'){
                            ?>                            	
                                        <li><a href="dashboard-ui/dist/std_acc.php" class="scroll-to-section">الصفحة الشخصية</a></li>	
                            <?php
                            	}if($_SESSION['staff_job'] == 'parent'){
							?>
							
                                        <li><a href="dashboard-ui/dist/parent_acc.php" class="scroll-to-section">الصفحة الشخصية</a></li>
							<?php
						if($_SESSION['staff_job'] == 'student'){
							$sql = "SELECT std_name as name FROM students WHERE std_id = '".$_SESSION['email']."'";
						}
						if($_SESSION['staff_job'] == 'parent'){
							$sql = "SELECT p_name as name FROM parent WHERE p_name = '".$_SESSION['email']."'";
						}
						echo mysqli_fetch_assoc(mysqli_query($conn,$sql))['name'];
					?></a></li>	
                                    <?php }
							?>
							<?php
								}
							?>
							<li><a href="logout.php" class="scroll-to-section" onclick="return confirmLogOut();">تسجيل الخروج</a></li>
						<?php  }?> 
                  </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
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
		setInterval(function() {
			var xhr = new XMLHttpRequest();
			xhr.open('GET', 'check_activity.php', true);
			xhr.send();
		}, 32000); // 1 minute interval
	</script>
