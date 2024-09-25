// Sample message data
const chatWindow = document.getElementById('chatWindow');
const messageInput = document.getElementById('messageInput');
const sendMessageBtn = document.getElementById('sendMessageBtn');

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

// Handle sending messages
sendMessageBtn.addEventListener('click', function() {
    const message = messageInput.value.trim();
    if (message !== '') {
        appendMessage(message, 'sent');
        messageInput.value = ''; // Clear input after sending
    }
});

// Optional: Handle sending messages when pressing Enter key
messageInput.addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        sendMessageBtn.click();
    }
});
