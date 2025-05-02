<?php
session_start(); // Iniciar a sessão para armazenar o token de autenticação

// Configuração do banco de dados
$host = 'localhost';
$dbname = 'estudai';
$user = 'gacussi'; 
$password = 'Gui10davi'; 

// Variável para mensagens de erro ou sucesso
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Conexão com o banco de dados
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Receber os dados do formulário
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Verificar se todos os campos foram preenchidos
        if (empty($username) || empty($email) || empty($password)) {
            $message = "Por favor, preencha todos os campos.";
        } else {
            // Verificar se o e-mail ou o nome de usuário já existem
            $sqlCheck = "SELECT COUNT(*) FROM usuarios WHERE email = :email OR username = :username";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->bindParam(':email', $email);
            $stmtCheck->bindParam(':username', $username);
            $stmtCheck->execute();
            $count = $stmtCheck->fetchColumn();

            if ($count > 0) {
                $message = "Erro: Nome de usuário ou e-mail já cadastrados.";
            } else {
                // Criptografar a senha
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Inserir os dados no banco de dados
                $sqlInsert = "INSERT INTO usuarios (username, password, email) VALUES (:username, :password, :email)";
                $stmtInsert = $pdo->prepare($sqlInsert);
                $stmtInsert->bindParam(':username', $username);
                $stmtInsert->bindParam(':password', $hashedPassword);
                $stmtInsert->bindParam(':email', $email);

                if ($stmtInsert->execute()) {
                    // Gerar token de autenticação
                    $token = bin2hex(random_bytes(16));
                    $_SESSION['auth_token'] = $token;
                    $_SESSION['username'] = $username;

                    // Redirecionar para chat.php
                    header("Location: chat.php?token=$token");
                    exit;
                } else {
                    $message = "Erro ao registrar o usuário.";
                }
            }
        }
    } catch (PDOException $e) {
        $message = "Erro ao conectar ao banco de dados: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EstudAI - REGISTRO</title>
    <link rel="stylesheet" href="style/form.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="animate-title">Estud<span class="highlight">AI</span></h1>
            <nav>
                <a href="index.html">Inicio</a>
                <a href="equipe.html">Equipe</a>
            </nav>
        </div>
    </header>
    <br>
    <br>
    <br>
    <main class="main-content">
        <section class="hero">
            <div class="container">
                <div class="transparent-box">
                    <h2 style="text-align: center;" class="animate-title">REGISTRO</h2>
                    <!-- Exibir mensagem de erro ou sucesso -->
                    <?php if (!empty($message)): ?>
                        <p style="color: red; text-align: center;"><?php echo $message; ?></p>
                    <?php endif; ?>
                    <form id="register-form" action="register.php" method="POST">
                        <label for="username" style="text-align: left;">Usuário:</label>
                        <input type="text" id="username" name="username" required>

                        <label for="email" style="text-align: left;">Email:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="password" style="text-align: left;">Senha:</label>
                        <input type="password" id="password" name="password" required>

                        <button type="submit" style="text-align: center;">Registrar</button>

                        <br>
                        <div style="text-align: center;">
                            <a href="login.php">
                                <button type="button">Já tenho uma conta</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script src="js/form.js"></script>
</body>
</html>
