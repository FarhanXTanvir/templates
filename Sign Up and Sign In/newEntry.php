<?php
if (isset($_POST['register'])) {
	// Store the form post data into some variables
	$username = trim(htmlspecialchars($_POST["username"]));  // input name="username"
	$email = trim(htmlspecialchars($_POST['email']));
	$password = $_POST["password"];  // input name="password"
	$confirm_password = $_POST['confirm_password']; // input name="confirm_password"

	// Array for storing Form Validation errors 
	$errors = array();

	// Checking empty fields
	if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
		array_push($errors, "All fields are required");
	}
	// Validating username
	if (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
		array_push($errors, "Username can only contain letters and numbers");
	}
	// Validating email syntax
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Email is not valid");
	}
	// Validating password rules
	if (empty($password)) {
		$password_err = "Please enter a password.";
	} elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])(?!.*\s)[A-Za-z\d@#$!%*?&]{6,}$/", $password)) {
		array_push($errors, "Please enter a valid password. Must be at least 6 characters long, contain at least one uppercase letter, one lowercase letter, one digit, and one special character (@$!%*?&).");
	} else {
		// Hashing password for data security
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
	}

	//Validating Confirmation password
	if ($password !== $confirm_password) {
		array_push($errors, "Confirmation Password does not match");
	}

	$con = require_once './connect.php';
	// $sql = "SELECT * FROM users WHERE username = '$username'";
	// $result = mysqli_query($con, $sql);

	// Prepare a select statement || Object oriented style
	$sql = "SELECT * FROM users WHERE username = ?";
	$stmt = $con->prepare($sql);

	if($stmt){
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();

		// Checking if same username already exists
		// $userCount = mysqli_num_rows($result);
		$userCount = $result->num_rows;
		if ($userCount > 0) {
			array_push($errors, "Username already exists!");
		}
		// If there are any errors print them one by one
		if (count($errors) > 0) {
			//  $error contains each error message from $errors
			foreach ($errors as $error) {
				echo "
				<div class='error'>
					<span class='close'> x </span> $error
				</div>";
			}
		}
		// If there is no error then insert the data into database or add new user in DB
		else {
			// Initializing statement
			$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

			// Preparing statement for execution || Object oriented style
			$stmt = $con->prepare($sql);

			// Procedural style
			// $stmt = mysqli_prepare($con, $sql);

			if ($stmt) {
				// If statement is prepared then bind the parameters || Object oriented style
				$stmt->bind_param("sss", $username, $email, $password_hash);

				// Procedural style
				// mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);

				// Execute the statement || Object oriented style
				$stmt->execute();

				// Procedural style
				// mysqli_stmt_execute($stmt);

				echo "
				<div class='success'>
					<span class='close'> x </span> Registration Successful. You can <a href = './login.php'></a>Login now!
				</div>";
				// Close statement || Object oriented style
				$stmt->close();

				// Procedural style
				// mysqli_stmt_close($stmt);
			} else {
				die("Oops! Something went wrong. Please try again later.");
			}
		}
	}
  // Close connection || Object oriented style
	$con->close();

	// Close connection
	// mysqli_close($con);
}