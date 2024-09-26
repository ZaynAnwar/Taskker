<?php 

    session_start();

    require('../connection.php');

    if(isset($_POST['Login'])){
      $email = $_POST['email'];
      $password = $_POST['password'];
      $type = $_POST['userType'];

      if($type == 'serviceProvider'){
          $sql = "SELECT * FROM `provider` WHERE `email` = '$email' AND `password` = '$password'";
          $result = mysqli_query($conn, $sql);

          if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['UID'] = $row['pid'];
            $_SESSION['A_TYPE'] = 'Provider';
            //header('Location:../home/home.php');
          } else {
            echo "<script>alert('Invalid credentials!')</script>";
          }
      } else if ($type == 'serviceSeeker'){
          $sql = "SELECT * FROM `seeker` WHERE `email` = '$email' AND `password` = '$password'";
          $result = mysqli_query($conn, $sql);

          if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['UID'] = $row['sid'];
            $_SESSION['A_TYPE'] = 'Seeker';
            header('Location: ../Client profile/cprofile.php');
          } else {
            echo "<script>alert('Invalid credentials!')</script>";
          }


      } else {
        echo ("<script>alert('Invalid user type')</script>");
        exit();
      }
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="/login/login.css" />
  </head>
  <body>
    <div class="container">
      <h2>Login</h2>
      <form id="loginForm" action="login.php" method="post">
        <div class="form-group">
          <label for="username">Email:</label>
          <input type="email" id="username" name="email" required />
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required />
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
          <button type="submit" name="Login">Login</button>
        </div>
      </form>

      <div class="or-separator">
        <span>OR</span>
      </div>

      <div class="signup-section">
        <h3>Don't have an account? Sign up with</h3>
        <div class="social-login">
          <button class="google">Continue with Google</button>
          <button class="facebook">Continue with Facebook</button>
          <button class="apple">Continue with Apple</button>
        </div>
        <p>Or <a href="../sign up/signup.php">create an account</a> manually.</p>
      </div>
    </div>

    <script src="/sign up/signup.js"></script>
  </body>
</html>
