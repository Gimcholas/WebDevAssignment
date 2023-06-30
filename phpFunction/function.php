<?php

include '../db_connect.php';
include 'function2.php';
if(isset($_SESSION['usertype'])) {
    if($_SESSION['usertype'] != "Admin" || $_SESSION['usertype'] != "Provider" || $_SESSION['usertype'] != "Instructor" || $_SESSION['usertype'] != "Student"){
    header("Location: ../login.php");
    }
}


function registerCourseDashboard(){
    createCourseDashboard(false);
}

function completedCourseDashboard(){
    createCourseDashboard(true,true);
}

function createCourseDashboard($myCoursePage = true,$completed = false){
    global $connect;
    echo "<h1>";
    if ($_SESSION["usertype"]  == "Student"){
        if(!$myCoursePage){
            echo "Register For Course";
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
            if($completed){
                echo "Completed Course";
                $course_sql = "SELECT * FROM course_student AS cst
                                JOIN course_section AS csc ON csc.course_section_id = cst.course_section_id
                                JOIN course AS c ON c.course_id = csc.course_id
                                WHERE cst.username = '{$_SESSION['username']}' 
                                    AND course_completed = 1";
            }
            else{
                echo "My Course";
                $course_sql = "SELECT * FROM course_student AS cst
                                JOIN course_section AS csc ON csc.course_section_id = cst.course_section_id
                                JOIN course AS c ON c.course_id = csc.course_id
                                WHERE cst.username = '{$_SESSION['username']}' 
                                    AND course_completed = 0";
            }
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

function generateHTMLProfileDetail($title,$variable){
    echo '<p><span class="title">'.$title.'</span><span class="colon">:</span>'.$variable.'</p>';
}

function generateHTMLEditProfile($title,$inputName,$value,$inputType = "text"){
    echo 
    '<p> 
        <span class="title">'.$title.'</span>
        <span class="colon">:</span>
        <input type="'.$inputType.'" name="'.$inputName.'" value = "'.$value.'" required>
    </p>';
}

function generateHTMLChangePassword($title,$inputName){
    echo 
    '<p> 
        <span class="title">'.$title.'</span>
        <span class="colon">:</span>
        <input id="'.$inputName.'" name="'.$inputName.'" placeholder = "'.$title.'" type="password" required>
    </p>';
}

function generateHTMLEditCourseSection($title,$inputName,$value,$inputType = "text",$attribute1 = "",$attribute2="",$attribute3=""){
    echo 
    '<p> 
        <span class="title">'.$title.'</span>
        <span class="colon">:</span>
        <input type="'.$inputType.'" name="'.$inputName.'" value = "'.$value.'" required ' .$attribute1.' ' .$attribute1.' ' .$attribute1.'>
    </p>';
}

function createProfilePage(){
    global $connect;
    if(array_key_exists('postdata',$_SESSION)){
        unset($_SESSION['postdata']);
    }
    if(isset($_POST['submitEdit'])){
        $contactNumber = $_POST["contactNumber"];
        $emailAddress = $_POST["emailAddress"];
        if($_SESSION['usertype'] == "Student"){
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $dateOfBirth = $_POST["dateOfBirth"];

            $edit_profile_sql = "UPDATE student
                                    SET first_name = '$firstName', last_name = '$lastName', date_of_birth = '$dateOfBirth', contact_number = '$contactNumber', email = '$emailAddress' 
                                    WHERE username = '".$_SESSION['username']."'";
        }

        else if($_SESSION['usertype'] == "Instructor"){
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            
            $edit_profile_sql = "UPDATE instructor
                                    SET first_name = '$firstName', last_name = '$lastName', contact_number = '$contactNumber', email = '$emailAddress' 
                                    WHERE username = '".$_SESSION['username']."'";
        }

        else if($_SESSION['usertype'] == "Provider"){
            $providerName = $_POST["providerName"];
            
            $edit_profile_sql = "UPDATE training_provider
                                    SET provider_name = '$providerName', contact_number = '$contactNumber', email = '$emailAddress' 
                                    WHERE username = '".$_SESSION['username']."'";
        }
 

        mysqli_query($connect, $edit_profile_sql); 
        header("Refresh:0");
        exit;
    }
    if (isset($_POST["submitChangePWD"])){
        $oldPassword = $_POST["oldPassword"];
        $old_pass = mysqli_fetch_assoc(mysqli_query($connect,"SELECT password_hash FROM user WHERE username = '".$_SESSION['username']."'"));

        if(password_verify($oldPassword,$old_pass["password_hash"])){
            $newPassword = $_POST["newPassword"];
            $hashed_password = password_hash($newPassword,PASSWORD_DEFAULT);
            $edit_password_sql = "UPDATE user SET password_hash =$hashed_password WHERE username = '".$_SESSION['username']."'";
            mysqli_query($connect, $edit_password_sql); 
            header("Refresh:0");
            exit;
        }
        else{
            generateJavaScriptAlert("Old password is wrong");
        }
    }

    if (isset($_FILES["uploadedPicture"])){

        $imageFolderPath = "../files/profile_picture/";

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        $filename = $_FILES["uploadedPicture"]["name"];
        $filetype = $_FILES["uploadedPicture"]["type"];
        $filesize = $_FILES["uploadedPicture"]["size"];
    
        // better handle error in javascript ??
        // // Verify file extension
        if(!array_key_exists(pathinfo($filename, PATHINFO_EXTENSION), $allowed)) 
            generateJavaScriptAlert("Error: Please select a valid file format.");
    
        else{
            // // Verify file size - 5MB maximum
            $maxsize = 5 * 1024 * 1024;
            if($filesize > $maxsize) 
                generateJavaScriptAlert("Error: File size is larger than the allowed limit.");
        
            else{
                // Verify MYME type of the file
                if(in_array($filetype, $allowed)){
                    $newFileName = $_SESSION["username"];
                    if ($filetype == "image/jpg") {
                        $newFileName .= ".jpg";
                    }
                    else if ($filetype == "image/jpeg") {
                        $newFileName .= ".jpeg";
                    }
                    else if ($filetype == "image/png") {
                        $newFileName .= ".png";
                    }

                    $imagePath = $imageFolderPath . $newFileName;
                    if(file_exists($imagePath)){
                        echo $filename . " is already exists.";  
                        chmod($imagePath,0755);
                        unlink($imagePath);
                    }
                    move_uploaded_file($_FILES["uploadedPicture"]["tmp_name"], $imagePath);
                    $insertpath_sql = "UPDATE user SET profile_image_path = '$imagePath' WHERE username = '".$_SESSION['username']."'";
                    mysqli_query($connect,$insertpath_sql); 
                    header("Location: " . $_SERVER['PHP_SELF']);
                }
                else{
                    generateJavaScriptAlert("Invalid FileType. Please try again."); 
                }
            }
        }
    }

    
    if($_SESSION['usertype'] == "Student"){
        $profile_sql = "SELECT * FROM user as u 
                        JOIN student as s ON s.username = u.username
                        WHERE u.username = '".$_SESSION['username']."'";
    }

    else if($_SESSION['usertype'] == "Instructor"){
        $profile_sql = "SELECT * FROM user as u 
                        JOIN instructor as i ON i.username = u.username
                        WHERE u.username = '".$_SESSION['username']."'";
    }

    else if($_SESSION['usertype'] == "Provider"){
        $profile_sql = "SELECT * FROM user as u 
                        JOIN training_provider as tp ON tp.username = u.username
                        WHERE u.username = '".$_SESSION['username']."'";
    }
    else if($_SESSION['usertype'] == "Admin") {
        $profile_sql = "SELECT * FROM user WHERE username = '".$_SESSION['username']."'";
    }


    $profile = mysqli_fetch_assoc(mysqli_query($connect, $profile_sql)); 

    echo<<<HTML
    <div class = "container">
        <div class = "left-side">
            <form id="changeProfilePictureForm" method="POST" action="" enctype="multipart/form-data">
                <label for="uploadPicture">
                    <img src = "{$profile['profile_image_path']}" alt="Profile Image"/>

                    <div class="image_overlay image_overlay_blur">
                        <h3>Change</h3>
                        <p>Profile Picture</p>
                    </div>
                </label>
                <input type="file" id="uploadPicture" name="uploadedPicture" style="display: none;"/>
            </form>

        </div>

        <div class = "right-side">

            <div id="displayDIV" style = "display:block;">

                <h1>
    HTML;
                    if($_SESSION['usertype'] == "Student" || $_SESSION['usertype'] == "Instructor"){
                        echo $profile["first_name"]." ".$profile["last_name"];
                    }
                    else if($_SESSION['usertype'] == "Provider"){
                        echo $profile["provider_name"];
                    }
                    else if ($_SESSION['usertype'] == "Admin"){
                        echo $profile["username"];
                    }
    echo<<<HTML
                </h1>
    HTML;
                    if ($_SESSION['usertype'] != "Admin") {
                        if($_SESSION['usertype'] == "Student" || $_SESSION['usertype'] == "Instructor"){
                            generateHTMLProfileDetail("Training Provider",$profile["provider_username"]);
                        }

                        generateHTMLProfileDetail("Join on",$profile["joined_date"]);
                        generateHTMLProfileDetail("Contact",$profile["contact_number"]);
                        generateHTMLProfileDetail("Email",$profile["email"]);

                        if($_SESSION['usertype'] == "Student"){
                            generateHTMLProfileDetail("Date Of Birth",$profile["date_of_birth"]);
                            generateHTMLProfileDetail("Academic Program",$profile["academic_program"]);
                        }
                    }
                    if ($_SESSION['usertype'] != "Admin") {
                        echo "<button id='startEditButton'>Edit Profile</button>";
                    }
    echo<<<HTML
                <button id="changePasswordButton">Change Password</button>
            </div>

            <div id="editDIV" style="display:none;">
                <form id="editProfileForm" method="POST" action="">
                    <h1>
                        Edit Profile
                    </h1>

    HTML;
                        if($_SESSION['usertype'] == "Student" || $_SESSION['usertype'] == "Instructor"){
                            generateHTMLEditProfile("First Name","firstName",$profile["first_name"]);
                            generateHTMLEditProfile("Last Name","lastName",$profile["last_name"]);
                        }
                        else if($_SESSION['usertype'] == "Provider"){
                            generateHTMLEditProfile("Provider Name","providerName",$profile["provider_name"]);
                        }

                        generateHTMLEditProfile("Contact","contactNumber",$profile["contact_number"],"tel");
                        generateHTMLEditProfile("Email","emailAddress",$profile["email"],"email");

                        if($_SESSION['usertype'] == "Student"){
                            generateHTMLEditProfile("Date Of Birth","dateOfBirth",$profile["date_of_birth"],"date");
                        }
    echo<<<HTML

                    <button type="button" id = "cancelEdit">Cancel</button>
                    <button type="submit" id = "submitEdit" name = "submitEdit">Edit</button>

                </form>
            </div>


            <div id="newPasswordDIV" style="display:none;">
                <form id="newPasswordForm" method="POST" action="">
                    <h1>Change to New Password</h1>
    HTML;
                        
                        generateHTMLChangePassword("Old Password","oldPassword");
                        generateHTMLChangePassword("New Password","newPassword");
                        generateHTMLChangePassword("Re-enter New Password","newPasswordConfirm");
    echo<<<HTML
                    <button type="button" id = "cancelChangePWD">Cancel</button>
                    <button type="submit" id = "submitChangePWD" name = "submitChangePWD">Edit</button>

                </form>
            </div>
        </div>
    </div>
    HTML;
}

function createCourseDetailPage(){
    global $connect;
    $course_section_id = $_GET['section'];
    $course_id = $_GET['course'];
    $course_sql = "SELECT * FROM course AS c
                    JOIN course_section AS cs ON cs.course_section_id = $course_section_id
                    WHERE c.course_id = $course_id";
    $course = mysqli_fetch_assoc(mysqli_query($connect,$course_sql));
    
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

    echo<<<HTML
        <div class="banner">
        <div class="left-panel">
            <div class="image-container">
                <img src="{$course['course_image_path']}" alt="Course img"/>
            </div>

            <div class="left-right-panel">
                <h1>
                    {$course['course_title']}
                </h1>
                <p>
                    {$course['start_date']} - {$course['end_date']}
                </p>
            </div>
        </div>

        <div class="right-panel">
            <div>
                <button id="toggleDetail" style = "display:block;">Course Description</button>
            </div>
    HTML;
                    if ($_SESSION["usertype"]  == "Instructor"){
    echo<<<HTML
                    <div>
                        <button type='submit' id="toggleStudentList" style = "display:block;"> Student List</button>
                    </div>
                    <div>
                        <button type='submit' id="toggleUpdateSection" style = "display:block;"> Update Section</button>
                    </div>
    HTML;
                    }
    echo<<<HTML
            </div>
        </div>

        <div id = "hiddenDetail"  style="display: none;">
        <h3>
            Course Description
        </h3>
        <p>
            {$course["course_description"]}
        </p> 
        <h3>
            Section Description
        </h3>
        <p>
            {$course["description"]}
        </p>
        </div>
        <div id="hiddenStudentList" style="display:none;">
        <h1> Students <h1>
    HTML;
            $student_list_sql = "   SELECT * FROM course_student as a 
                                    JOIN student as s ON a.username = s.username 
                                    JOIN user as u ON a.username = u.username 
                                    WHERE course_section_id = $course_section_id 
                                    ORDER BY s.last_name, s.first_name";
            $student_list = mysqli_query($connect,$student_list_sql);
            $student_count = mysqli_num_rows($student_list);

            if($student_count == 0){
    echo<<<HTML
                <p>No student found</p>
    HTML;
                }
            else {
                while($each_student = mysqli_fetch_array($student_list)){
    echo<<<HTML
            <div class="each-student">
                <img src="{$each_student['profile_image_path']}" alt="{$each_student['first_name']} {$each_student['last_name']}"/>                <p>
                    {$each_student['first_name']} {$each_student['last_name']}
                </p>

            </div>
    HTML;
                }
            }
    echo<<<HTML
        </div>

        <div id="hiddenUpdateSection" style="display:none;">
        <h1> Edit Section Information </h1>
            <form name= "editSectionForm" method="post" action="">
    HTML;
            $course_section_detail_sql = "SELECT * FROM course_section
                                        WHERE course_section_id = $course_section_id"; 
            $course_section_detail = mysqli_fetch_assoc(mysqli_query($connect, $course_section_detail_sql));

                generateHTMLEditCourseSection("Name","edited_course_section_name",$course_section_detail["course_section_name"]);
                generateHTMLEditCourseSection("Description","edited_description",$course_section_detail["description"]);
                generateHTMLEditCourseSection("Day","edited_day",$course_section_detail["day"]);
                generateHTMLEditCourseSection("Start Time","edited_start_time",$course_section_detail["start_time"],"time");
                generateHTMLEditCourseSection("End Time","edited_end_time",$course_section_detail["end_time"],"time");
                generateHTMLEditCourseSection("Maximum Student Number","edited_max_student_num",$course_section_detail["max_student_num"],"number",'min = "1"');
                generateHTMLEditCourseSection("Section Status","edited_status",$course_section_detail["status"]);
    echo<<<HTML
                <input type="submit" name="submitEditSectionForm"/>
            </form>
        </div>


        <div class="announcement" style="display: block;"  id="hiddenAnnouncement">
        <h1> Announcements </h1>

        <div id ="new-announcement-container">
    HTML;
            if($_SESSION["usertype"] == "Instructor"){
    echo<<<HTML
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
    HTML;
            }
            $announcement_sql = "SELECT * FROM announcement WHERE course_section_id = {$course_section_id} ORDER BY upload_date_time DESC";
            $announcement_result = mysqli_query($connect, $announcement_sql);	
            $count = mysqli_num_rows($announcement_result);

            if($count == 0){
    echo<<<HTML
            <p> No announcement found </p>
    HTML;
            }

            else{
                while($row = mysqli_fetch_assoc($announcement_result)){
                        $profile_image_sql = "SELECT * FROM user WHERE username='".$row['username']."'";
                        $profile_image = mysqli_fetch_assoc(mysqli_query($connect,$profile_image_sql));
                        $author_name_sql = "SELECT * FROM instructor WHERE username='".$row['username']."'";
                        $author_name = mysqli_fetch_assoc(mysqli_query($connect,$author_name_sql));
    echo<<<HTML
            <div class="each-announcement">
                <div class="upper">
                    <div class="upper-left">
                        <img src="{$profile_image['profile_image_path']}" alt="{$author_name['first_name']} {$author_name['last_name']}">
                        <h3>
                            {$author_name['first_name']} {$author_name['last_name']};
                        </h3>
                    </div>
                    <h3>
                        {$row['upload_date_time']}
                    </h3>

                </div>

                <div class="bottom">
                    <h3>
                        {$row['title']} 
                    </h3>
                    <p>
    HTML;
                        echo nl2br($row['content']);
    echo<<<HTML
                    </p>
                </div>
            </div>

    HTML;
                }
            }
    echo<<<HTML
        </div>
    HTML;
}

function createRegisterCoursePage(){
    global $connect;
    $course_id = $_GET['course'];
    $course_sql = "SELECT * FROM course WHERE course_id = $course_id";
    $course = mysqli_fetch_assoc(mysqli_query($connect,$course_sql));

    $course_section_sql = "SELECT * FROM course_section AS cs
                            JOIN instructor AS i ON i.username = cs.username
                            JOIN user AS u ON u.username = cs.username
                            where cs.course_id = $course_id";
    $course_section = mysqli_query($connect,$course_section_sql); 

    echo<<<HTML
    <div class="banner">
        <div class="left-panel">
            <div class="image-container">
                <img src="{$course['course_image_path']}" alt="Course img"/>
            </div>

            <div class="left-right-panel">
                <h1>
                    {$course['course_title']}
                </h1>
                <p>
                    {$course["start_date"]} - {$course["end_date"]}
                </p>
            </div>
        </div>

        <div class="right-panel">
            <form action="enrollment.php" method="post" >
                <button type='submit' name = "Enroll" value="{$course_id}">Enroll</button>
            </form>
        </div>
    </div>

    <div class='courseIntroSection'>
        <h2>Course Introduction</h2>
        <p>
            {$course['course_description']}
        </p>
    </div>


    <div class= "instructor-list">
    <h2>Course Instructor</h2>
    HTML;
            while($section = mysqli_fetch_assoc($course_section)){
    echo<<<HTML
            <div class = "instructor">
                <img src="{$section['profile_image_path']}" alt = "{$section['first_name']} {$section['last_name']}">
                    <p>
                        {$section["first_name"]} {$section["last_name"]}
                    </p>
            </div>
    HTML;
            }
    echo<<<HTML
    </div>
    HTML;
}

function createEnrollmentPage(){
    global $connect;
    if(isset($_POST['confirmation'])){
        $course_section_id = $_POST["confirmation"];
        $insert_sql = "INSERT INTO course_student (course_section_id, username) VALUES ('$course_section_id', '".$_SESSION["username"]."');";
        $output = mysqli_query($connect,$insert_sql);
        if($output){
            header("Location: dashboard.php");
        }
    }

    if(isset($_POST["Enroll"])){
        $course_id = $_POST['Enroll'];
        $course_sql = "SELECT * FROM course WHERE course_id = $course_id";
        $course = mysqli_fetch_assoc(mysqli_query($connect,$course_sql));

        $course_section_sql = "SELECT * FROM course_section AS cs
                                JOIN instructor AS i ON i.username = cs.username
                                JOIN user AS u ON u.username = cs.username
                                where cs.course_id = $course_id";
        $course_section = mysqli_query($connect,$course_section_sql); 
    
        echo<<<HTML
            <h1>
                {$course['course_title']}
            </h1>

        HTML;
                while($each_section = mysqli_fetch_assoc($course_section)){
        echo<<<HTML
            <div class="instructor-list">

                <img src="{$each_section['profile_image_path']}" alt = "{$each_section['first_name']} {$each_section['last_name']}">

                <h3>
                    {$each_section['first_name']} {$each_section['last_name']}
                </h3>

                <h3>   
                    {$each_section['course_section_name']}
                </h3>
                <h3>   
                    {$each_section['day']}
                </h3>
                <h3>   
                    {$each_section['start_time']} - {$each_section['end_time']}
                </h3>
        HTML;
                    if($each_section["status"] == "Open"){
        echo<<<HTML
                    <button open-modal="{$each_section['course_section_id']}">Enroll</button>

                    <dialog dialog-modal class="dialog-container dialog-{$each_section['course_section_id']}">
                        <form method="post" action="">
                            <p>
                                Course : {$course['course_title']}
                            </p>

                            <p>
                                Section : {$each_section['course_section_name']}
                            </p>

                            <p>
                                Lecturer : {$each_section['first_name']} {$each_section['last_name']}
                            </p>

                            <p>
                                Duration : {$course['start_date']} - {$course['end_date']}
                            </p>

                            <p>
                                Date : {$each_section['day']}
                            </p>

                            <p>
                                Time : {$each_section['start_time']} - {$each_section['end_time']}
                            </p>

                            <p> </p>

                            <p>
                                Do you really want to enroll this course?
                            </p>

                            <button type="submit" formmethod="dialog">Cancel </button>
                            <button type="submit" method = "post" name='confirmation' value= '{$each_section["course_section_id"]}'>Confirm</button>
                        </form>
                    </dialog>
        HTML;
                    }
                    if($each_section["status"] == "Close"){
        echo<<<HTML
                    <h3> Closed </h3>
        HTML;
                    }

        echo<<<HTML
            </div>
        HTML;
        }
    }

}

function createStudentFeedbackPage(){
    global $connect;
    echo<<<HTML

    HTML;
}
function generatePage($title,$function,$anyCodeOnHead="",$anyCodeInsideBody=""){
    session_start();
    echo <<<HTML
        <!DOCTYPE html>
        <html>
        <head> 
        <title>$title</title>
        <link rel="stylesheet" href="../navBar/navBarStyle.css"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src ="../js/navbar.js"></script>
        $anyCodeOnHead
        </head>
        <body>
        <div class="Container">
            <div class="sidebar">
    HTML;
                include '../navBar/navBar.php';
    echo <<<HTML
            </div>
            <div class="content" id="content"> 
    HTML;
                $function();

    echo <<<HTML
            </div>
        </div>
        $anyCodeInsideBody
        </body>
        </html>
    HTML;
}