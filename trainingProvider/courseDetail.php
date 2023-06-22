<?php 
    include "../db_connect.php";
    include "functions.php";
    $_SESSION["username"] = "Huawei";
    
?>

<html>
<head>
    <title>Course Details</title>
</head>

<body>
    <?php 
    if(isset($_GET["view"])) {
        if (isset($_GET['course'])) {
        $course = getCourse($_GET['course'],$connect);
        $courseSectionResult = getCourseSectionsResult($_GET['course'],$connect);
    ?>
    <div class='course-details'>
        <h2>Course Details</h2>
        <?php 
        echo "<a href='editCourse.php?edit&course=" .$_GET['course'] ."'><button>Edit</button></a>";
        echo "<a href='courses.php'><button>Back</button></a>";
        echo "<p>Course ID: ". $course['course_id'] . "</p>";
        echo "<p>Course Title: " . $course['course_title'] . "</p>";
        echo "<p>Course Description: " . $course['course_description'] . "</p>";
        echo "<p>Start Date: " . $course['start_date'] . "</p>";
        echo "<p>End Date: " . $course['end_date'] . "</p>";
        ?>
    </div>
    <hr>
    <?php
    while ($row = mysqli_fetch_assoc($courseSectionResult)) {
        echo "<div class='course-section-details'>";
        echo "<p>Course Section ID: ". $row['course_section_id']."</p>";
        echo "<p>Course Section Name: ". $row['course_section_name']."</p>";
        echo "<p>Instructor Username: ". $row['username']."</p>";
        echo "<p>Instructor Name: ". $row['first_name']. " " . $row['last_name'] . "</p>";
        echo "<p>Start Time: ". $row['start_time'] ."</p>";
        echo "<p>End Time: ". $row['end_time'] . "</p>";
        echo "<p>Day: ". $row['day'] . "</p>";
        echo "<p>Status: ". $row['status'] ."</p>";
        echo "<p>Maximum Students Allowed: ". $row['max_student_num'] . "</p>";
        echo "</div>";
        echo "<hr>";
    }
    }
}
    ?>
</body>
</html>