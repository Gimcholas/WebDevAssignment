<?php include '../db_connect.php'; ?>

<html>

<head>
    <title>Course Details</title>
    <link rel="stylesheet" type="text/css" href = "courseDetail.css">
</head>

<body>
    <!-- nav bar and stuff -->
    <div class="header">
    </div>

    <div class="banner">
        <?php
            $course_section_id = $_GET['course_section_id'];
            $course_section_sql = "SELECT * FROM course_section WHERE course_id = $course_section_id";
            $course_section = mysqli_fetch_assoc(mysqli_query($connect,$course_section_sql));

            $course_id = $course_section["course_id"];
            $course_sql = "SELECT * FROM course WHERE course_id = $course_id";
            $course = mysqli_fetch_assoc(mysqli_query($connect,$course_section_sql));
        ?>
        <img src="
        <?php
            echo $course["course_image_path"];
        ?>
        " alt="Course img">
        <h1>
            <?php
                echo $course["course_title"];
            ?>
        </h1>
        <p>
            <?php
                echo $course["startdate"];
                echo $course["end_date"];
            ?>
        </p>

        <div class="hidden">
            <p>
                <?php
                    echo $course["course_description"];
                ?>
            </p>
        </div>
    </div>

    </div class="announcement">
        <h1> Announcements </h1>
        <?php
            $announcement_sql = "SELECT * FROM announcement WHERE course_section_id = $course_section_id";
            $announcement_result = mysqli_query($connect, $announcement_sql);	

            while($row = mysqli_fetch_assoc($announcement_result)){
        ?>
        <div class="eachAnnouncement">
            <img src="
            <?php
                $profile_image_sql = "SELECT profileImagePath FROM user WHERE username='".$announcement_result['username']."'";
                $profile_image = mysqli_fetch_assoc(mysqli_query($connect,$profile_image_sql));
                echo $profile_image_path;
            ?>" alt="Author picture">
            <h3>
            <?php
                $author_name_sql = "SELECT * FROM instructor WHERE username='".$announcement_result['username']."'";
                $author_name = mysqli_fetch_assoc(mysqli_query($connect,$author_name_sql));
                echo $author_name['first_name'];
                echo $author_name['last_name'];
            ?></h3>

            <h3>
                <?php
                    echo $announcement_result['upload_date_time'];
                ?>
            </h3>
            <h3>
                <?php
                    echo $announcement_result['title'];
                ?> 
            </h3>
            <p>
                <?php
                    echo $announcement_result['content'];
                ?> 
            </p>
        </div>

        <?php
            }
        ?>
    </div>
</body>

</html>
