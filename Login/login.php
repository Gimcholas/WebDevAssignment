<?php include '../db_connect.php'; ?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href = "style.css">
    </head>

    <body>
        <div class="container">

        <!-- left part div -->
            <div class="leftdiv">
                <img src="../files/MMU_Logo.png" alt="MMU Logo" >
            </div>

        <!-- right part div -->
            <form action="Form submission" method="post">
                <div class = "rightdiv">            
                    <h2>Sign In</h2>
                    <input type="text" name="username" placeholder = "Username">

                    <input type="password" name="password" placeholder = "Password">

                    <button name="LoginBtn">Login</button>
                </div>
            </form>    
        </div>  
    </body>
</html>

<?php
    if (isset($_GET["del"])) {

        $usernameInput = $_POST["username"];
        $passwordInput = $_POST["password"];
        $sql = "select * from user where username='".$username."' And password = '".$passwordInput."'";
        $result = mysqli_query($connect,"$sql");
        if(mysql_num_rows($result) == 1){
            echo "Login successfully";
            exit();
        }
        else{
            echo "Login Failed";
            exit();
        }
    }
?>