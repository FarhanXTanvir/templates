<?php
session_start(); // For storing Session variables

if (isset($_SESSION["loggedIn"])) {
    if ($_SESSION['user']) {
        header('Location: user_dashboard.php');
    } else if ($_SESSION['admin']) {
        header('Location: admin_dashboard.php');
    }
} 
// Start output buffering
ob_start();
// Include the file
require_once "./authentication.php";

// Get the output and clean the buffer
$output = ob_get_clean();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Login </title>

    <!-- Style Sheet -->
    <link rel="stylesheet" href="./style/login.css">
</head>

<body>
    <?php // include './header.php'; ?> 
        <div class="signin">
            <h2>LOGIN</h2>
            <form method="post">
                <div class="inputBox">
                    <input type="text" name="username" id="username" area-label="username" placeholder="Username" autocomplete="username">
                    <?php
                    if (isset($userNameErr)) {
                        echo $userNameErr;
                    } 
                    ?>
                </div>
                <div class="inputBox">
                    <input type="password" name="password" id="password" area-label="password" placeholder="Password" autocomplete="current-password">
                    <?php
                    if (isset($passwordErr)) {
                        echo $passwordErr;
                    } ?>
                </div>
                <div class="links">
                    <a href="#">Forgot Password</a> <a href="register">Register</a>
                </div>
                <?php
                    // Display the output: Login Succesfull or Login Failed
                    echo $output;
                ?>
                <input type="submit" value="Login" name="login">
            </form>
        </div>
    <!-- ----------------- Footer Section --------------- -->
    <?php // include './footer.php'; ?>
</body>

</html>