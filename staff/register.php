<?php 


include('../db.php');
session_start();

$error = false;
$emailErr = $passwordErr = $websiteErr = "";

// REGISTER USER
if (isset($_POST['reg_user'])) {
	// receive all input values from the form
	$name = mysqli_real_escape_string($db, $_POST['name']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
	$department = mysqli_real_escape_string($db, $_POST['department']);
  
	// form validation: ensure that the form is correctly filled ...
	if (empty($email)) { $emailErr =  "Email is required"; }
	if (empty($password)) { $passwordErr = "Password is required"; }
  
	// first check the database to make sure 
	// a user does not already exist with the same username and/or email
	$user_check_query = "SELECT * FROM staff WHERE email='$email' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	
	if ($user) { // if user exists
		print_r($user);
		if ($user['email'] === $email) {
			$websiteErr = "email already exists";
		}
	}
	
	// Finally, register user if there are no errors in the form
	if ($errors == false) {
		$password = md5($password);//encrypt the password before saving in the database
	
		$query = "INSERT INTO staff (name, email, password, departmentid, role, createdat, updatedat) 
				  VALUES('$name', '$email', '$password', '$department', 2, now(), now())";
		mysqli_query($db, $query);
		$_SESSION['username'] = $username;
		header('location: login.php');
	}
	
  }

	//GET DEPARTMENTS
	$sql = "SELECT * FROM department";
	$result = mysqli_query($db, $sql);

	// set array
	$dept_array = array();


	// look through query
	while($row = mysqli_fetch_array($result)){

		// add each row returned into an array
		$dept_array[] = $row;
  
 	}


?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Lecturer Management System | Home</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/auth.css" />
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	</head>
	<body>
	<section class="main">
        <div class="login-card">
            <div class="login-items">
                <div class="logo">
                    <h1>Lecturer Attendance Management System</h1>
                </div>
                <div class="sign-in-text">
                    <p>Create a new account</p>
                </div>
				<form method="post" action="register.php">
                <div class="sign-in-form">
					<div class="form-g">
                        <label for="email">Name</label>
                        <input type="text" name="name" id="name" placeholder="John Doe" required>
                    </div>
                    <div class="form-g">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="name@email.com" required>
                    </div>
                    <div class="form-g">
                        <label for="password">Password</label>
                        <div class="password-div" id="pdiv">
                            <input type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                    </div>
					<br>
					<div class="form-g">
                        <label for="email">Department</label>
						<select name="department" id="role">
						<?php
							foreach($dept_array as $dept) { ?>
							<option value="<?= $dept['ID'] ?>"><?= $dept['Name'] ?></option>
						<?php
							} ?>
						</select>
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
						type="submit" class="btn" name="reg_user"
                        >
                            Sign Up
                        </button>
                    </div>
                </div>
				</form>
            </div>
        </div>
    </section>

	</body>
</html>