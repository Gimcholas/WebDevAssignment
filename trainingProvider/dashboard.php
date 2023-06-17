<?php 
    include "../db_connect.php";
    session_start();
    $_SESSION["username"] = "Huawei";

?>

<html>
<head>
<title>Dashboard</title>
</head>

<body>
<header>
    <h1>Training Provider Dashboard</h1>
    <a href="courses.php"><button>Manage Courses</button></a>
    <a href="accountDashboard.php"><button>Manage Accounts</button></a>
</header>
</body>
</html>
