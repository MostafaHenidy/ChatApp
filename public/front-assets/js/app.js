import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Initialize Laravel Echo
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusherapp.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Chat functionality
document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const messagesList = document.getElementById('messagesList');
    const messagesContainer = document.getElementById('messagesContainer');
    const fileInput = document.getElementById('fileInput');
    const sendButton = document.getElementById('sendButton');
    const typingIndicator = document.getElementById('typingIndicator');

    if (!messageForm) return;

    let typingTimer;
    let isTyping = false;

    // Auto-scroll to bottom
    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    // Initial scroll to bottom
    scrollToBottom();

    // Handle message form submission
    messageForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(messageForm);
        const content = formData.get('content');
        const file = formData.get('file');
        
        if (!content.trim() && !file) return;

        // Disable send button
        sendButton.disabled = true;
        
        try {
            const response = await fetch('/messages', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const data = await response.json();
                
                // Add message to UI immediately for sender
                addMessageToUI(data.message, true);
                
                // Clear form
                messageInput.value = '';
                fileInput.value = '';
                
                // Scroll to bottom
                scrollToBottom();
            } else {
                console.error('Failed to send message');
            }
        } catch (error) {
            console.error('Error sending message:', error);
        } finally {
            sendButton.disabled = false;
            messageInput.focus();
        }
    });

    // Handle file selection
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            const fileName = this.files[0].name;
            messageInput.placeholder = `File selected: ${fileName}`;
        } else {
            messageInput.placeholder = 'Type a message...';
        }
    });

    // Handle typing indicator
    messageInput.addEventListener('input', function() {
        if (!isTyping) {
            isTyping = true;
            // Broadcast typing start event
        }
        
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            isTyping = false;
            // Broadcast typing stop event
        }, 1000);
    });

    // Add message to UI
    function addMessageToUI(message, isSent = false) {
        const messageElement = document.createElement('div');
        messageElement.className = `message ${isSent ? 'sent' : 'received'}`;
        messageElement.setAttribute('data-message-id', message.id);

        let avatarHtml = '';
        let senderHtml = '';
        
        if (!isSent) {
            avatarHtml = `<img src="${message.sender.avatar_url}" alt="${message.sender.name}" class="message-avatar">`;
            
            if (window.chatData.type === 'group') {
                senderHtml = `<div class="message-sender">${message.sender.name}</div>`;
            }
        }

        let contentHtml = '';
        if (message.type === 'image') {
            contentHtml = `<img src="/storage/${message.file_path}" alt="Image" class="message-image">`;
        } else if (message.type === 'file') {
            contentHtml = `
                <div class="message-file">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"></path>
                    </svg>
                    <div class="file-info">
                        <span class="file-name">${message.file_name}</span>
                        <span class="file-size">${(message.file_size / 1024).toFixed(1)} KB</span>
                    </div>
                </div>
            `;
        }
        
        if (message.content) {
            contentHtml += `<p class="message-text">${escapeHtml(message.content)}</p>`;
        }

        const time = new Date(message.created_at).toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        });

        messageElement.innerHTML = `
            ${avatarHtml}
            <div class="message-content">
                ${senderHtml}
                <div class="message-bubble">
                    ${contentHtml}
                </div>
                <div class="message-meta">
                    <span class="message-time">${time}</span>
                </div>
            </div>
        `;

        messagesList.appendChild(messageElement);
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Listen for new messages
    if (window.chatData) {
        let channelName;
        
        if (window.chatData.type === 'user') {
            channelName = `private-user.${window.authUserId}`;
        } else if (window.chatData.type === 'group') {
            channelName = `private-group.${window.chatData.id}`;
        }

        if (channelName) {
            window.Echo.private(channelName)
                .listen('MessageSent', (e) => {
                    addMessageToUI(e.message, false);
                    scrollToBottom();
                });
        }
    }

    // Handle Enter key for sending messages
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            messageForm.dispatchEvent(new Event('submit'));
        }
    });

    // Focus message input on page load
    if (messageInput) {
        messageInput.focus();
    }
});

// Update user online status
function updateOnlineStatus() {
    if (navigator.onLine) {
        // User is online
        fetch('/api/user/online', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).catch(console.error);
    }
}

// Listen for online/offline events
window.addEventListener('online', updateOnlineStatus);
window.addEventListener('offline', updateOnlineStatus);

// Update status on page load
document.addEventListener('DOMContentLoaded', updateOnlineStatus);

// Update status before page unload
window.addEventListener('beforeunload', function() {
    if (navigator.sendBeacon) {
        navigator.sendBeacon('/api/user/offline', JSON.stringify({}));
    }
});
