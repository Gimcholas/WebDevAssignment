<!-- Student dashboard is viewing the registered course -->
<?php include '../db_connect.php'; ?>
<html>

<head>
    <title>My Courses</title>
    <link type="text/css" rel="stylesheet" href="myCourseDashboard.css">
</head>

<body>
    <h1>My Courses</h1>
    <div class="container">
    <?php
            $_SESSION["username"] = "student1";
            $registered_course_sql = "SELECT * FROM course_student WHERE username = '{$_SESSION['username']}'";
            $registered_course = mysqli_query($connect,$registered_course_sql);

            while($row = mysqli_fetch_assoc($registered_course)){
        ?>
            <a href = "../courseDetail/courseDetail.php?course=
                <?php
                    $course_section_sql = "SELECT * FROM course_section WHERE course_section_id =".$row['course_section_id'];
                    $course_section = mysqli_fetch_assoc(mysqli_query($connect,$course_section_sql));

                    $each_class_sql = "SELECT * FROM course WHERE course_id =".$course_section['course_id'];
                    $each_class = mysqli_fetch_assoc(mysqli_query($connect,$each_class_sql));

                    echo $course_section['course_id'];
                ?>
                &section=
                <?php
                    echo $course_section["course_section_id"];
                ?>
                ">
                <div class="classContainer">
                    <img src = "
                        <?php
                            echo $each_class["course_image_path"];
                        ?>
                    " alt = "
                        <?php
                            echo $each_class["course_title"];
                        ?>
                    ">
                    <h1>
                        <?php
                            echo $each_class["course_title"];
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