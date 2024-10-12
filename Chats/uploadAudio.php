<?php 
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['audio'])) {
        $targetDir = "../uploads/media/voices/";
        $targetFile = $targetDir . basename($_FILES['audio']['name']);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['audio']['tmp_name'], $targetFile)) {
            // Generate a unique filename for the audio file
            $audioFilename = pathinfo($targetFile, PATHINFO_FILENAME);
            $audioExtension = pathinfo($targetFile, PATHINFO_EXTENSION);
            $uniqueAudioFilename = $audioFilename . '-' . uniqid() . '.' . $audioExtension;
            rename($targetFile, $targetDir . $uniqueAudioFilename);

            // Now handle the message part
            if (isset($_POST['messageType'])) {
                $messageType = $_POST['messageType'];
                $sender = $_POST['sender'] ?? '';
                $receiver = $_POST['receiver'] ?? '';

                // Undefined Variables
                $chatId;

                $query = "SELECT * FROM chat WHERE (member_1 = '$sender' AND member_2 = '$receiver') OR (member_1 = '$receiver' AND member_2 = '$sender')";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) == 0) {
                    $sql = "INSERT INTO chat (member_1, member_2) VALUES ('$sender', '$receiver')";
                    mysqli_query($conn, $sql);
                    $chatId = mysqli_insert_id($conn); // Get the last inserted chat_id
                } else {
                    $row = mysqli_fetch_assoc($result);
                    $chatId = $row['chat_id'];
                }

                if ($messageType === 'audio') {
                    // Insert the audio message into the database
                    $audioFilePath = $targetDir . $uniqueAudioFilename;
                    $sql = "INSERT INTO messages (chat_id, sender, receiver, message_media, message_type, message_timestamp) VALUES ('$chatId', '$sender', '$receiver', '$uniqueAudioFilename', '$messageType', NOW())";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        $innerSQL = "UPDATE chat SET chat_last_message_C = '$uniqueAudioFilename', chat_last_message_T = NOW() WHERE chat_id = '$chatId'";
                        $innerResult = mysqli_query($conn, $innerSQL);

                        if ($innerResult) {
                            echo json_encode(['status' => 200, 'message' => 'File uploaded and message sent successfully.']);
                        } else {
                            echo json_encode(['status' => 500, 'message' => 'Failed to update chat']);
                        }
                    } else {
                        echo json_encode(['status' => 500, 'message' => 'Failed to send audio message']);
                    }
                }
            } else {
                echo json_encode(['status' => 400, 'message' => 'Message type is not defined']);
            }
        } else {
            // Respond with error
            echo json_encode(['status' => 500, 'message' => 'File upload failed.']);
        }
    } else {
        echo json_encode(['status' => 400, 'message' => 'No file uploaded.']);
    }
} else {
    echo json_encode(['status' => 405, 'message' => 'Method not allowed.']);
}
?>
