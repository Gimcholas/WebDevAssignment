<?php include "../db_connect.php";
    session_start();
    $_SESSION["username"] = "Huawei";
?>

<!DOCTYPE html>
<html>
<head> 
    <title>Add Course</title>
    <link rel="stylesheet" href="../NavBar/NavBarStyle.css"/>
    <link rel='stylesheet' type="text/css" href=style.css>
    <script text="text/javascript" src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src ="../js/navbar.js"></script></head>
</head>

<body>
<div class="Container">
    <div class="sidebar">
        <?php include '../NavBar/NavBar.php'?>
    </div>
    <div class="content" id="content"> 
    <form action="createCourse.php" method="post" id="courseForm" enctype="multipart/form-data">
        <?php if($_SESSION["usertype"] == "Admin") {
            // Show the select training provider
                    echo "<div class='input-box'>";
                    echo "<label for='providerUsername'>Provider Username </label>";
                    echo "<select name='providerUsername[]' required >";
                    echo "<option disabled selected value>Select A Training Provider</option>";
                    echo "<?php"; 
                    $sql = 'SELECT * FROM training_provider;';
                    $result = mysqli_query($connect,$sql);
                    $count = mysqli_num_rows($result);
                    if ($count == 0) {
                        ?>
                        <option disabled selected value>No Training Provider Found</option>

                    <?php
                    }
                    while($row = mysqli_fetch_array($result)) {
                        ?>
                        <option value="<?php echo $row["username"] ?>"><?php echo $row["username"] . " - " 
                        . $row["provider_name"]?></option> 
                    <?php } 
                ?>
            </select>
            </div><br>    
        <?php
        }
        ?>

        <div class="input-box">
        <label for="courseName">Course Name</label>
        <input type="text" name="courseName" required> 
        </div><br>

        <div class="input-box">
        <label for="startDate">Start Date</label>
        <input type="date" name="startDate" required> 
        </div><br>

        <div class="input-box">
        <label for="endDate">End Date</label>
        <input type="date" name="endDate" required> 
        </div><br>

        <div class="input-box">
        <label for="courseIntro">Course Introduction</label>
        <!-- <input type="text" name="courseIntro" required>  -->
        <textarea name="courseIntro" rows="5" cols="40"></textarea>
        </div><br>

        <div class="input-box">
        <label for="Course Image">Upload course image</label><br>
        <input type="file" name="photo">
        </div><br>

        <hr><br>
        <div id="courseSection">            
            <div class="input-box">
            <label for="sectionName">Section Name</label>
            <input type="text" name="sectionName[]" required>
            </div><br>


            <div class="input-box">
            <label for="instructorUsername">Instructor Username</label>
            <!-- <input type="text" name="instructorUsername[]" list="instructors" autocomplete="off" required/> -->
            <select name="instructorUsername[]" id="originalSelector" required >
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
                    while($row = mysqli_fetch_array($result)) {
                        ?>
                        <option value="<?php echo $row["username"] ?>"><?php echo $row["username"] . " - " 
                        . $row["first_name"] . " " . $row["last_name"]?></option> 
                    <?php } 
                ?>
            </select>
            </div><br>

            <!-- <div class="input-box">
            <label for="startTime">Start Time</label>
            <input type="time" name="startTime[]" required>
            </div><br>

            <div class="input-box">
            <label for="endTime">End Time</label>
            <input type="time" name="endTime[]" required>
            </div><br>

            <div class="input-box">
            <label for="day">Day</label>
            <select name="day[]" required>
                <option value="">Choose a day</option>
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
            </select>    
            </div><br> -->

            <div class="input-box">
                <label for="maxStudentNum">Maximum Student Allowed</label>
                <input type="number" name="maxStudentNum[]" required>
            </div><br>
        </div>
        <hr><br>
        
        <div id="additionalSection"></div>
        
        <div class="addSection">
        <input type="button" value="Add More Section" onclick="addSection()">
        </div>

        <div class="submit">
        <input type="submit" value="Create Course" name="submit">
        </div>

        <div class='back'>
            <?php if ($_SESSION["usertype"] == "Admin") {
                echo "<a href='../admin/courseOverview.php'><input type='button' value = 'Back'></a><br><br>";
            }
            else {
                echo "<a href='courses.php'><input type='button' value = 'Back'></a><br><br>";                
            }?>
        </div>
    </form>
    </div>
</div>
</body>
</html>

<?php 
    if(isset($_POST['submit'])) {
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
        
        echo $_POST['courseName']; 
        echo "<br>";
        echo $_POST['startDate'];
        echo "<br>";
        echo $_POST['endDate'];
        echo "<br>";
        echo $_POST['courseIntro'];
        echo "<br><br>";

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
                 
            } else{
                echo "Error: There was a problem uploading your file. Please try again."; 
            }
        }

        $sql1 = "INSERT into course(provider_username, course_title, course_description, start_date, end_date,course_image_path) values ('" . $_SESSION['username'] . "', '" . $_POST['courseName'] . "', '" . $_POST['courseIntro'] . "', '" . $_POST['startDate'] . "', '" . $_POST['endDate'] . "', '" . $imagePath ."');";
        
        
        $result = mysqli_query($connect,$sql1);
        if(!$result) {
            die('Cannot enter data'.mysqli_error($connect));
        }
        
        $courseID = mysqli_insert_id($connect); // Get the course_ID from the last query
        
        for($i=0; $i<count($_POST['sectionName']); $i++) {
            echo count($_POST['sectionName']);
            if(empty($_POST['instructorUsername'][$i])) {
                die("Instructor username is required"); 
            }
            if(empty($_POST['sectionName'][$i])) {
                die("Section name is required"); 
            }
            if(empty($_POST['maxStudentNum'][$i])) {
                die("Maximum Student Number is required"); 
            }
        
            $sql2 = "INSERT into course_section(course_id, username, course_section_name, status, max_student_num)
                 values (" . $courseID . ", '" . $_POST['instructorUsername'][$i] . "', '" . $_POST['sectionName'][$i] . "', " . "'Open'," .$_POST['maxStudentNum'][$i] . ");";
        
            $result = mysqli_query($connect,$sql2);
            if(!$result) {
                die('Cannot enter data'.mysqli_error($connect));
            }
            echo "sectionName" . $i . ":" . $_POST['sectionName'][$i] . "<br>";
            echo "instructorUsername" . $i . ":" . $_POST['instructorUsername'][$i] . "<br>";
            echo "maxStudentNum" .  $i . ":" . $_POST['maxStudentNum'][$i] . "<br><br>";
            
        }

        
    }
    
?>