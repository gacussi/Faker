// Exemplo de script para funcionalidades básicas de chat
document.addEventListener('DOMContentLoaded', () => {
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const userList = document.getElementById('user-list');

    // Usuários conectados (simulação)
    const users = ['João', 'Maria', 'Carlos'];
    users.forEach(user => {
        const li = document.createElement('li');
        li.textContent = user;
        userList.appendChild(li);
    });

    // Enviar mensagem
    chatForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (message) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message', 'user');
            messageDiv.textContent = message;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll para a última mensagem
            messageInput.value = '';
        }
    });

    // Simulação de mensagem recebida
    setTimeout(() => {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', 'other');
        messageDiv.textContent = 'Bem-vindo ao chat!';
        chatMessages.appendChild(messageDiv);
    }, 1000);
});
