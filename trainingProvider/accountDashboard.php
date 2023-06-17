<?php include '../db_connect.php';
    session_start(); 
    //echo $_SESSION["username"];
    //echo $_SESSION["usertype"];
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Training Provider Manage Accounts</title>

</head>

<body>
<header>
    <h1>Manage Accounts</h1>
    <a href="createAccount.php"><button>Add Account</button></a>
</header>

<table border="1">
    <legend>Instructors</legend>
    <tr>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Contact Number</th>
        <th>Email</th>
        <th>Joined Date</th>
        <th colspan="2">Action</th>
    </tr>
    <?php
    //$sql = "SELECT * FROM user ORDER BY joined_date;";
    $sql = "SELECT * FROM user INNER JOIN instructor on user.username = instructor.username WHERE provider_username = '". $_SESSION["username"] . "';";
    $result = mysqli_query($connect,$sql);
    $countInstructor = mysqli_num_rows($result);

    while($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?php echo $row["username"]; ?></td>
        <td><?php echo $row["first_name"]; ?></td>
        <td><?php echo $row["last_name"]; ?></td>
        <td><?php echo $row["contact_number"]; ?></td>
        <td><?php echo $row["email"]; ?></td>
        <td><?php echo $row["joined_date"]; ?></td>
        <td><a href="accountDetail.php?view&username=<?php echo $row["username"];?>">Details</a></td>
        <td><a href="editAccount.php?edit&username=<?php echo $row["username"];?>">Edit</a></td>
        <!-- <td><a href="dashboard.php?del&username=<?php echo $row["username"];?>" onclick="return confirmation();">Delete</a></td> -->
    </tr>
    <?php
    }
    
    ?>
    
      
</table>
<p>Number of instructor: <?php echo $countInstructor; ?></p>  
<br>
<table border="1">
    <legend>Students</legend>
    <tr>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Date Of Birth</th>
        <th>Academic Program</th>
        <th>Contact Number</th>
        <th>Email</th>
        <th>Joined Date</th>
        <th colspan="2">Action</th>
    </tr>
    <?php
    //$sql = "SELECT * FROM user ORDER BY joined_date;";
    $sql = "SELECT * FROM user INNER JOIN student on user.username = student.username WHERE provider_username = '". $_SESSION["username"] . "';";
    $result = mysqli_query($connect,$sql);
    $countStudent = mysqli_num_rows($result);

    while($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?php echo $row["username"]; ?></td>
        <td><?php echo $row["first_name"]; ?></td>
        <td><?php echo $row["last_name"]; ?></td>
        <td><?php echo $row["date_of_birth"]; ?></td>
        <td><?php echo $row["academic_program"]; ?></td>
        <td><?php echo $row["contact_number"]; ?></td>
        <td><?php echo $row["email"]; ?></td>
        <td><?php echo $row["joined_date"]; ?></td>
        <td><a href="accountDetail.php?view&username=<?php echo $row["username"];?>">Details</a></td>
        <td><a href="editAccount.php?edit&username=<?php echo $row["username"];?>">Edit</a></td>
        <!-- <td><a href="dashboard.php?del&username=<?php echo $row["username"];?>" onclick="return confirmation();">Delete</a></td> -->
    </tr>
    <?php
    }
    ?>
      
      
    </table>
    <?php

    ?>
    
    <p>Number of student: <?php echo $countStudent; ?></p>
</body>

</html>

<?php
 
    if(isset($_GET["del"])) {
        $username = $_GET['username'];
        // find the usertype
        $sql = "SELECT * from user where username ='" . $username . "';";
        $result = mysqli_query($connect,$sql);
        $count = mysqli_num_rows($result);
        if ($count == 0) {
            ?>
            <script>
            alert( "User '<?php echo $username ?>' not found ");
            window.location.href="dashboard.php";
            </script>
            <?php
        }
        else {
            $row = mysqli_fetch_assoc($result);
            if($row["usertype"] == 'Instructor') {
                $sql = "DELETE from instructor WHERE username ='" . $username . "';";
                $result = mysqli_query($connect,$sql);
            }
            else if($row["usertype"] == 'Student') {
                $sql = "DELETE from student WHERE username ='" . $username . "';";
                $result = mysqli_query($connect,$sql);
            }
            else if($row["usertype"] == 'Provider') {
                $sql = "DELETE from training_provider WHERE username ='" . $username . "';";
                $result = mysqli_query($connect,$sql);
            }
            
            $sql = "DELETE from user WHERE username ='" . $username . "';";
            $result = mysqli_query($connect,$sql);
            ?>

            <script>
            alert( "User '<?php echo $username ?>' has been deleted.");
            window.location.href="dashboard.php";
            </script>;

            <?php
        }
        //header("Location: dashboard.php");
    }
?>