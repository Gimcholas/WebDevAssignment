<?php include '../db_connect.php';
    session_start();
    // if($_SESSION["usertype"] != 'Admin') {
    //     header("Location: ../Login/login.php");
    // }
    $_SESSION['username'] = "Huawei";
?>

<!DOCTYPE html>
<html>
<head> 
    <title>Create New Account</title>
    <link rel='stylesheet' type="text/css" href=createAccount.css>
</head>

<body>
    <div class="create-account-form">
    <form action="createAccount.php" method="POST" onsubmit="return mySubmitFunction(event)" id="form">
        <h2>Create New Account</h2>
        <div class="input-box">
            <img src="../files/defaultProfileImage.jpg" alt="UserIcon">
            <input type="text" name="username" id="username" placeholder="Username"><br>
            <div class="errorMessageBox" id="username-messageBox"></div><br>

        </div>
        <div class="input-box">
            <img src="../files/password_icon.png" alt="UserIcon">
            <input type="password" id="password" name="password" placeholder="Password"><br>
            <div class="errorMessageBox" id="password-messageBox"></div><br>
        </div>  

        <div class="input-box">
            <select name="usertype" id="usertype" onchange="updateForm()">
                <option hidden disabled selected value>Select a usertype</option>
                <option value="Instructor">Instructor</option>
                <option value="Student">Student</option>
            </select><br>
            <div class="errorMessageBox" id="input-box-messageBox"></div><br>
        </div>
        <div id="additionalFields"></div>
        <div class="operationsButton">
            <a href="accountDashboard.php"><input type="button" value = "Back"></a><br><br>
            <input type="submit" name="submitBtn" value="Create Account"><br><br>
        </div>
    </form>
    </div>

    <script>
        function updateForm() {
            const usertypeSelected = document.getElementById("usertype").value;
            console.log(usertypeSelected);
            
            const additionalForm = document.getElementById("additionalFields");
            additionalForm.innerHTML = "";
            const commonHtml1 = `<div class="input-box">
                <input type="text" id="firstName" name="firstName" placeholder="First Name"><br>
                <div class="errorMessageBox" id="firstName-messageBox"></div><br>
                </div>
                <div class="input-box">
                <input type="text" id="lastName" name="lastName" placeholder="Last Name"><br>
                <div class="errorMessageBox" id="lastName-messageBox"></div><br>
                </div>`;
                
            const commonHtml2 = `<div class="input-box">
                <input type="tel" id="contactNumber" name="contactNumber" placeholder="Contact Number"><br>
                <div class="errorMessageBox" id="contactNumber-messageBox"></div><br>
                </div>
                <div class="input-box">
                <input type="email" id= "email" name="email" placeholder="Contact Email"><br>
                <div class="errorMessageBox" id="email-messageBox"></div><br>
                </div>`;

            if(usertypeSelected == "Instructor") {           
                additionalForm.innerHTML = commonHtml1 + commonHtml2;
            }
            else if (usertypeSelected == "Student") {
                const html = 
                `<div class="input-box">
                <img src="../files/BD_Icon.png" alt="UserIcon">
                <input type="date" id="dateOfBirth" name="dateOfBirth"><br>
                <div class="errorMessageBox" id="dateOfBirth-messageBox"></div><br>
                </div>
                <div class="input-box">
                <input type="text" id="academicProgram" name="academicProgram" placeholder="Academic Program"><br>
                <div class="errorMessageBox" id="academicProgram-messageBox"></div><br>
                </div>
                `;
                additionalForm.innerHTML = commonHtml1 + html + commonHtml2;
            }
            
        }

        function showErrorMessage(message, type){
            const errorMessageBox = document.getElementById(type+"-messageBox");
            const errorHtml = `${message}`;
            errorMessageBox.innerHTML = errorHtml;
        }
        
        
        function mySubmitFunction(event) {
            event.preventDefault();

            var usernameElement = document.getElementById("username");
            var passwordElement = document.getElementById("password");
            var usertypeElement = document.getElementById("usertype");

            var username = usernameElement ? usernameElement.value : "";
            var password = passwordElement ? passwordElement.value : "";
            var usertype = usertypeElement ? usertypeElement.value : "";

            var allowSubmission = true;

            if (username == "") {
                showErrorMessage("Username is required", "username");
                allowSubmission = false;
            }
            else{
                showErrorMessage("", "username");
            }

            var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)/;
            if (password.length < 8 || !passwordPattern.test(password)) {
                if(password.length < 8) showErrorMessage("Password must be at least 8 characters", "password");
                else showErrorMessage("Password must include at least one letter and one number", "password");
                allowSubmission = false;
            }
            else{
                showErrorMessage("", "password");
            }

            if (usertype == "") {
                showErrorMessage("Usertype is required", "input-box");
                allowSubmission = false;
            }
            else{
                showErrorMessage("", "input-box");
            }

            if (usertype == "Instructor" || usertype == "Student") {
                var firstNameElement = document.getElementById("firstName");
                var lastNameElement = document.getElementById("lastName");

                var firstName = firstNameElement ? firstNameElement.value : "";
                var lastName = lastNameElement ? lastNameElement.value : "";

                if (firstName == "") {
                    showErrorMessage("First name is required", "firstName");
                    allowSubmission = false;
                }
                else{
                    showErrorMessage("", "firstName");
                }

                if (lastName == "") {
                    showErrorMessage("Last name is required", "lastName");
                    allowSubmission = false;
                }
                else{
                    showErrorMessage("", "lastName");
                }

                if (usertype == "Student") {
                    var dateOfBirthElement = document.getElementById("dateOfBirth");
                    var academicProgramElement = document.getElementById("academicProgram");

                    var dateOfBirth = dateOfBirthElement ? dateOfBirthElement.value : "";
                    var academicProgram = academicProgramElement ? academicProgramElement.value : "";

                    if (dateOfBirth == "") {
                        showErrorMessage("Date of birth is required", "dateOfBirth");
                        allowSubmission = false;
                    }
                    else{
                        showErrorMessage("", "dateOfBirth");
                    }

                    if (academicProgram == "") {
                        showErrorMessage("Academic program is required", "academicProgram");
                        allowSubmission = false;
                    }
                    else{
                        showErrorMessage("", "academicProgram");
                    }
                }

                var contactElement = document.getElementById("contactNumber");
                var emailElement = document.getElementById("email");

                var contact = contactElement ? contactElement.value : "";
                var email = emailElement ? emailElement.value : "";

                if(contact == ""){
                    showErrorMessage("Contact is required", "contactNumber");
                    allowSubmission = false;
                }
                else{
                    showErrorMessage("", "contactNumber");
                }

                if(email == ""){
                    showErrorMessage("E-mail is required", "email");
                    allowSubmission = false;
                }
                else{
                    showErrorMessage("", "email");
                }


            }


            if(allowSubmission) {
                document.getElementById('form').submit();
            }

        }



    </script>

