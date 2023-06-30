<?php include '../db_connect.php';
session_start();
if(isset($_SESSION['usertype']) != "Admin" or isset($_SESSION['usertype']) != "Provider") {
    header("Location: ../login.php");
}
?>

<!DOCTYPE html>
<html>
<head> 
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../navBar/navBarStyle.css"/>
    <link rel="stylesheet" href="courses.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src ="../js/navbar.js"></script>    <script src ="../js/navbar.js"></script>
</head>

<body>
<div class="Container">
    <div class="sidebar">
        <?php include '../navBar/navBar.php'?>
    </div>
    <div class="content" id="content"> 
        <header class="header-bar">
            <h1>Courses Overview<h1>
        </header>
        <dialog selectInstructorModal>
            <?php if($_SESSION["usertype"] == "Admin") { ?>
                <!-- Show the select training provider -->
                <form action='../trainingProvider/createCourse.php' method='POST'>
                <h3>Choose a training provider</h3>
                <div class='input-box'>
                <select name='providerUsername' class="selectProvider" required >
                    <option disabled selected value>Select A Training Provider</option>
                    <?php
                    $sql = 'SELECT * FROM training_provider;';
                    $result = mysqli_query($connect,$sql);
                    $count = mysqli_num_rows($result);
                    if ($count == 0) {
                        ?>
                        <option disabled selected value>No Training Provider Found</option>

                    <?php
                    }
                    while($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row["username"] ?>"><?php echo $row["username"] . " - " . $row["provider_name"]?></option> 
                    <?php } 
                    ?>
                </select>
                </div>
                <div id='modal-button'>
                    <input class='back-btn' type='button' value='Cancel' onclick='closeModal()'>    
                    <input class='next-btn' type='submit' name='selectProvider' value='Next'>    
                </div>
            </form>
            <?php
            } ?>
        </dialog>
        <div class="left-panel">
            <div class="ongoing-course">
                <h1>Ongoing Courses</h1>
                <div class="display-course-container">
                    <?php if($_SESSION["usertype"] == "Admin") { ?>
                        <a onclick='selectProvider()'><button>Add Course</button><a>
                    <?php
                    }
                    else if($_SESSION["usertype"] == "Provider") { ?>
                        <a href="../trainingProvider/createCourse.php"><button>Add Course</button><a>
                    <?php
                    }

                    //Get the ongoing course
                    if($_SESSION['usertype'] == "Admin") {
                        $sql = "SELECT * FROM course WHERE end_date > '" . date("Y-m-d") . "';";
                    }
                    else if ($_SESSION['usertype'] == "Provider") {
                        $sql = "SELECT * FROM course WHERE provider_username = '" . $_SESSION["username"] . "' and end_date > '" . date("Y-m-d") . "';";
                    }
                    $result = mysqli_query($connect,$sql);
                    displayCourses($result);
                    ?>
                </div>
            </div>
            

            <div class="ended-course">
                <h1>Ended Courses</h1>
                <div class="display-course-container">
                    <?php 
                    //Get the ended course
                    if($_SESSION['usertype'] == "Admin") { 
                        $sql = "SELECT * FROM course WHERE end_date <= '" . date("Y-m-d") . "';";
                    }
                    else if ($_SESSION['usertype'] == "Provider") {
                        $sql = "SELECT * FROM course WHERE provider_username = '" . $_SESSION["username"] . "' and end_date <= '" . date("Y-m-d") . "';";
                    }
                    $result = mysqli_query($connect,$sql);
                    displayCourses($result);
                    ?>
                </div>
            </div>
        </div>

        <div class="right-panel">
        <?php
            if(isset($_GET['course'])) {
                $sql = "SELECT * FROM course where course_id=" . $_GET['course'] . ";";
                $result = mysqli_query($connect,$sql);
                $row = mysqli_fetch_assoc($result);
                //$row = getCourse($_GET['course'],$connect);
                ?>
                <div class='course-details'>
                    <h1>Course Details</h1>
                    <div class="course-details-box">
                        <?php 
                            echo "<p>Course ID: ". $row['course_id']."</p>";
                            echo "<p>Course Title: ". $row['course_title']."</p>";
                            echo "<p>Course Description: ". $row['course_description']."</p>";
                            echo "<p>Start Date: ". $row['start_date']."</p>";
                            echo "<p>End Date: ". $row['end_date']."</p>";
                            echo "<a href='../trainingProvider/courseDetail.php?view&course=". $row['course_id'] . "'><button>View More Details</button></a>";
                        ?>
                    </div>
                </div>

                <?php
                $sql2 = "SELECT * FROM course_section INNER JOIN instructor on course_section.username = instructor.username where course_id = " . $_GET['course'] . ";";
                $result2 = mysqli_query($connect,$sql2);
                if (!$result2) {
                    echo "Failed";
                }
                // $result = getCourseSectionsResult($_GET['course'],$connect);
                // while ($row2 = mysqli_fetch_assoc($result)) {
                //     echo "<div class='course-section-details'>";
                //     echo "<p>Course Section ID: ". $row2['course_section_id']."</p>";
                //     echo "<p>Course Section Name: ". $row2['course_section_name']."</p>";
                //     echo "<p>Instructor Username: ". $row2['username']."</p>";
                //     echo "<p>Instructor Name: ". $row2['first_name']. " " . $row2['last_name'] . "</p>";
                //     echo "<p>Start Time: ". $row2['start_time'] ."</p>";
                //     echo "<p>End Time: ". $row2['end_time'] . "</p>";
                //     echo "<p>Day: ". $row2['day'] . "</p>";
                //     echo "<p>Status: ". $row2['status'] ."</p>";
                //     echo "<p>Maximum Students Allowed: ". $row2['max_student_num'] . "</p>";
                    

                //     echo "<p>Course Section ID: ". $row['course_section_id']."</p>";
                //     echo "</div>";
                //     echo "<hr>";
                // }

            }
            ?>
        </div>
    </div>
</div>
</body>
</html>

<?php
    function displayCourses($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<a href="courseOverview.php?course=' . $row["course_id"] . '">';
            echo '<div class="display-course">';
            echo '<p class="course-id">' . $row["course_id"] . '</p>';
            echo '<p class="course-title">' . $row["course_title"] . '</p>';
            echo '</div>';
            echo '</a>';
        }
    }

?>

<script>
    const selectProviderModal = document.querySelector("[selectInstructorModal]");

    function closeModal() {
        selectProviderModal.close();
    }
    function selectProvider() {
        selectProviderModal.showModal();
    }

</script>
