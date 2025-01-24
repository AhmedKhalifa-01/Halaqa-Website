<!-- HTML code -->
<div class="news-container">
  
  <div class="news-item">
    <?php
      $sql = "SELECT * FROM main_posts WHERE post_id = '".$_GET['post_id']."'"; // Replace 1 with the ID of the news item you want to display
      $result = mysqli_query($conn,$sql);
      if($row = mysqli_fetch_assoc($result)){
        echo '
          <img src="dashboard-ui/dist/imgs/'.$row['img'].'" alt="'.$row['title'].'" class="news-image">
          
        ';
      }
    ?>
  </div>
  <div class="news-details">
    <?php
      $sql = "SELECT * FROM main_posts WHERE post_id = '".$_GET['post_id']."'"; // Replace 1 with the ID of the news item you want to display
      $result = mysqli_query($conn,$sql);
      if($row = mysqli_fetch_assoc($result)){
        echo '
          <h1 style = "color:white;">'.$row['title'].'</h1>
          <h4 style = "color:white;margin-top:20px;font-family: sans-serif;">'.$row['secondary_title'].'</h4>
          <div class="news-info">
          <div class="news-date">'.$row['date'].'</div>
            <a href="index.php" class="return-button">الرجوع</a>
          </div>
        ';
      }
    ?>
  </div>
</div>

<!-- CSS code -->
<style>
  @font-face {
		font-family: 'AL-Mateen';
		src: url('dashboard-ui/dist/AL-Mateen.woff') format('woff');
		src: url('dashboard-ui/dist/AL-Mateen.ttf') format('truetype');
		src: url('dashboard-ui/dist/AL-Mateen.woff2') format('woff2');
		src: url('dashboard-ui/dist/AL-Mateen.otf') format('opentype');
	}
  .news-container {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: flex-start;
    direction: rtl;
    background-color:#0000009c;
    border: 1px solid #000;
    padding: 10px;
    border-radius: 25px;
  }
  
  .news-item {
    width: 50%;
    height: 100%; /* increase this value to make the news item taller */
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: flex-start;
  }
  
  .news-image {
    max-width: 100%;
    max-height: 400px; /* increase this value to make the images taller */
    width: auto;
    height: auto;
    margin: 0 auto;
    border-radius: 25px;
  }
  
  .news-details {
    width: 50%;
    padding: 0 20px;
    text-align: right;
  }
  
  .news-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 10px;
    margin-top:50px;
  }
  
  .return-button {
    padding: 10px;
    background-color: #0000009c;
    border: 1px solid #000;
    border-radius: 5px;
    text-decoration: none;
    color:white;
  }
  
  .news-date {
    font-size: 16px;
    font-weight: bold;
    color: white;
    padding: 10px;
    background-color: #0000009c;
    border: 1px solid #000;
    border-radius: 5px;
    text-decoration: none;

  }
  @media only screen and (max-width: 768px) {
    .news-container {
      flex-direction: column;
      align-items: center;
    }
    
    .news-item {
      width: 100%;
      height: 100%; /* increase this value to make the news item taller */
      align-items: center;
    }
    
    .news-details {
      width: 100%;
      padding: 0 20px;
      text-align: center;
    }
    
    .news-info {
      margin-top: 20px;
    }
  }
</style>