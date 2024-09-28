<?php 

    session_start();

    if(!$_SESSION['UID']){
        header('location: ../login/login.php');
        exit();
    }

    include '../connection.php';

    if(isset($_POST['OPEN_CHAT_P2C'])){
        $clientId = $_POST['client_id'];
        $chatType = 'P2C'; // Provider to Client
    }
    else if(isset($_POST['OPEN_CHAT_C2P'])){
        $providerId = $_POST['provider_id'];
        $chatType = 'C2P'; // Client to Provider
    }

    $data;
    $dataId;


    if($chatType == 'P2C'){
        $sql = "SELECT * FROM `seeker` WHERE `sid` = '$clientId'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $dataId = $data['sid'];
    } else if($chatType == 'C2P'){
        $sql = "SELECT * FROM `provider` WHERE `pid` = '$providerId'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $dataId = $data['pid'];
    }


    $myID = $_SESSION['UID'];
    $otherID = $dataId;







?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskker | Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="chat.css">
</head>
<body>
    <div class="chat-container">
        <!-- Chat Header -->
        <header class="chat-header">
            <div class="user-info">
                <img src="../uploads/profiles/<?php echo $data['image'] ?>" class="avatar" alt="User Avatar">
                <div class="user-details">
                    <h3><?php echo $data['name'] ?></h3>
                    <p>Online</p>
                </div>
            </div>
            <button class="back-btn">
                <i class="ri-arrow-left-line"></i> Back to Conversations
            </button>
        </header>

        <!-- Chat Messages Section -->
        <div class="chat-window" id="chatWindow">
            
        </div>

        <!-- Chat Input Section -->
        <div class="chat-input">
            <input type="text" id="messageInput" placeholder="Type your message...">
            <!-- File Input for sending images/videos -->
            <label for="mediaInput" class="file-label">
                <i class="ri-attachment-line"></i>
            </label>
            <input type="file" id="mediaInput" accept="image/*, video/*" style="display:none;">

            <!-- Button for recording voice messages -->
            <button id="recordVoiceBtn" class="voice-btn"><i class="ri-mic-line"></i></button>

            <!-- Button for sending text message -->
            <button id="sendMessageBtn"><i class="ri-send-plane-2-fill"></i></button>
        </div>
    </div>

    
    <script>
        // Set the current user's ID
        const myID = "<?php echo $myID?>";
        // Set the other user's ID
        const otherID = "<?php echo $otherID?>";
    </script>

    <script src="chat.js"></script>

</body>
</html>
