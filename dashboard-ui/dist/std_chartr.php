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
              if(isset($_POST['day'])){
                $sql = "SELECT students.ring_id, students.std_name,
                                COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                                COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                                COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                                COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                                COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                                COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                        FROM review 
                        INNER JOIN students ON students.std_id = review.std_id 
                        WHERE students.std_id = '".$_GET['std_id']."'
                        AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE())";
                        ;
              }else if(isset($_POST['week'])){
                $sql ="SELECT students.ring_id, students.std_name,
                              COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                              COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                              COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                              COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                              COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                              COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                      FROM review 
                      INNER JOIN students ON students.std_id = review.std_id 
                      WHERE students.std_id = '".$_GET['std_id']."'
                      AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE())";
              }else if(isset($_POST['month'])){
                $sql = "SELECT students.ring_id, students.std_name,
                                COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                                COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                                COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                                COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                                COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                                COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                        FROM review 
                        INNER JOIN students ON students.std_id = review.std_id 
                        WHERE students.std_id = '".$_GET['std_id']."'
                        AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())";
                        ;
              }else{
                $sql = "SELECT students.ring_id,students.std_name ,
                          COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                          COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                          COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                          COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                          COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                          COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                      FROM review 
                      INNER JOIN students ON students.std_id = review.std_id 
                      WHERE students.std_id = '".$_GET['std_id']."'
                      AND review.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
              }
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
      if(isset($_POST['day'])){
        $sql = "SELECT students.ring_id, students.std_name,
                        COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                        COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                        COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                        COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                        COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                        COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                FROM recite 
                INNER JOIN students ON students.std_id = recite.std_id 
                WHERE students.std_id = '".$_GET['std_id']."'
                AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE())";
                ;
      }else if(isset($_POST['week'])){
        $sql ="SELECT students.ring_id, students.std_name,
                      COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                      COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                      COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                      COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                      COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                      COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
              FROM recite 
              INNER JOIN students ON students.std_id = recite.std_id 
              WHERE students.std_id = '".$_GET['std_id']."'
              AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE())";
      }else if(isset($_POST['month'])){
        $sql = "SELECT students.ring_id, students.std_name,
                        COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                        COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                        COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                        COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                        COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                        COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                FROM recite 
                INNER JOIN students ON students.std_id = recite.std_id 
                WHERE students.std_id = '".$_GET['std_id']."'
                AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())";
                ;
      }else{
        $sql = "SELECT students.ring_id,students.std_name ,
                  COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                  COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                  COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                  COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                  COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                  COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
              FROM recite 
              INNER JOIN students ON students.std_id = recite.std_id 
              WHERE students.std_id = '".$_GET['std_id']."'
              AND recite.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
      }
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
    <body><div style=\"margin-top:100px;\">
    <center style=\"margin-bottom:20px;background-color:gray;width:50px;height:20px;margin:auto;\">";
    if($_SESSION['staff_job'] == "JOB_02"){
      echo "<a href=\"ring_man.php\" class=\"button\" style=\"margin-top:100px;width:100%;height:100%;color:white;\">
      <span>اغلاق</span>
    </a></center>";
    }else if($_SESSION['staff_job'] == "JOB_04"){
      echo "<a href=\"visitor_std_single_stat_select_date.php?type=1&std_id=".$_GET['std_id']."&ring_id=".$_GET['ring_id']."\" class=\"button\" style=\"margin-top:100px;width:100%;height:100%;color:white;\">
      <span>اغلاق</span>
    </a></center>";
    }else{
      echo "<a href=\"std_single_stat_select_date.php?type=1&std_id=".$_GET['std_id']."&ring_id=".$_GET['ring_id']."\" class=\"button\" style=\"margin-top:100px;width:100%;height:100%;color:white;\">
      <span>اغلاق</span>
    </a></center>";
    }?>

    
<center><div>
  <?php
      $std_name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT std_name FROM students WHERE std_id = '".$_GET['std_id']."'"))['std_name'];
      echo "<h1>درجات الحفظ : ".$std_name."</h1>";
    ?> 
