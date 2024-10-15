const chatWindow = document.getElementById('chatWindow');
const messageInput = document.getElementById('messageInput');
const sendMessageBtn = document.getElementById('sendMessageBtn');
const mediaInput = document.getElementById('mediaInput');
const recordVoiceBtn = document.getElementById('recordVoiceBtn');
const chatList = document.getElementById('chatList');
const chatUserName = document.getElementById('chatUserName');
const chatUserAvatar = document.getElementById('chatUserAvatar');

let lastTimeStamp = '';
let chatId = '';
let mediaRecorder;
let audioChunks = [];

let otherId;
let displayedMessageIds = new Set();

let updateChatInterval;

// Function to append a message to the chat window
function appendMessage(message, type, timestamp) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', type);

    messageDiv.innerHTML = `
        <p class="message-text">${message}</p>
        <span class="message-time">${timestamp}</span>
    `;

    chatWindow.appendChild(messageDiv);
    chatWindow.scrollTop = chatWindow.scrollHeight; // Auto-scroll to the bottom
}

// Function to append media (image or video) to the chat
function appendMedia(mediaType, src, type, timestamp) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', type);

    if (mediaType === 'image') {
        messageDiv.innerHTML = `
            <img src="${src}" class="chat-media">
            <span class="message-time">${timestamp}</span>
        `;
    } else if (mediaType === 'video') {
        messageDiv.innerHTML = `
            <video controls class="chat-media">
                <source src="${src}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <span class="message-time">${timestamp}</span>
        `;
    }

    chatWindow.appendChild(messageDiv);
    chatWindow.scrollTop = chatWindow.scrollHeight;
}

// Function to append an audio message
function appendAudio(src, type, timestamp) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', type);

    messageDiv.innerHTML = `
        <audio controls class="chat-media">
            <source src="${src}" type="audio/mp3">
            Your browser does not support the audio tag.
        </audio>
        <span class="message-time">${timestamp}</span>
    `;

    chatWindow.appendChild(messageDiv);
    chatWindow.scrollTop = chatWindow.scrollHeight;
}

// Handle sending text messages
sendMessageBtn.addEventListener('click', function() {
    const message = messageInput.value.trim();
    if (message !== '') {
        sendMessage('text', message, myId, otherId);
        messageInput.value = ''; // Clear input after sending
    }
});

// Handle file input (images/videos)
mediaInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const fileType = file.type.startsWith('image') ? 'image' : 'video';
        const fileURL = URL.createObjectURL(file);

        // Create a FormData object to send the media file
        const formData = new FormData();
        formData.append('media', file);
        formData.append('mediaType', fileType);
        formData.append('sender', myId);
        formData.append('receiver', otherId);

        // Send the media file to the server using AJAX
        $.ajax({
            url: 'uploadMedia.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === 200) {
                    //appendMedia(fileType, fileURL, 'sent'); // Display the media in chat
                } else {
                    console.error('Media upload failed:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error uploading media:', error);
            }
        });
    }
    this.value = ''; // Clear file input after sending
});

// Handle voice message recording
recordVoiceBtn.addEventListener('click', function() {
    if (!mediaRecorder || mediaRecorder.state === 'inactive') {
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.start();
                audioChunks = [];

                mediaRecorder.addEventListener('dataavailable', event => {
                    audioChunks.push(event.data);
                });

                mediaRecorder.addEventListener('stop', () => {
                    const audioBlob = new Blob(audioChunks, { type: 'audio/mp3' });
                    const audioURL = URL.createObjectURL(audioBlob);

                    const formData = new FormData();
                    formData.append('messageType', 'audio');
                    formData.append('audio', audioBlob, 'voiceMessage.mp3');
                    formData.append('sender', myId);
                    formData.append('receiver', otherId);

                    // Send the audio file to the server using AJAX
                    $.ajax({
                        url: 'uploadAudio.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            response = JSON.parse(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error uploading audio:', error);
                        }
                    });
                });

                recordVoiceBtn.innerHTML = '<i class="ri-stop-circle-line"></i>'; // Change icon to indicate recording
            })
            .catch(error => {
                console.error('Error accessing microphone', error);
            });
    } else if (mediaRecorder.state === 'recording') {
        mediaRecorder.stop();
        recordVoiceBtn.innerHTML = '<i class="ri-mic-line"></i>'; // Reset icon to microphone
    }
});

// Optional: Handle sending messages when pressing Enter key
messageInput.addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        sendMessageBtn.click();
    }
});

function sendMessage(messageType, content, sender, receiver) {
    $.ajax({
        url: "sendMessage.php",
        type: "POST",
        data: { messageType: messageType, content: content, sender: sender, receiver: receiver },
        success: function(response) {
            response = JSON.parse(response);
            const { sender, receiver, content, chat } = response; // Destructure to avoid confusion

            // Only update the lastTimeStamp if the response includes it
            if (response.timestamp) {
                lastTimeStamp = response.timestamp; // Update lastTimeStamp if provided by server
            }

            console.log("Chat Id => ", chat);
            updateChat(chat); // Ensure the correct chatId is passed to updateChat
        },
        error: function(xhr, status, error) {
            console.error('Error sending message:', error);
        }
    });
}


