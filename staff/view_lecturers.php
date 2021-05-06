<?php
    include('../db.php');
    session_start();
    $user = $_SESSION["username"];
    $role = $_SESSION["role"];
    $id = $_SESSION["id"];


    $course_id = $_GET['id'];

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

    //get lecturers
    $sql = "SELECT * FROM lecturer_course where coursesid='$course_id'";
    $results2 = mysqli_query($db, $sql);

    // set array
    $lecturers_array = array();

    // look through query
    while($row = mysqli_fetch_array($results2)){

        $lecturer_id = $row["LecturerID"];
        //get lecturer details
        $sql = "SELECT * FROM staff where id='$lecturer_id'";
        $result = mysqli_query($db, $sql);
        $lect_data = mysqli_fetch_assoc($result);

        $lecturers_array[] = $lect_data;


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
                    <p><?php echo $course_data['Title'] ?> Lecturer(s)</p>
                </div>
                
            </div>
            <div class="table-body">
                <table>
                    <thead>
                        <tr class="top-row">
                            <th>Lecturer ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created</th>
                            <th>Updated</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        
						
                        
                        <?php
							foreach($lecturers_array as $lecture) { ?>
							<tr>
                            <td><?= $lecture['ID'] ?></td>
                            <td><?= $lecture['Name'] ?></td>
                            <td><?= $lecture['Email'] ?></td>
                            <td><?= $lecture['CreatedAt'] ?></td>
                            <td><?= $lecture['UpdatedAt'] ?></td>
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