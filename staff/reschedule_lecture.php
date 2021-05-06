<?php
    include('../db.php');
    session_start();
    $user = $_SESSION["username"];
    $role = $_SESSION["role"];
    $id = $_SESSION["id"];

    $error = "";


    $course_id = $_GET['id'];
    $lecture_id = $_GET['lecture'];

    $post_url = "reschedule_lecture.php?id=".$course_id."&lecture=".$lecture_id;

    // reschedule lecture
	if (isset($_POST['reschedule_course'])) {
		$date = mysqli_real_escape_string($db, $_POST['name']);
        
		if (empty($date)) {
			$emailErr = "Date is required";
			$error = true;
		}
	
		if ($error == false) {
			$query = "UPDATE lecture SET startdate='$date' WHERE id='$lecture_id'";
            mysqli_query($db, $query);
            echo "call me";
           
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

    //get lectures
    $sql = "SELECT * FROM lecture where course_id='$course_id' AND id='$lecture_id'";
    $results2 = mysqli_query($db, $sql);
    $lecture_data = mysqli_fetch_assoc($results2);

    $lecture_day = strftime('%Y-%m-%dT%H:%M:%S', strtotime($lecture_data['StartDate']));

   


?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Lecturer Management System | Lectures</title>
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
                    <p>Lecture Title: <?php echo $lecture_data['Title'] ?></p><br>
                    <p>Reschedule Lecture</p>



                    <form method="post" action=<?=$post_url?>>
                    <div class="sign-in-form">
                        <div class="form-g">
                            <input type="datetime-local" value="<?php echo $lecture_day; ?>" name="name" id="date" required>
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
                            type="submit" class="btn" name="reschedule_course"
                            >
                                Reschedule
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