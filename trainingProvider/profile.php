<?php include '../db_connect.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head> 
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../NavBar/NavBarStyle.css"/>
    <link rel="stylesheet" href="#"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src ="../js/navbar.js"></script></head>

<body>
<div class="Container">
    <div class="sidebar">
        <?php include '../NavBar/NavBar.php'?>
    </div>
    <div class="content" id="content"> 
        <!-- do profile code here  -->
    </div>
</div>
</body>


</html>