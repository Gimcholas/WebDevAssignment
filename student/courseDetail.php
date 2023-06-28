<?php 
  session_start();
  include '../phpFunction/function.php';
  generatePage("Course Detail",'createCourseDetail','<link rel="stylesheet" type="text/css" href = "../css/courseDetail.css"><link rel="stylesheet" type="text/css" href = "../css/courseBanner.css">','<script src="../js/courseDetail.js"></script>');
?>