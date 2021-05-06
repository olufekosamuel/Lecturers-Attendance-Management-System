<?php
    include('../db.php');
    session_start();
    $user = $_SESSION["username"];
    $role = $_SESSION["role"];
    $id = $_SESSION["id"];

    //get lectures
    $sql = "SELECT * FROM lecturer_course where lecturerid='$id'";
    $results2 = mysqli_query($db, $sql);

    // set array
    $lectures_array = array();

    // look through query
    while($row = mysqli_fetch_array($results2)){

        //foreach course lecturer owns lets get latest lectures coming up
        $courseId = $row["CoursesID"];
        

        //get lectures
        $sql = "SELECT * FROM lecture where Course_ID='$courseId' AND StartDate >= NOW()"; 
        $results3 = mysqli_query($db, $sql);
        $rest = mysqli_fetch_assoc($results3);

        $lectures_array[] = $rest;


    }



?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Lecturer Management System | Lectures</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/style.css" />
        <link rel="stylesheet" href="../assets/css/table.css" />
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
                    <h1>Upcoming Lectures</h1>
                </div>

               
                
            </div>
            <div class="table-body">
                <table>
                    <thead>
                        <tr class="top-row">
                            <th>Lecture ID</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Starting</th>
                            <th>Capacity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        
						
                        
                        <?php
							foreach($lectures_array as $lecture) { ?>
							<tr>
                            <td><?= $lecture['ID'] ?></td>
                            <td><?php echo "<a href='view_lecture_detail.php?id=".$lecture["Course_ID"]."&lecture=".$lecture['ID']."'alt='view_course_detail'>"; echo $lecture['Title']; echo "</a>"; ?></td>
                            <td><?= $lecture['Duration'] ?></td>
                            <td><?= $lecture['StartDate'] ?></td>
                            <td><?= $lecture['Capacity'] ?></td>
                            <td><?php echo "<a href='reschedule_lecture.php?id=".$lecture["Course_ID"]."&lecture=".$lecture['Course_ID']."'alt='view_course_detail'>"; echo "Reschedule"; echo "</a>"; ?><br><br>
                            <?php echo "<a href='mark_attendance.php?id=".$lecture["Course_ID"]."&lecture=".$lecture['ID']."'alt='mark_attendance'>"; echo "Mark Attendance"; echo "</a>"; ?>
                            </td>
                            </tr>
						<?php
							} ?>
                           
                           
                        
                    </tbody>
                    
                    
                    </table>
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