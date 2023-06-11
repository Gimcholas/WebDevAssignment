<?php include '../db_connect.php'; 
    // if($_SESSION["usertype"] != 'Admin') {
    //     header("Location: ../Login/login.php");
    // }
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
                <option value="Admin">Admin</option>
                <option value="Instructor">Instructor</option>
                <option value="Student">Student</option>
                <option value="Provider">Training Provider</option>
            </select><br><br>
        </div>
        <div id="additionalFields"></div>
    
        <input type="submit" name="submit" value="Create Account"><br><br>
    </form>
    </div>
</body>
</html>

<?php
if(isset($_POST["submit"])) {
    if(empty($_POST["username"])) {
        die("Username is required"); 
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
            
    if($_POST["usertype"] == "Provider") {
        if(empty($_POST["providerName"])) 
            die("Provider name is required");
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
    else 
        echo 'Successful created a new account';
    
    
    if ($usertype != "Admin") {
        if ($usertype == "Student") {
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $dateOfBirth = $_POST["dateOfBirth"];
            $academicProgram = $_POST["academicProgram"];
            $sql2 = "INSERT INTO student(username,first_name,last_name,date_of_birth,academic_program) values ('$username','$firstName','$lastName','$dateOfBirth','$academicProgram');";
        }
        else if ($usertype == "Instructor") {
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $sql2 = "INSERT INTO instructor(username,first_name,last_name) values ('$username','$firstName','$lastName');";
        }
        else if ($usertype == "Provider") {
            $providerName = $_POST["providerName"];
            $sql2 = "INSERT INTO training_provider(username,provider_name) values ('$username','$providerName');";
        }
        
        $abc2 = mysqli_query($connect,$sql2);
    
        if(!$abc2)
            die('Cannot enter data'.mysqli_error($connect));
        else 
            echo 'Successful created a new account';
    }
    
    
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
        if(usertypeSelected == "Instructor") {
            const html = 
            `<div class="input-box">
            <label>First Name</label>
            <input type="text" name="firstName" placeholder="First Name" required><br><br>
            </div>
            <div class="input-box">
            <label>Last Name</label>
            <input type="text" name="lastName" placeholder="Last Name" required><br><br>
            </div>
            `;
            additionalForm.innerHTML = html;
        }
        else if (usertypeSelected == "Student") {
            const html = 
            `<div class="input-box">
            <label>First Name</label>
            <input type="text" name="firstName" placeholder="First Name" required><br><br>
            </div>
            <div class="input-box">
            <label>Last Name</label>
            <input type="text" name="lastName" placeholder="Last Name" required><br><br>
            </div>
            <div class="input-box">
            <label>Date Of Birth</label>
            <input type="date" name="dateOfBirth" required><br><br>
            </div>
            <div class="input-box">
            <label>Academic Program</label>
            <input type="text" name="academicProgram" placeholder="Academic Program" required><br><br>
            </div>
            `;
            additionalForm.innerHTML = html;
        }
        else if (usertypeSelected == "Provider") {
            const html = 
            `<div class="input-box">
            <label>Provider Name</label>
            <input type="text" name="providerName" placeholder="Provider Name" required><br><br>
            </div>`;
            additionalForm.innerHTML = html;
        }
        
    }
</script>

