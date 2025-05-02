<?php
session_start(); // Iniciar a sessão para autenticação

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
        $login = trim($_POST['login']); // Pode ser e-mail ou nome de usuário
        $password = trim($_POST['password']);

        // Verificar se todos os campos foram preenchidos
        if (empty($login) || empty($password)) {
            $message = "Por favor, preencha todos os campos.";
        } else {
            // Buscar o usuário no banco de dados (pelo nome de usuário ou e-mail)
            $sql = "SELECT * FROM usuarios WHERE email = :login OR username = :login";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                echo "Usuário encontrado: " . $user['username'] . "<br>"; // Depuração
                // Verificar a senha
                if (password_verify($password, $user['password'])) {
                    echo "Senha verificada! <br>"; // Depuração

                    // Gerar token de autenticação
                    $token = bin2hex(random_bytes(16));
                    $_SESSION['auth_token'] = $token;
                    $_SESSION['username'] = $user['username'];

                    // Redirecionar para chat.php
                    header("Location: chat.php?token=$token");
                    exit;
                } else {
                    echo "Senha incorreta."; // Depuração
                }
            } else {
                echo "Usuário ou e-mail não encontrado."; // Depuração
            }
        }
    } catch (PDOException $e) {
        echo "Erro ao conectar ao banco de dados: " . $e->getMessage(); // Depuração
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EstudAI - Login</title>
    <link rel="stylesheet" href="style/form.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="animate-title">Estud<span class="highlight">AI</span></h1>
            <nav>
                <a href="index.html">Início</a>
                <a href="equipe.html">Equipe</a>
            </nav>
        </div>
    </header>
    <br><br><br>
    <main class="main-content">
        <section class="hero">
            <div class="container">
                <div class="transparent-box">
                    <h2 style="text-align: center;" class="animate-title">LOGIN</h2>
                    <!-- Exibir mensagem de erro ou sucesso -->
                    <?php if (!empty($message)): ?>
                        <p style="color: red; text-align: center;"><?php echo $message; ?></p>
                    <?php endif; ?>
                    <form id="login-form" action="login.php" method="POST">
                        <label for="login" style="text-align: left;">E-mail ou Usuário:</label>
                        <input type="text" id="login" name="login" required>

                        <label for="password" style="text-align: left;">Senha:</label>
                        <input type="password" id="password" name="password" required>

                        <button type="submit" style="text-align: center;">Entrar</button>

                        <br>
                        <div style="text-align: center;">
                            <a href="register.php">
                                <button type="button">Registrar-se</button>
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
