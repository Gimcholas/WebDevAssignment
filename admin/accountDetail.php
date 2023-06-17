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
            }
            else if($row["usertype"] == "Student") {
                $sql = "SELECT * FROM student JOIN training_provider ON student.provider_username = training_provider.username where student.username='$username';";
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