</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $allowSubmission=true;
    if(empty($_POST["username"])) {
        $allowSubmission=false;
    }

    $sql = "SELECT * FROM user where username='" . $_POST["username"] . "';";
    $result = mysqli_query($connect,$sql);
    $count = mysqli_num_rows($result);
    if($count > 0) {
        echo '<script>showErrorMessage("Username not available","username")</script>';
        $allowSubmission=false;

    }
    
    if(strlen($_POST["password"]) < 8) {
        $allowSubmission=false;
 
    }
    if (!preg_match('/[A-Za-z]/', $_POST["password"]) || !preg_match('/[0-9]/', $_POST["password"])) {
        $allowSubmission=false;

    }
    if(empty($_POST["usertype"])) {
        $allowSubmission=false;
 
    }

    if($_POST["usertype"] == "Instructor" || $_POST["usertype"] == "Student") {
        if(empty($_POST["firstName"])){
            $allowSubmission=false;    
    
        }
        if(empty($_POST["lastName"])){
            $allowSubmission=false;    
    
        }
    }

    if($_POST["usertype"] == "Student") {
        if(empty($_POST["dateOfBirth"])){
            $allowSubmission=false;    
    
        }
        if(empty($_POST["academicProgram"])){
            $allowSubmission=false;    
    
        }
    }

        

    if($allowSubmission){
        //print_r($_POST);
        $username = $_POST["username"];
        $password = $_POST["password"];
        $usertype = $_POST["usertype"];

        $hashed_password = password_hash($password,PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (username,password_hash,usertype) values ('$username','$hashed_password','$usertype')";
        $abc = mysqli_query($connect,$sql);
        if(!$abc)
            die('Cannot enter data'.mysqli_error($connect));

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
        ?>

        <script type="text/javascript">
            alert("Successful created a new account");
        </script>

    
    <?php
    }

}
?>