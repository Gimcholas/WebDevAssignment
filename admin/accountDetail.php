<?php include "../db_connect.php"; ?>

<html>
<head>
    <title>User Account Details</title>
</head>

<body>
    <h1>User Account Details</h1>
    <?php
        if(isset($_GET['view'])) {
            $username = $_GET['username'];
            $sql = "SELECT * FROM user where username='$username';";
            $result = mysqli_query($connect,$sql);
            $row = mysqli_fetch_assoc($result);

            echo "<br><b>Profile Image</b><br>";
            if ($row["profile_image_path"] != NULL) {
            ?>
            <!-- Profile image -->
            <img src=<?php echo $row["profile_image_path"] ?> alt = "Profile image">

            <?php
            }
            else {
            ?>
            <img src="../files/defaultProfileImage.jpg" alt = "Profile image">
            <?php
            }
            echo "<br><b>Username</b><br>";
		    echo $row["username"]; 
            echo "<br><b>Usertype</b><br>";
		    echo $row["usertype"]; 
            echo "<br><b>Joined Date</b><br>";
		    echo $row["joined_date"]; 

            if($row["usertype"] == "Instructor") {
                
                $sql = "SELECT AVG(rating) as rating, COUNT(rating) as amount FROM instructor_feedback where instructor_username = '$username'";
                $result = mysqli_query($connect,$sql);
                $row = mysqli_fetch_assoc($result);
                $numOfStars = floor($row["rating"]);
                echo "<div class=rating>";
                echo "<b>Rating</b>";
                for($i=0; $i<$numOfStars; $i++)
                    echo "<img src='../files/star-orange.png' alt='star'>";
                for($i=0; $i<(5-$numOfStars); $i++)
                    echo "<img src='../files/star-white.png' alt='star'>";
            
                echo " (" . $row["amount"] . ")";
                echo "</div>"; 
                

                $sql = "SELECT * FROM instructor JOIN training_provider ON instructor.provider_username = training_provider.username where instructor.username='$username';";
                $result = mysqli_query($connect,$sql);
                $row = mysqli_fetch_assoc($result);

                echo "<br><b>First Name</b><br>";
		        echo $row["first_name"]; 
                echo "<br><b>Last Name</b><br>";
		        echo $row["last_name"]; 
                echo "<br><b>Training Provider Username</b><br>";
		        echo $row["provider_username"]; 
                echo "<br><b>Training Provider Name</b><br>";
		        echo $row["provider_name"]; 
                echo "<br><b>Contact Number</b><br>";
		        echo $row["contact_number"]; 
                echo "<br><b>Email</b><br>";
		        echo $row["email"]; 
                

                echo "<h3>Courses</h3>"; ?>
                
                <?php 
                $sql = "SELECT * FROM instructor JOIN training_provider ON 
                        instructor.provider_username = training_provider.username 
                        JOIN course_section ON course_section.username = instructor.username
                        JOIN course ON course_section.course_id = course.course_id
                        where instructor.username='" . $username ."';";

                $result = mysqli_query($connect,$sql); 
                $numOfRows = mysqli_num_rows($result);
                if($numOfRows == 0) {
                    echo "No Course In Charge";
                }
                else {
                ?>
                <table border="1">
                <tr>
                    <th>Course ID</td>
                    <th>Course Title</td>
                    <th>Course Section</td>
                    <th>Day</td>
                    <th>Time</td>
                </tr>
                <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["course_id"]. "</td>";
                    echo "<td>" . $row["course_title"]. "</td>";
                    echo "<td>" . $row["course_section_name"] . "</td>";
                    echo "<td>" . $row["day"] . "</td>";
                    echo "<td>" . date("h:i:a",strtotime($row["start_time"])) . " - " . date("h:i:a",strtotime($row["end_time"])) ."</td>";
                    echo "</tr>";
                }
            }

            }
            else if($row["usertype"] == "Student") {
                $sql = "SELECT * FROM student JOIN training_provider ON 
                        student.provider_username = training_provider.username 
                        where student.username='" . $username ."';";

                $result = mysqli_query($connect,$sql);
                $row = mysqli_fetch_assoc($result);

                echo "<br><b>First Name</b><br>";
		        echo $row["first_name"]; 
                echo "<br><b>Last Name</b><br>";
		        echo $row["last_name"]; 
                echo "<br><b>Date of Birth</b><br>";
		        echo $row["date_of_birth"]; 
                echo "<br><b>Academic Program</b><br>";
		        echo $row["academic_program"]; 
                echo "<br><b>Training Provider Username</b><br>";
		        echo $row["provider_username"];
                echo "<br><b>Training Provider Name</b><br>";
		        echo $row["provider_name"];  
                echo "<br><b>Contact Number</b><br>";
		        echo $row["contact_number"]; 
                echo "<br><b>Email</b><br>";
		        echo $row["email"]; 
                ?>
                <h3>Registered Course</h3>
                <?php 
                $sql = "SELECT * FROM student JOIN training_provider ON 
                        student.provider_username = training_provider.username 
                        JOIN course_student ON course_student.username = student.username
                        JOIN course_section ON course_student.course_section_id = course_section.course_section_id
                        JOIN course ON course_section.course_id = course.course_id
                        where student.username='" . $username ."';";

                $result = mysqli_query($connect,$sql);
                $numOfRows = mysqli_num_rows($result);
                if ($numOfRows == 0) {
                    echo "<p>No course found</p>";
                }
                else {
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th>Course Title</th>";
                echo "<th>Course Section Name</th>";
                echo "<th>Day</th>";
                echo "<th>Time</th>";
                echo "<th>Completed Date</th>";
                echo "</tr>";
                    
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["course_title"] . "</td>";
                    echo "<td>" . $row["course_section_name"] . "</td>";
                    echo "<td>" . $row["day"] . "</td>";
                    echo "<td>" . date("h:i:a",strtotime($row["start_time"])) . " - " . date("h:i:a",strtotime($row["end_time"])) ."</td>";
                    echo "<td>" . $row["course_completed_date"] . "</td>";
                    echo "</tr>";
                }
                }

                ?>
                <?php
            }
            else if($row["usertype"] == "Provider") {
                $sql = "SELECT * FROM training_provider where username='$username';";
                $result = mysqli_query($connect,$sql);
                $row = mysqli_fetch_assoc($result);

                echo "<br><b>Training Provider Name</b><br>";
		        echo $row["provider_name"]; 
                echo "<br><b>Contact Number</b><br>";
		        echo $row["contact_number"]; 
                echo "<br><b>Email</b><br>";
		        echo $row["email"]; 
            }
        }
    ?>
</body>
</html>

