<?php
  session_start();
  if(!isset($_SESSION['admin'])){
    header('location: ./login.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
</head>
<body>
  <p>Welcome <?php echo $_SESSION['username']; ?></p>
</body>
</html>