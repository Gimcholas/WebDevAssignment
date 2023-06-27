<?php 
    include "../db_connect.php";
    session_start();
    //$_SESSION["username"] = "Huawei";

?>

<html>
<head>
<title>Dashboard</title>
</head>

<body>
<header>
    <h1>Training Provider Dashboard</h1>
    <?php 
    $sql = "SELECT * FROM user INNER JOIN instructor on user.username = instructor.username WHERE provider_username = '". $_SESSION["username"] . "';";
    $result = mysqli_query($connect,$sql);
    $countInstructor = mysqli_num_rows($result);

    $sql = "SELECT * FROM user INNER JOIN student on user.username = student.username WHERE provider_username = '". $_SESSION["username"] . "';";
    $result = mysqli_query($connect,$sql);
    $countStudent = mysqli_num_rows($result);

    $sql = "SELECT * FROM course where provider_username = '" . $_SESSION["username"] . "';";
    $result = mysqli_query($connect,$sql);
    $countCourse = mysqli_num_rows($result);
    ?>

    <div class="information">
        <div class="student-card">
            <h3>Total Student</h3>
            <h3><?php echo $countStudent ?></h3>
        </div>
        <div class="instructor-card">
            <h3>Total Instructor</h3>
            <h3><?php echo $countInstructor ?></h3>
        </div>
        <div class="course-card">
            <h3>Total Courses</h3>
            <h3><?php echo $countCourse ?></h3> 
        </div>
    </div>
    <a href="/assignment/trainingProvider/courses.php"><button>Manage Courses</button></a>
    <a href="/assignment/trainingProvider/accountDashboard.php"><button>Manage Accounts</button></a>
    <a href="/assignment/trainingProvider/feedback.php"><button>View Feedback</button></a>
</header>
</body>
</html>
