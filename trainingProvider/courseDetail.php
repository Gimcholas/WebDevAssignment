<?php include '../db_connect.php';
      include "functions.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head> 
    <title>Course Details</title>
    <link rel="stylesheet" href="../NavBar/NavBarStyle.css"/>
    <link rel="stylesheet" href="courseDetail.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src ="../js/navbar.js"></script></head>
    <script type="text/javascript">

    //create a javascript function named confirmation()
    function confirmation() {
	    answer = confirm("Do you want to delete this course?");
	    return answer;
    }
    </script>

<body>
<div class="Container">
    <div class="sidebar">
        <?php include '../NavBar/NavBar.php'?>
    </div>
    <div class="content" id="content"> 
        <!-- do course details code here  -->
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
                    echo "<a href='courseDetail.php?delete&course=" .$_GET['course'] ."' onclick='return confirmation();'><button>Delete Course</button></a>";
                    if ($_SESSION['usertype'] == "Admin") {
                        echo "<a href='../admin/courseOverview.php'><button>Back</button></a>";
                    }
                    if ($_SESSION['usertype'] == "Provider") {
                        echo "<a href='courses.php'><button>Back</button></a>";
                    }
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
                    echo "<a href='courseDetail.php?delete&courseSection=" .$row['course_section_id'] ."' onclick='return confirmation();'><button>Delete</button></a>";
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

    </div>
</div>
</body>
</html>

<?php 
if(isset($_GET["delete"])) {
    if(isset($_GET["course"])) {
        $course = $_GET["course"];
        $sql = "DELETE FROM course where course_id = $course";
        $result = mysqli_query($connect,$sql);
        if(!$result) {
            die(mysqli_error($result));
        }

        header("Location: courses.php");
    }
    if(isset($_GET["courseSection"])) {
        $courseSection = $_GET["courseSection"];
        $sql = "DELETE FROM course_section where course_section_id = $courseSection";
        $result = mysqli_query($connect,$sql);
        if(!$result) {
            die(mysqli_error($result));
        }
        echo "Delete";

        header("Location:" . $_SERVER["HTTP_REFERER"] );
        exit;
    }
}
?>