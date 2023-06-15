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
            if($usertype == 'Admin') {
                // Allow to change password only
            }
            else if($usertype == 'Instructor') {
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
            else if($usertype == 'Provider') {
                // Allow to change password, providername, contactnumber, email
                $sql2 = "SELECT * FROM training_provider where username='$username';";
                $result2 = mysqli_query($connect,$sql2);
                $row2 = mysqli_fetch_assoc($result2);
                ?>
                
                <div class="input-box">
                <label>Provider Name</label>
                <input type="text" name="providerName" required value="<?php echo $row2['provider_name']; ?>"><br><br>
                </div>
                <div class="input-box">
                <label>Contact Number</label>
                <input type="tel" name="contactNumber" placeholder="Contact Number" value="<?php echo $row2['contact_number']; ?>"><br><br>
                </div>
                <div class="input-box">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email" value="<?php echo $row2['email']; ?>"><br><br>
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
                <input type='submit' name='submit' value='Save'>
            </div>
            </form>
            <?php
        }
    ?>

</body>
</html>
<?php

if(isset($_POST['submit'])) {
    if($usertype == 'Admin') {

    }
    else if($usertype == 'Instructor') {

    }
    else if($usertype == 'Student') {

    }
    else if($usertype == 'Provider') {

    }
    
}

?>