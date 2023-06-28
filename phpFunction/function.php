<?php

include '../db_connect.php';

function createCourseDashboard($myCoursePage = true){
    global $connect;
    echo "<h1>";
    if ($_SESSION["usertype"]  == "Student"){
        if(!$myCoursePage){
            echo "Register Course";
            // rules is set that only course that student have not register will be displayed and the course (any section in the course) must be open in order to be  display
            // for session testing
            $course_sql = "SELECT DISTINCT * FROM course
                            WHERE course_id 
                                IN (SELECT course_id FROM course_section WHERE status = 'Open' 
                                    AND (course_section_id 
                                        NOT IN (SELECT course_section_id FROM course_student WHERE username = '{$_SESSION['username']}'))) 
                            ORDER BY course_title";
        }
        else{
            echo "My Course";
            $course_sql = "SELECT * FROM course_student AS cst
                            JOIN course_section AS csc ON csc.course_section_id = cst.course_section_id
                            JOIN course AS c ON c.course_id = csc.course_id
                            WHERE cst.username = '{$_SESSION['username']}'";
        }
    }
    else if ($_SESSION["usertype"]  == "Instructor"){
        echo "My Course";
        $course_sql = "SELECT * FROM course_section AS csc
                        JOIN course AS c ON c.course_id = csc.course_id
                        WHERE csc.username = '{$_SESSION['username']}'";
    }

    $result = mysqli_query($connect,$course_sql);
    echo "</h1>";
    echo '<div class="class-container">';
    retrieveEachDashboardCourse($result,$myCoursePage);
    echo '</div>';
}

function retrieveEachDashboardCourse($result,$myCoursePage){
    while($eachCourse = mysqli_fetch_array($result)){
        echo '<div class="class-child">';
            echo '<a href = "'.generateDashboardCourseLink($eachCourse,$myCoursePage).'">';
                echo '<img src = "'.$eachCourse["course_image_path"].'" alt = "'.$eachCourse["course_title"].'"/>';
                echo '<h2>';
                    echo $eachCourse["course_title"];
                echo '</h2>';
            echo '</a>';
        echo '</div>';
    }
}

function generateDashboardCourseLink($eachCourse,$myCoursePage){
    global $connect;
    if(!$myCoursePage){
        return 'registerCourse.php?course='.$eachCourse['course_id'];
    }
    else {
        return 'courseDetail.php?course='.$eachCourse['course_id'].'&section='.$eachCourse["course_section_id"];
    }
}

?>