document.querySelectorAll('#chatUserList li').forEach(chatItem => {
    chatItem.addEventListener('click', () => {
        let id = chatItem.getAttribute('data-userId');
        let name = chatItem.getAttribute('data-userName');
        let type = chatItem.getAttribute("data-acType");

        otherId = id;
        console.log("An account with id " + id + " Was just clicked And Now other id is " + otherId);
        chatWindow.innerHTML = '';
        fetchProfileDetails(id, type);
    })
})

function fetchProfileDetails(id, type){
    $.ajax({
        type: 'get',
        url: 'fetchProfileDetail.php',
        data: {id: id, type: type},
        success: (response)=> {
            //response = JSON.parse(response);
            //console.log("Response 225:1 => ", response);
            const responseObj = JSON.parse(response);
            const data = responseObj.data;
            const chatId = responseObj.chat;
            chatUserName.innerText = data.name;
            chatUserAvatar.src = "../uploads/profiles/" + data.image;
            loadInitialMessage(chatId);

        },
        error: (error)=> {
            //console.log(error)
            return error
        }
    })
}

function loadInitialMessage(chatId) {
    $.ajax({
        type: 'get',
        url: 'fetchChat.php',
        data: { id: chatId },
        success: function (response) {
            const data = JSON.parse(response);

            updateChat(data.chat_id);
            data.forEach((data) => {
                if (data.message_type == 'text') {
                    appendMessage(data.message_content, data.sender == myId ? 'sent' : 'received', formatTime(data.message_timestamp));
                } else if (data.message_type == 'video') {
                    appendMedia('video', "../uploads/media/videos/" + data.message_media, data.sender == myId ? 'sent' : 'received',  formatTime(data.message_timestamp));
                } else if (data.message_type == 'image') {
                    appendMedia('image', "../uploads/media/images/" + data.message_media, data.sender == myId ? 'sent' : 'received',  formatTime(data.message_timestamp));
                } else if (data.message_type == 'audio') {
                    appendAudio("../uploads/media/voices/" + data.message_media, data.sender == myId ? 'sent' : 'received',  formatTime(data.message_timestamp));
                }
            });

            // Clear any existing interval to avoid multiple intervals
            if (updateChatInterval) {
                clearInterval(updateChatInterval);
            }

            // Set a new interval to update the chat
            updateChatInterval = setInterval(() => updateChat(chatId), 1000);
        },
        error: function (error) {
            console.log(error);
        }
    });
}
function updateChat(chatId) {
    console.log("Updating Chat with chat id: ", chatId);

    $.ajax({
        type: 'get',
        url: 'fetchChat.php',
        data: { id: chatId },
        success: function (response) {
            let data = JSON.parse(response);
            if (!Array.isArray(data)) {
                data = [data];
            }
            //console.log("Data => ", data);
            data.forEach((data) => {
                if (data.message_id && !displayedMessageIds.has(data.message_id)) { // Check if message ID is defined and not already displayed
                    displayedMessageIds.add(data.message_id); // Add message ID to the set
                    console.log("Appending message with id: ", data.id);
                    if (data.message_type == 'text') {
                        appendMessage(data.message_content, data.sender == myId ? 'sent' : 'received',  formatTime(data.message_timestamp));
                    } else if (data.message_type == 'video') {
                        appendMedia('video', "../uploads/media/videos/" + data.message_media, data.sender == myId ? 'sent' : 'received',  formatTime(data.message_timestamp));
                    } else if (data.message_type == 'image') {
                        appendMedia('image', "../uploads/media/images/" + data.message_media, data.sender == myId ? 'sent' : 'received',  formatTime(data.message_timestamp));
                    } else if (data.message_type == 'audio') {
                        appendAudio("../uploads/media/voices/" + data.message_media, data.sender == myId ? 'sent' : 'received',  formatTime(data.message_timestamp));
                    }
                    chatWindow.scrollTop = chatWindow.scrollHeight;
                } else {
                    console.log('Message already displayed or ID is undefined (data id):', data.message_id);
                }
            });
        },
        error: function (error) {
            console.log(error);
        }
    });
}
function updateChatId(chat){
    chatId = chat;
}

function formatTime(dateString) {
    const date = new Date(dateString); // Create a Date object from the input string

    // Get the hours and minutes
    let hours = date.getHours();
    const minutes = date.getMinutes();

    // Determine AM or PM suffix
    const ampm = hours >= 12 ? 'PM' : 'AM';

    // Convert to 12-hour format
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'

    // Format minutes to be two digits
    const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;

    // Return formatted time
    return `${hours}:${formattedMinutes} ${ampm}`;
}
