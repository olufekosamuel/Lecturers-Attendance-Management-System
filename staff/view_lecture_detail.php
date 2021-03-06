<?php
    session_start();
    include('../db.php');
    $user = $_SESSION["username"];
    $role = $_SESSION["role"];
    $id = $_SESSION["id"];

    $page_id = $_GET['id'];
    $lecture_id = $_GET['lecture'];
    if(empty($page_id)){
        header('location: view_courses.php');
    }

    //GET COURSE DETAIL
    $sql = "SELECT * FROM course where id='$page_id'";
    $result = mysqli_query($db, $sql);
    $course_data = mysqli_fetch_assoc($result);

    //Check if lecturer owns course
    $sql = "SELECT * FROM lecturer_course where lecturerid='$id' and coursesid='$page_id'";
    $results = mysqli_query($db, $sql);

    if (mysqli_num_rows($results) == 1) {
        
    }else {
        $error = true;
        $websiteErr = "You dont have access to that course";
        echo "You dont have access to that course";
        header('location: view_courses.php');
    }

    //get lecture attendance
    $sql = "SELECT * FROM lecture where id='$lecture_id'";
    $result2 = mysqli_query($db, $sql);
    $lecture_data = mysqli_fetch_assoc($result2);

    //get lecture attendance
    $sql = "SELECT * FROM lecture_attendance where lectureid='$lecture_id'";
    $result3 = mysqli_query($db, $sql);
    $attendant = 0;
    // look through query
    while($row = mysqli_fetch_array($result3)){
        $attendant +=1;
    }

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Lecturer Management System | Course</title>
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
                <li><a href="">Lecturers</a></li>
                <li><a href="">Lectures</a></li>
            </ul> 
            <div class="social_media">
                <ul>
                    <li><a href="">Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="main_content">
            <div class="header">
               <p class="report"> Staff Dashboard</p>
               <div class="notifications"></div>
               </div>  
            <div class="info">
                <h1>Lecture: <?php echo $lecture_data["Title"] ?></h1><br>
                <p>Course: <?php echo $course_data["Title"] ?></p>
                
                <div class="catalog">
                    
                    <div class="cat cat1">
                        <p class="left">Capacity</p>
                        <p class="big-right"><?= $lecture_data["Capacity"]?></p>
                    </div>
                    <div class="cat cat2">
                        <p class="left">Attendants</p>
                        <p class="big-right"><?= $attendant?></p>
                    </div>
                    <div class="cat cat3">
                        <p class="left">Duration</p>
                        <p class="big-right"><?= $lecture_data["Duration"]?></p>
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