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
      .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        grid-gap: 20px;
        
      }
      footer{
        overflow: hidden;
      }
      .grid-item {
        border: 1px solid #ccc;
        text-align: center;
      }

      h3 {
        margin-top: 0;
        margin-bottom: 10px;
        color:#fff;
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
            <h2>الشيخ الحصري</h2>
          </div>
        </div>
      </div>
      <div class="row event_box" style="direction:rtl">
            <?php
              $folder_path = 'quran/2/';
              $files = scandir($folder_path);
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
            ?>
            <div class="grid">
            <?php 
              $count = 1; 
              $strCount = "1"; 
              foreach ($files as $file) {
              if (!is_dir($file) && pathinfo($file, PATHINFO_EXTENSION) === 'mp3') { ?>
                <div class="grid-item">
                  <h3><?php echo $soras[$strCount]; ?></h3>
                  <div class="audio-container">
                  <audio controls  preload="none">
                    <source src="<?php echo $folder_path . '/' . $file; ?>" type="audio/mpeg">
                    Your browser does not support the audio tag.
                  </audio>
              </div>
                </div>
              <?php
              $count++;
              $strCount = strval($count);
               }
            } ?>
          </div>
      </div>
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