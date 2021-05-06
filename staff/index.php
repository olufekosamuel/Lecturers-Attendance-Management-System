<?php
    include('../db.php');
    session_start();
    $user = $_SESSION["username"];
    $role = $_SESSION["role"];
    $id = $_SESSION["id"];
    $dept = $_SESSION["dept"];


    //get lecturers course count
    $sql = "SELECT * FROM lecturer_course where lecturerid='$id'";
    $result3 = mysqli_query($db, $sql);
    $coursecount = 0;
    // look through query
    while($row = mysqli_fetch_array($result3)){
        $coursecount +=1;
    }


    //get lecturers in same department count
    $sql = "SELECT * FROM staff where departmentid='$dept'";
    $result3 = mysqli_query($db, $sql);
    $deptcount = 0;
    // look through query
    while($row = mysqli_fetch_array($result3)){
        $deptcount +=1;
    }

    //get upcoming lectures count
    $sql = "SELECT * FROM lecturer_course where lecturerid='$id'";
    $results21 = mysqli_query($db, $sql);

    // set array
    $lectures_count = 0;

    // look through query
    while($row = mysqli_fetch_array($results21)){

        //foreach course lecturer owns lets get latest lectures coming up
        $courseId = $row["CoursesID"];
        

        //get lectures
        $sql = "SELECT * FROM lecture where Course_ID='$courseId' AND StartDate >= NOW()"; 
        $results3 = mysqli_query($db, $sql);
        $rest = mysqli_fetch_assoc($results3);

        $lectures_count +=1;


    }


?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Lecturer Management System | Home</title>
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
                <h1>Welcome, <?php echo $user; ?></h1>
                <p>Role: <?php if($role==1){echo "Administrator"; }elseif($role==2){ echo "Lecturer"; }else{echo "Head of Department";}?></p>

                <div class="catalog">
                    <div class="cat cat1">
                        <?php echo "<a href='view_courses.php' class='left' alt='view_courses'>"; echo "View Courses"; echo "</a>"; ?>
                        <p class="big-right"><?= $coursecount?></p>
                    </div>
                    <div class="cat cat2">
                        <?php echo "<a href='view_department_lecturers.php' class='left' alt='view_courses'>"; echo "View Department Lecturers"; echo "</a>"; ?>
                        <p class="big-right"><?= $deptcount?></p>
                    </div>
                    <div class="cat cat3">
                        <?php echo "<a href='view_latest_lectures.php' class='left' alt='view_courses'>"; echo "View Upcoming Lectures"; echo "</a>"; ?>
                        <p class="big-right"><?= $lectures_count?></p>
                    </div>
                </div>
                <div class="catalog">
                    <?php if ($role == 1): ?>
                        <div class="cat cat1">
                            <p>Create Course</p>
                        </div>
                    <?php else: ?>
                        <div style="visibility:hidden" class="cat cat1">
                            <p>Create Course</p>
                        </div>      
                    <?php endif; ?>
                    <div style="visibility:hidden" class="cat cat2">
                        <p>Coming soon</p>
                    </div>
                    <div style="visibility:hidden" class="cat cat3">
                        <p>Coming soon</p>
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