<?php 

    session_start();
    include('../connection.php');

    $uid = $_SESSION['UID'];

    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $notifications = $_POST['notifications'];

    

    $sql = "UPDATE `seeker` SET `name` = '$name', `email` = '$email', `gender` = '$gender', `m_notifications` = '$notifications' WHERE `sid` = '$uid'";
    $result = mysqli_query($conn, $sql);


    if ($result) {
        echo json_encode(['success' => 'Profile updated successfully.']);
    } else {
        echo json_encode(['error' => 'Database update failed: ' . mysqli_error($conn)]);
    }
    
?>