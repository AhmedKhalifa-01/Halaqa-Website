<!-- HTML code -->
<center><div class="title">
    <?php
        if($_SESSION['community'] == 3){
    ?>
    <h1>
      مجمع زيد لتحفيظ القرآن الكريم
    </h1>
    <?php
        }else if($_SESSION['community'] == 4){
    ?>
    <h1>
      مجمع النظيم لتحفيظ القرآن الكريم
    </h1>
    <?php
        }
    ?>

  </div></center>
        
<div class="slideshow-container" style="z-index: 50;">
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
  <?php
    $sql = "SELECT * FROM main_posts";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
      echo '
        <div class="news-item">
          <a href="index.php?post_id='.$row['post_id'].'">
            <img src="dashboard-ui/dist/imgs/'.$row['img'].'" alt="'.$row['title'].'" class="news-image">
          </a>
          <div class="news-details">
            <h2 style="color:#fff;margin:10px;float:right;">'.$row['title'].'</h2>
            <a href="index.php?post_id='.$row['post_id'].'" class="details-btn"><h4>المزيد</h4></a>
          </div>
        </div>
        
      ';
    }
  ?>

</div>

<!-- CSS code -->
<style>

  .slideshow-container {
    position: relative;
    width: 500px;
    height: auto;
    display: flex;
    margin:auto;
    flex-direction: column;
    overflow: hidden;
    background-color:#000;
    margin-top: 100px;
    border-radius: 25px;
  }
  .news-details{
    width:100%;
    height:100%;
 
  }
  .title{
    position: absolute;width: 100%;text-align: center;font-size:60px;"
  }
  .title h1{
    font-size: 50px;
    margin-bottom: 20px;
    color: #fff;
  }
  .title h2{
    font-size: 30px;
    color: #fff;
  }
  .news-item {
    position: relative;
    width: 100%;
     /* increase this value to make the news items taller */
    display: none;
    text-align: center;
  }
  .details-btn {
    display: inline-block;
    padding: 10px 10px;
    background-color: #fff;
    color: #000;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 20px;
    margin-left: 10px;
    float:left;
    margin:10px;
    border-radius: 25px;
  }
  .news-image {
    max-width: 100%;
    max-height: 600px; /* increase this value to make the images taller */
    width: auto;
    height: auto;
    margin: 0 auto;
	  border-radius: 25px;
  }
  
  .prev, .next {
    position: absolute;
    top: 57%;
    transform: translateY(-50%);
    width: auto;
    margin-top: -22px;
    font-size: 30px;
    font-weight: bold;
    color: white;
    padding: 16px;
    cursor: pointer;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
  }
  
  .next {
    right: 0;
  }
  
  .prev:hover, .next:hover {
    background-color: rgba(0, 0, 0, 0.8);
  }
  
  /* CSS code for larger screens */
  @media screen and (max-width: 960px) {
    .slideshow-container {
      position: relative;
      width: 70%;
      height: auto;
      display: flex;
      margin:auto;
      flex-direction: column;
      overflow: hidden;
      background-color:#000;
      margin-top: 100px;
      border-radius: 25px;
    }
		.prev, .next {
			display : none;
		}
		
		.prev {
			left: 0;
		}
		
		.next {
			right: 0;
		}
		
		.prev:hover, .next:hover {
			background-color: rgba(0, 0, 0, 0.8);
		}
    
	}
  @media screen and (max-width: 480px) {
      .title h1{
        font-size: 40px;
        margin-right: 20px;
      }
      .news-details h2{
        font-size: 16px;
      }
      .news-details a{
        width:50%;
        height:70%;
        font-size:6px;
        margin:5px;
        padding: 5px;
        text-align: center;
      }
      
    }
  
  .active {
    display: block;
  }
</style>

<!-- JavaScript code -->
<script>
  var slideIndex = 1;
  showSlides(slideIndex);
  
  function plusSlides(n) {
    showSlides(slideIndex += n);
  }
  
  function currentSlide(n) {
    showSlides(slideIndex = n);
  }
  
  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("news-item");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "block";
  }
  
  setInterval(function() {
    plusSlides(1);
  }, 10000);
</script>

