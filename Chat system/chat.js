const chatWindow = document.getElementById('chatWindow');
const messageInput = document.getElementById('messageInput');
const sendMessageBtn = document.getElementById('sendMessageBtn');
const mediaInput = document.getElementById('mediaInput');
const recordVoiceBtn = document.getElementById('recordVoiceBtn');

let lastTimeStamp = ''; 
let mediaRecorder;
let audioChunks = [];

// Function to append a message to the chat window
function appendMessage(message, type, timeStamp) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', type);
    messageDiv.innerHTML = `
        <p class="message-text">${message}</p>
        <span class="message-time">${timeStamp}</span>
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
            <a href='${src}'><img src="${src}" class="chat-media" alt="${src}"></a>
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
    chatWindow.scrollTop = chatWindow.scrollHeight; // Auto-scroll to the bottom
}

// Function to append an audio message
function appendAudio(src, type, timeStamp) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', type);
    messageDiv.innerHTML = `
        <audio controls class="chat-media">
            <source src="${src}" type="audio/mp3">
            Your browser does not support the audio tag.
        </audio>
        <span class="message-time">${timeStamp}</span>
    `;
    chatWindow.appendChild(messageDiv);
    chatWindow.scrollTop = chatWindow.scrollHeight; // Auto-scroll to the bottom
}

// Handle sending text messages
sendMessageBtn.addEventListener('click', function() {
    const message = messageInput.value.trim();
    if (message !== '') {
        sendMessage('text', message, myID, otherID);
        messageInput.value = ''; // Clear input after sending
    }
});

// Handle file input (images/videos)
mediaInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const fileType = file.type.startsWith('image') ? 'image' : 'video';
        const fileURL = URL.createObjectURL(file);
        // Optionally, send the media file to the server as well

        // Create a FormData object to send the media file
        const formData = new FormData();
        formData.append('media', file);  // Append the file
        formData.append('mediaType', fileType); // Indicate whether it's an image or video
        formData.append('sender', myID);  // Append the sender's ID
        formData.append('receiver', otherID);  // Append the receiver's ID

        // Send the media file to the server using AJAX
        $.ajax({
            url: 'uploadMedia.php', // Your server-side script for handling the upload
            type: 'POST',
            data: formData,
            contentType: false, // Required for FormData
            processData: false, // Required for FormData
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === 200) {
                    // Optionally, you can update the chat with the server-side URL or other data
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
                    formData.append('messageType', 'audio'); // Indicate that it's an audio message
                    formData.append('audio', audioBlob, 'voiceMessage.mp3'); // Append the audio blob
                    formData.append('sender', myID); // Append the sender's ID
                    formData.append('receiver', otherID); // Append the receiver's ID

                    // Send the audio file to the server using AJAX
                    $.ajax({
                        url: 'uploadAudio.php', // Your server-side script for handling the upload
                        type: 'POST',
                        data: formData,
                        contentType: false, // Required for FormData
                        processData: false, // Required for FormData
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.status === 200) {

                            } else {
                                console.error('Audio upload failed:', response.message);
                            }
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
            const { sender, receiver, content } = response; // Destructure to avoid confusion - @atif

            // Only update the lastTimeStamp if the response includes it - @atif
            if (response.timestamp) {
                lastTimeStamp = response.timestamp; // Update lastTimeStamp if provided by server - @atif
            }
            
            updateChat(sender, receiver, lastTimeStamp);
            //appendMessage(content, sender === myID ? 'sent' : 'received');
        },
        error: function(xhr, status, error) {
            console.error('Error sending message:', error);
        }
    });
}

let displayedMessageIds = new Set();

function updateChat(sender, receiver, lastTimeStamp) {
    console.log('Atif');

    $.ajax({
        url: 'updateChat.php',
        type: 'GET',
        data: { timeStamp: lastTimeStamp, sender: sender, receiver: receiver },
        success: function(response) {
            // Ensure response is an object
            if (response && typeof response === 'object') {
                const messages = response.Message; // Get the messages - @atif
                const latestTimestamp = response.Timestamp; // Get the latest timestamp - @atif

                messages.forEach(message => {

                    
                    // Only append the message if it has not been displayed yet - @atif
                    if (!displayedMessageIds.has(message.message_id)) {
                        if (message.message_type === 'image' || message.message_type === 'video') {
                            if(message.message_status === 'deleted'){
                                appendMessage('<i> This media was deleted </i>', message.sender === myID ? 'sent' : 'received', formatTime(message.message_timestamp))
                            } else {
                                appendMedia(message.message_type, `../uploads/media/${message.message_type}s/${message.message_media}`, message.sender === myID ? 'sent' : 'received', formatTime(message.message_timestamp));
                            }
                        } else if(message.message_type === 'audio') {
                            appendAudio(`../uploads/media/voices/${message.message_media}`, message.sender === myID ? 'sent' : 'received', formatTime(message.message_timestamp));
                        } 
                        else {
                            console.log('sender',message.sender);
                            appendMessage(message.message_content, message.sender === myID ? 'sent' : 'received', formatTime(message.message_timestamp));
                        }
                        displayedMessageIds.add(message.message_id); // Add the message ID to the set - @atif
                        chatWindow.scrollTop = chatWindow.scrollHeight; // Auto-scroll to the bottom - @atif
                    }
                });

                // Update the last timestamp to the latest one received
                lastTimeStamp = latestTimestamp; // Adjust as needed for your database schema
            } else {
                console.error("Unexpected response format:", response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating chat:', error);
        }
    });
}

// Load initial messages
function loadInitialMessages() {
    $.ajax({
        url: 'updateChat.php',
        type: 'GET',
        data: { timeStamp: lastTimeStamp, sender: myID, receiver: otherID },
        success: function(response) {
            response = JSON.parse(response);
            if (response.Message.length > 0) {
                // Update lastTimeStamp with the timestamp of the last message received
                lastTimeStamp = response.Message[response.Message.length - 1].message_timestamp; // Adjust as per your database schema
                response.Message.forEach(message => {
                    let img = document.createElement('img');
                        img.src = `../uploads/media/images/imagesProfile-Image(test-image).jfif`;
                        chatWindow.appendChild(img);
                    if (message.message_type === 'image' || message.message_type === 'video') {
                        //appendMedia(message.message_type, `../uploads/media/images/imagesProfile-Image(test-image).jfif`, message.sender === myID ? 'sent' : 'received');
                    } else {
                        appendMessage(message.message_content, message.sender === myID ? 'sent' : 'received', formatTime(message.message_timestamp));
                    }
                    
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading messages:', error);
        }
    });

    // Scroll to the latest message
    chatWindow.scrollTop = chatWindow.scrollHeight;

    // Use a function reference for setInterval
    setInterval(() => updateChat(myID, otherID, lastTimeStamp), 1000);
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


// Call loadInitialMessages when the script runs
loadInitialMessages();
