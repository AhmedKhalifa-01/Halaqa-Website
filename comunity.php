<?php
	session_start();
  include("includes/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

  <head>

  <meta charset="UTF-8">
  <link rel="icon" sizes="120x120" href="images/lggo.png">    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>نبذة عن المجمع</title>

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
  <style>
		.pdf-container {
			position: relative;
			padding-bottom: 100%;
      margin-top: 20px;
		}
    iframe{
      height: 1200px;
    }
    
	</style>
  </style>
  </head>
  <?php
  if($_SESSION['community'] == "4"){
    echo '<body style="direction: rtl; background-color:#4c3127;min-height: 100%" >';
  }else{
    echo '<body style="direction: rtl;min-height: 100%" >';
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
  </div> 
  <div class="spacer">
  </div>
  <section class="section courses" id="courses" style="direction:ltr;margin-top: -120px;" >
    <center>
      <div class="pdf-container">
      <iframe src="https://drive.google.com/file/d/1ikR15n0_4YxFIVm9Ei1pRkxtwt5OWZqO/preview" width="100%" allow="print"></iframe>      </div>
    </center>
  </section>

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