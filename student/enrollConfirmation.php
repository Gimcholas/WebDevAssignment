<?php include '../db_connect.php' ?>
<?php
    if(isset($_POST["Enroll"])){
        $course_section_id = $_POST['Enroll'];
        $course_section_sql = "SELECT * FROM course_section WHERE course_section_id = $course_section_id";
        $course_section = mysqli_fetch_assoc(mysqli_query($connect,$course_section_sql));

        $course_sql = "SELECT * FROM course WHERE course_id = '".$course_section['course_id']."'";
        $course = mysqli_fetch_assoc(mysqli_query($connect,$course_sql));
    }
?>

<html>
    <head>
        <title>Enroll Confirmation</title>
        <link rel="stylesheet" href="enrollConfirmation.css">
    </head>

    <body>  
        <?php
            if(isset($_POST["Enroll"])){
        ?>
        <p>
            Course : 
            <?php
                echo $course['course_title'];
            ?>
        </p>

        <p>
            Section : 
            <?php
                echo $course_section['course_section_name'];
            ?>
        </p>

        <p>
            Lecturer : 
            <?php
                $instructor_profile_sql = "SELECT first_name,last_name FROM instructor WHERE username = '".$course_section['username']."'";
                $instructor_profile = mysqli_fetch_assoc(mysqli_query($connect,$instructor_profile_sql));
                echo $instructor_profile['first_name']." ".$instructor_profile['last_name'];
            ?>
        </p>

        <p>
            Duration : 
            <?php
                echo $course['start_date']." - ".$course['end_date'];
            ?>
        </p>

        <p>
            Date : 
            <?php
                echo $course_section['day'];
            ?>
        </p>

        <p>
            Time : 
            <?php
                echo $course_section['start_time']." - ".$course_section['end_time'];
            ?>
        </p>

        <p>
            Do you really want to enroll this course?
        </p>

        <form method="post" action="">
            <button type="submit" name="confirmation" value="no">Cancel</button>
            <button type="submit" name="confirmation" value="yes">Confirm</button>
        </form>

        <?php
            }
        ?>

    </body>
</html>

<?php
    if(isset($_POST['confirmation'])){
        if($_POST['confirmation']=='yes'){
            $disable_foreign_key_check_sql = "SET FOREIGN_KEY_CHECKS=0";
            mysqli_query($connect,$disable_foreign_key_check_sql);
            $insert_sql = "INSERT INTO course_student (course_section_id, username, course_completed) VALUES ('$course_section_id', '".$_SESSION["username"]."', '0')";
            mysqli_query($connect,$insert_sql);
        }
        else{?>
            <script type="text/javascript">
			    alert("<?php echo $mtitle. ' cancelled.'; ?>");
		    </script><?php
            echo "Cancelled the confirmation";
        }

    }
?>