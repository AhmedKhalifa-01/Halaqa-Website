<?php
  session_start();
  include("../../includes/connection.php");
  if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02'){
			//	if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
		//	}
		}			
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<style>
  body{
    margin:auto;
    width: fit-content;
  }
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
  
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
button.print-button {
  width: 100px;
  height: 100px;
}
span.print-icon, span.print-icon::before, span.print-icon::after, button.print-button:hover .print-icon::after {
  border: solid 4px #333;
}
span.print-icon::after {
  border-width: 2px;
}

button.print-button {
  position: relative;
  padding: 0;
  border: 0;
  
  border: none;
  background: transparent;
}

span.print-icon, span.print-icon::before, span.print-icon::after, button.print-button:hover .print-icon::after {
  box-sizing: border-box;
  background-color: #fff;
}

span.print-icon {
  position: relative;
  display: inline-block;  
  padding: 0;
  margin-top: 20%;

  width: 60%;
  height: 35%;
  background: #fff;
  border-radius: 20% 20% 0 0;
}

span.print-icon::before {
  content: "";
  position: absolute;
  bottom: 100%;
  left: 12%;
  right: 12%;
  height: 110%;

  transition: height .2s .15s;
}

span.print-icon::after {
  content: "";
  position: absolute;
  top: 55%;
  left: 12%;
  right: 12%;
  height: 0%;
  background: #fff;
  background-repeat: no-repeat;
  background-size: 70% 90%;
  background-position: center;
  background-image: linear-gradient(
    to top,
    #fff 0, #fff 14%,
    #333 14%, #333 28%,
    #fff 28%, #fff 42%,
    #333 42%, #333 56%,
    #fff 56%, #fff 70%,
    #333 70%, #333 84%,
    #fff 84%, #fff 100%
  );

  transition: height .2s, border-width 0s .2s, width 0s .2s;
}

button.print-button:hover {
  cursor: pointer;
}

button.print-button:hover .print-icon::before {
  height:0px;
  transition: height .2s;
}
button.print-button:hover .print-icon::after {
  height:120%;
  transition: height .2s .15s, border-width 0s .16s;
}

</style>
</head>
<body>

<h1>سجلات الطلاب</h1>
<button class="print-button" onclick="pri()"><span class="print-icon"></span></button>
<script>
  function pri(){
    window.print();
  }
</script>
<table id="customers">
  <tr style="text-align-last: right;"> 
    <th>اسم الطالب</th>
    <th>رقم الهوية</th>
    <th>تاريخ الميلاد</th>
    <th>مكان الميلاد</th>
    <th>المرحلة الدراسية</th>
    <th>الجنسية</th>
    <th>الاجزاء التي تم حفظها</th>
    <th>الاجزاء التي تم اختبارها</th>
  </tr>
  <?php
    $sql = "SELECT * FROM students WHERE state!='مفصول' ORDER BY std_name";
    $res = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($res)){
      echo "
        <tr>
          <td>".$row['std_name']."</td>
          <td>".$row['std_id_num']."</td>
          <td>".$row['std_birth_date']."</td>
          <td>".$row['std_birth_loc']."</td>
          <td>".$row['std_lvl']."</td>
          <td>".$row['std_nat']."</td>
          <td>".$row['std_v_mem']."</td>
          <td>".$row['std_tested']."</td>
        </tr>
      ";
    }
  ?>
</table>

</body>
</html>