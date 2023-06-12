<?php include '../db_connect.php'; 
session_start()
;?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href = "login.css">
    </head>

    <body>
        <div class="container">

        <!-- left part div -->
            <div class="leftdiv">
                <img src="../files/MMU_Logo.png" alt="MMU Logo" >
            </div>

        <!-- right part div -->
            <form action="login.php" method="POST">
                <div class = "rightdiv">            
                    <h2>Sign In</h2>
                    <input type="text" name="username" placeholder = "Username" required>

                    <input type="password" name="password" placeholder = "Password" required>

                    <input type="submit" name="LoginBtn">
                </div>
            </form>    
        </div>  
    </body>
</html>

<?php
    if (isset($_POST["LoginBtn"])) {

        $usernameInput = $_POST["username"];
        $passwordInput = $_POST["password"];
        echo $usernameInput.$passwordInput;
        $sql = "select * from user where username='$usernameInput'";
        $result = mysqli_query($connect,$sql); 

        $row = mysqli_fetch_assoc($result);
        
        if(password_verify($passwordInput,$row["password_hash"])) {
            echo "Login successfully";
            $_SESSION["username"] = $row["username"];
            $_SESSION["usertype"] = $row["usertype"];
            if($row["usertype"] == "Admin") { // Redirect user to admin page
                header("Location: ../admin/dashboard.php");
            }
            //else if () // Redirect to Student
        }
        else {
            echo "Login Failed";
        }
    }    
?>