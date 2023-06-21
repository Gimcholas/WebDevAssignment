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
        <link rel="stylesheet" href="../css/enrollCourse.css">
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
                <button open-modal>Enroll</button>
                <dialog dialog-modal class = "dialog-container">
                    <form>
                        <p>
                            Course : 
                            <?php
                                echo $course['course_title'];
                            ?>
                        </p>

                        <p>
                            Section : 
                            <?php
                                echo $each_section['course_section_name'];
                            ?>
                        </p>

                        <p>
                            Lecturer : 
                            <?php
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
                                echo $each_section['day'];
                            ?>
                        </p>

                        <p>
                            Time : 
                            <?php
                                echo $each_section['start_time']." - ".$each_section['end_time'];
                            ?>
                        </p>

                        <p> </p>

                        <p>
                            Do you really want to enroll this course?
                        </p>

                        <button type="submit" formmethod="dialog">Cancel </button>
                        <button type="submit" method = "POST" name='confirmation' value= <?php echo $each_section['course_section_id']?>>Confirm</button>
                    </form>
                </dialog>
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

        <?php
            }
        ?>

        <script>
            const dialogModal = document.querySelector("[dialog-modal]")
            const openModal = document.querySelector('[open-modal]')
            const closeModal = document.querySelector('[close-modal]')
            openModal.addEventListener("click", () =>{
                dialogModal.showModal()
            })

            closeModal.addEventListener("click", () =>{
                dialogModal.close()
            })

        </script>
    </body>
</html>

<?php
    if(isset($_POST['confirmation'])){
        $disable_foreign_key_check_sql = "SET FOREIGN_KEY_CHECKS=0";
        mysqli_query($connect,$disable_foreign_key_check_sql);
        $insert_sql = "INSERT INTO course_student (course_section_id, username, course_completed) VALUES ('$course_section_id', '".$_SESSION["username"]."', '0')";
        $output = mysqli_query($connect,$insert_sql);
        if($output){
            header("Location: ../html/courseDashboard.php");
        }
    }
?>