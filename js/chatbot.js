document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const chatbotPopup = document.querySelector('.chatbot-popup');
    const chatToggler = document.getElementById('chatbot-toggler');
    const closeBtn = document.getElementById('close-chatbot');
    const getStartedBtn = document.getElementById('get-started-btn');
    const backBtn = document.getElementById('back-to-welcome');
    const tileBtns = document.querySelectorAll('.tile-btn');
    const tileContent = document.getElementById('tile-content');
    const chatBody = document.querySelector('.chat-body');
    const messageForm = document.querySelector('.chat-form');
    const messageInput = document.querySelector('.message-input');
    const fileInput = document.getElementById('file-input');
    const fileUploadWrapper = document.querySelector('.file-upload-wrapper');
    const fileCancelBtn = document.getElementById('file-cancel');

    let sessionId = 'skye-' + Math.random().toString(36).substring(2, 15);

    // Initialize user name from localStorage or session
    const userName = document.getElementById('user-name');
    userName.textContent = localStorage.getItem('userName') || 'Guest';

    // Event Listeners
    chatToggler.addEventListener('click', toggleChat);
    closeBtn.addEventListener('click', closeChat);
    getStartedBtn.addEventListener('click', () => setScreen('tiles'));
    backBtn.addEventListener('click', () => setScreen('welcome'));
    messageForm.addEventListener('submit', handleSubmit);
    messageInput.addEventListener('input', adjustTextarea);

    // File Upload Handling
    fileInput.addEventListener('change', handleFileSelect);
    fileCancelBtn.addEventListener('click', clearFileUpload);

    // Tile Navigation
    tileBtns.forEach(btn => {
        btn.addEventListener('click', () => handleTileClick(btn.dataset.tile));
    });

    // Functions
    function toggleChat() {
        document.body.classList.toggle('show-chatbot');
        if (document.body.classList.contains('show-chatbot')) {
            setScreen('welcome');
            messageInput.focus();
        }
    }

    function closeChat() {
        document.body.classList.remove('show-chatbot');
    }

    function setScreen(screenName) {
        chatbotPopup.setAttribute('data-screen', screenName);
        if (screenName === 'chat') {
            initializeChat();
        }
    }

    function initializeChat() {
        chatBody.innerHTML = '';
        addBotMessage('Hi! 👋 How can I assist you today?');
        addQuickOptions();
    }

    function handleTileClick(tile) {
        switch(tile) {
            case 'products':
                showProducts();
                break;
            case 'measurement':
                showMeasurementGuide();
                break;
            case 'order-status':
                showOrderStatus();
                break;
        }
    }

    async function showProducts() {
        tileContent.innerHTML = '<div class="loading">Loading products...</div>';
        try {
            const response = await fetch('../shop/products.json');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const products = await response.json();
            const topProducts = products.slice(0, 2);
            
            tileContent.innerHTML = topProducts.map(product => `
                <div class="product-card">
                    <img src="${product.image}" alt="${product.name}">
                    <h3>${product.name}</h3>
                    <p>${product.description}</p>
                    <p class="price">₱${product.price_php.toLocaleString()}</p>
                </div>
            `).join('');
        } catch (error) {
            console.error('Failed to load products:', error);
            tileContent.innerHTML = '<p>Failed to load products. Please try again later.</p>';
        }
    }

    function showMeasurementGuide() {
        tileContent.innerHTML = `
            <div class="measurement-guide">
                <h4>How to Measure Your Windows</h4>
                <p>1. Measure width at top, middle, and bottom</p>
                <p>2. Measure height at left, middle, and right</p>
                <p>3. Use the smallest measurements for inside mount</p>
                <p>4. Add 4 inches to each side for outside mount</p>
            </div>
        `;
    }

    function showOrderStatus() {
        tileContent.innerHTML = `
            <div class="order-status">
                <h4>Your Order Status</h4>
                <p>Order #12345: <span class="status-shipped">Shipped</span></p>
                <p>Order #12346: <span class="status-processing">Processing</span></p>
            </div>
        `;
    }

    function addBotMessage(text) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message bot-message';
        messageDiv.innerHTML = `<div class="message-text">${text}</div>`;
        chatBody.appendChild(messageDiv);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function addUserMessage(text) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message user-message';
        messageDiv.innerHTML = `<div class="message-text">${text}</div>`;
        chatBody.appendChild(messageDiv);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function addQuickOptions() {
        const optionsDiv = document.createElement('div');
        optionsDiv.className = 'message bot-message';
        optionsDiv.innerHTML = `
            <div class="chat-quick-options">
                <button class="quick-option" data-option="products">
                    <i class="fas fa-box"></i> View Products
                </button>
                <button class="quick-option" data-option="measure">
                    <i class="fas fa-ruler"></i> Get Measurement
                </button>
            </div>
        `;
        chatBody.appendChild(optionsDiv);
        
        // Add click handlers for quick options
        optionsDiv.querySelectorAll('.quick-option').forEach(btn => {
            btn.addEventListener('click', () => handleQuickOption(btn.dataset.option));
        });
    }

    function handleQuickOption(option) {
        switch(option) {
            case 'products':
                addUserMessage('Show me your products');
                setScreen('tiles');
                showProducts();
                break;
            case 'measure':
                addUserMessage('I need help with measurements');
                setScreen('tiles');
                showMeasurementGuide();
                break;
        }
    }

    function adjustTextarea() {
        messageInput.style.height = 'auto';
        messageInput.style.height = (messageInput.scrollHeight) + 'px';
    }

    function handleFileSelect(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            fileUploadWrapper.classList.add('file-uploaded');
            fileUploadWrapper.querySelector('img').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function clearFileUpload() {
        fileInput.value = '';
        fileUploadWrapper.classList.remove('file-uploaded');
        fileUploadWrapper.querySelector('img').src = '#';
    }

    async function handleSubmit(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        addUserMessage(message);
        messageInput.value = '';
        messageInput.style.height = 'auto';

        // Show typing indicator
        addBotMessage('<div class="thinking-indicator"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>');
        
        try {
            const response = await fetch('http://localhost:3000/message', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    message,
                    sessionId,
                    userName: userName.textContent
                })
            });

            const data = await response.json();
            
            // Remove typing indicator
            chatBody.removeChild(chatBody.lastElementChild);
            
            // Add bot response
            addBotMessage(data.reply);
            addQuickOptions();
        } catch (error) {
            // Remove typing indicator
            chatBody.removeChild(chatBody.lastElementChild);
            addBotMessage('Sorry, I\'m having trouble connecting right now. Please try again later.');
        }
    }
});

