<!-- HTML code -->

<div class="slideshow-container">
	<?php
		include("../../includes/connection.php");

	  $sql = "SELECT * FROM main_posts";
	  $result = mysqli_query($conn,$sql);
	  while($row = mysqli_fetch_assoc($result)){
		echo '
		  <div class="news-item">
			<h2>'.$row['title'].'</h2>
			<p>'.$row['secondary_title'].'</p>
			<img src="imgs/'.$row['img'].'" alt="'.$row['title'].'" class="news-image">
		  </div>
		';
	  }
	?>
	<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
	<a class="next" onclick="plusSlides(1)">&#10095;</a>
  </div>
  
  <style>
  .slideshow-container {
    position: relative;
    width: 80%;
    height: auto;
    display: flex;
    flex-direction: row;
    overflow: hidden;
    margin: 0 auto;
  }
  
  .news-item {
    position: relative;
    width: 10%;
    height: 400px;
    display: none;
    text-align: center;
    transition: all 0.5s ease-in-out;
  }
  
  .news-item.current {
    width: 80%;
    height: 500px;
  }
  
  .news-item.previous, .news-item.next {
    width: 10%;
    height: 300px;
  }
  
  .news-image {
    max-width: 100%;
    max-height: 400px;
    width: auto;
    height: auto;
    margin: 0 auto;
  }
  
  .prev, .next {
    position: absolute;
    top: 50%;
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
      slides[i].classList.remove("current", "previous", "next");
      slides[i].style.display = "none";
    }
    if (slideIndex > 1) {
      slides[slideIndex-2].classList.add("previous");
    } else {
      slides[slides.length-1].classList.add("previous");
    }
    slides[slideIndex-1].classList.add("current");
    if (slideIndex < slides.length) {
      slides[slideIndex].classList.add("next");
    } else {
      slides[0].classList.add("next");
    }
    slides[slideIndex-1].style.display = "block";
  }
</script>
