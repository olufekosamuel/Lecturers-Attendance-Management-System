<?php

	include('../db.php');
	session_start();

	$error = "";
	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password = mysqli_real_escape_string($db, $_POST['password']);
	
		if (empty($email)) {
			$error = "Email is required";
		}
		if (empty($password)) {
			$error = "Password is required";
		}
	
		if ($error == "") {
			$password = md5($password);
			$query = "SELECT * FROM staff WHERE email='$email' AND password='$password'";
			$results = mysqli_query($db, $query);
			if (mysqli_num_rows($results) == 1) {
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			echo "successvul";
			header('location: ../index.php');
			}else {
				$error = "Your Login Email or Password is invalid";
			}
		}
	}



?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('../errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="email" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>

	<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>