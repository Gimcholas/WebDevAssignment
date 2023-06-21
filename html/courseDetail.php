<?php include '../db_connect.php'; ?>
<?php
session_start();
?>
<?php
    $course_section_id = $_GET['section'];
    $course_id = $_GET['course'];
    $course_sql = "SELECT * FROM course WHERE course_id = $course_id";
    $course = mysqli_fetch_assoc(mysqli_query($connect,$course_sql));
?>

<html>

<head>
    <title>Course Details</title>
    <link rel="stylesheet" type="text/css" href = "../css/courseDetail.css">
    <link rel="stylesheet" type="text/css" href = "../css/courseBanner.css">
</head>

<body>
    <!-- nav bar and stuff -->

    <div class="banner">
        <div class="left-panel">
            <div class="image-container">
                <img src="
                    <?php
                        echo $course["course_image_path"];
                    ?>
                    " alt="Course img"
                />
            </div>

            <div class="left-right-panel">
                <h1>
                    <?php
                        echo $course["course_title"];
                    ?>
                </h1>
                <p>
                    <?php
                        echo $course["start_date"]." - ".$course["end_date"];
                    ?>
                </p>
            </div>
        </div>

        <div class="right-panel">
            <div>
                <button id="toggleDetail">View Course Detail</button>
            </div>
                <?php
                    if ($_SESSION["usertype"]  == "Instructor"){
                ?>
                    <div>
                        <button type='submit' name = "viewStudentList" value="<?php echo $course_section_id?>">View Student List</button>
                    </div>
                    <?php
                    }
                    ?>
        </div>
    </div>

    <div id = "hiddenDetail"  style="display: none;">
        <h3>
            Course Description
        </h3>
        <p>
            <?php
                echo $course["course_description"]; 
            ?>
        </p> 
    </div>

    <div class="announcement">
        <h1> Announcements </h1>
        <?php
            $announcement_sql = "SELECT * FROM announcement WHERE course_section_id = {$course_section_id}";
            $announcement_result = mysqli_query($connect, $announcement_sql);	
            $count = mysqli_num_rows($announcement_result);

            if($count == 0){
        ?>
            <p> No announcement found </p>
        <?php
            }

            else{
                while($row = mysqli_fetch_assoc($announcement_result)){
        ?>
            <div class="each-announcement">
                <div class="upper">
                    <div class="upper-left">
                        <img src="<?php
                            $profile_image_sql = "SELECT * FROM user WHERE username='".$row['username']."'";
                            $profile_image = mysqli_fetch_assoc(mysqli_query($connect,$profile_image_sql));
                            echo $profile_image['profile_image_path'];
                        ?>" alt="Author picture">
                        <h3><?php
                            $author_name_sql = "SELECT * FROM instructor WHERE username='".$row['username']."'";
                            $author_name = mysqli_fetch_assoc(mysqli_query($connect,$author_name_sql));
                            echo $author_name['first_name']." ".$author_name['last_name'];
                        ?></h3>
                    </div>
                    <h3>
                        <?php
                            echo $row['upload_date_time'];
                        ?>
                    </h3>

                </div>

                <div class="bottom">
                    <h3>
                        <?php
                            echo $row['title'];
                        ?> 
                    </h3>
                    <p>
                        <?php
                            echo $row['content'];
                        ?> 
                    </p>
                </div>
            </div>

        <?php
                }
            }
        ?>
    </div>

    
    <script>
        const toggleButton = document.getElementById("toggleDetail")
        const courseDetail = document.getElementById("hiddenDetail")

        toggleButton.addEventListener("click", function(e) {
            if(courseDetail.style.display == "none"){
                courseDetail.style.display = "block"
            }
            else {
                courseDetail.style.display = "none"
            }
        })
    </script>
</body>

</html>