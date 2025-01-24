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
    echo "
    </head>
    <body><div style=\"margin-right:200px;margin-top:100px;\">
    <center style=\"margin-bottom:20px;background-color:gray;width:50px;height:20px;margin:auto;\">";
    if($_SESSION['staff_job'] == "JOB_02"){
      echo "<a href=\"ring_man.php\" class=\"button\" style=\"margin-top:100px;width:100%;height:100%;color:white;\">
      <span>اغلاق</span>
    </a></center>";
    }else{
      echo "<a href=\"javascript:history.go(-1)\""; echo "class=\"button\" style=\"margin-top:100px;width:100%;height:100%;color:white;\">
      <span>اغلاق</span>
    </a></center>";
    }?>
   <center> <div>
    <?php
      $ring_name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT ring_name FROM ring WHERE ring_id = '".$_GET['ring_id']."'"))['ring_name'];
      echo "<h1>درجات التسميع : ".$ring_name."</h1>";
    ?> 
<table style="direction: rtl;width:70%;">
	<thead>
		<tr>
			<th>اسم الطالب</th>
			<th>خطة الحفظ</th>
      <th>ممتاز</th>
			<th>جيد جدا</th>
			<th>جيد</th>
			<th>إعادة التسميع</th>
			<th>لم يحفظ</th>
			<th>لم يسمع</th>
			<th>أوجه الحفظ</th>
      <th>أول سورة (حفظ)</th>
      <th>آخر سورة (حفظ)</th>
		</tr>
	</thead>
	<tbody>
		<?php
    $totRev = 0;
			if(isset($_POST['day'])){
        $sql = "SELECT students.std_name,students.std_id,
                COUNT(DISTINCT CASE WHEN grade = 'ممتاز' THEN review.id END) AS good_count,
                COUNT(DISTINCT CASE WHEN grade = 'جيد جدا' THEN review.id END) AS average_count,
                COUNT(DISTINCT CASE WHEN grade = 'جيد' THEN review.id END) AS below_average_count,
                COUNT(DISTINCT CASE WHEN grade = 'إعادة التسميع' THEN review.id END) AS accepted_count,
                COUNT(DISTINCT CASE WHEN grade = 'لم يحفظ' THEN review.id END) AS poor_count,
                COUNT(DISTINCT CASE WHEN grade = 'لم يسمع' THEN review.id END) AS not_count,
                SUM(sora_face.face) AS review_count
              FROM review
              INNER JOIN students ON students.std_id = review.std_id
              LEFT JOIN sora_face ON sora_face.rev_id = review.id AND sora_face.type = 'review'
              INNER JOIN std_att ON std_att.rev_id = review.id AND std_att.state = 'حضور'
              WHERE students.ring_id = '".$_GET['ring_id']."' AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE())
              GROUP BY students.std_id
              ORDER BY std_name";

                      
        
      }
      else if(isset($_POST['weak'])){
        $sql = "SELECT students.std_name,students.std_id,
                  COUNT(DISTINCT CASE WHEN grade = 'ممتاز' THEN review.id END) AS good_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد جدا' THEN review.id END) AS average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد' THEN review.id END) AS below_average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'إعادة التسميع' THEN review.id END) AS accepted_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يحفظ' THEN review.id END) AS poor_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يسمع' THEN review.id END) AS not_count,
                  SUM(sora_face.face) AS review_count
                FROM review
                INNER JOIN students ON students.std_id = review.std_id
                LEFT JOIN sora_face ON sora_face.rev_id = review.id AND sora_face.type = 'review'
                INNER JOIN std_att ON std_att.rev_id = review.id AND std_att.state = 'حضور'
                WHERE students.ring_id = '".$_GET['ring_id']."' AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE())
                GROUP BY students.std_id
                ORDER BY std_name";
      }else if(isset($_POST['month'])){
        $sql = "SELECT students.std_name,students.std_id,
                  COUNT(DISTINCT CASE WHEN grade = 'ممتاز' THEN review.id END) AS good_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد جدا' THEN review.id END) AS average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد' THEN review.id END) AS below_average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'إعادة التسميع' THEN review.id END) AS accepted_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يحفظ' THEN review.id END) AS poor_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يسمع' THEN review.id END) AS not_count,
                  SUM(sora_face.face) AS review_count
                FROM review
                INNER JOIN students ON students.std_id = review.std_id
                LEFT JOIN sora_face ON sora_face.rev_id = review.id AND sora_face.type = 'review'
                INNER JOIN std_att ON std_att.rev_id = review.id AND std_att.state = 'حضور'
                WHERE students.ring_id = '".$_GET['ring_id']."' AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())
                GROUP BY students.std_id
                ORDER BY std_name";
      }else{
        
        $sql = "SELECT students.std_name,students.std_id,
                  COUNT(DISTINCT CASE WHEN grade = 'ممتاز' THEN review.id END) AS good_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد جدا' THEN review.id END) AS average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد' THEN review.id END) AS below_average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'إعادة التسميع' THEN review.id END) AS accepted_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يحفظ' THEN review.id END) AS poor_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يسمع' THEN review.id END) AS not_count,
                  SUM(sora_face.face) AS review_count
                FROM review
                INNER JOIN students ON students.std_id = review.std_id
                LEFT JOIN sora_face ON sora_face.rev_id = review.id AND sora_face.type = 'review'
                INNER JOIN std_att ON std_att.rev_id = review.id AND std_att.state = 'حضور'
                WHERE students.ring_id = '".$_GET['ring_id']."' AND review.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'
                GROUP BY students.std_id
                ORDER BY std_name";
      }

			$res = mysqli_query($conn, $sql);

			while($row = mysqli_fetch_assoc($res)){
				echo "<tr><td>".$row['std_name']."</td>";
        $revPlan = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM review_plan WHERE std_id = '".$row['std_id']."'"))['amount'];
				echo "<td>".$revPlan."</td>";
				echo "<td>".$row['good_count']."</td>";
				echo "<td>".$row['average_count']."</td>";
				echo "<td>".$row['below_average_count']."</td>";
				echo "<td>".$row['accepted_count']."</td>";
				echo "<td>".$row['poor_count']."</td>";
				echo "<td>".$row['not_count']."</td>";
				echo "<td>".$row['review_count']."</td>";
        if(isset($_POST['day'])){
          $firstSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE()) AND type = 'review'
                          ORDER BY `std_homework_soras`.`id` LIMIT 1";
          $lastSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'  
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE()) AND type = 'review'
                          ORDER BY `std_homework_soras`.`id` DESC LIMIT 1"; 
        }else if(isset($_POST['weak'])){
          $firstSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()) AND type = 'review'
                          ORDER BY `std_homework_soras`.`id` LIMIT 1";
          $lastSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'  
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()) AND type = 'review'
                          ORDER BY `std_homework_soras`.`id` DESC LIMIT 1"; 
        } else if(isset($_POST['month'])){
          $firstSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()) AND type = 'review'
                          ORDER BY `std_homework_soras`.`id` LIMIT 1";
          $lastSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'  
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()) AND type = 'review'
                          ORDER BY `std_homework_soras`.`id` DESC LIMIT 1"; 
        } else{
          $firstSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'
                          AND date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."' AND type = 'review'
                          ORDER BY `std_homework_soras`.`id` LIMIT 1";
          $lastSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'  
                          AND date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."' AND type = 'review'
                          ORDER BY `std_homework_soras`.`id` DESC LIMIT 1";
        } 
        $ress = mysqli_query($conn,$firstSoraSQL);
        echo "<td>".mysqli_fetch_assoc($ress)['sora']."</td>";

        
        $ress = mysqli_query($conn,$lastSoraSQL);
        echo "<td>".mysqli_fetch_assoc($ress)['sora']."</td>";

				echo "</tr>";
        $totRev += $row['review_count'];
			}
      echo mysqli_error($conn);
		?>					
	</tbody>
