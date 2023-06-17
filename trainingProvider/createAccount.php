<?php include '../db_connect.php'; 
    // if($_SESSION["usertype"] != 'Admin') {
    //     header("Location: ../Login/login.php");
    // }
    session_start();
    $_SESSION['username'] = "Huawei";
?>
<!DOCTYPE html>
<html>
<head> 
    <title>Create New Account</title>
    <link rel='stylesheet' type="text/css" href=style.css>
</head>

<body>
    <div class="create-account-form">
    <form action="createAccount.php" method="POST">
        <h2>Create New Account</h2>
        <div class="input-box">
            <label>Username</label>
            <input type="text" name="username" placeholder="Username" required><br><br>
        </div>
        <div class="input-box">
            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required><br><br>
        </div>  

        <div class="input-box">
            <label>Usertype: </label>
            <select name="usertype" id="usertype" onchange="updateForm()" required>
                <option hidden disabled selected value>Select a usertype</option>
                <option value="Instructor">Instructor</option>
                <option value="Student">Student</option>
            </select><br><br>
        </div>
        <div id="additionalFields"></div>
    
        <input type="submit" name="submit" value="Create Account"><br><br>
        <a href="accountDashboard.php"><input type="button" value = "Back"></a><br><br>
    </form>
    </div>
</body>
</html>

<?php
if(isset($_POST["submit"])) {
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

    if($_POST["usertype"] == "Instructor" || $_POST["usertype"] == "Student") {
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
    // else 
    //     echo 'Successful created a new account';
    

    if ($usertype == "Student") {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $dateOfBirth = $_POST["dateOfBirth"];
        $academicProgram = $_POST["academicProgram"];
        $providerUsername = $_SESSION["username"];
        $contactNumber = $_POST["contactNumber"];
        $email = $_POST["email"];
        $sql2 = "INSERT INTO student(username,first_name,last_name,date_of_birth,academic_program,provider_username,contact_number,email) values ('$username','$firstName','$lastName','$dateOfBirth','$academicProgram','$providerUsername','$contactNumber','$email');";
    }
    else if ($usertype == "Instructor") {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $providerUsername = $_SESSION["username"];
        $contactNumber = $_POST["contactNumber"];
        $email = $_POST["email"];
        $sql2 = "INSERT INTO instructor(username,first_name,last_name,provider_username,contact_number,email) values ('$username','$firstName','$lastName','$providerUsername','$contactNumber','$email');";
    }

    
    $abc2 = mysqli_query($connect,$sql2);

    if(!$abc2)
        die('Cannot enter data'.mysqli_error($connect));
    // else 
    //     echo 'Successful created a new account';
        
    
    ?>

    <script type="text/javascript">
        alert("Successful created a new account");
    </script>

    <?php

}
?>

<script>
    function updateForm() {
        const usertypeSelected = document.getElementById("usertype").value;
        console.log(usertypeSelected);
        
        const additionalForm = document.getElementById("additionalFields");
        additionalForm.innerHTML = "";
        const commonHtml1 = `<div class="input-box">
            <label>First Name</label>
            <input type="text" name="firstName" placeholder="First Name" required><br><br>
            </div>
            <div class="input-box">
            <label>Last Name</label>
            <input type="text" name="lastName" placeholder="Last Name" required><br><br>
            </div>`;
            
        const commonHtml2 = `<div class="input-box">
            <label>Contact Number</label>
            <input type="tel" name="contactNumber" placeholder="Contact Number"><br><br>
            </div>
            <div class="input-box">
            <label>Email</label>
            <input type="email" name="email" placeholder="Contact Email"><br><br>
            </div>`;

        if(usertypeSelected == "Instructor") {           
            additionalForm.innerHTML = commonHtml1 + commonHtml2;
        }
        else if (usertypeSelected == "Student") {
            const html = 
            `<div class="input-box">
            <label>Date Of Birth</label>
            <input type="date" name="dateOfBirth" required><br><br>
            </div>
            <div class="input-box">
            <label>Academic Program</label>
            <input type="text" name="academicProgram" placeholder="Academic Program" required><br><br>
            </div>
            `;
            additionalForm.innerHTML = commonHtml1 + html + commonHtml2;
        }
        
    }
</script>

