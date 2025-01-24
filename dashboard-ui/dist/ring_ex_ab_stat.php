<?php
    session_start();
    include("../../includes/connection.php");
    echo "<html>
    <head>";
    echo "
      <script type=\"text/javascript\" src=\"https://www.gstatic.com/charts/loader.js\"></script>";

    $sql = "SELECT ring.ring_id ,ring.ring_name,
                COUNT(CASE WHEN std_att.state = 'حضور' THEN 1 END) AS pre_count,
                COUNT(CASE WHEN std_att.state = 'غياب' THEN 1 END) AS abs_count,
                COUNT(CASE WHEN std_att.state = 'مستاذن' THEN 1 END) AS exc_count
            FROM std_att INNER JOIN students ON students.std_id = std_att.std_id
            INNER JOIN ring ON students.ring_id = ring.ring_id  
            WHERE ring.ring_id = '".$_GET['ring_id']."'
            AND std_att.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
    if($_SESSION['staff_job'] == 'JOB_02'){
      $sql = "SELECT ring.ring_id ,ring.ring_name,
                  COUNT(CASE WHEN std_att.state = 'حضور' THEN 1 END) AS pre_count,
                  COUNT(CASE WHEN std_att.state = 'غياب' THEN 1 END) AS abs_count,
                  COUNT(CASE WHEN std_att.state = 'مستاذن' THEN 1 END) AS exc_count
              FROM std_att INNER JOIN students ON students.std_id = std_att.std_id
              INNER JOIN ring ON students.ring_id = ring.ring_id  
              WHERE ring.ring_man = '".$_SESSION['email']."' AND std_att.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'
              GROUP BY students.ring_id";
    }
    $res = mysqli_query($conn,$sql);

    
    echo "
      <script type=\"text/javascript\">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);
  
        function drawVisualization() {
          // Some raw data (not necessarily accurate)
          var data = google.visualization.arrayToDataTable([
            ['الحلقات', 'حضور', 'غياب', 'مستاذن'],";
            while($row = mysqli_fetch_assoc($res)){
              $numOfRev = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(std_att.std_id) AS rev FROM std_att INNER JOIN students ON students.std_id = std_att.std_id WHERE students.ring_id = '".$row['ring_id']."'"))['rev'];
              if($numOfRev == 0){
                $numOfRev = 1;
              }
              echo "['".$row['ring_name']."',  ".floatval(($row['pre_count']/$numOfRev)*100).",      ".floatval(($row['abs_count']/$numOfRev)*100).",         ".floatval(($row['exc_count']/$numOfRev)*100)."],";
          }
            echo "
          ]);
  
          var options = {
            title : 'نسب درجات الحفظ لكل حلقة',
            vAxis: {title: 'النسبة'},
            hAxis: {title: 'الحلقة'},
            seriesType: 'bars',
            series: {5: {type: 'line'}}
          };
  
          var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
          chart.draw(data, options);


          
        }
      </script>";

      // recite
      
    echo "
    </head>";?>
    <body>
    <style>
		table {
			border-collapse: collapse;
			max-width: auto;
			margin: 0 auto;
		}
		h1{
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
    thead {
			position: sticky;
			top: 0;
			z-index: 1;
		}
    #main{
      width: 100%;
      Height: 100%;
      display:contents;
      direction: rtl;
    }
    @media screen and (min-width: 800px) {
			#main{
        display: contents;
      }
		}
	</style>
  <?php if($_SESSION['staff_job'] == "JOB_02"){ ?>
  <center style="margin-bottom:20px;background-color:gray;width:50px;height:20px;margin:auto;">
  <a href="ring_man.php" class="button" style="margin-top:100px;width:100%;height:100%;color:white;">
					<span>اغلاق</span>
				</a></center>
  <?php }else{ ?>
    <center style="margin-bottom:20px;background-color:gray;width:50px;height:20px;margin:auto;margin-top: 70px;"><a href="ring_det.php?ring_id=<?php echo $_GET['ring_id']; ?>" class="button" style="margin-top:100px;width:100%;height:100%;color:white;">
					<span>اغلاق</span>
				</a></center>
  <?php } ?>
  <center><div id= "main">
  
    <div style="margin-right: 30px;margin-top: 20px;">
    <table>
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
          if(isset($_POST['day'])){
            $sql = "SELECT students.std_name,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'حضور' THEN std_att.id END) AS good_count,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'غياب' THEN std_att.id END) AS abs_count,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'مستاذن' THEN std_att.id END) AS ex_count
                    FROM std_att
                    INNER JOIN students ON students.std_id = std_att.std_id
                    WHERE students.ring_id = '".$_GET['ring_id']."' AND (std_att.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE())
                    GROUP BY students.std_id
                    ORDER BY std_name";

            $sqlTot = "SELECT students.ring_id,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'حضور' THEN std_att.id END) AS good_count,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'غياب' THEN std_att.id END) AS abs_count,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'مستاذن' THEN std_att.id END) AS ex_count
                      FROM std_att 
                      INNER JOIN students ON students.std_id = std_att.std_id
                      INNER JOIN ring ON ring.ring_id = students.ring_id 
                      WHERE ring.ring_id = '".$_GET['ring_id']."'
                      AND (std_att.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE())";
          
          }
          else if(isset($_POST['week'])){
            $sql = "SELECT students.std_name,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'حضور' THEN std_att.id END) AS good_count,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'غياب' THEN std_att.id END) AS abs_count,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'مستاذن' THEN std_att.id END) AS ex_count
                    FROM std_att
                    INNER JOIN students ON students.std_id = std_att.std_id
                    WHERE students.ring_id = '".$_GET['ring_id']."' AND (std_att.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE())
                    GROUP BY students.std_id
                    ORDER BY std_name";

            $sqlTot = "SELECT students.ring_id,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'حضور' THEN std_att.id END) AS good_count,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'غياب' THEN std_att.id END) AS abs_count,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'مستاذن' THEN std_att.id END) AS ex_count
                      FROM std_att 
                      INNER JOIN students ON students.std_id = std_att.std_id
                      INNER JOIN ring ON ring.ring_id = students.ring_id 
                      WHERE ring.ring_id = '".$_GET['ring_id']."'
                      AND (std_att.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE())";
          }
          else if(isset($_POST['month'])){
            $sql = "SELECT students.std_name,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'حضور' THEN std_att.id END) AS good_count,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'غياب' THEN std_att.id END) AS abs_count,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'مستاذن' THEN std_att.id END) AS ex_count
                    FROM std_att
                    INNER JOIN students ON students.std_id = std_att.std_id
                    WHERE students.ring_id = '".$_GET['ring_id']."' AND (std_att.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())
                    GROUP BY students.std_id
                    ORDER BY std_name";

            $sqlTot = "SELECT students.ring_id,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'حضور' THEN std_att.id END) AS good_count,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'غياب' THEN std_att.id END) AS abs_count,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'مستاذن' THEN std_att.id END) AS ex_count
                      FROM std_att 
                      INNER JOIN students ON students.std_id = std_att.std_id
                      INNER JOIN ring ON ring.ring_id = students.ring_id 
                      WHERE ring.ring_id = '".$_GET['ring_id']."'
                      AND (std_att.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())";
          }else{
            $sql = "SELECT students.std_name,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'حضور' THEN std_att.id END) AS good_count,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'غياب' THEN std_att.id END) AS abs_count,
                      COUNT(DISTINCT CASE WHEN std_att.state = 'مستاذن' THEN std_att.id END) AS ex_count
                    FROM std_att
                    INNER JOIN students ON students.std_id = std_att.std_id
                    WHERE students.ring_id = '".$_GET['ring_id']."' AND std_att.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'
                    GROUP BY students.std_id
                    ORDER BY std_name";

            $sqlTot = "SELECT students.ring_id,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'حضور' THEN std_att.id END) AS good_count,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'غياب' THEN std_att.id END) AS abs_count,
                          COUNT(DISTINCT CASE WHEN std_att.state = 'مستاذن' THEN std_att.id END) AS ex_count
                      FROM std_att 
                      INNER JOIN students ON students.std_id = std_att.std_id
                      INNER JOIN ring ON ring.ring_id = students.ring_id 
                      WHERE ring.ring_id = '".$_GET['ring_id']."'
                      AND std_att.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
          }
						/*$sql = "SELECT ring.ring_id ,ring.ring_name,
                      COUNT(CASE WHEN std_att.state = 'حضور' THEN 1 END) AS pre_count,
                      COUNT(CASE WHEN std_att.state = 'غياب' THEN 1 END) AS abs_count,
                      COUNT(CASE WHEN std_att.state = 'مستاذن' THEN 1 END) AS exc_count
                  FROM std_att 
                  INNER JOIN students ON students.std_id = std_att.std_id 
                  INNER JOIN ring ON students.ring_id = ring.ring_id 
                  WHERE ring.ring_id = '".$_GET['ring_id']."'
                  AND std_att.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'
								";*/
            $res = mysqli_query($conn,$sql);
            echo mysqli_error($conn);
            while($row = mysqli_fetch_assoc($res)){
              echo "<tr>";
              echo "<td>".$row['std_name']."</td>";
              echo "<td>".$row['good_count']."</td>";
              echo "<td>".$row['abs_count']."</td>";
              echo "<td>".$row['ex_count']."</td>";
              echo "</tr>";
            }
            echo "</tbody>
				</table></div>";

            
        ?>
        </br>
        <table>
          <thead>
            <tr>
              <th>اجمالي الحضور</th>
              <th>اجمالي الغياب</th>
              <th>اجمالي الاستئذان</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $res = mysqli_query($conn,$sqlTot);
              echo mysqli_error($conn);
              while($row = mysqli_fetch_assoc($res)){
                echo "<tr>";
                echo "<td>".$row['good_count']."</td>";
                echo "<td>".$row['abs_count']."</td>";
                echo "<td>".$row['ex_count']."</td>";
                echo "</tr>";
              }
                    
          echo "</tbody>
          </table></div>";
            ?>
          </tbody>
        </table>
        <?php
        /*echo "
      <div id=\"chart_div\" style=\"width: 700px; height: 500px;margin-right: 30px;\"></div>
      </div></center>";*/
      echo "
    </body>
  </html>
  ";
?>
