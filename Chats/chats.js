const chatWindow = document.getElementById('chatWindow');
const messageInput = document.getElementById('messageInput');
const sendMessageBtn = document.getElementById('sendMessageBtn');
const mediaInput = document.getElementById('mediaInput');
const recordVoiceBtn = document.getElementById('recordVoiceBtn');
const chatList = document.getElementById('chatList');
const chatUserName = document.getElementById('chatUserName');

let mediaRecorder;
let audioChunks = [];

// Function to append a message to the chat window
function appendMessage(message, type) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', type);

    messageDiv.innerHTML = `
        <p class="message-text">${message}</p>
        <span class="message-time">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
    `;

    chatWindow.appendChild(messageDiv);
    chatWindow.scrollTop = chatWindow.scrollHeight; // Auto-scroll to the bottom
}

// Function to append media (image or video) to the chat
function appendMedia(mediaType, src, type) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', type);

    if (mediaType === 'image') {
        messageDiv.innerHTML = `
            <img src="${src}" class="chat-media">
            <span class="message-time">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
        `;
    } else if (mediaType === 'video') {
        messageDiv.innerHTML = `
            <video controls class="chat-media">
                <source src="${src}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <span class="message-time">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
        `;
    }

    chatWindow.appendChild(messageDiv);
    chatWindow.scrollTop = chatWindow.scrollHeight; // Auto-scroll to the bottom
}

// Function to append an audio message
function appendAudio(src, type) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', type);

    messageDiv.innerHTML = `
        <audio controls class="chat-media">
            <source src="${src}" type="audio/mp3">
            Your browser does not support the audio tag.
        </audio>
        <span class="message-time">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
    `;

    chatWindow.appendChild(messageDiv);
    chatWindow.scrollTop = chatWindow.scrollHeight; // Auto-scroll to the bottom
}

// Handle sending text messages
sendMessageBtn.addEventListener('click', function() {
    const message = messageInput.value.trim();
    if (message !== '') {
        appendMessage(message, 'sent');
        messageInput.value = ''; // Clear input after sending
    }
});

// Handle file input (images/videos)
mediaInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const fileType = file.type.startsWith('image') ? 'image' : 'video';
        const fileURL = URL.createObjectURL(file);
        appendMedia(fileType, fileURL, 'sent');
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
                    appendAudio(audioURL, 'sent');
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

// Handle switching chats from chat list
chatList.addEventListener('click', function(event) {
    const chatId = event.target.getAttribute('data-chat-id');
    const chatUser = event.target.textContent;

    if (chatId && chatUser) {
        chatUserName.textContent = chatUser;
        chatWindow.innerHTML = ''; // Clear chat window when switching chats
        appendMessage(`You have switched to a chat with ${chatUser}.`, 'received');
    }


});

// Scripts added by @Atif
