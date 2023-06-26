<?php 
    include "../db_connect.php";
    include "functions.php";
    $_SESSION["username"] = "Huawei";


    if(isset($_POST["updateCourse"])) {
            if(empty($_POST['courseID'])) {
                die("Course ID not found");
            }
            if(empty($_POST['courseName'])) {
                die("Course name is required"); 
            }
            
            if(empty($_POST['courseIntro'])) {
                die("Course Introduction is required"); 
            }
            if(empty($_POST['startDate'])) {
                die("Start date is required"); 
            }
            if(empty($_POST['endDate'])) {
                die("End date is required"); 
            }

            $imagePath = NULL;
            // Upload image
            if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
                // Directory where the images are stored
                $imageFolderPath = "../files/";
                

                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
                $filename = $_FILES["photo"]["name"];
                $filetype = $_FILES["photo"]["type"];
                $filesize = $_FILES["photo"]["size"];
            
                // Verify file extension
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
            
                // Verify file size - 5MB maximum
                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
            
                // Verify MYME type of the file
                if(in_array($filetype, $allowed)){
                    echo "Old filename: " . $filename;
                    $newFileName = uniqid();
                    if ($filetype == "image/jpg") {
                        $newFileName .= ".jpg";
                    }
                    else if ($filetype == "image/jpeg") {
                        $newFileName .= ".jpeg";
                    }
                    else if ($filetype == "image/png") {
                        $newFileName .= ".png";
                    }

                    if(file_exists($imageFolderPath . $filename)){
                        echo $filename . " is already exists.";  
                    }
                    else {
                        $imagePath = $imageFolderPath . $newFileName;
                        move_uploaded_file($_FILES["photo"]["tmp_name"], $imagePath);
                        

                    }

                    $sql = "UPDATE course SET(course_image_path = '" . $imagePath . "') WHERE course_id = " .$_POST["course_id"] . ";";
                    $result = mysqli_query($connect,$sql);
                    if(!$result) {
                        die('Cannot enter data'.mysqli_error($connect));
                    }
                    
                } else{
                    echo "Error: There was a problem uploading your file. Please try again."; 
                }
            }

            $sql1 = "UPDATE course SET course_title = '{$_POST['courseName']}', 
                    course_description = '{$_POST['courseIntro']}', 
                    start_date = '{$_POST['startDate']}', end_date = '{$_POST['endDate']}' 
                    WHERE course_id = {$_POST['courseID']}";

            
            
            $result = mysqli_query($connect,$sql1);
            if(!$result) {
                die('Cannot enter data'.mysqli_error($connect));
            }
            
            $courseID = mysqli_insert_id($connect); // Get the course_ID from the last query
            
            for($i=0; $i<count($_POST['sectionName']); $i++) {
                if(empty($_POST['courseSectionID'][$i])) {
                    die("Course Section ID missing");
                }
                if(empty($_POST['instructorUsername'][$i])) {
                    die("Instructor username is required"); 
                }
                if(empty($_POST['sectionName'][$i])) {
                    die("Section name is required"); 
                }
                if(empty($_POST['maxStudentNum'][$i])) {
                    die("Maximum Student Number is required"); 
                }
                
                $sql2 = "UPDATE course_section SET username = '{$_POST['instructorUsername'][$i]}'
                        , course_section_name = '{$_POST['sectionName'][$i]}', status = '{$_POST['status'][$i]}'
                        , max_student_num = '{$_POST['maxStudentNum'][$i]}' 
                        WHERE course_section_id = {$_POST['courseSectionID'][$i]}";


            
                $result = mysqli_query($connect,$sql2);
                if(!$result) {
                    die('Cannot enter data'.mysqli_error($connect));
                }

                if(!empty($_POST["startTime"][$i]) && !empty($_POST["endTime"][$i])) {
                    $startTime = date('H:i:s', strtotime($_POST['startTime'][$i]));
                    $endTime = date('H:i:s', strtotime($_POST['endTime'][$i]));
                    $sql2 = "UPDATE course_section SET start_time = '{$startTime}'
                            , end_time = '{$endTime}'
                            WHERE course_section_id = {$_POST['courseSectionID'][$i]}";

                    $result = mysqli_query($connect,$sql2);
                    if(!$result)
                        die('Cannot enter data'.mysqli_error($connect));
                }

                if(!empty($_POST["day"][$i])) {
                    $sql2 = "UPDATE course_section SET day = '{$_POST["day"][$i]}' 
                            WHERE course_section_id = {$_POST['courseSectionID'][$i]}";
                    $result = mysqli_query($connect,$sql2);
                    if(!$result)
                        die('Cannot enter data'.mysqli_error($connect));
                }            
            }
            header("refresh:0.5; url=courseDetail.php?view&course={$_POST['courseID']}");
        }
        
?>

<html>
<head>
    <title>Edit Course Details</title>
</head>

