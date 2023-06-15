<?php include '../db_connect.php';
    session_start(); 
    //echo $_SESSION["username"];
    //echo $_SESSION["usertype"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>

<body>
<header>
    <h1>Admin Dashboard</h1>
    <a href="createAccount.php"><button>Add Account</button></a>
</header>
<table>
    <tr>
        <th>Username</th>
        <th>Usertype</th>
        <th>Joined Date</th>
        <th colspan="3">Action</th>
    </tr>
    <?php
    $sql = "SELECT * FROM user;";
    $result = mysqli_query($connect,$sql);
    $count = mysqli_num_rows($result);

    while($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?php echo $row["username"]; ?></td>
        <td><?php echo $row["usertype"]; ?></td>
        <td><?php echo $row["joined_date"]; ?></td>
        <td><a href="accountDetail.php?view&username=<?php echo $row["username"]?>">Details</a></td>
        <td><a href="editAccount.php?edit&username=<?php echo $row["username"]?>">Edit</a></td>
        <td><a href="dashboard.php?del&username=<?php echo $row["username"]?>" onclick="return confirmation();">Delete</a></td>
    </tr>
    <?php
    }
    ?>
      
      
    </table>
    <?php
    $sql = "SELECT * FROM user where usertype = 'Admin';";
    $result = mysqli_query($connect,$sql);
    $countAdmin = mysqli_num_rows($result);

    $sql = "SELECT * FROM instructor;";
    $result = mysqli_query($connect,$sql);
    $countInstructor = mysqli_num_rows($result);

    $sql = "SELECT * FROM student;";
    $result = mysqli_query($connect,$sql);
    $countStudent = mysqli_num_rows($result);

    $sql = "SELECT * FROM training_provider;";
    $result = mysqli_query($connect,$sql);
    $countProvider = mysqli_num_rows($result);

    ?>
    <p>Number of users: <?php echo $count; ?></p>
    <p>Number of admin: <?php echo $countAdmin; ?></p>
    <p>Number of instructor: <?php echo $countInstructor; ?></p>
    <p>Number of student: <?php echo $countStudent; ?></p>
    <p>Number of training provider: <?php echo $countProvider; ?></p>
</body>

</html>