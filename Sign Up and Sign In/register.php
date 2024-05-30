<?php
session_start();
if (isset($_SESSION["loggedIn"])) {
    if ($_SESSION['user']) {
        header('Location: user_dashboard.php');
    } else if ($_SESSION['admin']) {
        header('Location: admin_dashboard.php');
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Register | RouteRover </title>

    <!-- Style Sheet -->
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <?php // include './header.php'; ?>
    <div class="signin">
        <h2>Create Account</h2>
        <form method="post">
            <div class="inputBox">
                <i class="fas fa-user" aria-hidden="true"></i>
                <input type="text" name="username" id="username" area-label="username" placeholder="Username"
                    autocomplete="username">
            </div>
            <div class="inputBox">
                <i class="fas fa-envelope" aria-hidden="true"></i>
                <input type="email" name="email" id="email" area-label="email" placeholder="Email"
                    autocomplete="email">
            </div>
            <div class="inputBox">
                <i class="fas fa-lock" aria-hidden="true"></i>
                <input type="password" name="password" id="password" area-label="password"
                    placeholder="Password" autocomplete="new-password">
            </div>
            <div class="inputBox">
                <i class="fas fa-lock" aria-hidden="true"></i>
                <input type="password" name="confirm_password" id="confirm_password" area-label="confirm_password"
                    placeholder="Confirm Password" autocomplete="new-password">
            </div>
            <div class="links">
                <p style="color: white;">Already Registered?</p> <a href="login.php">Login</a>
            </div>
            <?php require_once "./newEntry.php"; ?>
            <input type="submit" value="REGISTER" name="register">
        </form>
    </div>
    <?php // include './footer.php'; ?>
</body>

</html>