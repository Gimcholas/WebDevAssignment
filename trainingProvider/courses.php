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
    <link rel="stylesheet" type="text/css" href="courses.css">
    <link rel="stylesheet" href="../navBar/navBarStyle.css"/>
    <link rel="stylesheet" href="#"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src ="../js/navbar.js"></script></head>
<body>
<div class="Container">
    <div class="sidebar">
        <?php include '../navBar/navBar.php'?>
    </div>
    <div class="content" id="content"> 
        <header class="header-bar">
            <h1>Courses<h1>
        </header>

        <div class="left-panel">
            <div class="ongoing-course">
                <h1>Ongoing Courses</h1>
                <div class="display-course-container">
                    <a href="createCourse.php"><button>Add Course</button><a>
                    <?php 
                    //Get the ongoing course
                    $sql = "SELECT * FROM course WHERE provider_username = '" . $username . "' and end_date > '" . date("Y-m-d") . "';";
                    $result = mysqli_query($connect,$sql);
                    displayCourses($result);
                    ?>
                </div>
            </div>
            

            <div class="ended-course">
                <h1>Ended Courses</h1>
                <div class="display-course-container">
                    <?php 
                    //Get the ended course 
                    $sql = "SELECT * FROM course WHERE provider_username = '" . $username . "' and end_date <= '" . date("Y-m-d") . "';";
                    $result = mysqli_query($connect,$sql);
                    displayCourses($result);
                    ?>
                </div>
            </div>
        </div>

        <div class="right-panel">
        <?php
            if(isset($_GET['course'])) {
                $sql = "SELECT * FROM course where course_id=" . $_GET['course'] . ";";
                $result = mysqli_query($connect,$sql);
                $row = mysqli_fetch_assoc($result);
                // $row = getCourse($_GET['course'],$connect);
                ?>
                <div class='course-details'>
                    <h1>Course Details</h1>
                    <div class="course-details-box">
                        <?php 
                            echo "<p>Course ID: ". $row['course_id']."</p>";
                            echo "<p>Course Title: ". $row['course_title']."</p>";
                            echo "<p>Course Description: ". $row['course_description']."</p>";
                            echo "<p>Start Date: ". $row['start_date']."</p>";
                            echo "<p>End Date: ". $row['end_date']."</p>";
                            echo "<a href='courseDetail.php?view&course=". $_GET['course'] . "'><button>View More Details</button></a>";
                        ?>
                    </div>
                </div>

                <?php
                $sql2 = "SELECT * FROM course_section INNER JOIN instructor on course_section.username = instructor.username where course_id = " . $_GET['course'] . ";";
                $result2 = mysqli_query($connect,$sql2);
                if (!$result2) {
                    echo "Failed";
                }
                // $result = getCourseSectionsResult($_GET['course'],$connect);
                // while ($row2 = mysqli_fetch_assoc($result)) {
                //     echo "<div class='course-section-details'>";
                //     echo "<p>Course Section ID: ". $row2['course_section_id']."</p>";
                //     echo "<p>Course Section Name: ". $row2['course_section_name']."</p>";
                //     echo "<p>Instructor Username: ". $row2['username']."</p>";
                //     echo "<p>Instructor Name: ". $row2['first_name']. " " . $row2['last_name'] . "</p>";
                //     echo "<p>Start Time: ". $row2['start_time'] ."</p>";
                //     echo "<p>End Time: ". $row2['end_time'] . "</p>";
                //     echo "<p>Day: ". $row2['day'] . "</p>";
                //     echo "<p>Status: ". $row2['status'] ."</p>";
                //     echo "<p>Maximum Students Allowed: ". $row2['max_student_num'] . "</p>";
                    

                //     echo "<p>Course Section ID: ". $row['course_section_id']."</p>";
                //     echo "</div>";
                //     echo "<hr>";
                // }

            }
            ?>
        </div>
    </div>
</div>
</body>



</html>

<?php
    function displayCourses($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<a href="courses.php?course=' . $row["course_id"] . '">';
            echo '<div class="display-course">';
            echo '<p class="course-id">' . $row["course_id"] . '</p>';
            echo '<p class="course-title">' . $row["course_title"] . '</p>';
            echo '</div>';
            echo '</a>';
        }
    }

?>