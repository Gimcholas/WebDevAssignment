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
        $password = $_POST["newPassword"];
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        $edit_password_sql = "UPDATE user SET password_hash =$hashed_password WHERE username = '".$_SESSION['username']."'";
        mysqli_query($connect, $edit_password_sql); 
        header("Refresh:0");
        exit;
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
            die("Error: Please select a valid file format.");
    
        // // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) 
            die("Error: File size is larger than the allowed limit.");
    
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
        }
        else{
            die ("Invalid FileType. Please try again."); }
        
        $insertpath_sql = "UPDATE user SET profile_image_path = '$imagePath' WHERE username = '".$_SESSION['username']."'";
        mysqli_query($connect,$insertpath_sql); 
        header("Location: " . $_SERVER['PHP_SELF']);
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

    $profile = mysqli_fetch_assoc(mysqli_query($connect, $profile_sql)); 

    
}

?>