<?php

    include('../../connection.php');

    $rating = $_POST['rating'];
    $clientId = $_POST['client'];
    $providerId = $_POST['provider'];
    $taskId = $_POST['task'];

    $query = "SELECT rating_id FROM rating WHERE rating_giver = '$clientId' AND rating_taker = '$providerId' AND task_id = '$taskId'";
    $run = mysqli_query($conn, $query);

    if(mysqli_num_rows($run) > 0){
        $row = mysqli_fetch_assoc($run);
        $sql = "UPDATE rating SET rating.rating = '$rating' WHERE rating_id = '". $row['rating_id']. "'";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo json_encode("Rating updated successfully");
        } else {
            echo json_encode("Rating failed");
        }
    } else {
        $sql = "INSERT INTO rating (rating_giver, rating_taker, rating, task_id, rating_createdOn) VALUES ('$clientId', '$providerId', '$rating', '$taskId', now())";
        $result = mysqli_query($conn, $sql);

        if($result){
            echo json_encode("Rating given successfully");

        } else {
            echo json_encode("Rating failed");
        }
    }

    

    mysqli_close($conn);


?>