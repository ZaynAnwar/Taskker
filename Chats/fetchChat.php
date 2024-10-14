<?php

include '../connection.php';

$id = $_GET['id'];

$message = array();

$sql = "SELECT * FROM messages WHERE chat_id = '$id'";
$result = mysqli_query($conn, $sql);
 if (mysqli_num_rows($result) > 0) {
     while ($row = mysqli_fetch_assoc($result)) {
         $message[] = $row;
     }
     echo json_encode($message);

 } else {
     echo json_encode("No chat found with this id");
 }