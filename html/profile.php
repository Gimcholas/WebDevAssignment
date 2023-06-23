<?php
    include "../db_connect.php";
    session_start();

    function generateHTMLProfileDetail($title,$variable){
        echo '<p><span class="title">'.$title.'</span><span class="colon">:</span>'.$variable.'</p>';
    }

    function generateHTMLEditProfile($title,$inputName,$value,$inputType = "text"){
        echo 
        '<p> 
            <span class="title">'.$title.'</span>
            <span class="colon">:</span>
            <input type="'.$inputType.'" name="'.$inputName.'" value = "'.$value.'" required>
        </p>';
    }

    function generateHTMLChangePassword($title,$inputName){
        echo 
        '<p> 
            <span class="title">'.$title.'</span>
            <span class="colon">:</span>
            <input id="'.$inputName.'" name="'.$inputName.'" placeholder = "'.$title.'" type="password" required>
        </p>';
    }
?>

<?php
    if(isset($_POST['submitEdit'])){
        $contactNumber = $_POST["contactNumber"];
        $emailAddress = $_POST["emailAddress"];
        if($_SESSION['usertype'] == "Student"){
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $dateOfBirth = $_POST["dateOfBirth"];

            $edit_profile_sql = "UPDATE student
                                    SET first_name = '$firstName', last_name = '$lastName', date_of_birth = '$dateOfBirth', contact_number = '$contactNumber', email = '$emailAddress' 
                                    WHERE username = '".$_SESSION['username']."'";
        }

        else if($_SESSION['usertype'] == "Instructor"){
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            
            $edit_profile_sql = "UPDATE instructor
                                    SET first_name = '$firstName', last_name = '$lastName', contact_number = '$contactNumber', email = '$emailAddress' 
                                    WHERE username = '".$_SESSION['username']."'";
        }

        else if($_SESSION['usertype'] == "Provider"){
            $providerName = $_POST["providerName"];
            
            $edit_profile_sql = "UPDATE training_provider
                                    SET provider_name = '$providerName', contact_number = '$contactNumber', email = '$emailAddress' 
                                    WHERE username = '".$_SESSION['username']."'";
        }

        mysqli_query($connect, $edit_profile_sql); 
        header("Refresh:0");
        exit;
    }
    if (isset($_POST["submitChangePWD"])){
        $password = $_POST["newPassword"];
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        $edit_password_sql = "UPDATE user SET password_hash =$hashed_password WHERE username = '".$_SESSION['username']."'";
        mysqli_query($connect, $edit_password_sql); 
        header("Refresh:0");
        exit;
    }
?>
<?php
    $_SESSION['usertype'] = "Student";
    $_SESSION['username'] = "Student1";

    // $_SESSION['usertype'] = "Instructor";
    // $_SESSION['username'] = "Tan";

    // $_SESSION['usertype'] = "Provider";
    // $_SESSION['username'] = "Huawei";

    if($_SESSION['usertype'] == "Student"){
        $profile_sql = "SELECT * FROM user as u 
                        JOIN student as s ON s.username = u.username
                        WHERE u.username = '".$_SESSION['username']."'";
    }

    else if($_SESSION['usertype'] == "Instructor"){
        $profile_sql = "SELECT * FROM user as u 
                        JOIN instructor as i ON i.username = u.username
                        WHERE u.username = '".$_SESSION['username']."'";
    }

    else if($_SESSION['usertype'] == "Provider"){
        $profile_sql = "SELECT * FROM user as u 
                        JOIN training_provider as tp ON tp.username = u.username
                        WHERE u.username = '".$_SESSION['username']."'";
    }

    $profile = mysqli_fetch_assoc(mysqli_query($connect, $profile_sql)); 
?>


