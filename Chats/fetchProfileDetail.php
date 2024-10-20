<?php
include '../connection.php';

session_start();
$uid = $_SESSION['UID'];
$id = $_GET['id'];
$type = $_GET['type'];





if ($type == "Seeker") {
    $stmt = $conn->prepare("SELECT * FROM seeker WHERE sid = ?");
    $stmt->bind_param("s", $id);
} else if ($type == "Provider") {
    $stmt = $conn->prepare("SELECT * FROM provider WHERE pid = ?");
    $stmt->bind_param("s", $id);
} else {
    echo json_encode(['error' => "Invalid User Type: {$type}"], JSON_PRETTY_PRINT);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        echo json_encode(array('message' => "{$type} Found", 'data' => $row, 'chat' => getChatId($conn, $uid, $id)));
    } else {
        echo json_encode(['error' => "Invalid User: No user found"]);
    }
} else {
    echo json_encode(['error' => "Query failed: " . $stmt->error]);
}




$stmt->close();
$conn->close();

function getChatId($conn, $user1, $user2) {
    $sql = "SELECT chat_id FROM `chat` WHERE (member_1 = '$user1' AND member_2 = '$user2') OR (member_1 = '$user2' AND member_2 = '$user1')";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row['chat_id'];
    } else {
        return null; // No chat found
    }
}
?>
