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
            GROUP BY students.ring_id";

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
	</style>
  <center style="margin-bottom:20px;background-color:gray;width:50px;height:20px;margin:auto;"><a href="std_stat.php" class="button" style="margin-top:100px;width:100%;height:100%;color:white;">
					<span>اغلاق</span>
				</a></center>
  <center><div id= "main">
  
    <div style="margin-right: 30px;">
    <table>
				<thead>
					<tr>
						<th>اسم الحلقة</th>
						<th>الحضور</th>
						<th>الغياب</th>
            <th>الاستئذان</th>
					</tr>
				</thead>
				<tbody>
          <?php
						$sql = "SELECT ring.ring_id ,ring.ring_name,
                      COUNT(CASE WHEN std_att.state = 'حضور' THEN 1 END) AS pre_count,
                      COUNT(CASE WHEN std_att.state = 'غياب' THEN 1 END) AS abs_count,
                      COUNT(CASE WHEN std_att.state = 'مستاذن' THEN 1 END) AS exc_count
                  FROM std_att 
                  INNER JOIN students ON students.std_id = std_att.std_id 
                  INNER JOIN ring ON students.ring_id = ring.ring_id 
                  GROUP BY students.ring_id
								";
            $res = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($res)){
              echo "<tr>";
              echo "<td>".$row['ring_name']."</td>";
              echo "<td>".$row['pre_count']."</td>";
              echo "<td>".$row['abs_count']."</td>";
              echo "<td>".$row['exc_count']."</td>";
              echo "</tr>";
            }
									
				echo "</tbody>
				</table></div>";
        ?>
        <?php
        echo "
      <div id=\"chart_div\" style=\"width: 700px; height: 500px;margin-right: 30px;\"></div>
      </div></center>
    </body>
  </html>
  ";
?>
