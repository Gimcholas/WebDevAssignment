<?php 
    include "../db_connect.php";
    include "functions.php";
    
?>

<html>
<head>
    <title>Course Details</title>
</head>

<body>
    <?php 
    if(isset($_GET['course'])) {
        $course = getCourse($_GET['course'],$connect);
        $courseSectionResult = getCourseSectionsResult($_GET['course'],$connect);
    ?>
    <div class='course-details'>
        <h2>Course Details</h2>
        <?php 
        echo "<a id='". $_GET['course'] . "' onclick='editCourseDetails(this)'><button>Edit</button></a>";
        echo "<p>Course ID: <span id='course-id'>" . $course['course_id'] . "</span></p>";
        echo "<p>Course Title: <span id='course-title'>" . $course['course_title'] . "</span></p>";
        echo "<p>Course Description: <span id='course-description'>" . $course['course_description'] . "</span></p>";
        echo "<p>Start Date: <span id='start-date'>" . $course['start_date'] . "</span></p>";
        echo "<p>End Date: <span id='end-date'>" . $course['end_date'] . "</span></p>";
        ?>
    </div>
    <hr>
    <?php
    while ($row = mysqli_fetch_assoc($courseSectionResult)) {
        echo "<div class='course-section-details'>";
        echo "<a id=". $row['course_section_id'] . " onclick=><button>Edit</button></a>";
        echo "<p>Course Section ID: ". $row['course_section_id']."</p>";
        echo "<p>Course Section Name: ". $row['course_section_name']."</p>";
        echo "<p>Instructor Username: ". $row['username']."</p>";
        echo "<p>Instructor Name: ". $row['first_name']. " " . $row['last_name'] . "</p>";
        echo "<p>Start Time: ". $row['start_time'] ."</p>";
        echo "<p>End Time: ". $row['end_time'] . "</p>";
        echo "<p>Day: ". $row['day'] . "</p>";
        echo "<p>Status: ". $row['status'] ."</p>";
        echo "<p>Maximum Students Allowed: ". $row['max_student_num'] . "</p>";
        

        //echo "<p>Course Section ID: ". $row['course_section_id']."</p>";
        echo "</div>";
        echo "<hr>";
    }
    }
    ?>
</body>
</html>

<script>
    function editCourseDetails(editButton) {
        var courseDetails = editButton.parentNode;
        var spans = courseDetails.getElementsByTagName('span');

        for (var i = 0; i < spans.length; i++) {
            var span = spans[i];
            var input = document.createElement('input');
            input.value = span.innerText;
            span.innerHTML = '';
            span.appendChild(input);
        }

        editButton.innerHTML = 'Save';
        editButton.onclick = function() {
            saveCourseDetails(editButton);
        };
    }

    function saveCourseDetails(saveButton) {
        var courseDetails = saveButton.parentNode;
        var spans = courseDetails.getElementsByTagName('span');

        for (var i = 0; i < spans.length; i++) {
            var span = spans[i];
            var input = span.firstChild;
            span.innerHTML = input.value;
        }

        saveButton.innerHTML = 'Edit';
        saveButton.onclick = function() {
            editCourseDetails(saveButton);
        };
    }
</script>
