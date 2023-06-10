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
            <select name="usertype">
                <option value="Admin">Admin</option>
                <option value="Instructor">Instructor</option>
                <option value="Student">Student</option>
                <option value="Provider">Training Provider</option>
            </select><br><br>
        </div>
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
    
    ?>
        <script type="text/javascript">
            alert("Successful created a new account");
        </script>
    <?php

}
?>