</table>
<table style= "direction:rtl;width:70%;">
				<thead>
					<tr>
						<th>اسم الحلقة</th>
						<th>ممتاز</th>
            <th>جيد جدا</th>
            <th>جيد</th>
						<th>إعادة التسميع</th>
						<th>لم يحفظ</th>
						<th>لم يسمع</th>
            <th>أوجه الحفظ</th>
            
					</tr>
				</thead>
				<tbody>
					<?php
          
          if(isset($_POST['day'])){
						 $sql = "SELECT students.ring_id,ring.ring_name ,
                  COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                  COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                  COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                  COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                  COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                  COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
              FROM review 
              INNER JOIN students ON students.std_id = review.std_id
              INNER JOIN ring ON ring.ring_id = students.ring_id 
              WHERE ring.ring_id = '".$_GET['ring_id']."'
              AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE())";
          }else if(isset($_POST['weak'])){
            $sql = "SELECT students.ring_id,ring.ring_name ,
                        COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                        COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                        COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                        COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                        COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                        COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                    FROM review
                    INNER JOIN students ON students.std_id = review.std_id
                    INNER JOIN ring ON ring.ring_id = students.ring_id 
                    WHERE ring.ring_id = '".$_GET['ring_id']."'
                    AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE())";
          }else if(isset($_POST['month'])){
            $sql = "SELECT students.ring_id,ring.ring_name,
                        COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                        COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                        COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                        COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                        COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                        COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                    FROM review 
                    INNER JOIN students ON students.std_id = review.std_id
                    INNER JOIN ring ON ring.ring_id = students.ring_id 
                    WHERE ring.ring_id = '".$_GET['ring_id']."'
                    AND (review.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())";
          }else{
            $sql = "SELECT students.ring_id,ring.ring_name ,
                        COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                        COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                        COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                        COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                        COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                        COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
                    FROM review
                    INNER JOIN students ON students.std_id = review.std_id
                    INNER JOIN ring ON ring.ring_id = students.ring_id 
                    WHERE ring.ring_id = '".$_GET['ring_id']."'
                    AND review.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
          }

						$res = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($res)){
							echo "<tr><td>".$row['ring_name']."</td>";
							echo "<td>".$row['good_count']."</td>";
              echo "<td>".$row['average_count']."</td>";
              echo "<td>".$row['below_average_count']."</td>";
              echo "<td>".$row['accepted_count']."</td>";
              echo "<td>".$row['poor_count']."</td>";
              echo "<td>".$row['not_count']."</td>";
                echo "<td>".$totRev."</td>";
						}
								
					?>					
				</tbody>
				</table>
          </div></center>
          <center><div>
          <h1>درجات المراجعة</h1>


        <table style="direction: rtl;width:70%;">
	<thead>
		<tr>
			<th>اسم الطالب</th>
			<th>خطة المراجعة</th>
      <th>ممتاز</th>
			<th>جيد جدا</th>
			<th>جيد</th>
			<th>إعادة التسميع</th>
			<th>لم يحفظ</th>
			<th>لم يسمع</th>
			<th>أوجه المراجعة</th>
      <th>أول سورة (مراجعة)</th>
      <th>آخر سورة (مراجعة)</th>
		</tr>
	</thead>
	<tbody>
  <?php
    $totRev = 0;
			if(isset($_POST['day'])){
        $sql = "SELECT students.std_name,students.std_id,
                COUNT(DISTINCT CASE WHEN grade = 'ممتاز' THEN recite.id END) AS good_count,
                COUNT(DISTINCT CASE WHEN grade = 'جيد جدا' THEN recite.id END) AS average_count,
                COUNT(DISTINCT CASE WHEN grade = 'جيد' THEN recite.id END) AS below_average_count,
                COUNT(DISTINCT CASE WHEN grade = 'إعادة التسميع' THEN recite.id END) AS accepted_count,
                COUNT(DISTINCT CASE WHEN grade = 'لم يحفظ' THEN recite.id END) AS poor_count,
                COUNT(DISTINCT CASE WHEN grade = 'لم يسمع' THEN recite.id END) AS not_count,
                SUM(sora_face.face) AS recite_count
              FROM recite
              INNER JOIN students ON students.std_id = recite.std_id
              LEFT JOIN sora_face ON sora_face.rev_id = recite.rev_id AND sora_face.type = 'recite'
              INNER JOIN std_att ON std_att.rev_id = recite.rev_id AND std_att.state = 'حضور'
              WHERE students.ring_id = '".$_GET['ring_id']."' AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE())
              GROUP BY students.std_id
              ORDER BY std_name";
      }
      else if(isset($_POST['weak'])){
        $sql = "SELECT students.std_name,students.std_id,
                  COUNT(DISTINCT CASE WHEN grade = 'ممتاز' THEN recite.id END) AS good_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد جدا' THEN recite.id END) AS average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد' THEN recite.id END) AS below_average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'إعادة التسميع' THEN recite.id END) AS accepted_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يحفظ' THEN recite.id END) AS poor_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يسمع' THEN recite.id END) AS not_count,
                  SUM(sora_face.face) AS recite_count
                FROM recite
                INNER JOIN students ON students.std_id = recite.std_id
                LEFT JOIN sora_face ON sora_face.rev_id = recite.rev_id AND sora_face.type = 'recite'
                INNER JOIN std_att ON std_att.rev_id = recite.rev_id AND std_att.state = 'حضور'
                WHERE students.ring_id = '".$_GET['ring_id']."' AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE())
                GROUP BY students.std_id
                ORDER BY std_name";
      }else if(isset($_POST['month'])){
        $sql = "SELECT students.std_name,students.std_id,
                  COUNT(DISTINCT CASE WHEN grade = 'ممتاز' THEN recite.id END) AS good_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد جدا' THEN recite.id END) AS average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد' THEN recite.id END) AS below_average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'إعادة التسميع' THEN recite.id END) AS accepted_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يحفظ' THEN recite.id END) AS poor_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يسمع' THEN recite.id END) AS not_count,
                  SUM(sora_face.face) AS recite_count
                FROM recite
                INNER JOIN students ON students.std_id = recite.std_id
                LEFT JOIN sora_face ON sora_face.rev_id = recite.rev_id AND sora_face.type = 'recite'
                INNER JOIN std_att ON std_att.rev_id = recite.rev_id AND std_att.state = 'حضور'
                WHERE students.ring_id = '".$_GET['ring_id']."' AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())
                GROUP BY students.std_id
                ORDER BY std_name";
      }else{
        
        $sql = "SELECT students.std_name,students.std_id,
                  COUNT(DISTINCT CASE WHEN grade = 'ممتاز' THEN recite.id END) AS good_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد جدا' THEN recite.id END) AS average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'جيد' THEN recite.id END) AS below_average_count,
                  COUNT(DISTINCT CASE WHEN grade = 'إعادة التسميع' THEN recite.id END) AS accepted_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يحفظ' THEN recite.id END) AS poor_count,
                  COUNT(DISTINCT CASE WHEN grade = 'لم يسمع' THEN recite.id END) AS not_count,
                  SUM(sora_face.face) AS recite_count
                FROM recite
                INNER JOIN students ON students.std_id = recite.std_id
                LEFT JOIN sora_face ON sora_face.rev_id = recite.rev_id AND sora_face.type = 'recite'
                INNER JOIN std_att ON std_att.rev_id = recite.rev_id AND std_att.state = 'حضور'
                WHERE students.ring_id = '".$_GET['ring_id']."' AND recite.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'
                GROUP BY students.std_id
                ORDER BY std_name";
      }
      echo mysqli_error($conn);
			$res = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_assoc($res)){
				echo "<tr><td>".$row['std_name']."</td>";
        $recPlan = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM recite_plan WHERE std_id = '".$row['std_id']."'"))['amount'];
				echo "<td>".$recPlan."</td>";
        echo "<td>".$row['good_count']."</td>";
				echo "<td>".$row['average_count']."</td>";
				echo "<td>".$row['below_average_count']."</td>";
				echo "<td>".$row['accepted_count']."</td>";
				echo "<td>".$row['poor_count']."</td>";
				echo "<td>".$row['not_count']."</td>";
				echo "<td>".$row['recite_count']."</td>";
        if(isset($_POST['day'])){
          $firstSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE()) AND type = 'recite'
                          ORDER BY `std_homework_soras`.`id` LIMIT 1";
          $lastSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'  
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE()) AND type = 'recite'
                          ORDER BY `std_homework_soras`.`id` DESC LIMIT 1"; 
        }else if(isset($_POST['weak'])){
          $firstSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()) AND type = 'recite'
                          ORDER BY `std_homework_soras`.`id` LIMIT 1";
          $lastSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'  
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()) AND type = 'recite'
                          ORDER BY `std_homework_soras`.`id` DESC LIMIT 1"; 
        } else if(isset($_POST['month'])){
          $firstSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()) AND type = 'recite'
                          ORDER BY `std_homework_soras`.`id` LIMIT 1";
          $lastSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'  
                          AND (date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()) AND type = 'recite'
                          ORDER BY `std_homework_soras`.`id` DESC LIMIT 1"; 
        } else{
          $firstSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'
                          AND date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."' AND type = 'recite'
                          ORDER BY `std_homework_soras`.`id` LIMIT 1";
          $lastSoraSQL = "SELECT * FROM `std_homework_soras` WHERE std_id = '".$row['std_id']."'  
                          AND date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."' AND type = 'recite'
                          ORDER BY `std_homework_soras`.`id` DESC LIMIT 1";
        } 
                
                  
                $ress = mysqli_query($conn,$firstSoraSQL);
                echo "<td>".mysqli_fetch_assoc($ress)['sora']."</td>";

                $ress = mysqli_query($conn,$lastSoraSQL);
                echo "<td>".mysqli_fetch_assoc($ress)['sora']."</td>";
				echo "</tr>";
        $totRev += $row['recite_count'];
			}
      echo mysqli_error($conn);
		?>					
	</tbody>
