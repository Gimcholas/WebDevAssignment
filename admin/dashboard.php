<?php include '../db_connect.php';
    session_start(); 
    //echo $_SESSION["username"];
    //echo $_SESSION["usertype"];
    if(isset($_POST["createAccount"])) {
        if(empty($_POST["username"])) {
            die("Username is required"); 
        }

        $sql = "SELECT * FROM user where username='" . $_POST["username"] . "';";
        $result = mysqli_query($connect,$sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            die("Username not available");
        }

        if(strlen($_POST["password"]) < 8) {
            die("Password must be at least 8 characters"); 
        }
        if (!preg_match('/[A-Za-z]/', $_POST["password"]) || !preg_match('/[0-9]/', $_POST["password"])) {
            die("Password must include at least one letter and one number");
        }
        if(empty($_POST["usertype"])) {
            die("Usertype is required"); 
        }

        $contactNumber = NULL;
        $email = NULL;            
        if($_POST["usertype"] == "Provider") {
            if(empty($_POST["providerName"])) 
                die("Provider name is required");
            if(!empty($_POST["contactNumber"])) {
            $contactNumber = $_POST["contactNumber"];
            }
            if(strlen($_POST['email']) > 0) {
                if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    echo "Invalid email";
                }
                else {
                    $email = $_POST["email"];
                } 
            }            
        }
        if($_POST["usertype"] == "Instructor" || $_POST["usertype"] == "Student") {
            if(empty($_POST["provider"])) // Check the provider username is empty
                die("Provider is required");
            
            // Check if the provider username is valid
            $sql = "SELECT * FROM training_provider where username='" . $_POST["provider"] . "';";
            $result = mysqli_query($connect,$sql);
            $count = mysqli_num_rows($result);
            if($count == 0) {
                die("Provider Username not found");
            }
            if(empty($_POST["firstName"])) 
                die("First name is required");
            if(empty($_POST["lastName"])) 
                die("Last name is required");
        }

        if($_POST["usertype"] == "Student") {
            if(empty($_POST["dateOfBirth"])) 
                die("Date of birth is required");
            if(empty($_POST["academicProgram"])) 
                die("Academic program is required");
        }
            

            
        //print_r($_POST);
        $username = $_POST["username"];
        $password = $_POST["password"];
        $usertype = $_POST["usertype"];

        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        //echo $hashed_password;

        $sql = "INSERT INTO user (username,password_hash,usertype) values ('$username','$hashed_password','$usertype')";
        $abc = mysqli_query($connect,$sql);
        if(!$abc)
            die('Cannot enter data'.mysqli_error($connect));
        //else 
            //echo 'Successful created a new account';
        
        if ($usertype != "Admin") {
            if ($usertype == "Provider") {
                    $providerName = $_POST["providerName"];
                    $sql2 = "INSERT INTO training_provider(username,provider_name,contact_number,email) values ('$username','$providerName','$contactNumber','$email');";
            } 
            else if ($usertype == "Student") {
                $firstName = $_POST["firstName"];
                $lastName = $_POST["lastName"];
                $dateOfBirth = $_POST["dateOfBirth"];
                $academicProgram = $_POST["academicProgram"];
                $providerUsername = $_POST["provider"];
                $contactNumber = $_POST["contactNumber"];
                $email = $_POST["email"];
                $sql2 = "INSERT INTO student(username,first_name,last_name,date_of_birth,academic_program,provider_username,contact_number,email) values ('$username','$firstName','$lastName','$dateOfBirth','$academicProgram','$providerUsername','$contactNumber','$email');";
            }
            else if ($usertype == "Instructor") {
                $firstName = $_POST["firstName"];
                $lastName = $_POST["lastName"];
                $providerUsername = $_POST["provider"];
                $contactNumber = $_POST["contactNumber"];
                $email = $_POST["email"];
                $sql2 = "INSERT INTO instructor(username,first_name,last_name,provider_username,contact_number,email) values ('$username','$firstName','$lastName','$providerUsername','$contactNumber','$email');";
            }

        
            $abc2 = mysqli_query($connect,$sql2);

            if(!$abc2)
                die('Cannot enter data'.mysqli_error($connect));
        }
        
        
        ?>

            <script type="text/javascript">
                alert("Successful created a new account");
            </script>
        <?php
    }
    
    
    if(isset($_POST['editAccount'])) {
        $username = $_GET['username'];
        $sql = "SELECT * FROM user where username='$username';";
        $result = mysqli_query($connect,$sql);
        $row = mysqli_fetch_assoc($result);
        $usertype = $row['usertype'];
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
    
    
    
        if($usertype == 'Instructor' || $usertype == 'Student' || $usertype == 'Provider') {
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
        else if($usertype == 'Provider') {
            $providerName = $_POST['providerName'];
            $sql2 = "UPDATE training_provider SET provider_name = '" . $providerName . "', contact_number ='" 
                    . $contactNumber . "', email='" . $email 
                    . "' WHERE username='" . $username ."';";
            $result = mysqli_query($connect,$sql2);
        }
        ?>
    
        <script>
            alert("User <?php echo $username.' Updated!';?>");
        </script>
    
        <?php
        header( "refresh:0.5; url=dashboard.php" );
    }
?>

<!DOCTYPE html>
<html>
<head> 
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../NavBar/NavBarStyle.css"/>
    <link rel="stylesheet" href="dashboard.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src ="../js/navbar.js"></script></head>

<body>
<div class="Container">
    <div class="sidebar">
        <?php include '../NavBar/NavBar.php'?>
    </div>
    <div class="content" id="content">    
        <header>
            <h1>Admin Dashboard</h1>
    <!-- <a href="createAccount.php"><button>Add Account</button></a> -->
            <button create-account-button>Add Account</button>
        </header>
            <dialog create-account>
            <form action="" method="POST">
                    <h3>Create New Account</h3>
                    <div class="input-box-user">
                        <img src="../files/defaultProfileImage.jpg" alt="UserIcon">
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-box-pw">
                        <img src="../files/password_icon.png" alt="PwIcon">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>  
                    <div class="input-box">
                        <select name="usertype" id="usertype" onchange="updateForm()" required>
                            <option hidden disabled selected value>Select a usertype</option>
                            <option value="Admin">Admin</option>
                            <option value="Instructor">Instructor</option>
                            <option value="Provider">Training Provider</option>
                            <option value="Student">Student</option>
                        </select>
                    </div>
                    <div id="additionalFields"></div>
                    <div  class="operations-button">
                        <a href="dashboard.php"><input type="button" value = "Back"></a>
                        <input type="submit" name="createAccount" value="Create Account">
                    </div>
                </form>
            </dialog>

<?php if(isset($_GET['edit'])) {
            
            $username = $_GET['username'];

            // Check the usertype
            $sql = "SELECT * FROM user where username='$username';";
            $result = mysqli_query($connect,$sql);
            $row = mysqli_fetch_assoc($result);
            $usertype = $row['usertype'];
            ?>
            <dialog edit-account-modal>
            <h3>Edit Account Details</h3>
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
                <input type='submit' name='editAccount' value='Save'><br><br>
            </div>
            <div class='backBtn'>
                <a href="dashboard.php"><input type='button' name='back' value='Back'></a>
            </div>
            </form>
            </dialog>
            <?php
        }
?>

<?php
if(isset($_GET['view'])) {
    $username = $_GET['username'];
    $sql = "SELECT * FROM user where username='$username';";
    $result = mysqli_query($connect,$sql);
    $row = mysqli_fetch_assoc($result);
    echo "<dialog view-details-modal>";
    echo "<button id='close-view'>X</button>";
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
                <th>Course ID</th>
                <th>Course Title</th>
                <th>Course Section</th>
                <th>Day</th>
                <th>Time</th>
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
            echo "</table>";
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
            echo "</table>";
        }
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

        $sql = "SELECT * FROM course where provider_username = '" . $username . "';";
        $result = mysqli_query($connect,$sql);
        $numOfRows = mysqli_num_rows($result);
        if($numOfRows == 0) {
            echo "No Course Created";
        }
        else {
            ?>
            <table border="1">
            <tr>
                <th>Course ID</th>
                <th>Course Title</th>
                <th>Course Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                
            </tr>
            <?php
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["course_id"]. "</td>";
                echo "<td>" . $row["course_title"]. "</td>";
                echo "<td>" . $row["course_description"] . "</td>";
                echo "<td>" . $row["start_date"] . "</td>";
                echo "<td>" . $row["end_date"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    echo "</dialog>";
}
?>

<table>
    <tr>
        <th>Username</th>
        <th>Usertype</th>
        <th>Joined Date</th>
        <th colspan="2">Action</th>
    </tr>
    <?php
    $sql = "SELECT * FROM user;";
    $result = mysqli_query($connect,$sql);
    $count = mysqli_num_rows($result);

    while($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?php echo $row["username"]; ?></td>
        <td><?php echo $row["usertype"]; ?></td>
        <td><?php echo $row["joined_date"]; ?></td>
        <!-- <td><a href="accountDetail.php?view&username=<?php echo $row["username"];?>">Details</a></td> -->
        <td><a href="dashboard.php?view&username=<?php echo $row["username"];?>"><button class="view-details">Details</button></a></td>

        <!-- <td><a href="editAccount.php?edit&username=<?php echo $row["username"];?>">Edit</a></td> -->
        <td><a href="dashboard.php?edit&username=<?php echo $row["username"];?>"><button class="edit-details">Edit</button></a></td>
    </tr>
    <?php
    }
    ?>
      
      
    </table>
    <?php
    $sql = "SELECT * FROM user where usertype = 'Admin';";
    $result = mysqli_query($connect,$sql);
    $countAdmin = mysqli_num_rows($result);

    $sql = "SELECT * FROM instructor;";
    $result = mysqli_query($connect,$sql);
    $countInstructor = mysqli_num_rows($result);

    $sql = "SELECT * FROM student;";
    $result = mysqli_query($connect,$sql);
    $countStudent = mysqli_num_rows($result);

    $sql = "SELECT * FROM training_provider;";
    $result = mysqli_query($connect,$sql);
    $countProvider = mysqli_num_rows($result);

    ?>
    <p>Number of users: <?php echo $count; ?></p>
    <p>Number of admin: <?php echo $countAdmin; ?></p>
    <p>Number of instructor: <?php echo $countInstructor; ?></p>
    <p>Number of student: <?php echo $countStudent; ?></p>
    <p>Number of training provider: <?php echo $countProvider; ?></p>
    </div>
</body>
<script>
    $(document).ready(function() {
        $(".sidebar").hover(
          function() {
            $(".content").addClass("shifted");
            // console.log('done')
          },
          function() {
            $(".content").removeClass("shifted");
          }
        );
      }
    );

    const createAccountModal = document.querySelector("[create-account]");
    const createAccountButton = document.querySelector("[create-account-button]");
    const viewDetailsButton = document.getElementsByClassName('view-details');
    const editDetailsButton = document.getElementsByClassName("edit-details");
    const closeViewDetailsBtn = document.getElementById("close-view");
    
    const detailsModal = document.querySelector("[view-details-modal]");
    const editModal = document.querySelector("[edit-account-modal]");

    if (closeViewDetailsBtn != null) {
        closeViewDetailsBtn.addEventListener('click', () => {
            detailsModal.close();
        });
    }



    window.addEventListener('load', e => {
        //console.log(window.location.toString().includes('view'));
        if ("view" == "<?php if (isset($_GET['view'])) echo "view"; else echo "";?>") 
        {
            detailsModal.showModal();
        }
        else if ("edit" == "<?php if (isset($_GET['edit'])) echo "edit"; else echo "";?>") 
        {
            editModal.showModal();
        }
    });

    window.addEventListener('click', e => {
        // console.log("Closing");
        const dialogDimension = detailsModal.getBoundingClientRect();
        // console.log(e.clientX > dialogDimension.left);
        // console.log(e.clientX + " " + dialogDimension.left);
        // console.log(e.clientX < dialogDimension.right);
        // console.log(e.clientY > dialogDimension.top);
        // console.log(e.clientY < dialogDimension.bottom);
        if (
            e.clientX < dialogDimension.left ||
            e.clientX > dialogDimension.right ||
            e.clientY < dialogDimension.top ||
            e.clientY > dialogDimension.bottom
        ) {
            detailsModal.close();
            // console.log("Closing");
        }
    }
    );

    window.addEventListener('click', e => {
        // console.log("Closing");
        const dialogDimension = editModal.getBoundingClientRect();
        // console.log(e.clientX > dialogDimension.left);
        // console.log(e.clientX + " " + dialogDimension.left);
        // console.log(e.clientX < dialogDimension.right);
        // console.log(e.clientY > dialogDimension.top);
        // console.log(e.clientY < dialogDimension.bottom);
        if (
            e.clientX < dialogDimension.left ||
            e.clientX > dialogDimension.right ||
            e.clientY < dialogDimension.top ||
            e.clientY > dialogDimension.bottom
        ) {
            editModal.close();
            // console.log("Closing");
        }
    }
    );

    createAccountModal.addEventListener('click', e => {
        const dialogDimension = createAccountModal.getBoundingClientRect();
        if (
            e.clientX < dialogDimension.left ||
            e.clientX > dialogDimension.right ||
            e.clientY < dialogDimension.top ||
            e.clientY > dialogDimension.bottom
        ) {
            createAccountModal.close();
        }
    }
    );

    createAccountButton.addEventListener("click", () =>{
        createAccountModal.showModal();
    });

    function updateForm() {
        const usertypeSelected = document.getElementById("usertype").value;
        // console.log(usertypeSelected);
        
        const additionalForm = document.getElementById("additionalFields");
        additionalForm.innerHTML = "";
        
        const selectProviderHtml = 
            `<div class="input-box">
            <select name="provider" required>
            <option disabled selected value>Select the training provider</option>
            <?php 
                    $sql = "SELECT * FROM training_provider;";
                    $result = mysqli_query($connect,$sql);
                    $count = mysqli_num_rows($result);
                    if ($count == 0) {
                        echo $count;
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
            </div>`;

        const nameInputHtml = `<div class="input-box">
            <input type="text" name="firstName" placeholder="First Name" required>
            </div>
            <div class="input-box">
            <input type="text" name="lastName" placeholder="Last Name" required>
            </div>`;
            
        const contactInputHtml = `<div class="input-box">
            <input type="tel" name="contactNumber" placeholder="Contact Number">
            </div>
            <div class="input-box">
            <input type="email" name="email" placeholder="Contact Email">
            </div>`;

        if (usertypeSelected == "Provider") {
            const html = 
            `<div class="input-box">
            <input type="text" name="providerName" placeholder="Provider Name" required>
            </div>`;
            additionalForm.innerHTML = html + contactInputHtml;
        }
        else if (usertypeSelected == "Instructor") {
            additionalForm.innerHTML = selectProviderHtml + nameInputHtml + contactInputHtml;
        }
        else if (usertypeSelected == "Student") {
            const html = 
            `<div class="input-box">
            <input type="date" name="dateOfBirth" required>
            </div>
            <div class="input-box">
            <input type="text" name="academicProgram" placeholder="Academic Program" required>
            </div>
            `;
            additionalForm.innerHTML = selectProviderHtml + nameInputHtml + html + contactInputHtml;
        }
        else if (usertypeSelected == "Admin") {
            // Do nothing
        } 
    }

    

</script>
</html>




