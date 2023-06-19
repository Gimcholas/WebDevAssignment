<!-- for testing purposes -->

<?php
    $_SESSION['usertype'] = 'Student';
    $_SESSION["username"] = "student1";
    $_SESSION['redirectTo'] = 'myCourse';
    $_SESSION['redirectTo'] = 'registerCourse';
?>

<?php include '../db_connect.php'; ?>
<html>

<head>
    <title>
        <?php

            if(! isset($_SESSION['redirectTo'])){
                $_SESSION['redirectTo'] = 'myCourse';
            }
                    
            if ($_SESSION["usertype"]  == "Student"){
                if($_SESSION["redirectTo"] == "registerCourse"){
                    echo "Register Course";
                }

                else if($_SESSION["redirectTo"] == "myCourse"){
                    echo "My Course";
                }
            }
        ?>
    </title>
    <link type="text/css" rel="stylesheet" href="courseDashboard.css">
</head>

<body>
    <h1>
        <?php
            if ($_SESSION["usertype"]  == "Student"){
                if($_SESSION["redirectTo"] == "registerCourse"){
                    echo "Register Course";
                    // rules is set that only course that student have not register will be displayed and the course (any section in the course) must be open in order to be  display
                    // for session testing
                    $all_unregistered_course_sql = "SELECT DISTINCT * FROM course WHERE course_id IN (SELECT course_id FROM course_section WHERE status = 'Open' 
                                                    AND (course_section_id NOT IN (SELECT course_section_id FROM course_student WHERE username = '{$_SESSION['username']}')))";
                    $result = mysqli_query($connect,$all_unregistered_course_sql);
                }

                else if($_SESSION["redirectTo"] == "myCourse"){
                    echo "My Course";
                    $registered_course_sql = "SELECT * FROM course_student WHERE username = '{$_SESSION['username']}'";
                    $result = mysqli_query($connect,$registered_course_sql);
                }
            }
        ?>
    </h1>
    <div class="class-container">
        <?php
            while($row = mysqli_fetch_assoc($result)){
        ?>
            <div class="class-child">
                <a href = "
                    <?php
                        if ($_SESSION["usertype"]  == "Student"){
                            if($_SESSION["redirectTo"] == "registerCourse"){
                                echo "registerCourse.php?course=".$row['course_id'];
                            }
            
                            else if($_SESSION["redirectTo"] == "myCourse"){
                                $course_section_sql = "SELECT * FROM course_section WHERE course_section_id =".$row['course_section_id'];
                                $course_section = mysqli_fetch_assoc(mysqli_query($connect,$course_section_sql));
            
                                $each_class_sql = "SELECT * FROM course WHERE course_id =".$course_section['course_id'];
                                $each_class = mysqli_fetch_assoc(mysqli_query($connect,$each_class_sql));
                                echo "../courseDetail/courseDetail.php?course=".$course_section['course_id']."&section=".$course_section["course_section_id"];
                            }
                        }
                    ?>
                ">
                    <img src = "
                        <?php

                            if ($_SESSION["usertype"]  == "Student"){
                                if($_SESSION["redirectTo"] == "registerCourse"){
                                    echo $row["course_image_path"];
                                }

                                else if($_SESSION["redirectTo"] == "myCourse"){
                                    echo $each_class["course_image_path"];
                                }
                            }
                        ?>
                    " alt = "
                        <?php

                        if ($_SESSION["usertype"]  == "Student"){
                            if($_SESSION["redirectTo"] == "registerCourse"){
                                echo $row["course_title"];
                            }

                            else if($_SESSION["redirectTo"] == "myCourse"){
                                echo $each_class["course_title"];
                            }
                        }
                        ?>
                    "/>
                    <h2>
                        <?php

                        if ($_SESSION["usertype"]  == "Student"){
                            if($_SESSION["redirectTo"] == "registerCourse"){
                                echo $row["course_title"];
                            }

                            else if($_SESSION["redirectTo"] == "myCourse"){
                                echo $each_class["course_title"];
                            }
                        }
                        ?>
                    </h2>
             </a>
            </div>
        <?php
            }
        ?>
    </div>
</body>

</html>