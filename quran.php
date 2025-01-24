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
    .card-link {
      display: block;
      text-decoration: none;
      color: inherit;
    }

    .card-link:hover .card {
      box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.4);
    }

    .card-link:active .card {
      transform: scale(0.95);
    }
    .cardo-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
    }

    .cardo {
      flex-basis: calc(33.33% - 20px);
      margin-bottom: 20px;
      background-color: #fff;
      box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
      border-radius: 5px;
      overflow: hidden;
      padding: 20px;
      text-align: center;

    }

    .cardo img {
      width: 100%;
      
      height: auto;
      object-fit: cover;
      margin-bottom: 10px;
    }

    .cardo h3 {
      font-size: 26px;
      margin: 0;
    }

    @media screen and (max-width: 768px) {
      .cardo {
        flex-basis: calc(50% - 20px);
        
      }
    }

    @media screen and (max-width: 480px) {
      .cardo {
        flex-basis: 100%;
      }
    }

  </style>
  <style>
    .flower {
        position: absolute;
        width: 100px;
        height: 133px;
        z-index: -1;
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

  <div class="main-banner" id="top" style="direction: ltr;">
  </div> 

  <section class="section courses" id="courses" style="direction:ltr;" >
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="section-heading">
            <h2>اختر القارئ الذي تريد الاستماع له</h2>
          </div>
        </div>
      </div>
      <div class="cardo-container">
        
          <div class="cardo">
            <a href="play_quran1.php" class="cardo-link">
              <img src="images/22.jpg" alt="cardo 1">
            </a>
            <h3>الشيخ  محمد صديق المنشاوي</h3>
          </div>
        
        
          <div class="cardo">
            <a href="play_quran2.php" class="cardo-link">
              <img src="images/33.jpeg" alt="cardo 2">
            </a>
            <h3>الشيخ الحصري</h3>
          </div>
        
        
          <div class="cardo">
            <a href="play_quran3.php" class="cardo-link">
              <img src="images/11.jpg" alt="cardo 3">
            </a>
            <h3>الشيخ علي الحذيفي</h3>
          </div>
        
      </div>

      <!-- <div class="row event_box" style="direction:rtl">
            <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6 design">
              <div class="events_item">
                <div class="thumb">
                  <a href=""><img src="" alt=""></a>
                </div>
                <div class="down-content">
                  <h4></h4>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6 design">
              <div class="events_item">
                <div class="thumb">
                  <a href="play_quran2.php"><img src="" alt=""></a>
                </div>
                <div class="down-content">
                  <h4></h4>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6 design">
              <div class="events_item">
                <div class="thumb">
                  <a href="play_quran3.php"><img src="" alt=""></a>
                </div>
                <div class="down-content">
                  <h4></h4>
                </div>
              </div>
            </div>
      </div>-->
    </div>
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