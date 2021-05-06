<?php
    include('../db.php');
    session_start();
    $user = $_SESSION["username"];
    $role = $_SESSION["role"];
    $id = $_SESSION["id"];

    $error = "";


    $course_id = $_GET['id'];

    $post_url = "create_lectures.php?id=".$course_id;

    // reschedule lecture
	if (isset($_POST['create_lecture'])) {
		$startdate = mysqli_real_escape_string($db, $_POST['startdate']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $duration = mysqli_real_escape_string($db, $_POST['duration']);
        $capacity = mysqli_real_escape_string($db, $_POST['capacity']);
        
		if (empty($startdate)) {
			$emailErr = "Start Date is required";
			$error = true;
		}

        if (empty($title)) {
			$emailErr = "Title is required";
			$error = true;
		}

        if (empty($duration)) {
			$emailErr = "Duration is required";
			$error = true;
		}

        if (empty($capacity)) {
			$emailErr = "Capacity is required";
			$error = true;
		}
	
		if ($error == false) {
            $query = "INSERT INTO lecture (title, duration, startdate, capacity, course_id) 
				  VALUES('$title', '$duration',now(), '$capacity', '$course_id')";
		    mysqli_query($db, $query);
           
            $url = 'location: view_lectures.php?id='.$course_id;
            header($url);
		}
	}


    //get course details
    $sql = "SELECT * FROM course where id='$course_id'";
    $result = mysqli_query($db, $sql);
    $course_data = mysqli_fetch_assoc($result);


    //Check if lecturer owns course
    $sql = "SELECT * FROM lecturer_course where lecturerid='$id' and coursesid='$course_id'";
    $results = mysqli_query($db, $sql);

    if (mysqli_num_rows($results) == 1) {
        
    }else {
        $error = true;
        $websiteErr = "You dont have access to that course";
        echo "You dont have access to that course";
        header('location: view_courses.php');
    }


?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Lecturer Management System | Create Course</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/style.css" />
        <link rel="stylesheet" href="../assets/css/table.css" />
        <link rel="stylesheet" href="../assets/css/auth.css" />
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
            <div class="report-table">
            <div class="table-head">
                <div class="title">
                    <p>Course: <?php echo $course_data['Title'] ?> </p>
                    <br>
                    <p>Create Lecture</p>



                    <form method="post" action=<?=$post_url?>>
                    <div class="sign-in-form">

                        <div class="form-g">
                        <label for="email">Title</label>
                        <input type="text" name="title" id="title" placeholder="Introduction to cloud computing" required>
                        </div>
                        <div class="form-g">
                            <label for="duration">Duration</label>
                            <input type="text" name="duration" id="duration" placeholder="2 Hours" required>
                        </div>
                        <div class="form-g">
                            <label for="date">Start Date</label>
                            <input type="datetime-local" name="startdate" id="date" required>
                        </div>
                        <div class="form-g">
                            <label for="capacity">Capacity</label>
                            <input type="text" name="capacity" id="capacity" placeholder="50" required>
                        </div>
                        

                        <?php if ($error): ?>
                            <div class="err-msg" v-show="error == true">
                            <span class="err-icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.99996 0.666626C4.39996 0.666626 0.666626 4.39996 0.666626 8.99996C0.666626 13.6 4.39996 17.3333 8.99996 17.3333C13.6 17.3333 17.3333 13.6 17.3333 8.99996C17.3333 4.39996 13.6 0.666626 8.99996 0.666626ZM8.16663 13.1666V11.5H9.83329V13.1666H8.16663ZM8.16663 4.83329V9.83329H9.83329V4.83329H8.16663Z" fill="#FF323E"/>
                                </svg>
                            </span>
                            <p><?php echo $websiteErr; ?><p> 
                            
                            </div> 
                        <?php endif; ?>


                    
                        <div class="form-btn">
                            <button
                            type="submit" class="btn" name="create_lecture"
                            >
                                Create Lecture
                            </button>
                        </div>
                    </div>
				</form>
                    
                </div>
                
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