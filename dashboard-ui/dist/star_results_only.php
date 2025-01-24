<?php
/* checking if an admin is logged in */
	session_start();
	include("../../includes/connection.php");
	if((isset($_SESSION['email'])!= "") && (isset($_SESSION['staff_job']) == "JOB_01")) {
		if($_SESSION['staff_job'] != 'JOB_01' and $_SESSION['staff_job'] != 'JOB_02' and $_SESSION['staff_job'] != 'JOB_04'){
			//if($_SESSION['staff_job'] != 'JOB_03'){
				echo "<script>window.location.href='index.php';</script>";
			//}
		}			
	}else{
		echo "<script>window.location.href='index.php';</script>";
	}
?>
<!DOCTYPE html>
<html lang="ar" >
	<head>
	<meta charset="UTF-8">
	<link rel="icon" sizes="120x120" href="../../images/lggo.png">  <title>عرض النجوم</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
		<?php
		if($_SESSION['community'] == "4"){
			echo '<link rel="stylesheet" href="./style2.css?v=8">';
		}else{
			echo '<link rel="stylesheet" href="./style.css?v=8">';
		}
	?>
	</head>
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

		.pronze:nth-child(even) {
			background-color: #91895f;
			color: #fff;
		}
		.pronze:nth-child(even):hover {
			background-color: #787357;
			color: #fff;
		}

		.pronze:nth-child(odd) {
			background-color: #5c563d;
			color: #fff;
		}
		.pronze:nth-child(odd):hover {
			background-color: #383525;
			color: #fff;
		}

		.gold:nth-child(even) {
			background-color: #cda140;
			color: #fff;
		}
		.gold:nth-child(even):hover {
			background-color: #a98434;
			color: #fff;
		}

		.gold:nth-child(odd) {
			background-color: #e5b500;
			color: #fff;
		}
		.gold:nth-child(odd):hover {
			background-color: #a38101;
			color: #fff;
		}

		.silver:nth-child(even) {
			background-color: #bfb7b7;
		}
		.silver:nth-child(even):hover {
			background-color: #f9f9f9;
		}

		.silver:nth-child(odd) {
			background-color: #d5cccc;
		}
		.silver:nth-child(odd):hover {
			background-color: #f2f2f2;
		}

		table td, th{
			font-size: 16px;
		}
		@media screen and (max-width: 400px) {
			table td, th{
				font-size: 12px;
			}
		}
		table {
			width:320px;;
			border-collapse: collapse;
		}
		
		thead {
			position: sticky;
			top: 0;
			z-index: 1;
		}
		
		tbody td {
			padding-top: 20px; /* Set padding-top to the height of the fixed header */
		}
		#stdname{
			white-space: normal;
			word-wrap: break-word;
			max-width: 150px;
		}
		.adjust{
			width: 100px;
		}
		@media screen and (min-width: 800px) {
			table{
				width: 600px;
			}
			#stdname{
				max-width: 300px;
			}
			tbody td {
				padding-top: 10px; /* Set padding-top to the height of the fixed header */
			}
			tbody td{
				font-size: 16px;
			}
		}
	</style>
<body style="padding-top:0px;">
<!-- partial:index.partial.html -->
<center style="margin-bottom:20px;"><a href="prize_show_result_select_ring.php?prize_id=<?php echo $_GET['prize_id'];?>" class="button" style="margin-top:100px;width:100px;height:50px;">
					<span>اغلاق</span>
				</a></center>
		<center><h1>احصائيات النجوم</h1></center>
		
			<table>
				<thead>
					<tr>
						<th>اسم الطالب</th>
						<th>النجمة البرونزية</th>
						<th>النجمة الفضية</th>
						<th>النجمة الذهبية</th>
					</tr>
				</thead>
				<tbody>
	<?php
		// define conversion rates for stars
		$bronze_to_silver_rate = 3;
		$silver_to_gold_rate = 3;
		
		// retrieve star counts for each student
		$sql = "SELECT 
					s.std_id AS StudentID,
					s.std_name AS StudentName,
					COUNT(CASE WHEN pd.star = 'البرونزية' THEN 1 ELSE NULL END) AS BronzeStars,
					COUNT(CASE WHEN pd.star = 'الفضية' THEN 1 ELSE NULL END) AS SilverStars,
					COUNT(CASE WHEN pd.star = 'الذهبية' THEN 1 ELSE NULL END) AS GoldStars
				FROM students s
				LEFT JOIN prize_participating_students pps ON s.std_id = pps.std_id
				LEFT JOIN prize_details pd ON pps.prize_id = pd.prize_id AND s.std_id = pd.std_id
				WHERE pps.prize_id = '".$_GET['prize_id']."' AND s.ring_id = '".$_GET['ring_id']."'
				GROUP BY s.std_id, s.std_name
				ORDER BY s.std_name";
		$result = mysqli_query($conn, $sql);
		
		if($result && mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				// calculate total star count for the student
				$total_stars = $row['BronzeStars'] + $row['SilverStars'] + $row['GoldStars'];
				
				echo '
					<tr>
						<td class="silver" style="width:400px;">'.$row['StudentName'].'</td>
						<td class="pronze" style="width:600px;">
							<span class="star-count">'.$row['BronzeStars'].'</span>
						</td>
						<td class="silver" style="width:600px;">
							<span class="star-count">'.$row['SilverStars'].'</span>
						</td>
						<td class="gold" style="width:600px;">
							<span class="star-count">'.$row['GoldStars'].'</span>
						</td>
					</tr>
				';
			}
		}
	?>					
