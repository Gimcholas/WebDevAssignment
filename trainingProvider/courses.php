<?php 
    include "../db_connect.php";
    include "functions.php";
    session_start();
    $_SESSION["username"] = "Huawei";
    $username = $_SESSION["username"];
?>

<html>
<head>
    <title>Courses</title>
    <link rel="stylesheet" type="text/css" href = "courses.css">
</head>
<body>
    <div class="ongoing-course">
    <h1>Ongoing Courses</h1>
    <a href="createCourse.php"><button>Add Course</button><a>
    
    <?php 
    //Get the ongoing course
    $sql = "SELECT * FROM course WHERE provider_username = '" . $username . "' and end_date > '" . date("Y-m-d") . "';";
    $result = mysqli_query($connect,$sql);
    displayCourses($result);
    ?>
    </div>

    <div class="ended-course">
        <h1>Ended Courses</h1>
        <?php 
        //Get the ended course 
        $sql = "SELECT * FROM course WHERE provider_username = '" . $username . "' and end_date <= '" . date("Y-m-d") . "';";
        $result = mysqli_query($connect,$sql);
        displayCourses($result);
    ?>
    </div>
    
    <?php
    if(isset($_GET['course'])) {
        // $sql = "SELECT * FROM course where course_id=" . $_GET['course'] . ";";
        // $result = mysqli_query($connect,$sql);
        // $row = mysqli_fetch_assoc($result);
        $row = getCourse($_GET['course'],$connect);
        ?>
        <div class='course-details'>
            <h2>Course Details</h2>
            <?php 
                echo "<a href='courseDetail.php?view&course=". $_GET['course'] . "'><button>View More Details</button></a>";
                echo "<p>Course ID: ". $row['course_id']."</p>";
                echo "<p>Course Title: ". $row['course_title']."</p>";
                echo "<p>Course Description: ". $row['course_description']."</p>";
                echo "<p>Start Date: ". $row['start_date']."</p>";
                echo "<p>End Date: ". $row['end_date']."</p>";
            ?>
        </div>
        <hr>
        <?php
        // $sql2 = "SELECT * FROM course_section INNER JOIN instructor on course_section.username = instructor.username where course_id = " . $_GET['course'] . ";";
        // $result2 = mysqli_query($connect,$sql2);
        // if (!$result2) {
        //     echo "Failed";
        // }
        $result = getCourseSectionsResult($_GET['course'],$connect);
        while ($row2 = mysqli_fetch_assoc($result)) {
            echo "<div class='course-section-details'>";
            //echo "<p>Course Section ID: ". $row2['course_section_id']."</p>";
            echo "<p>Course Section Name: ". $row2['course_section_name']."</p>";
            //echo "<p>Instructor Username: ". $row2['username']."</p>";
            echo "<p>Instructor Name: ". $row2['first_name']. " " . $row2['last_name'] . "</p>";
            //echo "<p>Start Time: ". $row2['start_time'] ."</p>";
            //echo "<p>End Time: ". $row2['end_time'] . "</p>";
            //echo "<p>Day: ". $row2['day'] . "</p>";
            echo "<p>Status: ". $row2['status'] ."</p>";
            echo "<p>Maximum Students Allowed: ". $row2['max_student_num'] . "</p>";
            

            //echo "<p>Course Section ID: ". $row['course_section_id']."</p>";
            echo "</div>";
            echo "<hr>";
        }

    }
    ?>

</body>

</html>

<?php
    function displayCourses($result) {
        echo "<table border=1>";
        echo "<tr>";
        echo "<th>Course ID</th>";
        echo "<th>Course Title</th>";
        echo "<th>Action</th>";
        while ($row = mysqli_fetch_assoc($result)) {
            
            echo "<tr>";
            // echo "<div class='display-course'>";
            echo "<td>" . $row["course_id"] . "</td>";
            echo "<td>" . $row["course_title"] . "</td>";
            echo "<td><a href='courses.php?course=" . $row["course_id"] . "'>View</a></td>";
            // echo "</div>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</tr>";


    }

?>