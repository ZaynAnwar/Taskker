<?php
session_start();
include '../connection.php';

header('Content-Type: application/json');

if (!isset($_GET['sender']) || !isset($_GET['receiver']) || !isset($_GET['timeStamp'])) {
    echo json_encode(['error' => 'Invalid request']);
    exit();
}

$myID = $_GET['sender'];
$otherID = $_GET['receiver'];
$timeStamp = $_GET['timeStamp'];

// Example SQL to fetch messages since the last timestamp
$sql = "SELECT * FROM messages WHERE (sender = '$myID' AND receiver = '$otherID' OR sender = '$otherID' AND receiver = '$myID') AND message_timestamp > '$timeStamp'";
$result = mysqli_query($conn, $sql);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

// Assuming you want to return the latest timestamp from the fetched messages
$latestTimestamp = (count($messages) > 0) ? $messages[count($messages) - 1]['message_timestamp'] : $timeStamp;

echo json_encode(array(
    'Message' => $messages,
    'Timestamp' => $latestTimestamp,
));
?>
