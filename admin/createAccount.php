<?php include '../db_connect.php'; 
    // if($_SESSION["usertype"] != 'Admin') {
    //     header("Location: ../Login/login.php");
    // }
    
?>
<!DOCTYPE html>
<html>
<head> 
    <title>Create New Account</title>
    <link rel="stylesheet" type="text/css" href = "createAccount.css">
</head>

<body>

    <header class="header-bar">
        <h1>Create Account<h1>
    </header>

    <div class="create-account-form">
    <form action="createAccount.php" method="POST">
        <h2>Create New Account</h2>
        <div class="input-box-user">
            <img src="../files/defaultProfileImage.jpg" alt="UserIcon">
            <input type="text" name="username" placeholder="Username" required><br><br>
        </div>
        <div class="input-box-pw">
            <img src="../files/password_icon.png" alt="PwIcon">
            <input type="password" name="password" placeholder="Password" required><br><br>
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
            <a href="dashboard.php"><input type="button" value = "Back"></a><br><br>
            <input type="submit" name="submit" value="Create Account"><br><br>
        </div>
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
                $abc2 = mysqli_query($connect,$sql2);
                if(!$abc2)
                    die('Cannot enter data'.mysqli_error($connect));
                //else 
                //echo 'Successful created a new account';
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
?>

<script>
    function updateForm() {
        const usertypeSelected = document.getElementById("usertype").value;
        console.log(usertypeSelected);
        
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
            </select><br><br>
            </div>`;

        const nameInputHtml = `<div class="input-box">
            <input type="text" name="firstName" placeholder="First Name" required><br><br>
            </div>
            <div class="input-box">
            <input type="text" name="lastName" placeholder="Last Name" required><br><br>
            </div>`;
            
        const contactInputHtml = `<div class="input-box">
            <input type="tel" name="contactNumber" placeholder="Contact Number"><br><br>
            </div>
            <div class="input-box">
            <input type="email" name="email" placeholder="Contact Email"><br><br>
            </div>`;

        if (usertypeSelected == "Provider") {
            const html = 
            `<div class="input-box">
            <input type="text" name="providerName" placeholder="Provider Name" required><br><br>
            </div>`;
            additionalForm.innerHTML = html + contactInputHtml;
        }
        else if (usertypeSelected == "Instructor") {
            additionalForm.innerHTML = selectProviderHtml + nameInputHtml + contactInputHtml;
        }
        else if (usertypeSelected == "Student") {
            const html = 
            `<div class="input-box">
            <input type="date" name="dateOfBirth" required><br><br>
            </div>
            <div class="input-box">
            <input type="text" name="academicProgram" placeholder="Academic Program" required><br><br>
            </div>
            `;
            additionalForm.innerHTML = selectProviderHtml + nameInputHtml + html + contactInputHtml;
        }
        else if (usertypeSelected == "Admin") {
            // Do nothing
        }
        
    }
</script>

