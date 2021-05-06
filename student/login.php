<?php

	include('../db.php');
	session_start();

	$error = false;
	$emailErr = $passwordErr = $websiteErr = "";
	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password = mysqli_real_escape_string($db, $_POST['password']);
	
		if (empty($email)) {
			$emailErr = "Email is required";
			$error = true;
		}
		if (empty($password)) {
			$passwordErr = "Password is required";
			$error = true;
		}
	
		if ($error == false) {
			$password = md5($password);
			$query = "SELECT * FROM student WHERE email='$email' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				foreach($results as $res){
					$_SESSION['name'] = $res["Name"];
					$_SESSION['email'] = $res["Email"];
					$_SESSION['dept'] = $res["DepartmentID"];
					$_SESSION['id'] = $res["ID"];
				}
				header('location: index.php');
			}else {
				$error = true;
				$websiteErr = "Your Login Email or Password is invalid";
			}
		}
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
					<p>Student Platform</p>
                    <p>Sign In to your account</p>
                </div>
				<form method="post" action="login.php">
					<div class="sign-in-form">
						<div class="form-g">
							<label for="email">Your Email</label>
							<input type="email" name="email" id="email" placeholder="name@email.com" v-model="email" required>
						</div>
						<div class="form-g">
							<label for="password">Password</label>
							<div class="password-div" id="pdiv">
								<input type="password" name="password" id="password" placeholder="Password" v-model="password" required>
							
							</div>
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
							<button type="submit" class="btn" name="login_user"
							>
								Sign In
							</button>
						</div>
					</div>
				</form>
            </div>
        </div>
    </section>

	</body>
</html>