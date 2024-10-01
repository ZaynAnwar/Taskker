<?php

    include('../../connection.php');

    $review = $_POST['review'];
    $clientId = $_POST['client'];
    $providerId = $_POST['provider'];
    $taskId = $_POST['task'];

    $query = "SELECT review_id FROM reviews WHERE review_giver = '$clientId' AND review_taker = '$providerId' AND task_id = '$taskId'";
    $run = mysqli_query($conn, $query);

    if(mysqli_num_rows($run) > 0){
        $row = mysqli_fetch_assoc($run);
        $sql = "UPDATE reviews SET reviews.review_description = '$review' WHERE review_id = '". $row['review_id']. "'";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo json_encode("review updated successfully");
        } else {
            echo json_encode("review failed");
        }
    } else {
        $sql = "INSERT INTO reviews (review_giver, review_taker, review_description, task_id, review_createdOn) VALUES ('$clientId', '$providerId', '$review', '$taskId', now())";
        $result = mysqli_query($conn, $sql);

        if($result){
            echo json_encode("review given successfully");

        } else {
            echo json_encode("review failed");
        }
    }

    

    mysqli_close($conn);


?>