</table>

<table style= "direction:rtl;width:70%;">

				<thead>
					<tr>
						<th>اسم الحلقة</th>
						<th>ممتاز</th>
            <th>جيد جدا</th>
            <th>جيد</th>
						<th>إعادة التسميع</th>
						<th>لم يحفظ</th>
						<th>لم يسمع</th>
            <th>أوجه المراجعة</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(isset($_POST['day'])){
              $sql = "SELECT students.ring_id,ring.ring_name ,
                   COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
                   COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
                   COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
                   COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
                   COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
                   COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
               FROM recite 
               INNER JOIN students ON students.std_id = recite.std_id
               INNER JOIN ring ON ring.ring_id = students.ring_id 
               WHERE ring.ring_id = '".$_GET['ring_id']."'
               AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND CURDATE())";
           }else if(isset($_POST['weak'])){
             $sql = "SELECT students.ring_id,ring.ring_name ,
             COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
             COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
             COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
             COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
             COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
             COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
         FROM recite
         INNER JOIN students ON students.std_id = recite.std_id
         INNER JOIN ring ON ring.ring_id = students.ring_id 
         WHERE ring.ring_id = '".$_GET['ring_id']."'
         AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE())";
           }else if(isset($_POST['month'])){
             $sql = "SELECT students.ring_id,ring.ring_name ,
             COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
             COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
             COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
             COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
             COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
             COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
         FROM recite 
         INNER JOIN students ON students.std_id = recite.std_id
         INNER JOIN ring ON ring.ring_id = students.ring_id 
         WHERE ring.ring_id = '".$_GET['ring_id']."'
         AND (recite.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())";
           }else{

             $sql = "SELECT students.ring_id,ring.ring_name ,
             COUNT(CASE WHEN grade = 'ممتاز' THEN 1 END) AS good_count,
             COUNT(CASE WHEN grade = 'جيد جدا' THEN 1 END) AS average_count,
             COUNT(CASE WHEN grade = 'جيد' THEN 1 END) AS below_average_count,
             COUNT(CASE WHEN grade = 'إعادة التسميع' THEN 1 END) AS accepted_count,
             COUNT(CASE WHEN grade = 'لم يحفظ' THEN 1 END) AS poor_count,
             COUNT(CASE WHEN grade = 'لم يسمع' THEN 1 END) AS not_count
         FROM recite
         INNER JOIN students ON students.std_id = recite.std_id
         INNER JOIN ring ON ring.ring_id = students.ring_id 
         WHERE ring.ring_id = '".$_GET['ring_id']."'
         AND recite.date BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."'";
           }

						$res = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($res)){
							echo "<tr><td>".$row['ring_name']."</td>";
							echo "<td>".$row['good_count']."</td>";
              echo "<td>".$row['average_count']."</td>";
              echo "<td>".$row['below_average_count']."</td>";
              echo "<td>".$row['accepted_count']."</td>";
              echo "<td>".$row['poor_count']."</td>";
              echo "<td>".$row['not_count']."</td>";
              echo "<td>".$totRev."</td>";
              echo "<tr></tr>"; 
						}
								
					?>					
				</tbody>
				</table></br>
          </div></center>
    </body>
  </html>
