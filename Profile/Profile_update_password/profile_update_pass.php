<?php 

  session_start();

  include '../../connection.php';


  $uid = $_SESSION['UID'];

  if(isset($_POST['UPDATE_PASS'])){
    $pass = $_POST['new-password'];

    $sql = "UPDATE `provider` SET `password` = '$pass' WHERE `pid` = '$uid' ";
    $stmt = mysqli_query($conn, $sql);

    if($stmt){
      echo "<script>alert('Password updated successfully!')</script>";
      header("location: ../profile.php");
    } else {
      echo "<script>alert('Password update failed!')</script>";
    }

  }


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Change Password</title>
    <link rel="stylesheet" href="profile_update_pass.css" />
  </head>
  <body>
    <div class="change-password-container">
      <div class="change-password-box">
        <h1>Update Password</h1>
        <p>Please enter your new password.</p>

        <form id="change-password-form" method="post">
          <div class="pass-in">
            <div class="pass-up">
              <label for="new-password">New Password</label>
              <input
                type="password"
                id="new-password"
                name="new-password"
                required
                placeholder="Enter new password"
              />
            </div>

            <div class="pass-up">
              <label for="confirm-password">Confirm Password</label>
              <input
                type="password"
                id="confirm-password"
                name="confirm-password"
                required
                placeholder="Confirm new password"
              />
            </div>
          </div>
          <button type="submit" name="UPDATE_PASS" class="change-password-btn">
            Update Password
          </button>
        </form>

        <div class="back-to-login">
          <a href="../profile.php">← Back to profile</a>
        </div>
      </div>
    </div>

    <script src="Profile_update_pass.js"></script>
  </body>
</html>
