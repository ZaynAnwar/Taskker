<?php

    session_start();

    include '../connection.php';

    $uid  = $_SESSION['UID'];
    $taskId = $_POST['taskId'];

    $sql = "INSERT INTO `applied_tasks` (`applier_id`, `task_id`, `applied_on`, `applied_status`) values ('$uid', '$taskId', now(), 'Applied') ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo json_encode(array('status' => 'success', 'taskId' => $taskId));
    } else {
        echo json_encode("Task Failed");
    }




?>