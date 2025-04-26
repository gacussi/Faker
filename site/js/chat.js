document.addEventListener("DOMContentLoaded", () => {
    const chatContainer = document.querySelector(".chat-container");
    const messageInput = document.getElementById("messageInput");
    const sendButton = document.getElementById("sendButton");

    const addMessage = (content, type) => {
        const message = document.createElement("div");
        message.className = `message ${type} border`;
        message.textContent = content;
        chatContainer.appendChild(message);
        chatContainer.scrollTop = chatContainer.scrollHeight; // Rolar para a última mensagem
    };

    sendButton.addEventListener("click", () => {
        const userMessage = messageInput.value.trim();
        if (userMessage) {
            addMessage(userMessage, "sent");
            messageInput.value = "";

            // Simular resposta automática
            setTimeout(() => {
                addMessage("Esta é uma resposta automática.", "received");
            }, 1000);
        }
    });

    messageInput.addEventListener("keypress", (event) => {
        if (event.key === "Enter") {
            sendButton.click();
        }
    });
});
