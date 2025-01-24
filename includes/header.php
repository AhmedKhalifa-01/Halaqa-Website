
<header>
				<div id="logo">
					<img src="images/LOGO2.png"/>
				</div>
				<nav>
					<ul>
						<li><a href="index.html" id="homenav">الصفحة الرئيسية</a></li>
						<li><a href="blog.html" id="blognav">فضل القران الكريم</a></li>
						<li><a href="fullwidth.html" id="fullwidthnav">نبذة عن المجمع</a></li>
						<li><a href="contact.html">نبذة عن التجوية</a></li>
						<li><a href="sign-up.html">التسجيل</a></li>
						<?php 
							if(isset($_SESSION['email']) == "") {
						?>
							<li><a href="login.php" id="fullwidthnav">تسجيل الدخول</a></li>	
						<?php 
							} else {
						?>
							<?php 
								if(($_SESSION['staff_job'] == "JOB_01")){	
							?>
								<li><a href="login.php" id="fullwidthnav">لوحة التحكم</a></li>	
							<?php 
								}else if(($_SESSION['staff_job'] == "JOB_02")){
							?>
							<?php 
								}else if(($_SESSION['staff_job'] == "JOB_03")){
							?>
							<?php
								}else{
							?>
							<?php
								}
							?>
							<li><a href="logout.php" id="fullwidthnav">تسجيل الخروج</a></li>
						<?php }?> 

					</ul>
				</nav>
			</header>
			
			