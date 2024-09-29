<?php 
include('../connection.php');

if (isset($_POST['messageType'])) {
    $messageType = $_POST['messageType'];
    $content = $_POST['content'];
    $sender  = $_POST['sender'] ? $_POST['sender'] : '';
    $receiver = $_POST['receiver'] ? $_POST['receiver'] : '';

    // Undefined Variables
    $chatId;

    // Check for existing chat - @atif
    $query = "SELECT * FROM chat WHERE (member_1 = ? AND member_2 = ?) OR (member_1 = ? AND member_2 = ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $sender, $receiver, $receiver, $sender);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) == 0) {
        $sql = "INSERT INTO chat (member_1, member_2) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $sender, $receiver);
        $stmt->execute();
    } else {
        $row = mysqli_fetch_assoc($result);
        $chatId = $row['chat_id'];
    }

    if ($messageType == 'text') {
        $stmt = $conn->prepare("INSERT INTO messages (chat_id, sender, receiver, message_content, message_type, message_timestamp) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("issss", $chatId, $sender, $receiver, $content, $messageType);

        if ($stmt->execute()) {
            // Update the last message in the chat - @atif
            $innerSQL = "UPDATE chat SET chat_last_message_C = ?, chat_last_message_T = NOW() WHERE chat_id = ?";
            $innerStmt = $conn->prepare($innerSQL);
            $innerStmt->bind_param("si", $content, $chatId);
            
            if ($innerStmt->execute()) {
                echo json_encode(array('status' => 200, 'type' => $messageType, 'content' => $content, 'sender' => $sender, 'receiver' => $receiver));
            } else {
                echo json_encode("Failed to update chat");
            }
        } else {
            echo json_encode("Failed to send message");
        }
    }
} else {
    echo json_encode("Failed to send message");
}
?>
