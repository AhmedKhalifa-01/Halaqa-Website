<?php
	include('includes/connection.php');
  session_start(); // Start the session
  //checking for students who are absent for over 7 days in a row and set change their state
  $sql = "UPDATE students
          SET state = 'مفصول'
          WHERE state != 'مستاذن' AND std_id IN (
            SELECT std_id
            FROM std_att
            WHERE state = 'غياب'
            AND date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY std_id
            HAVING COUNT(*) >= 7
          )";
  mysqli_query($conn,$sql);
	if(isset($_POST['submit'])){
		$usr = $_POST['email'];
		$pass = $_POST['pass'];
		$sql = "SELECT * FROM `staff` WHERE staff_id_num = '".$usr."' AND pass = '".$pass."'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		if($row != null){
      $SQL = "SELECT teacher_id FROM teacher_session WHERE teacher_id = '".$row['staff_id']."'";
      if(mysqli_num_rows(mysqli_query($conn,$SQL)) > 0){
        mysqli_query($conn,"DELETE FROM teacher_session WHERE teacher_id = '".$row['staff_id']."'");
      }

      
      
			$_SESSION['email'] = $row['staff_id'];
			$_SESSION['staff_job'] = $row['staff_job'];

      $teacherId = $row['staff_id'];
      $sessionId = session_id();
      date_default_timezone_set('Asia/Riyadh');
    	$currentTime = date('Y-m-d H:i:s');

      $expiryTime = time() + (60 * 60 * 3); // 60 seconds * 60 minutes * 3 hours
      setcookie('email', $row['staff_id'], $expiryTime, '/');
      setcookie('job', $row['staff_job'], $expiryTime, '/');

      $sesexpiryTime = time() + 60 * 3000;
      setcookie('sesId', session_id(), $sesexpiryTime, '/');

      // Insert the session data into the teacher_sessions table
      $sql = "INSERT INTO teacher_session (teacher_id, session_id, last_activity_time) VALUES ('$teacherId', '$sessionId', '$currentTime')
      ON DUPLICATE KEY UPDATE last_activity_time = '$currentTime'";
      mysqli_query($conn, $sql);

      echo "<script>alert('تم تسجيل الدخول');</script>";
       // Redirect to the desired page
       header('Location: index.php');
       exit();
		}else{
			$sql = "SELECT * FROM `students` WHERE std_id_num = '".$usr."' AND pass = '".$pass."'";
			$result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
				$_SESSION['email'] = $row['std_id'];
        $_SESSION['staff_job'] = 'student';
        echo "<script>alert('تم تسجيل الدخول');</script>";
				echo "<script>window.location.href='index.php';</script>";
			}else{
        $sql = "SELECT * FROM `parent` WHERE p_phone = '".$usr."' AND pass = '".$pass."'";
        $result = mysqli_query($conn,$sql);
        
        if(mysqli_num_rows($result) > 0){
          $row = mysqli_fetch_assoc($result);
          $_SESSION['email'] = $row['p_id'];
          $_SESSION['staff_job'] = 'parent';
          echo "<script>alert('تم تسجيل الدخول');</script>";
          echo "<script>window.location.href='index.php';</script>";
        }
      }
		}
		echo "<script>alert('بيانات اعتماد خاطئة');</script>";
	  }
?>
<!DOCTYPE html>
<html lang="ar">

  <head>

  <meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="images/lggo.png">    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>التسجيل في المجمع</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-scholar.css?v=8">
    <link rel="stylesheet" href="assets/css/owl.css">
<!--

TemplateMo 586 Scholar

https://templatemo.com/tm-586-scholar

-->

  </head>

  <?php
  if($_SESSION['community'] == "4"){
    echo '<body style="direction: rtl; background-color:#4c3127;" >';
  }else{
    echo '<body style="direction: rtl;" >';
  }
?>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <?php
    include('includes/header2.php');
  ?>
  <!-- ***** Header Area End ***** -->
  <div class="main-banner" id="top" style="direction: ltr;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-banner">
          <div class="login-page">
            <div class="form">
              <div class="login">
                <div class="login-header">
                  <h3>تسجيل الدخول</h3>
                  <p>الرجاء التأكد من البيانات قبل تسجيل الدخول.</p>
                </div>
              </div>
              <form class="login-form" action="log-in.php" method="post">
                <input type="text" placeholder="اسم المستخدم" name="email"/>
                <input type="password" placeholder="كلمة المرور" name="pass"/>
                <button type="submit" name="submit">تسجيل الدخول</button>
              </form>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/counter.js"></script>
  <script src="assets/js/custom.js"></script>
    
  </body>
</html>