<!-- <?php include '../db_connect.php'; 
// session_start();
// unset($_SESSION["usernama"]);
// unset($_SESSION["usertype"]);
// header("Location:login.php");
;?> -->

<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Side Menu Bar | Web Development Assignment </title>
        <link rel="stylesheet" href="../NavBar/NavBarStyle.css"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <nav>
            <ul>
                <li>
                    <a href="#" class="logo">
                        <img src="../NavBar/logo1.png" alt="">
                        <span class="nav-itme">TPMS</span>
                    </a>
                </li>
                <li><a href="#" class="">
                    <i class="fas fa-home"></i>
                    <span class="nav-item">Dashboard</span>
                </a></li>
                <li><a href="#">
                    <i class="fas fa-server"></i>
                    <span class="nav-item">Course Overview</span>
                </a></li>
                <li><a href="#">
                    <i class="fas fa-book"></i>
                    <span class="nav-item">Registered Course</span>
                </a></li>
                <li><a href="#">
                    <i class="fas fa-bullhorn"></i>
                    <span class="nav-item">Feedback</span>
                </a></li>
                <li><a href="#">
                    <i class="fas fa-user"></i>
                    <span class="nav-item">Profile</span>
                </a></li>
                <li><a href="#" class="logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-item">Logout</span>
                </a></li>
            </ul>
        </nav>
    </body>

    <script>
        var navItems = document.querySelectorAll('nav ul li a');

        // Add click event listener to each navigation item
        navItems.forEach(function(navItem) {
        navItem.addEventListener('click', function(e) {
            // Prevent the default link behavior
            e.preventDefault();

            // Remove the 'active' class from all navigation items
            navItems.forEach(function(item) {
            item.classList.remove('active');
            });

            // Add the 'active' class to the clicked navigation item
            this.classList.add('active');
        });
        });
    </script>
</html>