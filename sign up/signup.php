<?php 

  session_start();


  include '../connection.php';



  if(isset($_POST['ADD_DATA'])){
    $uname = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];
    
    if($userType == 'serviceSeeker'){

        $sql = "SELECT email FROM seeker WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) == 0){
          $query = "INSERT INTO `seeker` (`name`, `email`, `password`, `created_at`, `status`) VALUES ('$uname', '$email', '$password', now(), 'Active')";
          $result = mysqli_query($conn, $query);

          if($result) {
            header('Location: ../login/login.php');
          } else {
            echo "Error: ". $query. "<br>". mysqli_error($conn);
          }
        } else {
          echo "<script>alert('Email already exists!')</script>";
        }

        
    } else if($userType == 'serviceProvider'){

        $sql = "SELECT email FROM `provider` WHERE `email` = '$email'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) == 0){
          $query = "INSERT INTO `provider` (`name`, `email`, `password`, `created_At`) VALUES ('$uname', '$email', '$password', now())";
          $result = mysqli_query($conn, $query);

          if($result) {
            $lastId = mysqli_insert_id($conn);
            $_SESSION['TPID'] = $lastId; // Temporary Service provider id returend by database

            header('Location: ../become tasker/taskerform/tskrform.php');
          } else {
            echo "Error: ". $query. "<br>". mysqli_error($conn);
          }
 
          

        } else {
          echo "<script>alert('Email already exists!')</script>";
        }

        
    }
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <script src="https://accounts.google.com/gsi/client" async defer></script>
  <link rel="stylesheet" href="signup.css">
</head>
<body>

<div class="container">
  <h2>Sign Up</h2>
  <form id="signupForm" method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input class="email" type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div class="typee"><h4>Please enter your type</h4></div>
        <div class="radio-group">
          <label>
            <input
              type="radio"
              name="userType"
              value="serviceSeeker"
              required
            />
            Service Seeker
          </label>
          <label>
            <input
              type="radio"
              name="userType"
              value="serviceProvider"
              required
            />
            Service Provider
          </label>
        </div>
    <div class="form-group">
      <button type="submit" name="ADD_DATA">Sign Up</button>
    </div>
  </form>
  
  <div class="or-separator">
    <span>OR</span>
  </div>
  
  <div class="social-login">
  <div id="g_id_onload"
     data-client_id="YOUR_GOOGLE_CLIENT_ID"
     data-context="signup"
     data-ux_mode="popup"
     data-login_uri="https://yourdomain.com/auth/callback"
     data-auto_prompt="false">
</div>
<div class="g_id_signin"
     data-type="standard"
     data-shape="rectangular"
     data-theme="outline"
     data-text="signup_with"
     data-size="large"
     data-logo_alignment="left">
</div>
    <button class="google">Continue with Google</button>
    <button class="facebook">Continue with Facebook</button>
    <button class="apple">Continue with Apple</button>
  </div>
</div>

<!-- 
<script src="signup.js"></script>
-->

</body>
</html>
