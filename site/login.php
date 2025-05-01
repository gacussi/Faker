<?php
session_start(); // Iniciar a sessão

// Configuração do banco de dados
$host = 'localhost';
$dbname = 'estudai';
$user = 'gacussi';
$password = 'Gui10davi';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $message = "Por favor, preencha todos os campos.";
        } else {
            $sql = "SELECT * FROM usuarios WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Login bem-sucedido
                $_SESSION['user_id'] = $user['id']; // Armazena o ID do usuário na sessão
                $_SESSION['username'] = $user['username']; // Opcional: armazenar o nome de usuário
                header("Location: chat.html");
                exit();
            } else {
                $message = "Usuário ou senha inválidos.";
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
    <title>EstudAI - LOGIN</title>
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
                    <h2 style="text-align: center;" class="animate-title">LOGIN</h2>
                    <!-- Exibir mensagem de erro ou sucesso -->
                    <?php if (!empty($message)): ?>
                        <p style="color: red; text-align: center;"><?php echo $message; ?></p>
                    <?php endif; ?>
                    <form id="login-form" action="login.php" method="POST">
                        <label for="username" style="text-align: left;">Usuário:</label>
                        <input type="text" id="username" name="username" required>

                        <label for="password" style="text-align: left;">Senha:</label>
                        <input type="password" id="password" name="password" required>

                        <button type="submit" style="text-align: center;">Entrar</button>

                        <br>
                        <div style="text-align: center;">
                            <a href="register.php">
                                <button type="button">Cadastre-se</button>
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
