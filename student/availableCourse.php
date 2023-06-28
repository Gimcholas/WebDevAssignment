<?php include '../db_connect.php';
session_start();
include "../phpFunction/function.php";
?>

<!DOCTYPE html>
<html>
<head> 
    <title>Register Course</title>
    <link rel="stylesheet" href="../NavBar/NavBarStyle.css"/>
    <link type="text/css" rel="stylesheet" href="../css/courseDashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src ="../js/navbar.js"></script></head>

<body>
<div class="Container">
    <div class="sidebar">
        <?php include '../NavBar/NavBar.php'?>
    </div>
    <div class="content" id="content"> 
        <?php
          createCourseDashboard(false);
        ?>
    </div>
</div>
</body>


</html>