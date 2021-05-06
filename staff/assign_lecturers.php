<?php
    include('../db.php');
    session_start();
    $user = $_SESSION["username"];
    $role = $_SESSION["role"];
    $id = $_SESSION["id"];

    $error = "";


    $course_id = $_GET['id'];

    $post_url = "assign_lecturers.php?id=".$course_id;

    // reschedule lecture
	if (isset($_POST['assign_lecturer'])) {
         

        /*
		$startdate = mysqli_real_escape_string($db, $_POST['startdate']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $duration = mysqli_real_escape_string($db, $_POST['duration']);
        $capacity = mysqli_real_escape_string($db, $_POST['capacity']);
        
		if (empty($startdate)) {
			$emailErr = "Start Date is required";
			$error = true;
		}

		if ($error == false) {
            $query = "INSERT INTO lecture (title, duration, startdate, capacity, course_id) 
				  VALUES('$title', '$duration', '$startdate', '$capacity', '$course_id')";
		    mysqli_query($db, $query);
           
            $url = 'location: view_lectures.php?id='.$course_id;
            header($url);
		}
        */
	}


    //get course details
    $sql = "SELECT * FROM course where id='$course_id'";
    $result = mysqli_query($db, $sql);
    $course_data = mysqli_fetch_assoc($result);
    $dept_id = $course_data["Department_ID"];

    if($role!=1){
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
    }

    //get lecturers in department
    $sql2 = "SELECT * FROM staff where departmentid='$dept_id' and role=2";
    $result3 = mysqli_query($db, $sql2);

    $lecturer_array = array();


	// look through query
	while($row = mysqli_fetch_array($result3)){

        // add each row returned into an array
        $lecturer_array[] = $row;
    
    }
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Lecturer Management System | Assign Lecturers</title>
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
                    <p>Assign Lecturers</p>



                    <form method="post" action=<?=$post_url?>>
                    <div class="sign-in-form">

                        <div class="form-g">
                        <label for="email">Select lecturer(s) to assign</label>
                        
                        </div>

                        
						<?php
							foreach($lecturer_array as $lect) { ?>
                            <input type='checkbox' name='selectedlecturer[]' value='<?= $lect['ID'] ?>'><?= " ". $lect['Name'] ?><br>
						<?php
							} ?>
						
                        
                        

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
                            type="submit" class="btn" name="assign_lecturer"
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