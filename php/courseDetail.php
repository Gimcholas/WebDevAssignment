<?php
    include '../db_connect.php';
    session_start();
    $course_section_id = $_GET['section'];
    $course_id = $_GET['course'];
    $course_sql = "SELECT * FROM course AS c
                    JOIN course_section AS cs ON cs.course_section_id = $course_section_id
                    WHERE c.course_id = $course_id";
    $course = mysqli_fetch_assoc(mysqli_query($connect,$course_sql));
?>

<?php
    if(isset($_POST['makeAnnouncement'])){
        $datetime = new Datetime();
        $formattedDateTime = $datetime->format('Y-m-d H:i:s');

        $title = $_POST['title'];
        $content = $_POST['content'];
        $username = $_SESSION['username'];
        $sql = "INSERT INTO announcement (course_section_id,username,title,content,upload_date_time) VALUES ('$course_section_id','$username','$title','$content','$formattedDateTime')";
        mysqli_query($connect,$sql);
        header("Refresh:0");
        exit;
    }
    else if (isset($_POST['submitEditSectionForm'])){
        $edited_course_section_name = $_POST['edited_course_section_name'];
        $edited_description = $_POST['edited_description'];
        $edited_day = $_POST['edited_day'];
        $edited_start_time = $_POST['edited_start_time'];
        $edited_end_time = $_POST['edited_end_time'];
        $edited_max_student_num = $_POST['edited_max_student_num'];
        $edited_status = $_POST['edited_status'];

        $sql = "UPDATE course_section 
                SET course_section_name = '$edited_course_section_name', description = '$edited_description',
                    day = '$edited_day', start_time = '$edited_start_time', end_time = '$edited_end_time',
                    max_student_num = '$edited_max_student_num', status = '$edited_status' 
                WHERE course_section_id = $course_section_id";
        mysqli_query($connect,$sql);
        header("Refresh:0");
        exit;
    }
?>


