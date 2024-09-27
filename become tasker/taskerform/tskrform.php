<?php 

  session_start();

  include '../../connection.php';

  if(isset($_POST['UPDATE_PROVIDER_DETAIL'])){
    $id = $_SESSION['TPID'];
    $phone = $_POST['phone'];
    $skills = $_POST['skills'];
    $bio = $_POST['bio'];
    $availability = $_POST['availability'];
    $experience = $_POST['experience'];

    $imageName = $_FILES['profileImage']['name'];
    $imageTempName = $_FILES['profileImage']['tmp_name'];
    

    $destination = '../../uploads/profiles/';
    $imagePath = $destination. $imageName;
    if(move_uploaded_file( $imageTempName, $imagePath)){
      $sql = "UPDATE `provider` SET `phone` = '$phone', `skills` = '$skills', `bio` = '$bio', `availbality` = '$availability', `experience` = '$experience', `image` = '$imagePath' WHERE `pid` = '$id'";
      $result = mysqli_query($conn, $sql);
      if($result){
        echo 'Profile updated successfully!';
        header('Location: ../../login/login.php');
      }else{
        echo 'Error: '. mysqli_error($conn);
      }
    } else {
      echo 'Error: Unable to upload image.';
    }


  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Become a Tasker</title>
<link rel="stylesheet" href="tskr.css">
</head>
<body>

<div class="container">
    <div class="main">
        <h1>Become a Tasker</h1>
    </div>
  <form id="taskerForm"  method="post" enctype="multipart/form-data">
    <div class="progress-bar">
      <div class="progress"></div>
    </div>
    <label for="phone">Phone:</label>
    <input type="tel" id="phone" name="phone" required>
    <label for="skills">Skills:</label>
    <textarea id="skills" rows="4" name="skills" required></textarea>
    <label for="bio">Bio:</label>
    <textarea id="bio" rows="4" name="bio" required></textarea>
    <label for="profileImage">Profile Image:</label>
    <input type="file" id="profileImage" name="profileImage" required>
    <label for="availability">Availability:</label>
    <select id="availability" required name="availability">
      <option value="" selected disabled>Select Availability</option>
      <option value="full-time">Full Time</option>
      <option value="part-time">Part Time</option>
      <option value="flexible">Flexible</option>
    </select>
    <label for="experience">Experience (years):</label>
    <input type="number" id="experience" name="experience" min="0" required>
    <button type="submit" name="UPDATE_PROVIDER_DETAIL">Submit</button>
  </form>
</div>

<!-- <script src="tskr.js"></script> -->

</body>
</html>
