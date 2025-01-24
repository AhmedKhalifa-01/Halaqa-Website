<?php
    if($_SESSION['community'] == "4"){
?>
    <a href="../../index.php" class="logo">
        <img src="../../assets/images/nazeem.jpeg" style="width: 80px; height: 80px;"/>
    </a>
    <img id="header_img" src="../../images/header2.png" style="width: 370px; height: 199px;"/>
    <a href="../../index.php" style="margin-left:50px;color:#4c3127"> الصفحة الرئيسية </a>
    <a href="../../logout.php" style="color:#4c3127" onclick="return confirmLogOut();"> تسجيل الخروج </a>
<?php
    }else{
?>
    <a href="../../index.php" class="logo">
        <img src="../../assets/images/LOGO1.png" style="width: 80px; height: 80px;"/>
    </a>
    <img id="header_img" src="../../images/header.png" style="width: 370px; height: 199px;"/>
    <a href="../../index.php" style="margin-left:50px;"> الصفحة الرئيسية </a>
    <a href="../../logout.php" onclick="return confirmLogOut();"> تسجيل الخروج </a>
<?php
    }
?>