</tbody>

<!-- Add jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Add script to handle star count updates -->
<script>
	$(document).ready(function(){
		// define conversion rates for stars
		var bronze_to_silver_rate = 3;
		var silver_to_gold_rate = 3;
		
		// handle + button click
		$('.add-star').click(function(){
			// get student ID and star type
			var student_id = $(this).data('student-id');
			var star_type = $(this).data('star-type');
			
			// get current date
			var date = new Date().toISOString().slice(0, 19).replace('T', ' ');
			
			// update star count on page
			var star_count = parseInt($(this).siblings('.star-count').text());
			star_count++;
			$(this).siblings('.star-count').text(star_count);

			// check if the star count has reached the conversion rate
			var conversion_rate = (star_type == 'bronze') ? bronze_to_silver_rate : silver_to_gold_rate;
			if(star_count % conversion_rate == 0){
				// convert to the next star type
				var silver_count = parseInt($(this).closest('tr').find('.silver .star-count').text());
				var gold_count = parseInt($(this).closest('tr').find('.gold .star-count').text());
				if(star_type == 'البرونزية'){
					$(this).siblings('.star-count').text(0);
					
					if(silver_count >= 2){
						// convert to gold stars and decrement silver stars
						$(this).closest('tr').find('.silver .star-count').text(0);
						gold_count++;
						silver_count = 0;
						$.ajax({
							url: 'insert_star.php',
							method: 'POST',
							data: {student_id: student_id, star_type: 'الذهبية', date: date},
							success: function(response){
								// handle success response
								console.log(response);
							},
							error: function(xhr, status, error){
								// handle error response
								console.log(xhr.responseText);
							}
						});
						// remove silver stars
						$.ajax({
							url: 'remove_star.php',
							method: 'POST',
							data: {student_id: student_id, star_type: 'الفضية', limit: 2},
							success: function(response){
								// handle success response
								console.log(response);
							},
							error: function(xhr, status, error){
								// handle error response
								console.log(xhr.responseText);
							}
						});
						// remove bronze stars
						$.ajax({
							url: 'remove_star.php',
							method: 'POST',
							data: {student_id: student_id, star_type: 'البرونزية', limit: 2},
							success: function(response){
								// handle success response
								console.log(response);
							},
							error: function(xhr, status, error){
								// handle error response
								console.log(xhr.responseText);
							}
						});
					} else {
						silver_count++;
						$.ajax({
							url: 'insert_star.php',
							method: 'POST',
							data: {student_id: student_id, star_type: 'الفضية', date: date},
							success: function(response){
								// handle success response
								console.log(response);
							},
							error: function(xhr, status, error){
								// handle error response
								console.log(xhr.responseText);
							}
						});
						//remove bronze star
						$.ajax({
							url: 'remove_star.php',
							method: 'POST',
							data: {student_id: student_id, star_type: 'البرونزية', limit: 2},
							success: function(response){
								// handle success response
								console.log(response);
							},
							error: function(xhr, status, error){
								// handle error response
								console.log(xhr.responseText);
							}
						});
					}
					$(this).closest('tr').find('.silver .star-count').text(silver_count);
					$(this).closest('tr').find('.gold .star-count').text(gold_count);
				} else if(star_type == 'الفضية'){
					$(this).siblings('.star-count').text(0);
					var gold_count = parseInt($(this).closest('tr').find('.gold .star-count').text());
					//if(gold_count >= 3){
						// convert to gold stars and decrement gold stars
						//$(this).closest('tr').find('.gold .star-count').text(gold_count - 3);
						//$(this).closest('tr').find('.silver .star-count').text(0);
						//addStar(student_id, 'الذهبية', date);
					//} else {
						
					//}
					if(silver_count >= 2){
						gold_count++;
						silver_count = 0;
						$(this).closest('tr').find('.silver .star-count').text(0);
					$(this).closest('tr').find('.gold .star-count').text(gold_count);
						
						$.ajax({
							url: 'insert_star.php',
							method: 'POST',
							data: {student_id: student_id, star_type: 'الذهبية', date: date},
							success: function(response){
								// handle success response
								console.log(response);
							},
							error: function(xhr, status, error){
								// handle error response
								console.log(xhr.responseText);
							}
						});
						// remove silver stars
						$.ajax({
							url: 'remove_star.php',
							method: 'POST',
							data: {student_id: student_id, star_type: 'الفضية', limit: 2},
							success: function(response){
								// handle success response
								console.log(response);
							},
							error: function(xhr, status, error){
								// handle error response
								console.log(xhr.responseText);
							}
						});
						// remove bronze stars
						$.ajax({
							url: 'remove_star.php',
							method: 'POST',
							data: {student_id: student_id, star_type: 'البرونزية', limit: 2},
							success: function(response){
								// handle success response
								console.log(response);
							},
							error: function(xhr, status, error){
								// handle error response
								console.log(xhr.responseText);
							}
						});
					}
				}
				
				// insert the star into the database
				
			} else {
				// insert the star into the database
				$.ajax({
					url: 'insert_star.php',
					method: 'POST',
					data: {student_id: student_id, star_type: star_type, date: date},
					success: function(response){
						// handle success response
						console.log(response);
					},
					error: function(xhr, status, error){
						// handle error response
						console.log(xhr.responseText);
					}
				});
			}
		});
		
		// handle - button click
		$('.remove-star').click(function(){
			// get student ID and star type
			var student_id = $(this).data('student-id');
			var star_type = $(this).data('star-type');
			var date = new Date().toISOString().slice(0, 19).replace('T', ' ');
			
			var star_count = parseInt($(this).siblings('.star-count').text());
			if(star_count == 0){
				var silver_count = parseInt($(this).closest('tr').find('.silver .star-count').text());
				if(silver_count == 0){
					var gold_count = parseInt($(this).closest('tr').find('.gold .star-count').text());
					if(gold_count != 0){
						$.ajax({
							url: 'remove_star.php',
							method: 'POST',
							data: { student_id: student_id, star_type: 'الذهبية', limit: 1 },
							success: function(response) {
								// handle success response from first request
								console.log(response);

								// initiate second AJAX request
								$.ajax({
								url: 'insert_star.php',
								method: 'POST',
								data: { student_id: student_id, star_type: 'الفضية', date: date },
								success: function(response) {
									// handle success response from second request
									console.log(response);

									$.ajax({
										url: 'insert_star.php',
										method: 'POST',
										data: { student_id: student_id, star_type: 'الفضية', date: date },
										success: function(response) {
											// handle success response from second request
											console.log(response);
										},
										error: function(xhr, status, error) {
											// handle error response from second request
											console.log(xhr.responseText);
										}
									});
								},
								error: function(xhr, status, error) {
									// handle error response from second request
									console.log(xhr.responseText);
								}
								});
							},
							error: function(xhr, status, error) {
								// handle error response from first request
								console.log(xhr.responseText);
							}
							});
						silver_count+=2;
						gold_count--;
						$(this).closest('tr').find('.gold .star-count').text(gold_count);
						$(this).closest('tr').find('.silver .star-count').text(silver_count);
					}
				}else{
					$.ajax({
						url: 'remove_star.php',
						method: 'POST',
						data: { student_id: student_id, star_type: 'الفضية', limit: 1 },
						success: function(response) {
							// handle success response from first request
							console.log(response);
							// initiate second AJAX request
							$.ajax({
								url: 'insert_star.php',
								method: 'POST',
								data: { student_id: student_id, star_type: 'البرونزية', date: date },
								success: function(response) {
									// handle success response from second request
									console.log(response);

									$.ajax({
										url: 'insert_star.php',
										method: 'POST',
										data: { student_id: student_id, star_type: 'البرونزية', date: date },
										success: function(response) {
											// handle success response from second request
											console.log(response);
										},
										error: function(xhr, status, error) {
											// handle error response from second request
											console.log(xhr.responseText);
										}
									});
								},
								error: function(xhr, status, error) {
									// handle error response from second request
									console.log(xhr.responseText);
								}
							});
						},
						error: function(xhr, status, error) {
							// handle error response from first request
							console.log(xhr.responseText);
						}
					});
					silver_count--;
					star_count+=2;
					$(this).siblings('.star-count').text(star_count);
					$(this).closest('tr').find('.silver .star-count').text(silver_count);
				}
			}else{
				// delete last row of star_type for student_id in prize_details table
				$.ajax({
					url: 'remove_star.php',
					method: 'POST',
					data: {student_id: student_id, star_type: star_type, limit: 1},
					success: function(response){
						// handle success response
						console.log(response);
					},
					error: function(xhr, status, error){
						// handle error response
						console.log(xhr.responseText);
					}
				});
				// update star count on page
				var star_count = parseInt($(this).siblings('.star-count').text());
				if(star_count > 0){
					star_count--;
					$(this).siblings('.star-count').text(star_count);
				}
			}
			
		});
		
		// function to add a star of a given type
		function addStar(student_id, star_type){

			// insert new row in prize_details table
			$.ajax({
				url: 'insert_star.php',
				method: 'POST',
				data: {student_id: student_id, star_type: star_type, date: date},
				success: function(response){
					// handle success response
					console.log(response);
				},
				error: function(xhr, status, error){
					// handle error response
					console.log(xhr.responseText);
				}
			});
		}
	});
</script>
				</table>

</body>
<script>
		function confirmLogOut() {
			if (confirm("هل أنت متأكد من تسجيل الخروج ؟")) {
				return true;
			} else {
				return false;
			}
		}
	</script>
</html>
