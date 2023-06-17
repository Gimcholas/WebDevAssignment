<?php include "../db_connect.php"; ?>

<html>
<head>
    <title>Edit Account Details</title>
</head>

<body>
    <h1>Edit Account Details</h1>
    <?php 
        if(isset($_GET['edit'])) {
            $username = $_GET['username'];

            // Check the usertype
            $sql = "SELECT * FROM user where username='$username';";
            $result = mysqli_query($connect,$sql);
            $row = mysqli_fetch_assoc($result);
            $usertype = $row['usertype'];
            ?>
            <form action='' method='POST'>
            <?php
            if($usertype == 'Instructor') {
                // Allow to change password, firstname, lastname, contactnumber, email
                $sql2 = "SELECT * FROM instructor where username='$username';";
                $result2 = mysqli_query($connect,$sql2);
                $row2 = mysqli_fetch_assoc($result2);
                ?>
                <div class="input-box">
                <label>First Name</label>
                <input type="text" name="firstName" placeholder="First Name" required value="<?php echo $row2['first_name']; ?>"><br><br>
                </div>
                <div class="input-box">
                <label>Last Name</label>
                <input type="text" name="lastName" placeholder="Last Name" required value="<?php echo $row2['last_name']; ?>"><br><br>
                </div>
                <div class="input-box">
                <label>Contact Number</label>
                <input type="tel" name="contactNumber" placeholder="Contact Number" value="<?php echo $row2['contact_number']; ?>"><br><br>
                </div>
                <div class="input-box">
                <label>Email</label>
                <input type="email" name="email" placeholder="Contact Email" value="<?php echo $row2['email']; ?>"><br><br>
                </div>
                <?php
            }
            else if($usertype == 'Student') {
                // Allow to change password, firstname, lastname, dataofbirth, academicprogram, contactnumber, email
                $sql2 = "SELECT * FROM student where username='$username';";
                $result2 = mysqli_query($connect,$sql2);
                $row2 = mysqli_fetch_assoc($result2);
                ?>
                <div class="input-box">
                <label>First Name</label>
                <input type="text" name="firstName" placeholder="First Name" required value="<?php echo $row2['first_name']; ?>"><br><br>
                </div>
                <div class="input-box">
                <label>Last Name</label>
                <input type="text" name="lastName" placeholder="Last Name" required value="<?php echo $row2['last_name']; ?>"><br><br>
                </div>
                <div class="input-box">
                <label>Date Of Birth</label>
                <input type="date" name="dateOfBirth" required value="<?php echo $row2['date_of_birth']; ?>"><br><br>
                </div>
                <div class="input-box">
                <label>Academic Program</label>
                <input type="text" name="academicProgram" placeholder="Academic Program" required value="<?php echo $row2['academic_program']; ?>"><br><br>
                </div>
                <div class="input-box">
                <label>Contact Number</label>
                <input type="tel" name="contactNumber" placeholder="Contact Number" value="<?php echo $row2['contact_number']; ?>"><br><br>
                </div>
                <div class="input-box">
                <label>Email</label>
                <input type="email" name="email" placeholder="Contact Email" value="<?php echo $row2['email']; ?>"><br><br>
                </div>
                <?php
            }
            
            // Change password
            ?>
            <div class="input-box">
            <label>New Password</label>
            <input type="password" name="password" placeholder="Password"><br><br>
            </div> 
            
            <div class='submitBtn'>
                <input type='submit' name='submit' value='Save'><br><br>
            </div>
            <div class='backBtn'>
                <a href="accountDashboard.php"><input type='button' name='back' value='Back'></a>
            </div>
            </form>
            <?php
        }
    ?>

</body>
</html>
<?php

if(isset($_POST['submit'])) {
    // User change password
    if(!empty($_POST["password"])) {
        if(strlen($_POST["password"]) < 8) {
            die("Password must be at least 8 characters"); 
        }
        if (!preg_match('/[A-Za-z]/', $_POST["password"]) || !preg_match('/[0-9]/', $_POST["password"])) {
            die("Password must include at least one letter and one number");
        }
        
        // Update password in the database
        $password = $_POST["password"];
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password_hash = '" . $hashed_password . "' where username = " . "'" . $username . "';";
        $result = mysqli_query($connect,$sql);
        if (!$result) {
            echo "Error: " . mysqli_error($connect);
        }
    }
    

    // Admin can only edit password



    if($usertype == 'Instructor' || $usertype == 'Student') {
        $contactNumber = $_POST["contactNumber"];
        $email = $_POST["email"];
    }

    if($usertype == 'Instructor') {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        
        $sql2 = "UPDATE instructor SET first_name = '" . $firstName . "', last_name = '" . $lastName 
                . "', contact_number = '" . $contactNumber . "', email ='" . $email 
                . "' WHERE username = '" . $username . "';";
   
        $result = mysqli_query($connect,$sql2);
    }
    else if($usertype == 'Student') {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $dateOfBirth = $_POST["dateOfBirth"];
        $academicProgram = $_POST["academicProgram"];
        $sql2 = "UPDATE student SET first_name = '" . $firstName . "', last_name = '" . $lastName 
                . "', date_of_birth = '" . $dateOfBirth ."', academic_program = '". $academicProgram 
                . "',contact_number = '" . $contactNumber . "', email ='" . $email 
                . "' WHERE username = '" . $username . "';";
        $result = mysqli_query($connect,$sql2);
    }
    ?>

    <script>
		alert("User <?php echo $username.' Updated!';?>");
	</script>

    <?php
    header( "refresh:0.5; url=accountDashboard.php" );
}

?>