<!DOCTYPE html>
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
                <button id="toggleDetail" style = "display:block;">Course Description</button>
            </div>
                <?php
                    if ($_SESSION["usertype"]  == "Instructor"){
                ?>
                    <div>
                        <button type='submit' id="toggleStudentList" style = "display:block;"> Student List</button>
                    </div>
                    <div>
                        <button type='submit' id="toggleUpdateSection" style = "display:block;"> Update Section</button>
                    </div>
                    <?php
                    }
                    ?>
        </div>
    </div>

    <!-- Hidden Course Description (to be open only when user click view) -->
    <div id = "hiddenDetail"  style="display: none;">
        <h3>
            Course Description
        </h3>
        <p>
            <?php
                echo $course["course_description"]; 
            ?>
        </p> 
        <h3>
            Section Description
        </h3>
        <p>
            <?php
                echo $course["description"];
            ?>
        </p>
    </div>


    <div id="hiddenStudentList" style="display:none;">
        <h1> Students <h1>
        <?php
            $student_list_sql = "   SELECT * FROM course_student as a 
                                    JOIN student as s ON a.username = s.username 
                                    JOIN user as u ON a.username = u.username 
                                    WHERE course_section_id = $course_section_id 
                                    ORDER BY s.last_name, s.first_name";
            $student_list = mysqli_query($connect,$student_list_sql);
            $student_count = mysqli_num_rows($student_list);

            if($student_count == 0){
                ?>
                <p>No student found</p>

            <?php
                }
            else {
                while($each_student = mysqli_fetch_array($student_list)){
            ?>
            <div class="each-student">
                <img src="
                <?php
                    echo $each_student['profile_image_path']
                ?>
                " alt = "
                <?php
                    echo $each_student["first_name"]." ".$each_student["last_name"];
                ?> "/>

                <p>
                    <?php
                    echo $each_student["first_name"]." ".$each_student["last_name"];
                   ?> 
                </p>

            </div>

            <?php
                }
            }
        ?>
    </div>

    <div id="hiddenUpdateSection" style="display:none;">
        <h1> Edit Section Information </h1>
            <form name= "editSectionForm" method="post" action="">
        <?php
            $course_section_detail_sql = "SELECT * FROM course_section
                                        WHERE course_section_id = $course_section_id"; 
            $course_section_detail = mysqli_fetch_assoc(mysqli_query($connect, $course_section_detail_sql));

            function generateHTMLEditCourseSection($title,$inputName,$value,$inputType = "text",$attribute1 = "",$attribute2="",$attribute3=""){
                echo 
                '<p> 
                    <span class="title">'.$title.'</span>
                    <span class="colon">:</span>
                    <input type="'.$inputType.'" name="'.$inputName.'" value = "'.$value.'" required ' .$attribute1.' ' .$attribute1.' ' .$attribute1.'>
                </p>';
            }

                generateHTMLEditCourseSection("Name","edited_course_section_name",$course_section_detail["course_section_name"]);
                generateHTMLEditCourseSection("Description","edited_description",$course_section_detail["description"]);
                generateHTMLEditCourseSection("Day","edited_day",$course_section_detail["day"]);
                generateHTMLEditCourseSection("Start Time","edited_start_time",$course_section_detail["start_time"],"time");
                generateHTMLEditCourseSection("End Time","edited_end_time",$course_section_detail["end_time"],"time");
                generateHTMLEditCourseSection("Maximum Student Number","edited_max_student_num",$course_section_detail["max_student_num"],"number",'min = "1"');
                generateHTMLEditCourseSection("Section Status","edited_status",$course_section_detail["status"]);
        ?>
                <input type="submit" name="submitEditSectionForm"/>
            </form>
    </div>


    <div class="announcement" style="display: block;"  id="hiddenAnnouncement">
        <h1> Announcements </h1>

        <div id ="new-announcement-container">
        <?php 
            if($_SESSION["usertype"] == "Instructor"){
        ?>
            <form id = "newAnnouncementForm" method="POST" action="">
                <input id="newAnnouncementInput" placeholder="New announcement Title" name= "title" required> </input>
                <textarea class="hiddenAttributeNewAnnouncement" style="display: none;" oninput="autoExpand(this)" name="content" placeholder="New announcement Content" required></textarea>
                <div class="hiddenAttributeNewAnnouncement" style="display: none;" >
                    <div id="hidden-right-left">
                        <button type="button" id =  "cancelAnnouncement">Cancel</button>
                        <button type="submit" name = "makeAnnouncement">Submit</button>
                    </div>  
                </div>
            </form>

        </div>
        <?php
            }
            $announcement_sql = "SELECT * FROM announcement WHERE course_section_id = {$course_section_id} ORDER BY upload_date_time DESC";
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
                        <?php echo nl2br($row['content']); ?>
                    </p>
                </div>
            </div>

        <?php
                }
            }
        ?>
    </div>

    
    <script>
        function autoExpand(e){
            e.style.height = '2 rem';
            e.style.height = (e.scrollHeight) + "px";
        }
        const toggleDetail = document.getElementById("toggleDetail");
        const toggleStudentList = document.getElementById("toggleStudentList");
        const hiddenStudentList = document.getElementById("hiddenStudentList");
        const hiddenAnnouncement = document.getElementById("hiddenAnnouncement");
        const courseDetail = document.getElementById("hiddenDetail");
        const newAnnouncementInput = document.getElementById("newAnnouncementInput");
        const hiddenAttributeNewAnnouncement = document.querySelectorAll(".hiddenAttributeNewAnnouncement");
        const cancelAnnouncementButton = document.getElementById("cancelAnnouncement");
        // const newannouncementContainer = document.getElementById("new-announcement-container");
        const newAnnouncementForm = document.getElementById("newAnnouncementForm");
        const toggleUpdateSection = document.getElementById("toggleUpdateSection");
        const hiddenUpdateSection = document.getElementById("hiddenUpdateSection");

        toggleDetail.addEventListener("click", function(e) {
            if(courseDetail.style.display == "none"){
                courseDetail.style.display = "block";
                toggleDetail.innerHTML = "Hide Description";
            }
            else {
                courseDetail.style.display = "none";
                toggleDetail.innerHTML = "Course Description";
            }
        })

        toggleStudentList.addEventListener("click", function(e) {
            if(hiddenStudentList.style.display == "none"){
                hiddenStudentList.style.display = "block";
                hiddenAnnouncement.style.display = "none";
                toggleDetail.style.display = "none";
                toggleUpdateSection.style.display = "none";
                toggleStudentList.innerHTML = "Announcement";
            }
            else {
                hiddenStudentList.style.display = "none";
                hiddenAnnouncement.style.display = "block";
                toggleDetail.style.display = "block";
                toggleUpdateSection.style.display = "block";
                toggleStudentList.innerHTML = "Student List";
            }
        })

        toggleUpdateSection.addEventListener("click", function(e) {
            if(hiddenUpdateSection.style.display == "none"){
                hiddenUpdateSection.style.display = "block";
                hiddenAnnouncement.style.display = "none";
                toggleDetail.style.display = "none";
                toggleStudentList.style.display = "none";
                toggleUpdateSection.innerHTML = "Announcement";
            }
            else {
                hiddenUpdateSection.style.display = "none";
                hiddenAnnouncement.style.display = "block";
                toggleDetail.style.display = "block";
                toggleStudentList.style.display = "block";
                toggleUpdateSection.innerHTML = "Update Section";
            }
        })

        cancelAnnouncementButton.addEventListener("click", function(e) {
            Array.from(hiddenAttributeNewAnnouncement).forEach(function(f) {
                newAnnouncementForm.reset();
                f.style.display = "none";
            });
        });

        newAnnouncementInput.addEventListener("click", function(e) {
            Array.from(hiddenAttributeNewAnnouncement).forEach(function(f) {
                if (f.style.display === "none") {
                    f.style.display = "block";
                } 
                // else {
                //     f.style.display = "none";
                // }
            });
        });

        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }


    </script>
</body>


</html>