<table style= "direction:rtl;">
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
						 if(isset($_POST['day'])){
              $sql = "SELECT students.ring_id, students.std_name,
                              COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                              COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                              COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                              COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                              COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                              COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                      FROM review 
                      INNER JOIN students ON students.std_id = review.std_id 
                      WHERE students.std_id = '".$_GET['std_id']."'
                      AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE())";
            }else if(isset($_POST['week'])){
              $sql ="SELECT students.ring_id, students.std_name,
                            COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                            COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                            COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                            COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                            COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                            COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                    FROM review 
                    INNER JOIN students ON students.std_id = review.std_id 
                    WHERE students.std_id = '".$_GET['std_id']."'
                    AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE())";
            }else if(isset($_POST['month'])){
              $sql = "SELECT students.ring_id, students.std_name,
                              COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                              COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                              COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                              COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                              COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                              COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                      FROM review 
                      INNER JOIN students ON students.std_id = review.std_id 
                      WHERE students.std_id = '".$_GET['std_id']."'
                      AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())";
            }else{
              $sql = "SELECT students.ring_id,students.std_name ,
                        COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                        COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                        COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                        COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                        COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                        COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                    FROM review 
                    INNER JOIN students ON students.std_id = review.std_id 
                    WHERE students.std_id = '".$_GET['std_id']."'
                    AND review.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
            }

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
   // echo "
     // <div id=\"chart_div\" style=\"width: 600px;float:right; height: 400px;\"></div>";?>
      <?php
        $std_name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT std_name FROM students WHERE std_id = '".$_GET['std_id']."'"))['std_name'];
        echo "<h1>درجات المراجعة : ".$std_name."</h1>";
      ?> 
      <table style= "direction:rtl;">
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
						 if(isset($_POST['day'])){
              $sql = "SELECT students.ring_id, students.std_name,
                              COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                              COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                              COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                              COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                              COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                              COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                      FROM recite 
                      INNER JOIN students ON students.std_id = recite.std_id 
                      WHERE students.std_id = '".$_GET['std_id']."'
                      AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE())";
                      ;
            }else if(isset($_POST['week'])){
              $sql ="SELECT students.ring_id, students.std_name,
                            COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                            COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                            COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                            COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                            COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                            COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                    FROM recite 
                    INNER JOIN students ON students.std_id = recite.std_id 
                    WHERE students.std_id = '".$_GET['std_id']."'
                    AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE())";
            }else if(isset($_POST['month'])){
              $sql = "SELECT students.ring_id, students.std_name,
                              COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                              COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                              COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                              COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                              COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                              COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                      FROM recite 
                      INNER JOIN students ON students.std_id = recite.std_id 
                      WHERE students.std_id = '".$_GET['std_id']."'
                      AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())";
                      ;
            }else{
              $sql = "SELECT students.ring_id,students.std_name ,
                        COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                        COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                        COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                        COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                        COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                        COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                    FROM recite 
                    INNER JOIN students ON students.std_id = recite.std_id 
                    WHERE students.std_id = '".$_GET['std_id']."'
                    AND recite.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
            }

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
      <?php //echo "<div id=\"chart_dec_div\" style=\"width: 600px;float:right; height: 400px;\"></div>";
      ?>
      
          </div>
          <center><?php
        $std_name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT std_name FROM students WHERE std_id = '".$_GET['std_id']."'"))['std_name'];
        echo "<h1>احصائيات الأوجه : ".$std_name."</h1>";
      ?></center>
		<center><h3>احصائيات الأوجه : يتم حساب الدرجات الآتية فقط : ممتاز - جيد جدا - جيد.</h3></center>
			<table style="direction:rtl">
				<thead>
					<tr>
						<th>اسم الطالب</th>
						<th>عدد أوجه الحفظ</th>
						<th>عدد أوجه المراجعة</th>
					</tr>
				</thead>
				<tbody>
					<?php
					 if(isset($_POST['day'])){
						$sql = "SELECT SUM(face) as su FROM `sora_face`
								INNER JOIN review ON review.id = sora_face.rev_id
								WHERE review.std_id = '".$_GET['std_id']."' and type = 'review'
								AND sora_face.date = CURDATE()
								AND review.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
					 }else  if(isset($_POST['week'])){
						$sql = "SELECT SUM(face) as su FROM `sora_face`
								INNER JOIN review ON review.id = sora_face.rev_id
								WHERE review.std_id = '".$_GET['std_id']."' and type = 'review'
								AND sora_face.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()
								AND review.grade IN ('ممتاز', 'جيد جدا', 'جيد');";
					 }else  if(isset($_POST['month'])){
						$sql = "SELECT SUM(face) as su FROM `sora_face`
								INNER JOIN review ON review.id = sora_face.rev_id
								WHERE review.std_id = '".$_GET['std_id']."' and type = 'review'
								AND sora_face.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()
								AND review.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
					 }else{
						$sql = "SELECT SUM(face) as su FROM `sora_face`
								INNER JOIN review ON review.id = sora_face.rev_id
								WHERE review.std_id = '".$_GET['std_id']."' and type = 'review'
								AND DATE(sora_face.date) BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'
								AND review.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
					 }
						
						$res = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($res);
						$std_name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT std_name FROM students WHERE std_id = '".$_GET['std_id']."'"))['std_name'];
						echo "<tr><td>".$std_name."</td>";
						echo "<td>".$row['su']."</td>";
						if(isset($_POST['day'])){
							$sql = "SELECT SUM(face) as su FROM `sora_face`
									INNER JOIN recite ON recite.rev_id = sora_face.rev_id
									WHERE recite.std_id = '".$_GET['std_id']."' and type = 'recite'
									AND sora_face.date = CURDATE()
									AND recite.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
						 }else  if(isset($_POST['week'])){
							$sql = "SELECT SUM(face) as su FROM `sora_face`
									INNER JOIN recite ON recite.rev_id = sora_face.rev_id
									WHERE recite.std_id = '".$_GET['std_id']."' and type = 'recite'
									AND sora_face.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()
									AND recite.grade IN ('ممتاز', 'جيد جدا', 'جيد');";
						 }else  if(isset($_POST['month'])){
							$sql = "SELECT SUM(face) as su FROM `sora_face`
									INNER JOIN recite ON recite.rev_id = sora_face.rev_id
									WHERE recite.std_id = '".$_GET['std_id']."' and type = 'recite'
									AND sora_face.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()
									AND recite.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
						 }else{
							$sql = "SELECT SUM(face) as su FROM `sora_face`
									INNER JOIN recite ON recite.rev_id = sora_face.rev_id
									WHERE recite.std_id = '".$_GET['std_id']."' and type = 'recite'
									AND DATE(sora_face.date) BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'
									AND recite.grade IN ('ممتاز', 'جيد جدا', 'جيد')";
						 }
						$res = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($res);
						echo "<td>".$row['su']."</td>";
						echo mysqli_error($conn);
					?>					
				</tbody>
				</table>

        <center><?php
        $std_name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT std_name FROM students WHERE std_id = '".$_GET['std_id']."'"))['std_name'];
        echo "<h1> الحضور - الغياب - الاستئذان : ".$std_name."</h1>";
      ?></center>
        <table style="direction:rtl;">
				<thead>
					<tr>
						<th>اسم الطالب</th>
						<th>الحضور</th>
						<th>الغياب</th>
            <th>الاستئذان</th>
					</tr>
				</thead>
				<tbody>
          <?php
						
            if(isset($_POST['day'])) {
              $sql = "SELECT students.std_id, students.std_name,
                      COUNT(CASE WHEN std_att.state = 'حضور' THEN 1 END) AS pre_count,
                      COUNT(CASE WHEN std_att.state = 'غياب' THEN 1 END) AS abs_count,
                      COUNT(CASE WHEN std_att.state = 'مستاذن' THEN 1 END) AS exc_count
                      FROM std_att INNER JOIN students ON students.std_id = std_att.std_id
                      WHERE students.std_id = '".$_GET['std_id']."'
                      AND std_att.date = CURDATE()";
          } else if(isset($_POST['week'])) {
              $sql = "SELECT students.std_id, students.std_name,
                      COUNT(CASE WHEN std_att.state = 'حضور' THEN 1 END) AS pre_count,
                      COUNT(CASE WHEN std_att.state = 'غياب' THEN 1 END) AS abs_count,
                      COUNT(CASE WHEN std_att.state = 'مستاذن' THEN 1 END) AS exc_count
                      FROM std_att INNER JOIN students ON students.std_id = std_att.std_id
                      WHERE students.std_id = '".$_GET['std_id']."'
                      AND std_att.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()";
          } else if(isset($_POST['month'])) {
              $sql = "SELECT students.std_id, students.std_name,
                      COUNT(CASE WHEN std_att.state = 'حضور' THEN 1 END) AS pre_count,
                      COUNT(CASE WHEN std_att.state = 'غياب' THEN 1 END) AS abs_count,
                      COUNT(CASE WHEN std_att.state = 'مستاذن' THEN 1 END) AS exc_count
                      FROM std_att INNER JOIN students ON students.std_id = std_att.std_id
                      WHERE students.std_id = '".$_GET['std_id']."'
                      AND std_att.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()";
          }else{
              $sql = "SELECT students.std_id, students.std_name,
                          COUNT(CASE WHEN std_att.state = 'حضور' THEN 1 END) AS pre_count,
                          COUNT(CASE WHEN std_att.state = 'غياب' THEN 1 END) AS abs_count,
                          COUNT(CASE WHEN std_att.state = 'مستاذن' THEN 1 END) AS exc_count
                      FROM std_att INNER JOIN students ON students.std_id = std_att.std_id
                      WHERE students.std_id = '".$_GET['std_id']."'
                      AND std_att.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
          }
            $res = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($res)){
              echo "<tr>";
              echo "<td>".$row['std_name']."</td>";
              echo "<td>".$row['pre_count']."</td>";
              echo "<td>".$row['abs_count']."</td>";
              echo "<td>".$row['exc_count']."</td>";
              echo "</tr>";
            }
									
				echo "</tbody>
				</table>";?>
          </div>
          </center>
    </body>
  </html>
