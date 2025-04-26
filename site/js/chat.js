document.addEventListener("DOMContentLoaded", () => {
    // Seletores do DOM
    const chatContainer = document.querySelector(".chat-container");
    const messageInput = document.getElementById("messageInput");
    const sendButton = document.getElementById("sendButton");

    document.addEventListener("DOMContentLoaded", () => {
    const chatContainer = document.querySelector(".chat-container");
    const messageInput = document.getElementById("messageInput");
    const sendButton = document.getElementById("sendButton");

    // Função para adicionar mensagens no chat
    const addMessage = (content, type) => {
        const message = document.createElement("div");
        message.className = `message ${type}`;
        message.textContent = content;
        chatContainer.appendChild(message);
        chatContainer.scrollTop = chatContainer.scrollHeight; // Scroll automático
    };

    // Função para enviar mensagem via AJAX
    const sendMessage = async (userMessage) => {
        try {
            const response = await fetch("php/chat.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ message: userMessage })
            });

            if (!response.ok) {
                throw new Error("Erro na conexão com o servidor");
            }

            const data = await response.json();
            if (data.response) {
                addMessage(data.response, "received");
            } else {
                addMessage("Erro: Resposta inválida do servidor.", "received");
            }
        } catch (error) {
            console.error("Erro:", error);
            addMessage("Erro: Não foi possível enviar a mensagem.", "error");
        }
    };

    // Evento de clique no botão Enviar
    sendButton.addEventListener("click", () => {
        const userMessage = messageInput.value.trim();
        if (userMessage) {
            addMessage(userMessage, "sent");
            messageInput.value = ""; // Limpar o campo de entrada
            sendMessage(userMessage); // Enviar mensagem para o servidor
        }
    });

    // Enviar mensagem ao pressionar Enter
    messageInput.addEventListener("keypress", (event) => {
        if (event.key === "Enter") {
            sendButton.click();
        }
    });
});
   
    // Animação de partículas
    const canvas = document.createElement("canvas");
    canvas.classList.add("canvas-container");
    document.body.appendChild(canvas);

    const ctx = canvas.getContext("2d");
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    window.addEventListener("resize", () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });

    const colors = ["#6C2CC0", "#6E0EEB", "#503C6B", "#39363D", "#E8E6E3"];
    const particles = [];

    class Particle {
        constructor(x, y, radius, color, velocity) {
            this.x = x;
            this.y = y;
            this.radius = radius;
            this.color = color;
            this.velocity = velocity;
            this.alpha = 1;
        }

        draw() {
            ctx.save();
            ctx.globalAlpha = this.alpha;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
            ctx.fillStyle = this.color;
            ctx.fill();
            ctx.restore();
        }

        update() {
            this.draw();
            this.x += this.velocity.x;
            this.y += this.velocity.y;
            this.alpha -= 0.003;
        }
    }

    function initParticles() {
        setInterval(() => {
            const radius = Math.random() * 5 + 2;
            const x = Math.random() * canvas.width;
            const y = Math.random() * canvas.height;
            const color = colors[Math.floor(Math.random() * colors.length)];
            const velocity = {
                x: (Math.random() - 0.5) * 2,
                y: (Math.random() - 0.5) * 2,
            };
            particles.push(new Particle(x, y, radius, color, velocity));
        }, 100);
    }

    function animateParticles() {
        requestAnimationFrame(animateParticles);
        ctx.fillStyle = "rgba(0, 0, 0, 0.1)";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        particles.forEach((particle, index) => {
            if (particle.alpha <= 0) {
                particles.splice(index, 1);
            } else {
                particle.update();
            }
        });
    }

    initParticles();
    animateParticles();
});
