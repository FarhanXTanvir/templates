<?php
if (isset($_POST['login'])) {

  // trim() removes whitespace from the beginning and end of a string
  // htmlspecialchars() converts special characters to HTML entities for security
  
    $username = trim(htmlspecialchars($_POST["username"]));  // input name="username"
    $password = $_POST["password"];  // input name="password"
    
    $con = require_once './connect.php';
    $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
  if($stmt){
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;

    if ($userCount === 1) {
      $user = $result->fetch_assoc();
      if (password_verify($password, $user["password"])) {
          $_SESSION["loggedIn"] = true;
          $_SESSION["user"] = true; // user is logged in, you can do the same with admin
          // $_SESSION["admin"] = true; // admin is logged in
          $_SESSION["username"] = $username;
          
          // $output variable
          echo " 
          <div class='success'>
              Login successful, Redirecting to User Dashboard... 
          </div>";
        echo "
          <script>
              setTimeout(function(){
              window.location.href = './user_dashboard.php';
              }, 1000);
          </script>";
      } else {
          $passwordErr = "<p>Incorrect password</p>";
          return;
      }
    } else {
          $userNameErr = "<p>Incorrect username</p>";
          return;
      }
  }
} else{
  // $output variable 
  echo "
  <div class='error'>
      <i class='fa-regular fa-times'></i> Post request not received
  </div>";
}