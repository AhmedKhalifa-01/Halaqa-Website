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

    <title>مجمع زيد</title>

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
    .flower {
        position: absolute;
        width: 100px;
        height: 133px;
        z-index: -1;
    }
    .flower-1 {
        top: <?php echo rand(0,1000) ?>px;
        left: <?php echo rand(0,1000) ?>px;
        transform: rotate(<?php echo rand(0,360); ?>deg);
    }
    .flower-2 {
        top: <?php echo rand(0,1000) ?>px;
        left: <?php echo rand(0,1000) ?>px;
        transform: rotate(<?php echo rand(0,360); ?>deg);
    }
    .flower-3 {
        top: <?php echo rand(0,1000) ?>px;
        left: <?php echo rand(0,1000) ?>px;
        transform: rotate(<?php echo rand(0,360); ?>deg);
    }
    .flower-4 {
        top: <?php echo rand(0,1000) ?>px;
        left: <?php echo rand(0,1000) ?>px;
        transform: rotate(<?php echo rand(0,360); ?>deg);
    }
    .flower-5 {
        top: <?php echo rand(0,1000) ?>px;
        left: <?php echo rand(0,1000) ?>px;
        transform: rotate(<?php echo rand(0,360); ?>deg);
    }
    @media (max-width: 800px){
      .flower {
        position: absolute;
        width: 50px;
        height: 83px;
        z-index: -1;
      }
    }
</style>
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
 <!-- <div class="spacer">
  </div>
-->
  <div class="main-banner" id="top" style="direction: ltr;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
        
        
              <?php
                /*$sql = "SELECT * FROM main_posts";
                $result = mysqli_query($conn,$sql);
                while($row = mysqli_fetch_assoc($result)){
                  
                }*/
                
                if(isset($_GET['post_id'])){
                  include('dashboard-ui/dist/main_news_details.php');
                }else{
                  include('dashboard-ui/dist/main_news.php');
                }
                
              ?>
            
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