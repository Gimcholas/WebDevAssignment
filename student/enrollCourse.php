<?php include '../db_connect.php' ?>
<?php
    if(isset($_POST["Enroll"])){
        $course_id = $_POST['Enroll'];
        $course_sql = "SELECT * FROM course WHERE course_id = $course_id";
        $course = mysqli_fetch_assoc(mysqli_query($connect,$course_sql));

        $course_section_sql = "SELECT * FROM course_section WHERE course_id = $course_id";
        $course_section_query = mysqli_query($connect,$course_section_sql);
    }
?>

<html>
    <head>
        <title>Enroll</title>
        <link rel="stylesheet" href="enrollCourse.css">
    </head>

    <body>
        <h1>
            <?php
                echo $course['course_title'];
            ?>
        </h1>

        <?php
            while($each_section = mysqli_fetch_assoc($course_section_query)){
        ?>
        <div class="instructor-list">

            <img src="
            <?php 
                $instructor_image_sql = "SELECT profile_image_path FROM user WHERE username ='".$each_section['username']."'";
                $instructor_image = mysqli_fetch_assoc(mysqli_query($connect,$instructor_image_sql));
                echo $instructor_image['profile_image_path'];
            ?>
            " alt = "
            <?php
                $instructor_profile_sql = "SELECT first_name,last_name FROM instructor WHERE username = '".$each_section['username']."'";
                $instructor_profile = mysqli_fetch_assoc(mysqli_query($connect,$instructor_profile_sql));
                echo $instructor_profile['first_name']." ".$instructor_profile['last_name'];
            ?>
            ">

        <h3>
            <?php
                echo $instructor_profile['first_name']." ".$instructor_profile['last_name'];
            ?>
        </h3>

        <h3>   
            <?php
                echo $each_section['course_section_name'];
            ?>
        </h3>
        <h3>   
            <?php
                echo $each_section['day'];
            ?>
        </h3>
        <h3>   
            <?php
                echo $each_section['start_time']." - ".$each_section['end_time'];
            ?>
        </h3>

        <?php
            if($each_section["status"] == "Open"){
        ?>
            <form action='enrollConfirmation.php' method='post'>
                <button type='submit' name='Enroll' value=<?php echo $each_section['course_section_id']?>>Enroll</button>
            </form>

        <?php
            }
        ?>

        <?php
            if($each_section["status"] == "Close"){

        ?>
            <h3> Closed </h3>
        <?php
            }
        ?>

        </div>

        

        
        </div>



        <?php
            }
        ?>


    </body>
</html>