<html>
    <head>
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="../css/profile.css">
    </head>

    <body>
        <div class = "container">
            <div class = "left-side">

                <img src = "
                    <?php
                        echo $profile["profile_image_path"];
                    ?>
                    " alt="Profile Image" 
                />

            </div>

            <div class = "right-side">

                <div id="displayDIV" style = "display:block;">

                    <h1>
                        <?php
                        if($_SESSION['usertype'] == "Student" || $_SESSION['usertype'] == "Instructor"){
                            echo $profile["last_name"]." ".$profile["first_name"];
                        }
                        else if($_SESSION['usertype'] == "Provider"){
                            echo $profile["provider_name"];
                        }
                        ?>
                    </h1>

                    <?php
                        if($_SESSION['usertype'] == "Student" || $_SESSION['usertype'] == "Instructor"){
                            generateHTMLProfileDetail("Training Provider",$profile["provider_username"]);
                        }

                        generateHTMLProfileDetail("Join on",$profile["joined_date"]);
                        generateHTMLProfileDetail("Contact",$profile["contact_number"]);
                        generateHTMLProfileDetail("Email",$profile["email"]);

                        if($_SESSION['usertype'] == "Student"){
                            generateHTMLProfileDetail("Date Of Birth",$profile["date_of_birth"]);
                            generateHTMLProfileDetail("Academic Program",$profile["academic_program"]);
                        }
                    ?>

                    <button id="startEditButton">Edit Profile</button>
                    <button id="changePasswordButton">Change Password</button>
                </div>

                <div id="editDIV" style="display:none;">
                    <form id="editProfileForm" method="POST" action="">
                        <h1>
                            Edit Profile
                        </h1>

                        <?php
                            if($_SESSION['usertype'] == "Student" || $_SESSION['usertype'] == "Instructor"){
                                generateHTMLEditProfile("First Name","firstName",$profile["first_name"]);
                                generateHTMLEditProfile("Last Name","lastName",$profile["last_name"]);
                            }
                            else if($_SESSION['usertype'] == "Provider"){
                                generateHTMLEditProfile("Provider Name","providerName",$profile["provider_name"]);
                            }

                            generateHTMLEditProfile("Contact","contactNumber",$profile["contact_number"],"tel");
                            generateHTMLEditProfile("Email","emailAddress",$profile["email"],"email");

                            if($_SESSION['usertype'] == "Student"){
                                generateHTMLEditProfile("Date Of Birth","dateOfBirth",$profile["date_of_birth"],"date");
                            }
                        ?>

                        <button type="button" id = "cancelEdit">Cancel</button>
                        <button type="submit" id = "submitEdit" name = "submitEdit">Edit</button>

                    </form>
                </div>


                <div id="newPasswordDIV" style="display:none;">
                    <form id="newPasswordForm" method="POST" action="">
                        <h1>
                            Change to New Password
                        </h1>
                            
                        <?php
                            generateHTMLChangePassword("New Password","newPassword");
                            generateHTMLChangePassword("Re-enter New Password","newPasswordConfirm");
                        
                        ?>

                        <button type="button" id = "cancelChangePWD">Cancel</button>
                        <button type="submit" id = "submitChangePWD" name = "submitChangePWD">Edit</button>

                    </form>
                </div>
            </div>
        </div>
    </body>
    <script>
        const editDIV = document.getElementById("editDIV");
        const displayDIV = document.getElementById("displayDIV");
        const newPasswordDIV = document.getElementById("newPasswordDIV");

        const editButton = document.getElementById("startEditButton");
        const changePasswordButton = document.getElementById("changePasswordButton");

        const submitEditButton = document.getElementById("submitEdit");
        const cancelEditButton = document.getElementById("cancelEdit");

        const cancelChangePWDButton = document.getElementById("cancelChangePWD");
        const submitChangePWDButton = document.getElementById("submitChangePWD");

        const editProfileForm = document.getElementById("editProfileForm");
        const newPasswordForm = document.getElementById("newPasswordForm");

        const password = document.getElementById("newPassword");
        const passwordConfirm = document.getElementById("newPasswordConfirm");

        editButton.addEventListener("click",function(e){
            displayDIV.style.display = "none";
            editDIV.style.display = "block";
        })

        cancelEditButton.addEventListener("click", function(e){
            displayDIV.style.display = "block";
            editDIV.style.display = "none";
            editProfileForm.reset();
        })

        changePasswordButton.addEventListener("click", function(e) {
            displayDIV.style.display = "none";
            newPasswordDIV.style.display = "block";
        })

        cancelChangePWDButton.addEventListener("click", function(e) {
            displayDIV.style.display = "block";
            newPasswordDIV.style.display = "none";
            newPasswordForm.reset();
        })

        function check_password_input(){
            if(password.value != passwordConfirm.value){
                passwordConfirm.setCustomValidity("Password Don't Match");
            }
            else{
                passwordConfirm.setCustomValidity("");
            }
        }
        password.onchange = check_password_input;
        passwordconfirm.onkeyup = check_password_input;

    </script>
</html>