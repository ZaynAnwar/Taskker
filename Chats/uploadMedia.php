<?php 

    include('../connection.php');

    if(isset($_POST['mediaType'])){
        $messageType = $_POST['mediaType'];
        $sender  = $_POST['sender'] ? $_POST['sender'] : '';
        $receiver = $_POST['receiver']? $_POST['receiver'] : '';

        // Undefined Variables
        $chatId;

        // Check if a chat exists between the sender and receiver
        $query = "SELECT * FROM chat WHERE (member_1 = '$sender' AND member_2 = '$receiver') OR (member_1 = '$receiver' AND member_2 = '$sender')";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) == 0){
            // If no chat exists, create a new one
            $sql = "INSERT INTO chat (member_1, member_2) VALUES ('$sender', '$receiver')";
            mysqli_query($conn, $sql);
            $chatId = mysqli_insert_id($conn); // Get the ID of the new chat
        } else {
            $row = mysqli_fetch_assoc($result);
            $chatId = $row['chat_id']; // Get the existing chat ID
        }

        // Handle media message (image or video)
        if($messageType == 'image' || $messageType == 'video'){
            $media = $_FILES['media']['name']; // File name
            $targetDir;
            if($messageType == 'image') {
                $targetDir = "../uploads/media/images/"; // Directory to upload the image
            } else if($messageType == 'video'){
                $targetDir = "../uploads/media/videos/"; // Directory to upload the video
            }
            $targetFile = $targetDir . basename($media);
            
            // Move the uploaded file to the target directory
            if(move_uploaded_file($_FILES['media']['tmp_name'], $targetFile)){
                // Insert the media message into the database
                $sql = "INSERT INTO messages (chat_id, sender, receiver, message_media, message_type, message_timestamp) 
                        VALUES ('$chatId', '$sender', '$receiver', '$media', '$messageType', now())";
                $result = mysqli_query($conn, $sql);

                if($result) {
                    // Update the chat with the last message
                    $innerSQL = "UPDATE chat SET chat_last_message_C = '$messageType', chat_last_message_T = now() WHERE chat_id = '$chatId'";
                    $innerReslt = mysqli_query($conn, $innerSQL);

                    if($innerReslt){
                        echo json_encode(array('status' => 200, 'type' => $messageType, 'media' => $media, 'sender' => $sender, 'receiver' => $receiver));
                    } else {
                        echo json_encode("Failed to update chat with last message". mysqli_error($conn));
                    }
                    
                } else {
                    echo json_encode("Failed to send media: ". mysqli_error($conn));
                }
            } else {
                echo json_encode("Failed to upload media");
            }
        }
        
    } else {
        echo json_encode("Failed to send media");
    }

?>
