<?php

    session_start();

    require ('../connection.php');

    $title = $_SESSION['T_TITLE'];
    $task_OnDate = $_SESSION['T_ONDATE'];
    $task_BeforeDate = $_SESSION['T_BEFOREDATE'];
    $task_Description = $_SESSION['T_DESCRIPTION'];
    $task_city = $_SESSION['T_CITY'];
    $task_budget = $_SESSION['T_BUDGET'];

    // User ID of current user - (Who is posting this task?)
    $uid = $_SESSION['UID'];


    $query = "INSERT INTO `tasks` (task_title, task_onDate, task_beforeDate, task_city, task_description, task_budget, task_status, task_createdOn, Creater) 
        VALUES ('$title', '$task_OnDate', '$task_BeforeDate', '$task_city', '$task_Description', '$task_budget', 'Active', now(), '$uid')";

    $result = mysqli_query($conn, $query);

    if($result){
        echo "Task created successfully";
        unset($_SESSION['T_TITLE']);
        unset($_SESSION['T_ONDATE']);
        unset($_SESSION['T_BEFOREDATE']);
        unset($_SESSION['T_DESCRIPTION']);
        unset($_SESSION['T_CITY']);
        unset($_SESSION['T_BUDGET']);

        header('location: ../Client profile/cprofile.php');
    } else {
        echo "Error: ". $query. "<br>". mysqli_error($conn);
    }



?>