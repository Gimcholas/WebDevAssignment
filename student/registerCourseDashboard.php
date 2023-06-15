<!-- Student dashboard is viewing the registered course -->
<?php include '../db_connect.php'; ?>
<html>

<head>
    <title>Register Courses</title>
    <link type="text/css" rel="stylesheet" href="myCourseDashboard.css">
</head>

<body>
    <h1>Register Courses</h1>
    <div class="container">
    <?php
    // rules is set that only course that student have not register will be displayed and the course (any section in the course) must be open in order to be  display
            // for session testing
            $_SESSION["username"] = "student1";
            $all_unregistered_course_sql = "SELECT DISTINCT * FROM course WHERE course_id NOT IN (SELECT course_id FROM course_section WHERE section_status = 'Open' AND (course_section_id IN (SELECT course_section_id FROM course_student WHERE username = '{$_SESSION['username']}')))";
            $all_unregistered_course = mysqli_query($connect,$all_unregistered_course_sql);
            while($unregistered_course = mysqli_fetch_assoc($all_unregistered_course)){
        ?>
            <a href = "registerCourse.php?course=
                <?php
                    echo $unregistered_course['course_id'];
                ?>
                ">
                <div class="classContainer">
                    <img src = "
                        <?php
                            echo $unregistered_course["course_image_path"];
                        ?>
                    " alt = "
                        <?php
                            echo $unregistered_course["course_title"];
                        ?>
                    ">
                    <h1>
                        <?php
                            echo $unregistered_course["course_title"];
                        ?>
                    </h1>
                </div>
            </a>
        <?php
            }
        ?>
    </div>
</body>

</html>