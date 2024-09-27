<?php 

    session_start();
    include('../connection.php');

    $uid = $_SESSION['UID'];

    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $location = $_POST['location'];
    $cnic = $_POST['cnic'];
    $experience = $_POST['experience'];
    $notifications = $_POST['notifications'];

    $oldImage;

    
    
    $imageName = $_FILES['profileImage']['name'];
    if(!empty($imageName)){
        $imageName = $uid . '-' . time() . '-' . $imageName;
    }
    $imageTempName = $_FILES['profileImage']['tmp_name'];
    $destination = '../uploads/profiles/';
    $imagePath = $destination . $imageName;

    if(empty($imageName)){
        // No image uploaded, just update the profile
        $sql = "UPDATE `provider` SET `name` = '$name', `gender` = '$gender', `cnic` = '$cnic', `location` = '$location', `experience` = '$experience', `m_notifications` = '$notifications' WHERE `pid` = '$uid'";
        $stmt = mysqli_query($conn, $sql);
        
        if ($stmt) {
            header('Location: profile.php');
        } else {
            // Handle database error
            echo ('Database update failed: '.mysqli_error($conn));
        }
    } else {
    if(isset($_SESSION['PROFILE_IMAGE'])){
        $oldImage = $_SESSION['PROFILE_IMAGE'];
        
        
        // Delete the old image
        unlink('../uploads/profiles/'. $oldImage);
    }
    
    

    // allow only valid types of images
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['profileImage']['type'], $allowedTypes) && !empty($imageName)) {
        echo $imageName;
        echo 'Invalid image type. Only JPEG, PNG, and GIF are allowed.';
        exit;

        
    } else {
        if (move_uploaded_file($imageTempName, $imagePath)) {
            // Read the image file into binary data
            $imageBinary = file_get_contents($imagePath);
        
            // Insert image binary data into the database
            $sql = "UPDATE `provider` SET `name` = '$name', `gender` = '$gender', `cnic` = '$cnic', `location` = '$location', `experience` = '$experience', `m_notifications` = '$notifications', `image` = '$imageName' WHERE `pid` = '$uid'";
            $stmt = mysqli_query($conn, $sql);
            
            if ($stmt) {
                header('Location: profile.php');
            } else {
                // Handle database error
                echo ('Database update failed: '.mysqli_error($conn));
            }
        }else {
            echo $imageName;
            // Handle file upload error'
            echo ('Error: Unable to upload image.');
        }
        
        
    }
}


    

        

        
        
?>