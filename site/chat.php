<?php
// Incluir a lógica de verificação de sessão
require 'session_verify.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - EstudAI</title>
    <link rel="stylesheet" href="style/chat.css">
    <style>
  .header {
            position: sticky;
            top: 0;
            background-color: #6C2CC0;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .header h1 {
            font-size: 1.5rem;
            color: white;
        }

        .header nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 1rem;
        }

        .header nav a:hover {
            text-decoration: underline;
        }

        /* Fundo de partículas */
        #particleCanvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Coloca o canvas de fundo */
        }

        /* Caixa com texto */
        .text-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7); /* Fundo escuro transparente */
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            max-width: 700px;
        }

</style>

</head>
<body>
    <!-- Partículas no fundo -->
    <div id="particles-js"></div>

    <header class="header">
        <h1>Estud<span class="highlight">AI</span></h1>
        <nav>
            <a href="index.html">Início</a>
            <a href="chat.html">Chat</a>
            <a href="equipe.html">Equipe</a>
        </nav>
    </header>

    <!-- Conteúdo principal do chat -->
    <main class="chat-container">
        <section class="chat-box">
            <div class="messages" id="messages">
                <div class="message">
                    <span class="username">EstudAI:</span>
                    <span class="text">Bem-vindo ao chat!</span>
                </div>
                <div class="message">
                    <span class="username">Usuário1:</span>
                    <span class="text">Olá, tudo bem?</span>
                </div>
                <div class="message">
                    <span class="username">Usuário2:</span>
                    <span class="text">Sim, e você?</span>
                </div>
            </div>
            <form id="chat-form" class="chat-form" action="send_message.php" method="POST">
                <input type="text" id="message" name="message" placeholder="Digite sua mensagem..." required>
                <button type="submit">Enviar</button>
            </form>
        </section>
    </main>
   <script src="js/chat.js"></script>
</body>
</html>
