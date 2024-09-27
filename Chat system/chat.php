<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskker | Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="chat.css">
</head>
<body>
    <div class="chat-container">
        <!-- Chat Header -->
        <header class="chat-header">
            <div class="user-info">
                <img src="user-avatar.jpg" class="avatar" alt="User Avatar">
                <div class="user-details">
                    <h3>John Robert</h3>
                    <p>Online</p>
                </div>
            </div>
            <button class="back-btn">
                <i class="ri-arrow-left-line"></i> Back to Conversations
            </button>
        </header>

        <!-- Chat Messages Section -->
        <div class="chat-window" id="chatWindow">
            <div class="message received">
                <p class="message-text">Hi, can we schedule the task for tomorrow?</p>
                <span class="message-time">10:30 AM</span>
            </div>
            <div class="message sent">
                <p class="message-text">Yes, that works for me. What time?</p>
                <span class="message-time">10:32 AM</span>
            </div>
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

    <script src="chat.js"></script>
</body>
</html>