<?php
    include('../db.php');
    session_start();

    if (!isset($_SESSION["username"])){
        header('location: login.php');
    }
    $user = $_SESSION["username"];
    $role = $_SESSION["role"];
    $id = $_SESSION["id"];
    $deptid = $_SESSION['dept'];

    if ($role != 1){//meaning not an administrator
        //GET LECTURE COURSE
        $sql = "SELECT * FROM lecturer_course where lecturerid='$id'";
        $result = mysqli_query($db, $sql);

        // set array
        $courses_array = array();

        // look through query
        while($row = mysqli_fetch_array($result)){

            // add each row returned into an array
            $course_id = $row["ID"];
            $user_check_query = "SELECT * FROM course WHERE id='$course_id'";
            $results = mysqli_query($db, $user_check_query);
            $course_data = mysqli_fetch_assoc($results);
            $course_dept_id = $course_data["Department_ID"];

            $dept_check_query = "SELECT * FROM department WHERE id='$course_dept_id'";
            $results1 = mysqli_query($db, $dept_check_query);
            $dept = mysqli_fetch_assoc($results1);
            $course_data["Department_ID"] = $dept["Name"];
            $courses_array[] = $course_data;

        }
    }else{//administrator
        // set array
        $courses_array = array();

        $user_check_query = "SELECT * FROM course WHERE department_id='$deptid'";
        $results = mysqli_query($db, $user_check_query);
        

        $dept_check_query = "SELECT * FROM department WHERE id='$deptid'";
        $results1 = mysqli_query($db, $dept_check_query);
        $dept = mysqli_fetch_assoc($results1);

        // look through query
        while($row = mysqli_fetch_array($results)){
            $row["Department_ID"] = $dept["Name"];
            $courses_array[] = $row;
        }
        
    }
    

    

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Lecturer Management System | Courses</title>
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
                    <p><?php if($role==1){ echo "All Courses";}else{ echo "My Courses"; }?></p>
                </div>
                
            </div>
            <div class="table-body">
                <table>
                    <thead>
                        <tr class="top-row">
                            <th>Course ID</th>
                            <th>Title</th>
                            <th>Department</th>
                            <th>Created</th>
                            <th>Updated</th>

                            <?php if ($role==1): ?>
                                <th>Actions</th> 
                            <?php endif; ?>
                            
                        </tr>
                    </thead>
                    
                    <tbody>
                        
						
                        
                        <?php
							foreach($courses_array as $course) {  echo "<a href='view_course_detail.php?id=".$course["ID"]."' alt='view_course_detail'>"?>
                            
							<tr>
                            <td><?= $course['ID'] ?></td>
                            <td><?php echo "<a href='view_course_detail.php?id=".$course["ID"]."' alt='view_course_detail'>"; echo $course['Title']; echo "</a>"; ?></td>
                            <td><?= $course['Department_ID'] ?></td>
                            <td><?= $course['CreatedAt'] ?></td>
                            <td><?= $course['UpdatedAt'] ?></td>
                            <?php if ($role==1): ?>
                                <td><?php echo "<a href='assign_lecturers.php?id=".$course["ID"]."'alt='view_course_detail'>"; echo "Assign"; echo "</a>"; ?></td>
                            <?php endif; ?>
                            </tr>
                            
						<?php
							echo "</a>";} ?>
                           
                           
                        
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