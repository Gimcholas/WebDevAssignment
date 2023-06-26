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
    if(array_key_exists('postdata',$_SESSION)){
        unset($_SESSION['postdata']);
    }
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

    if (isset($_FILES["uploadedPicture"])){

        $imageFolderPath = "../files/profile_picture/";

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        $filename = $_FILES["uploadedPicture"]["name"];
        $filetype = $_FILES["uploadedPicture"]["type"];
        $filesize = $_FILES["uploadedPicture"]["size"];
    
        // better handle error in javascript ??
        // // Verify file extension
        if(!array_key_exists(pathinfo($filename, PATHINFO_EXTENSION), $allowed)) 
            die("Error: Please select a valid file format.");
    
        // // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) 
            die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            $newFileName = $_SESSION["username"];
            if ($filetype == "image/jpg") {
                $newFileName .= ".jpg";
            }
            else if ($filetype == "image/jpeg") {
                $newFileName .= ".jpeg";
            }
            else if ($filetype == "image/png") {
                $newFileName .= ".png";
            }

            $imagePath = $imageFolderPath . $newFileName;
            if(file_exists($imagePath)){
                echo $filename . " is already exists.";  
                chmod($imagePath,0755);
                unlink($imagePath);
            }
            move_uploaded_file($_FILES["uploadedPicture"]["tmp_name"], $imagePath);
        }
        else{
            die ("Invalid FileType. Please try again."); }
        
        $insertpath_sql = "UPDATE user SET profile_image_path = '$imagePath' WHERE username = '".$_SESSION['username']."'";
        mysqli_query($connect,$insertpath_sql); 
        header("Location: " . $_SERVER['PHP_SELF']);
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
                <form id="changeProfilePictureForm" method="POST" action="" enctype="multipart/form-data">
                    <label for="uploadPicture">
                        <div class="content-overlay"></div>
                        <img src = "
                            <?php
                                echo $profile["profile_image_path"];
                            ?>
                        " alt="Profile Image"/>

                        <div class="content-details fadeIn-bottom">
                            <h3>Change Profile Picture</h3>
                        </div>
                    </label>
                    <input type="file" id="uploadPicture" name="uploadedPicture" style="display: none;"/>
                </form>

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
        const uploadPictureInput = document.getElementById("uploadPicture");

        uploadPictureInput.addEventListener("change", function(e) {
            document.getElementById("changeProfilePictureForm").submit();
        });


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