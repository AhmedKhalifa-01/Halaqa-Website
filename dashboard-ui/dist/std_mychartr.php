<?php
    session_start();
    include("../../includes/connection.php");
    echo "<html>
    <head>";
    ?>
    <style>
		table {
			border-collapse: collapse;
			max-width: auto;
			margin: 0 auto;
			margin-top: 50px;
		}
		h1{
			margin-top:100px;
			font-size: 32px;
			font-weight: bold;
		}

		thead th {
			background-color: #f2f2f2;
			border: 1px solid #ddd;
			font-weight: bold;
			padding: 10px;
			text-align: right;
		}

		tbody tr {
			border: 1px solid #ddd;
		}

		tbody td {
			font-size:16px;
			font-weight:bold;
			padding: 20px;
			text-align: right;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		td:nth-child(even) {
			background-color: #f2f2f2;
		}
		td:nth-child(even):hover {
			background-color: #f9f9f9;
		}

		td:nth-child(odd) {
			background-color: #fff;
		}
		td:nth-child(odd):hover {
			background-color: #f2f2f2;
		}
	</style>
    <?php 
    echo "
      <script type=\"text/javascript\" src=\"https://www.gstatic.com/charts/loader.js\"></script>";

              $sql = "SELECT students.ring_id,students.std_name ,
                          COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                          COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                          COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                          COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                          COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                          COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                      FROM review 
                      INNER JOIN students ON students.std_id = review.std_id 
                      WHERE students.std_id = '".$_SESSION['email']."'
                      AND review.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";

        $res = mysqli_query($conn,$sql);

        
        echo "
          <script type=\"text/javascript\">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawVisualization);
      
            function drawVisualization() {
              // Some raw data (not necessarily accurate)
              var data = google.visualization.arrayToDataTable([
                ['الحلقات', 'ممتاز', 'جيد جدا', 'جيد', 'إعادة التسميع', 'لم يحفظ', 'لم يسمع'],";
                while($row = mysqli_fetch_assoc($res)){
                    $numOfRev = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(review.std_id) AS rev FROM review INNER JOIN students ON students.std_id = review.std_id INNER JOIN ring ON ring.ring_id = students.ring_id WHERE ring.ring_id = '".$row['ring_id']."' AND review.grade != '-'"))['rev'];
                    if($numOfRev == 0){
                      $numOfRev = 1;
                    }
                    $numOfStd = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(std_id) AS co FROM students WHERE ring_id = '".$row['ring_id']."'"))['co'];
                    echo "['".$row['std_name']."',  ".floatval(($row['good_count']/$numOfRev)*100).",      ".floatval(($row['average_count']/$numOfRev)*100).",         ".floatval(($row['below_average_count']/$numOfRev)*100).",             ".floatval(($row['accepted_count']/$numOfRev)*100).",           ".floatval(($row['poor_count']/$numOfRev)*100).",      ".floatval(($row['not_count']/$numOfRev)*100)."],";
                }
                echo "
              ]);
      
              var options = {
                title : 'نسب درجات الحفظ لكل حلقة',
                vAxis: {title: 'النسبة'},
                hAxis: {title: 'الطالب'},
                seriesType: 'bars',
                series: {5: {type: 'line'}}
              };
      
              var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
              chart.draw(data, options);


              
            }
          </script>";
          
      
      // recite
      $sql = "SELECT students.ring_id,students.std_name ,
                COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
            FROM recite 
            INNER JOIN students ON students.std_id = recite.std_id 
            WHERE students.std_id = '".$_SESSION['email']."' 
            AND recite.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
  $res = mysqli_query($conn,$sql);


  echo "
  <script type=\"text/javascript\">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawVisualization);

  function drawVisualization() {
  // Some raw data (not necessarily accurate)
  var data = google.visualization.arrayToDataTable([
    ['الحلقات', 'ممتاز', 'جيد جدا', 'جيد', 'إعادة التسميع', 'لم يحفظ', 'لم يسمع'],";
    while($row = mysqli_fetch_assoc($res)){
        $numOfRec = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(recite.std_id) AS rev FROM recite INNER JOIN students ON students.std_id = recite.std_id INNER JOIN ring ON ring.ring_id = students.ring_id WHERE ring.ring_id = '".$row['ring_id']."' AND recite.grade != '-'"))['rev'];
        //$numOfRec = 10;
        if($numOfRec == 0){
          $numOfRec = 1;
        }
        $numOfStd = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(std_id) AS co FROM students WHERE ring_id = '".$row['ring_id']."'"))['co'];
        echo "['".$row['std_name']."',  ".floatval(($row['good_count']/$numOfRec)*100).",      ".floatval(($row['average_count']/$numOfRec)*100).",         ".floatval(($row['below_average_count']/$numOfRec)*100).",             ".floatval(($row['accepted_count']/$numOfRec)*100).",           ".floatval(($row['poor_count']/$numOfRec)*100).",      ".floatval(($row['not_count']/$numOfRec)*100)."],";
    }
    echo "
  ]);

  var options = {
    title : 'نسب درجات الحفظ لكل حلقة',
    vAxis: {title: 'النسبة'},
    hAxis: {title: 'الطالب'},
    seriesType: 'bars',
    series: {5: {type: 'line'}}
  };

  var chart = new google.visualization.ComboChart(document.getElementById('chart_dec_div'));
  chart.draw(data, options);



  }
  </script>";
      

    echo "
    </head>
    <body><div style=\"margin-right:200px;margin-top:100px;\">
    <center style=\"margin-bottom:20px;background-color:gray;width:50px;height:20px;margin:auto;\">";
    if($_SESSION['staff_job'] == "JOB_02"){
      echo "<a href=\"ring_man.php\" class=\"button\" style=\"margin-top:100px;width:100%;height:100%;color:white;\">
      <span>اغلاق</span>
    </a></center>";
    }else{
      echo "<a href=\"std_my_stat.php\" class=\"button\" style=\"margin-top:100px;width:100%;height:100%;color:white;\">
      <span>اغلاق</span>
    </a></center>";
    }?>

<table style= "direction:rtl;float:right;">
				<thead>
					<tr>
						<th>اسم الطالب</th>
						<th>ممتاز</th>
            <th>جيد جدا</th>
            <th>جيد</th>
						<th>إعادة التسميع</th>
						<th>لم يحفظ</th>
						<th>لم يسمع</th>

					</tr>
				</thead>
				<tbody>
					<?php
						 $sql = "SELECT students.ring_id,students.std_name ,
             COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
             COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
             COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
             COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
             COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
             COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
         FROM review 
         INNER JOIN students ON students.std_id = review.std_id 
         WHERE students.std_id = '".$_SESSION['email']."'
         AND review.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";

						$res = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($res)){
							echo "<tr><td>".$row['std_name']."</td>";
							echo "<td>".$row['good_count']."</td>";
              echo "<td>".$row['average_count']."</td>";
              echo "<td>".$row['below_average_count']."</td>";
              echo "<td>".$row['accepted_count']."</td>";
              echo "<td>".$row['poor_count']."</td>";
              echo "<td>".$row['not_count']."</td>";
						}
								
					?>					
				</tbody>
				</table>
    <?php 
    echo "
      <div id=\"chart_div\" style=\"width: 600px;float:right; height: 400px;\"></div>";?>
      <table style= "direction:rtl;float:right;">
				<thead>
					<tr>
						<th>اسم الطالب</th>
						<th>ممتاز</th>
            <th>جيد جدا</th>
            <th>جيد</th>
						<th>إعادة التسميع</th>
						<th>لم يحفظ</th>
						<th>لم يسمع</th>

					</tr>
				</thead>
				<tbody>
					<?php
						 $sql = "SELECT students.ring_id,students.std_name ,
                        COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                        COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                        COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                        COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                        COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                        COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                    FROM recite 
                    INNER JOIN students ON students.std_id = recite.std_id 
                    WHERE students.std_id = '".$_SESSION['email']."' 
                    AND recite.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";

						$res = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($res)){
							echo "<tr><td>".$row['std_name']."</td>";
							echo "<td>".$row['good_count']."</td>";
              echo "<td>".$row['average_count']."</td>";
              echo "<td>".$row['below_average_count']."</td>";
              echo "<td>".$row['accepted_count']."</td>";
              echo "<td>".$row['poor_count']."</td>";
              echo "<td>".$row['not_count']."</td>";
						}
								
					?>					
				</tbody>
				</table>
      <?php echo "<div id=\"chart_dec_div\" style=\"width: 600px;float:right; height: 400px;\"></div>";
      ?>
      
          </div>
    </body>
  </html>
