<?php
    session_start();
    $user = $_SESSION["name"];

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Lecturer Management System (Students) | Home</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/style.css" />
        <link rel="stylesheet" href="../assets/css/dashboard.css" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	</head>
	<body>
	<div class="wrapper">
        <div class="sidebar">
            
            <div class="logo-div">
                <h1>LAMS</h1>
            </div>
            <div class="menu">
                <p class="menu-text">Menu</p>
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="view_courses.php">Courses</a></li>
            </ul> 
            <div class="social_media">
                <ul>
                    <li><a href="">Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="main_content">
            <div class="header">
               <p class="report"> Student Dashboard</p>
               <div class="notifications"></div>
               </div>  
            <div class="info">
                <h1>Welcome, <?php echo $user; ?></h1>

                <div class="catalog">
                    <div class="cat cat1">
                    <?php echo "<a href='view_enrolled_courses.php' alt='view_courses'>"; echo "View Enrolled Courses"; echo "</a>"; ?>
                    </div>
                    <div class="cat cat2">
                        <p>View Latest Lectures</p>
                    </div>
                    <div class="cat cat3">
                        <p>Enroll in Course</p>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

	
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
		

	</body>
</html>