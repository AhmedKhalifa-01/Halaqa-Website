<!DOCTYPE html>
<html>
<head>
    <title>Course Selection Form</title>
    <style>
        html{
            direction:rtl;
        }
        .course-container {
            margin-bottom: 10px;
        }
        .page-range {
            width: 30px;
        }
    </style>
    <script>
        function addCourse() {
            // Get the container element
            var container = document.getElementById("course-container");

            // Clone the original course container
            var originalContainer = document.getElementById("course1-container");
            var newContainer = originalContainer.cloneNode(true);

            // Reset the values of the cloned elements
            var newSelect = newContainer.querySelector("select");
            newSelect.selectedIndex = 0;
            var newInput = newContainer.querySelector("input");
            newInput.value = "";

            // Add the new course container to the main container
            container.appendChild(newContainer);
        }
    </script>
</head>
<body>
    
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

<?php
    function generateOptions() {
        // List of courses
        $soras = array(
                "1"=>"الفاتحة",
                "2"=>"البقرة",
                "3"=>"آل عمران",
                "4"=>"النساء",
                "5"=>"المائدة",
                "6"=>"الأنعام",
                "7"=>"الأعراف",
                "8"=>"الأنفال",
                "9"=>"التوبة",
                "10"=>"يونس",
                "11"=>"هود",
                "12"=>"يوسف",
                "13"=>"الرعد",
                "14"=>"ابراهيم",
                "15"=>"الحجر",
                "16"=>"النحل",
                "17"=>"الإسراء",
                "18"=>"الكهف",
                "19"=>"مريم",
                "20"=>"طه",
                "21"=>"الأنبياء",
                "22"=>"الحج",
                "23"=>"المؤمنون",
                "24"=>"النور",
                "25"=>"الفرقان",
                "26"=>"الشعراء",
                "27"=>"النمل",
                "28"=>"القصص",
                "29"=>"العنكبوت",
                "30"=>"الروم",
                "31"=>"لقمان",
                "32"=>"السجدة",
                "33"=>"الأحزاب",
                "34"=>"سبإ",
                "35"=>"فاطر",
                "36"=>"يس",
                "37"=>"الصافات",
                "38"=>"ص",
                "39"=>"الزمر",
                "40"=>"غافر",
                "41"=>"فصلت",
                "42"=>"الشورى",
                "43"=>"الزخرف",
                "44"=>"الدخان",
                "45"=>"الجاثية",
                "46"=>"الأحقاف",
                "47"=>"محمد",
                "48"=>"الفتح",
                "49"=>"الحجرات",
                "50"=>"ق",
                "51"=>"الذاريات",
                "52"=>"الطور",
                "53"=>"النجم",
                "54"=>"القمر",
                "55"=>"الرحمن",
                "56"=>"الواقعة",
                "57"=>"الحديد",
                "58"=>"المجادلة",
                "59"=>"الحشر",
                "60"=>"الممتحنة",
                "61"=>"الصف",
                "62"=>"الجمعة",
                "63"=>"المنافقون",
                "64"=>"التغابن",
                "65"=>"الطلاق",
                "66"=>"التحريم",
                "67"=>"الملك",
                "68"=>"القلم",
                "69"=>"الحاقة",
                "70"=>"المعارج",
                "71"=>"نوح",
                "72"=>"الجن",
                "73"=>"المزمل",
                "74"=>"المدثر",
                "75"=>"القيامة",
                "76"=>"الانسان",
                "77"=>"المرسلات",
                "78"=>"النبإ",
                "79"=>"النازعات",
                "80"=>"عبس",
                "81"=>"التكوير",
                "82"=>"الإنفطار",
                "83"=>"المطففين",
                "84"=>"الإنشقاق",
                "85"=>"البروج",
                "86"=>"الطارق",
                "87"=>"الأعلى",
                "88"=>"الغاشية",
                "89"=>"الفجر",
                "90"=>"البلد",
                "91"=>"الشمس",
                "92"=>"الليل",
                "93"=>"الضحى",
                "94"=>"الشرح",
                "95"=>"التين",
                "96"=>"العلق",
                "97"=>"القدر",
                "98"=>"البينة",
                "99"=>"الزلزلة",
                "100"=>"العاديات",
                "101"=>"القارعة",
                "102"=>"التكاثر",
                "103"=>"العصر",
                "104"=>"الهمزة",
                "105"=>"الفيل",
                "106"=>"قريش",
                "107"=>"الماعون",
                "108"=>"الكوثر",
                "109"=>"الكافرون",
                "110"=>"النصر",
                "111"=>"المسد",
                "112"=>"الإخلاص",
                "113"=>"الفلق",
                "114"=>"الناس"
        );
    
        // Loop through the courses and create an option element for each one
        $options = "";
        foreach ($soras as $value => $sora) {
            $options .= "<option value=\"$sora\">$sora</option>";
        }
    
        return $options;
    }
    if(isset($_POST['submit'])){
        $courses = $_POST["courses"];
        $pages1 = $_POST["pages1"];
        $pages2 = $_POST["pages2"];

        // Loop through the selected courses and page ranges
        for ($i = 0; $i < count($courses); $i++) {
            //$course = $conn->real_escape_string($courses[$i]);
            //$page_range = $conn->real_escape_string($pages[$i]);
            
            echo $courses[$i]." من آية ".$pages1[$i]." إلى آية ".$pages2[$i]."</br>";
           

            /*// Insert the course and page range into the database
            $sql = "INSERT INTO course_data (course, page_range) VALUES ('$course', '$page_range')";
            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }*/
        }
    }
?>