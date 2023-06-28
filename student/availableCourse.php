<?php include '../db_connect.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head> 
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../NavBar/NavBarStyle.css"/>
    <link rel="stylesheet" href="#"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<div class="Container">
    <div class="sidebar">
        <?php include '../NavBar/NavBar.php'?>
    </div>
    <div class="content" id="content"> 
        <!-- do available course code here  -->
    </div>
</div>
</body>

<script>
    $(document).ready(function() {
        $(".sidebar").hover(
          function() {
            $(".content").addClass("shifted");
            // console.log('done')
          },
          function() {
            $(".content").removeClass("shifted");
          }
        );
      }
    );
</script>
</html>