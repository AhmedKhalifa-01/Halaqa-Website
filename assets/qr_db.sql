-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 13, 2023 at 04:41 PM
-- Server version: 10.6.12-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u289455186_qr`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `msg` varchar(500) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(50) NOT NULL,
  `c_start_date` date NOT NULL,
  `c_end_date` date NOT NULL,
  `staff_id` int(11) NOT NULL,
  `status` varchar(250) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `course_attendance`
--

CREATE TABLE `course_attendance` (
  `course_attendance_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `state` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `course_details`
--

CREATE TABLE `course_details` (
  `course_details_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `course_results`
--

CREATE TABLE `course_results` (
  `course_results_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `total_mark` int(11) NOT NULL,
  `result` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `course_results_details`
--

CREATE TABLE `course_results_details` (
  `course_results_details_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `mark` int(11) NOT NULL,
  `face_mem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `sora` varchar(50) NOT NULL,
  `h_from` varchar(10) NOT NULL,
  `h_to` varchar(10) NOT NULL,
  `homework_date` date NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`id`, `std_id`, `sora`, `h_from`, `h_to`, `homework_date`, `type`) VALUES
(13, 33, 'آل عمران', '1', '15', '2023-04-12', 'review'),
(14, 33, 'البقرة', '1', '20', '2023-04-12', 'recite'),
(15, 34, 'التغابن', '1', '20', '2023-04-12', 'recite'),
(16, 34, 'الفاتحة', '', '', '2023-04-12', 'review');

-- --------------------------------------------------------

--
-- Table structure for table `is_p_following`
--

CREATE TABLE `is_p_following` (
  `id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `main_posts`
--

CREATE TABLE `main_posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `secondary_title` varchar(2000) NOT NULL,
  `img` varchar(500) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `main_posts`
--

INSERT INTO `main_posts` (`post_id`, `title`, `secondary_title`, `img`, `date`) VALUES
(7, 'بدء دورة جديدة', 'في الكود أعلاه ، نقوم أولاً بتحديث متغير endX كما كان من قبل. بعد ذلك ، نحصل على مراجع لحاوية عرض الشرائح والشرائح الحالية والتالية. إذا قام المستخدم بالتمرير إلى اليسار ، فإننا نزيد فهرس الشرائح ونحصل على مرجع للشريحة التالية. ثم قمنا بتعيين خاصية التحويل للحاوية الرئيسية للشريحة الحالية على translateX (-100٪) لإخراجها من الشاشة إلى اليسار ، وقمنا بتعيين خاصية التحويل للحاوية الرئيسية للشريحة التالية على translateX (0) لنقلها إلى شاشة. إذا قام المستخدم بالتمرير لليمين ، فإننا نقوم بإنقاص فهرس الشريحة والحصول على مرجع للشريحة السابقة ، وتعيين خصائص التحويل وفقًا لذلك.  لاحظ أن هذا التنفيذ يفترض أن كل شريحة مضمنة في عنصر أصلي له الموضع: مطلق والعرض: 100٪. قد تحتاج إلى ضبط الشفرة لتتوافق مع بنية HTML و CSS الخاصة بك. بالإضافة إلى ذلك ، يعمل هذا التطبيق فقط مع أحداث اللمس والماوس ، لذلك قد ترغب في إضافة مستمعين للأحداث إضافية لإدخال لوحة المفاتيح أيضًا.', 'LGO.png', '2023-04-12'),
(8, 'تهنئة', 'نبارك للطالب عبد الله اجورو ختم القران الكريم ', '558b2e82-92d0-40d4-a8f1-17dd118306be.jpg', '2023-04-12');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `msg` varchar(500) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton`
--

CREATE TABLE `mton` (
  `mton_id` int(11) NOT NULL,
  `mton_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton_attendance`
--

CREATE TABLE `mton_attendance` (
  `mton_attendance_id` int(11) NOT NULL,
  `mton_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton_details`
--

CREATE TABLE `mton_details` (
  `mton_details_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton_homework`
--

CREATE TABLE `mton_homework` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `sora` varchar(500) NOT NULL,
  `mh_from` varchar(500) NOT NULL,
  `mh_to` varchar(500) NOT NULL,
  `mh_date` date NOT NULL,
  `mh_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton_recite`
--

CREATE TABLE `mton_recite` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `grade` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton_recite_plan`
--

CREATE TABLE `mton_recite_plan` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `a_from` int(11) DEFAULT NULL,
  `a_to` int(11) DEFAULT NULL,
  `sora` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton_results`
--

CREATE TABLE `mton_results` (
  `mton_results_id` int(11) NOT NULL,
  `mton_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `result_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton_review`
--

CREATE TABLE `mton_review` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `grade` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton_review_plan`
--

CREATE TABLE `mton_review_plan` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `a_from` int(11) DEFAULT NULL,
  `a_to` int(11) DEFAULT NULL,
  `sora` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton_std_att`
--

CREATE TABLE `mton_std_att` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton_std_on_plan`
--

CREATE TABLE `mton_std_on_plan` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `onPlan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mton_std_plan`
--

CREATE TABLE `mton_std_plan` (
  `plan_id` int(11) NOT NULL DEFAULT 0,
  `std_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `versus` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `p_id_number` varchar(50) NOT NULL,
  `p_phone` varchar(50) NOT NULL,
  `p_address` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `prize`
--

CREATE TABLE `prize` (
  `prize_id` int(11) NOT NULL,
  `prize_name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `no_std` int(11) NOT NULL,
  `state` varchar(50) NOT NULL,
  `gift` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `prize`
--

INSERT INTO `prize` (`prize_id`, `prize_name`, `start_date`, `end_date`, `no_std`, `state`, `gift`) VALUES
(9, 'نجوم القران', '2023-04-13', '2023-05-04', 2, 'مستمرة', '150 ريال');

-- --------------------------------------------------------

--
-- Table structure for table `prize_details`
--

CREATE TABLE `prize_details` (
  `prize_details_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `star` varchar(50) NOT NULL,
  `prize_id` int(11) NOT NULL,
  `recieved_gold_gift` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `prize_details`
--

INSERT INTO `prize_details` (`prize_details_id`, `std_id`, `date`, `star`, `prize_id`, `recieved_gold_gift`) VALUES
(87, 35, '2023-04-12', 'البرونزي', 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prize_participating_students`
--

CREATE TABLE `prize_participating_students` (
  `pps_id` int(11) NOT NULL,
  `prize_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `prize_participating_students`
--

INSERT INTO `prize_participating_students` (`pps_id`, `prize_id`, `std_id`) VALUES
(8, 9, 34),
(9, 9, 35);

-- --------------------------------------------------------

--
-- Table structure for table `recite`
--

CREATE TABLE `recite` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `grade` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `recite`
--

INSERT INTO `recite` (`id`, `std_id`, `date`, `grade`) VALUES
(82, 33, '2023-04-12', 'ممتاز'),
(83, 34, '2023-04-12', 'ممتاز'),
(84, 35, '2023-04-12', 'ممتاز');

-- --------------------------------------------------------

--
-- Table structure for table `recite_plan`
--

CREATE TABLE `recite_plan` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `a_from` int(11) DEFAULT NULL,
  `a_to` int(11) DEFAULT NULL,
  `sora` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `recite_plan`
--

INSERT INTO `recite_plan` (`id`, `std_id`, `type`, `amount`, `a_from`, `a_to`, `sora`) VALUES
(11, 33, '3', '7 أوجه', NULL, NULL, NULL),
(12, 34, '3', '10 أوجه', NULL, NULL, NULL),
(13, 35, '3', '10 اوجه', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `result_id` int(11) NOT NULL,
  `result_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `grade` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `std_id`, `date`, `grade`) VALUES
(82, 33, '2023-04-12', 'ممتاز'),
(83, 34, '2023-04-12', 'ممتاز'),
(84, 35, '2023-04-12', 'ممتاز');

-- --------------------------------------------------------

--
-- Table structure for table `review_plan`
--

CREATE TABLE `review_plan` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `a_from` int(11) DEFAULT NULL,
  `a_to` int(11) DEFAULT NULL,
  `sora` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `review_plan`
--

INSERT INTO `review_plan` (`id`, `std_id`, `type`, `amount`, `a_from`, `a_to`, `sora`) VALUES
(23, 33, '3', '5 أوجه', NULL, NULL, NULL),
(24, 34, '3', 'وجه و نصف', NULL, NULL, NULL),
(25, 35, '3', 'وجهين', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ring`
--

CREATE TABLE `ring` (
  `ring_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `temp_staff_id` int(11) NOT NULL,
  `isTemp` tinyint(1) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `ring`
--

INSERT INTO `ring` (`ring_id`, `std_id`, `staff_id`, `temp_staff_id`, `isTemp`, `date`) VALUES
(13, 33, 37, 37, 0, '2023-04-12'),
(14, 34, 37, 37, 0, '2023-04-12'),
(15, 35, 37, 37, 0, '2023-04-12');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(50) NOT NULL,
  `staff_nat` varchar(50) NOT NULL,
  `staff_id_num` int(15) NOT NULL,
  `staff_birthday` date NOT NULL,
  `staff_lvl` varchar(50) NOT NULL,
  `staff_enroll` date NOT NULL,
  `staff_phone` varchar(50) NOT NULL,
  `staff_extraphone` varchar(50) DEFAULT NULL,
  `staff_address` varchar(50) NOT NULL,
  `staff_job` varchar(11) NOT NULL,
  `staff_profile` varchar(250) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `pass` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`, `staff_nat`, `staff_id_num`, `staff_birthday`, `staff_lvl`, `staff_enroll`, `staff_phone`, `staff_extraphone`, `staff_address`, `staff_job`, `staff_profile`, `email`, `pass`, `status`) VALUES
(26, 'admin', 'admin', 811, '2023-04-04', 'admin', '2023-04-01', '0128297066', NULL, 'admin', 'JOB_01', 'none', NULL, '123', 'admin'),
(37, 'خالد صباحي', 'السودان', 321, '2023-03-30', 'الجامعي', '2023-04-13', '+249128297066', '', 'الدخل 1', 'JOB_03', '176.jpg', '', '123', ''),
(38, 'حسان بن إبراهيم العطوي', 'سعودي', 1111618508, '2001-03-01', 'جامعي', '2020-03-13', '0536307101', '', 'تبوك', 'JOB_03', 'WhatsApp Image 2023-04-09 at 10.40.30 PM (8).jpeg', '', '123', '');

-- --------------------------------------------------------

--
-- Table structure for table `staff_att`
--

CREATE TABLE `staff_att` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `state` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `staff_att`
--

INSERT INTO `staff_att` (`id`, `staff_id`, `date`, `state`) VALUES
(7, 37, '2023-04-12', 'حضور'),
(8, 38, '2023-04-12', ''),
(9, 38, '2023-04-13', 'حضور');

-- --------------------------------------------------------

--
-- Table structure for table `staff_job`
--

CREATE TABLE `staff_job` (
  `job_id` varchar(10) NOT NULL,
  `job_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `staff_job`
--

INSERT INTO `staff_job` (`job_id`, `job_name`) VALUES
('JOB_01', 'Admin'),
('JOB_02', 'Manager'),
('JOB_03', 'Teacher'),
('JOB_04', 'Visitor');

-- --------------------------------------------------------

--
-- Table structure for table `std_att`
--

CREATE TABLE `std_att` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `std_att`
--

INSERT INTO `std_att` (`id`, `std_id`, `date`, `state`) VALUES
(82, 33, '2023-04-12', 'حضور'),
(83, 34, '2023-04-12', 'حضور'),
(84, 35, '2023-04-12', 'حضور');

-- --------------------------------------------------------

--
-- Table structure for table `std_on_plan`
--

CREATE TABLE `std_on_plan` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `onPlan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `std_on_plan`
--

INSERT INTO `std_on_plan` (`id`, `std_id`, `date`, `onPlan`) VALUES
(81, 33, '2023-04-12', 'حسب الخطة'),
(82, 34, '2023-04-12', 'حسب الخطة'),
(83, 35, '2023-04-12', 'حسب الخطة');

-- --------------------------------------------------------

--
-- Table structure for table `std_parent_rel`
--

CREATE TABLE `std_parent_rel` (
  `std_parent_rel_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `std_plan`
--

CREATE TABLE `std_plan` (
  `plan_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `versus` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `std_recite_sora`
--

CREATE TABLE `std_recite_sora` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `sorah` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `std_sorahs`
--

CREATE TABLE `std_sorahs` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `sorah` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `std_id` int(11) NOT NULL,
  `std_name` varchar(50) NOT NULL,
  `std_lvl` varchar(50) NOT NULL,
  `std_nat` varchar(50) NOT NULL,
  `std_id_num` varchar(50) NOT NULL,
  `std_birth_date` date NOT NULL,
  `std_birth_loc` varchar(50) DEFAULT NULL,
  `std_enroll_date` date NOT NULL,
  `std_phone` varchar(15) NOT NULL,
  `std_parent_phone` varchar(15) NOT NULL,
  `std_relative_phone` varchar(15) DEFAULT NULL,
  `std_last_sorah` varchar(15) DEFAULT NULL,
  `std_tested` varchar(50) DEFAULT NULL,
  `std_profile` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `pass` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `p_id` int(11) NOT NULL,
  `std_v_mem` int(11) DEFAULT NULL,
  `state` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`std_id`, `std_name`, `std_lvl`, `std_nat`, `std_id_num`, `std_birth_date`, `std_birth_loc`, `std_enroll_date`, `std_phone`, `std_parent_phone`, `std_relative_phone`, `std_last_sorah`, `std_tested`, `std_profile`, `email`, `pass`, `status`, `p_id`, `std_v_mem`, `state`) VALUES
(33, 'محمد احمد', 'الجامعية', 'السعودية', '212', '2023-04-28', 'تبوك', '2023-03-31', '0543534534', '', 'أب', 'الفاتحة', '10', 'ABDO.jpg', 'kjd@gmail.com', '123', '', 13, 10, 'منتظم'),
(34, 'عمار بن إبراهيم بن عيد العطوي', 'جامعي', 'سعودي', '1117906923', '2002-02-13', 'تبوك', '2023-04-13', '0501529395', '', 'اب', 'الاعراف', '5', 'd102a9eb-3a3d-4528-af2c-89b65aaeaec8.jpg', '', '123', '', 0, 5, 'منتظم'),
(35, 'هادي بن إبراهيم البلوي', 'جامعي', 'سعودي', '1117906923', '2023-04-06', 'تبوك', '2023-04-25', '0556980862', '', 'اب', 'الاعراف', '5', 'WhatsApp Image 2023-04-09 at 10.40.29 PM.jpeg', '', '123', '', 13, 5, 'مفصول');

-- --------------------------------------------------------

--
-- Table structure for table `student_courses`
--

CREATE TABLE `student_courses` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `course_ibfk_1` (`staff_id`);

--
-- Indexes for table `course_attendance`
--
ALTER TABLE `course_attendance`
  ADD PRIMARY KEY (`course_attendance_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `course_attendance_ibfk_1` (`course_id`);

--
-- Indexes for table `course_details`
--
ALTER TABLE `course_details`
  ADD PRIMARY KEY (`course_details_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `course_details_ibfk_33` (`course_id`);

--
-- Indexes for table `course_results`
--
ALTER TABLE `course_results`
  ADD PRIMARY KEY (`course_results_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `std_id` (`std_id`);

--
-- Indexes for table `course_results_details`
--
ALTER TABLE `course_results_details`
  ADD PRIMARY KEY (`course_results_details_id`),
  ADD KEY `c_id` (`c_id`),
  ADD KEY `std_id` (`std_id`);

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_std_id_homework` (`std_id`);

--
-- Indexes for table `is_p_following`
--
ALTER TABLE `is_p_following`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_is_p_id` (`p_id`);

--
-- Indexes for table `main_posts`
--
ALTER TABLE `main_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `mton`
--
ALTER TABLE `mton`
  ADD PRIMARY KEY (`mton_id`);

--
-- Indexes for table `mton_attendance`
--
ALTER TABLE `mton_attendance`
  ADD PRIMARY KEY (`mton_attendance_id`),
  ADD KEY `state` (`state`),
  ADD KEY `mton_id` (`mton_id`),
  ADD KEY `std_id` (`std_id`);

--
-- Indexes for table `mton_details`
--
ALTER TABLE `mton_details`
  ADD PRIMARY KEY (`mton_details_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `std_id` (`std_id`);

--
-- Indexes for table `mton_homework`
--
ALTER TABLE `mton_homework`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mton_recite`
--
ALTER TABLE `mton_recite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mton_std_id_recite` (`std_id`);

--
-- Indexes for table `mton_recite_plan`
--
ALTER TABLE `mton_recite_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mton_results`
--
ALTER TABLE `mton_results`
  ADD PRIMARY KEY (`mton_results_id`),
  ADD KEY `mton_id` (`mton_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `result_id` (`result_id`);

--
-- Indexes for table `mton_review`
--
ALTER TABLE `mton_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mton_std_id_review` (`std_id`);

--
-- Indexes for table `mton_review_plan`
--
ALTER TABLE `mton_review_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mton_std_id_reciteplan` (`std_id`);

--
-- Indexes for table `mton_std_att`
--
ALTER TABLE `mton_std_att`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mton_std_id_att` (`std_id`);

--
-- Indexes for table `mton_std_on_plan`
--
ALTER TABLE `mton_std_on_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mton_std_id_onplan` (`std_id`);

--
-- Indexes for table `mton_std_plan`
--
ALTER TABLE `mton_std_plan`
  ADD KEY `fk_mton_std_id_plan` (`std_id`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `prize`
--
ALTER TABLE `prize`
  ADD PRIMARY KEY (`prize_id`);

--
-- Indexes for table `prize_details`
--
ALTER TABLE `prize_details`
  ADD PRIMARY KEY (`prize_details_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `fk_details_prize_id` (`prize_id`);

--
-- Indexes for table `prize_participating_students`
--
ALTER TABLE `prize_participating_students`
  ADD PRIMARY KEY (`pps_id`),
  ADD KEY `fk_mton_prize_participating_students_prize_id` (`prize_id`),
  ADD KEY `fk_prize_participating_students_std_id` (`std_id`);

--
-- Indexes for table `recite`
--
ALTER TABLE `recite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recite_fk_stdid` (`std_id`);

--
-- Indexes for table `recite_plan`
--
ALTER TABLE `recite_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recite_stdid_plan` (`std_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`result_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_fk_stdid` (`std_id`);

--
-- Indexes for table `review_plan`
--
ALTER TABLE `review_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_r_stdid` (`std_id`);

--
-- Indexes for table `ring`
--
ALTER TABLE `ring`
  ADD PRIMARY KEY (`ring_id`),
  ADD KEY `fk_temp_staffid` (`temp_staff_id`),
  ADD KEY `fk_ring_stdid` (`std_id`),
  ADD KEY `fk_ring_staff_id` (`staff_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `staff_id_num` (`staff_id_num`),
  ADD KEY `staff_job` (`staff_job`);

--
-- Indexes for table `staff_att`
--
ALTER TABLE `staff_att`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_job`
--
ALTER TABLE `staff_job`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `std_att`
--
ALTER TABLE `std_att`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_att_stdid` (`std_id`);

--
-- Indexes for table `std_on_plan`
--
ALTER TABLE `std_on_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ponplanstd` (`std_id`);

--
-- Indexes for table `std_parent_rel`
--
ALTER TABLE `std_parent_rel`
  ADD PRIMARY KEY (`std_parent_rel_id`),
  ADD KEY `fk_std_id` (`std_id`),
  ADD KEY `fk_parent_id` (`parent_id`);

--
-- Indexes for table `std_plan`
--
ALTER TABLE `std_plan`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `std_recite_sora`
--
ALTER TABLE `std_recite_sora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recite_stdid_sora` (`std_id`);

--
-- Indexes for table `std_sorahs`
--
ALTER TABLE `std_sorahs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sora_stdid` (`std_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`std_id`);

--
-- Indexes for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sc_cid` (`course_id`),
  ADD KEY `fk_sc_stdid` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `course_attendance`
--
ALTER TABLE `course_attendance`
  MODIFY `course_attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `course_details`
--
ALTER TABLE `course_details`
  MODIFY `course_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `course_results`
--
ALTER TABLE `course_results`
  MODIFY `course_results_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `course_results_details`
--
ALTER TABLE `course_results_details`
  MODIFY `course_results_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `is_p_following`
--
ALTER TABLE `is_p_following`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `main_posts`
--
ALTER TABLE `main_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mton`
--
ALTER TABLE `mton`
  MODIFY `mton_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mton_attendance`
--
ALTER TABLE `mton_attendance`
  MODIFY `mton_attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mton_details`
--
ALTER TABLE `mton_details`
  MODIFY `mton_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mton_homework`
--
ALTER TABLE `mton_homework`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mton_recite`
--
ALTER TABLE `mton_recite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `mton_recite_plan`
--
ALTER TABLE `mton_recite_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mton_results`
--
ALTER TABLE `mton_results`
  MODIFY `mton_results_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mton_review`
--
ALTER TABLE `mton_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `mton_review_plan`
--
ALTER TABLE `mton_review_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mton_std_att`
--
ALTER TABLE `mton_std_att`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `mton_std_on_plan`
--
ALTER TABLE `mton_std_on_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `prize`
--
ALTER TABLE `prize`
  MODIFY `prize_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prize_details`
--
ALTER TABLE `prize_details`
  MODIFY `prize_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `prize_participating_students`
--
ALTER TABLE `prize_participating_students`
  MODIFY `pps_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `recite`
--
ALTER TABLE `recite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `recite_plan`
--
ALTER TABLE `recite_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `review_plan`
--
ALTER TABLE `review_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `ring`
--
ALTER TABLE `ring`
  MODIFY `ring_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `staff_att`
--
ALTER TABLE `staff_att`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `std_att`
--
ALTER TABLE `std_att`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `std_on_plan`
--
ALTER TABLE `std_on_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `std_parent_rel`
--
ALTER TABLE `std_parent_rel`
  MODIFY `std_parent_rel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `std_plan`
--
ALTER TABLE `std_plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `std_recite_sora`
--
ALTER TABLE `std_recite_sora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `std_sorahs`
--
ALTER TABLE `std_sorahs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `std_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `student_courses`
--
ALTER TABLE `student_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_attendance`
--
ALTER TABLE `course_attendance`
  ADD CONSTRAINT `course_attendance_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_attendance_ibfk_2` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_details`
--
ALTER TABLE `course_details`
  ADD CONSTRAINT `course_details_ibfk_2` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_details_ibfk_33` FOREIGN KEY (`course_id`) REFERENCES `course` (`c_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_results`
--
ALTER TABLE `course_results`
  ADD CONSTRAINT `course_results_ibfk_2` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_results_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `course` (`c_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_results_details`
--
ALTER TABLE `course_results_details`
  ADD CONSTRAINT `c_id` FOREIGN KEY (`c_id`) REFERENCES `course` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `std_id` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `homework`
--
ALTER TABLE `homework`
  ADD CONSTRAINT `fk_std_id_homework` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `is_p_following`
--
ALTER TABLE `is_p_following`
  ADD CONSTRAINT `fk_is_p_id` FOREIGN KEY (`p_id`) REFERENCES `parent` (`p_id`);

--
-- Constraints for table `mton_attendance`
--
ALTER TABLE `mton_attendance`
  ADD CONSTRAINT `mton_attendance_ibfk_1` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`),
  ADD CONSTRAINT `mton_attendance_ibfk_2` FOREIGN KEY (`mton_id`) REFERENCES `mton` (`mton_id`);

--
-- Constraints for table `mton_details`
--
ALTER TABLE `mton_details`
  ADD CONSTRAINT `mton_details_ibfk_1` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`),
  ADD CONSTRAINT `mton_details_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `mton_recite`
--
ALTER TABLE `mton_recite`
  ADD CONSTRAINT `fk_mton_std_id_recite` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `mton_results`
--
ALTER TABLE `mton_results`
  ADD CONSTRAINT `mton_results_ibfk_1` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`),
  ADD CONSTRAINT `mton_results_ibfk_2` FOREIGN KEY (`mton_id`) REFERENCES `mton` (`mton_id`);

--
-- Constraints for table `mton_review`
--
ALTER TABLE `mton_review`
  ADD CONSTRAINT `fk_mton_std_id_review` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `mton_review_plan`
--
ALTER TABLE `mton_review_plan`
  ADD CONSTRAINT `fk_mton_std_id_reciteplan` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_mton_std_id_review_plan` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`);

--
-- Constraints for table `mton_std_att`
--
ALTER TABLE `mton_std_att`
  ADD CONSTRAINT `fk_mton_std_id_att` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `mton_std_on_plan`
--
ALTER TABLE `mton_std_on_plan`
  ADD CONSTRAINT `fk_mton_std_id_onplan` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `mton_std_plan`
--
ALTER TABLE `mton_std_plan`
  ADD CONSTRAINT `fk_mton_std_id_plan` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`);

--
-- Constraints for table `prize_details`
--
ALTER TABLE `prize_details`
  ADD CONSTRAINT `fk_details_prize_id` FOREIGN KEY (`prize_id`) REFERENCES `prize` (`prize_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prize_details_ibfk_1` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`);

--
-- Constraints for table `prize_participating_students`
--
ALTER TABLE `prize_participating_students`
  ADD CONSTRAINT `fk_mton_prize_participating_students_prize_id` FOREIGN KEY (`prize_id`) REFERENCES `prize` (`prize_id`),
  ADD CONSTRAINT `fk_prize_participating_students_std_id` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `recite`
--
ALTER TABLE `recite`
  ADD CONSTRAINT `recite_fk_stdid` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `recite_plan`
--
ALTER TABLE `recite_plan`
  ADD CONSTRAINT `fk_recite_stdid_plan` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_fk_stdid` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `review_plan`
--
ALTER TABLE `review_plan`
  ADD CONSTRAINT `fk_r_stdid` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `ring`
--
ALTER TABLE `ring`
  ADD CONSTRAINT `fk_ring_staff_id` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ring_stdid` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_temp_staffid` FOREIGN KEY (`temp_staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`staff_job`) REFERENCES `staff_job` (`job_id`);

--
-- Constraints for table `std_att`
--
ALTER TABLE `std_att`
  ADD CONSTRAINT `fk_att_stdid` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `std_on_plan`
--
ALTER TABLE `std_on_plan`
  ADD CONSTRAINT `fk_ponplanstd` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `std_parent_rel`
--
ALTER TABLE `std_parent_rel`
  ADD CONSTRAINT `fk_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`p_id`),
  ADD CONSTRAINT `fk_std_id` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`);

--
-- Constraints for table `std_plan`
--
ALTER TABLE `std_plan`
  ADD CONSTRAINT `std_plan_ibfk_1` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`),
  ADD CONSTRAINT `std_plan_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `course` (`c_id`);

--
-- Constraints for table `std_recite_sora`
--
ALTER TABLE `std_recite_sora`
  ADD CONSTRAINT `fk_recite_stdid_sora` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `std_sorahs`
--
ALTER TABLE `std_sorahs`
  ADD CONSTRAINT `fk_sora_stdid` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD CONSTRAINT `fk_sc_cid` FOREIGN KEY (`course_id`) REFERENCES `course` (`c_id`),
  ADD CONSTRAINT `fk_sc_stdid` FOREIGN KEY (`student_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
