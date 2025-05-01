
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EstudAI - Chat</title>
    <link rel="stylesheet" href="style/chat.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="animate-title">Estud<span class="highlight">AI</span> Chat</h1>
            <nav>
                <a href="index.html">Início</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>
    <main class="main-content">
        <section class="chat-container">
            <div class="chat-sidebar">
                <h3>Usuários Conectados</h3>
                <ul id="user-list">
                    <!-- Lista de usuários conectados será preenchida dinamicamente -->
                </ul>
            </div>
            <div class="chat-main">
                <div id="chat-messages" class="chat-messages">
                    <!-- Mensagens do chat serão exibidas aqui -->
                </div>
                <form id="chat-form" class="chat-form">
                    <input type="text" id="message-input" placeholder="Digite sua mensagem..." required>
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </section>
    </main>
    <script src="js/chat.js"></script>
</body>
</html>