<body>
    <h1>Edit Course</h1>
    <?php 
    if(isset($_GET["edit"])) {
        if(isset($_GET["course"])) {
            $course = getCourse($_GET['course'],$connect);
            $courseSectionResult = getCourseSectionsResult($_GET['course'],$connect);
            ?>
            <form action="" method="post" id="courseForm" enctype="multipart/form-data">
                <input type="text" name="courseID" value = <?php echo $course["course_id"]?> hidden>
            <div class="course-container">
                <div class="input-box">
                <label for="courseName">Course Name</label>
                <input type="text" name="courseName" required value = "<?php echo $course['course_title']; ?>"> 
                </div><br>

                <div class="input-box">
                <label for="startDate">Start Date</label>
                <input type="date" name="startDate" required value = <?php echo $course['start_date']; ?>> 
                </div><br>

                <div class="input-box">
                <label for="endDate">End Date</label>
                <input type="date" name="endDate" required value = <?php echo $course['end_date']; ?>> 
                </div><br>

                <div class="input-box">
                <label for="courseIntro">Course Introduction</label>
                
                <textarea name="courseIntro" rows="5" cols="50"><?php echo $course['course_description']; ?></textarea>
                </div><br>

                <div class="input-box">
                <label for="Course Image">Upload course image</label><br>
                <input type="file" name="photo">
                </div><br>
            </div>

            <div class=course-sections-container>
            <?php while($row = mysqli_fetch_assoc($courseSectionResult)) { ?>
                <div class=course-section>
                <input type="text" name="courseSectionID[]" value = <?php echo $row["course_section_id"]?> hidden>
                <div class="input-box">
                <label for="sectionName">Section Name</label>
                <input type="text" name="sectionName[]" required value="<?php echo $row["course_section_name"]?>">
                </div><br>
    
    
                
                <div class="input-box">
                <label for="instructorUsername">Instructor Username</label>
                <select name="instructorUsername[]" id="originalSelector" required value>
                <!-- Get instructor list -->
                <?php 
                        $sql = "SELECT * FROM instructor where provider_username" . "= '" . $_SESSION['username'] . "';";
                        $result = mysqli_query($connect,$sql);
                        $count = mysqli_num_rows($result);
                        if ($count == 0) {
                            echo $count;
                            ?>
                            <option disabled selected value>No Available Instructors Found</option>
    
                        <?php
                        }
                        while($row2 = mysqli_fetch_array($result)) {
                         ?>    
                            <option value=<?php echo "'" . $row2["username"] . "' "; if ($row2["username"] == $row["username"]) echo " selected";?>>
                                    <?php echo $row2["username"] . " - " . $row2["first_name"] . " " . $row2["last_name"]?>
                            </option> 
                        <?php }
                        ?>
                </select>
                </div><br>
    
                <div class="input-box">
                <label for="startTime">Start Time</label>
                <input type="time" name="startTime[]" value = <?php echo $row["start_time"]?>>
                </div><br>
    
                <div class="input-box">
                <label for="endTime">End Time</label>
                <input type="time" name="endTime[]" value = <?php echo $row["end_time"]?>>
                </div><br>
    
                <div class="input-box">
                <label for="day">Day</label>
                <select name="day[]">
                    <option disabled hidden value="" selected>Choose a day</option>
                    <option value="Sunday" <?php if ($row["day"] == 'Sunday') echo ' selected'; ?>>Sunday</option>
                    <option value="Monday" <?php if ($row["day"] == 'Monday') echo ' selected'; ?>>Monday</option>
                    <option value="Tuesday"<?php if ($row["day"] == 'Tuesday') echo ' selected'; ?>>Tuesday</option>
                    <option value="Wednesday"<?php if ($row["day"] == 'Wednesday') echo ' selected'; ?>>Wednesday</option>
                    <option value="Thursday"<?php if ($row["day"] == 'Thursday') echo ' selected'; ?>>Thursday</option>
                    <option value="Friday"<?php if ($row["day"] == 'Friday') echo ' selected'; ?>>Friday</option>
                    <option value="Saturday"<?php if ($row["day"] == 'Saturday') echo ' selected'; ?>>Saturday</option>
                </select>    
                </div><br>
    
                <div class="input-box">
                <label for="status">Status</label>
                <select name="status[]" required>
                    <option disabled hidden value="" selected>Choose a status</option>
                    <option value="Open" <?php if ($row["status"] == 'Open') echo ' selected';?> >Open</option>
                    <option value="Close" <?php if ($row["status"] == 'Closed') echo ' selected';?> >Closed</option>
                </select>    
                </div><br>

                <div class="input-box">
                    <label for="maxStudentNum">Maximum Student Allowed</label>
                    <input type="number" name="maxStudentNum[]" required value=<?php echo $row["max_student_num"]?>>
                </div><br>
            </div>

            <?php }
            ?>
            </div>
            <a href="courseDetail.php?view&course=<?php echo $_GET["course"]?>">Cancel</a>
            <input type="submit" name="updateCourse" value="Save">
            
            </form>
        

    <?php
        }
    }
    ?>

</body>
</html>

