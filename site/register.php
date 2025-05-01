<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'estudai';
$user = 'gacussi'; // Substitua pelo seu usuário do MySQL
$password = 'Gui10davi'; // Substitua pela sua senha do MySQL

// Variável para mensagens de erro ou sucesso
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Conexão com o banco de dados
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Receber os dados do formulário
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Verificar se todos os campos foram preenchidos
        if (empty($username) || empty($email) || empty($password)) {
            $message = "Por favor, preencha todos os campos.";
        } else {
            // Criptografar a senha
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Inserir os dados no banco de dados
            $sql = "INSERT INTO usuarios (username, password, email) VALUES (:username, :password, :email)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                // Redirecionar para chat.html após o registro bem-sucedido
                header("Location: chat.html");
                exit;
            } else {
                $message = "Erro ao registrar o usuário.";
            }
        }
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            $message = "Erro: Email já cadastrado.";
        } else {
            $message = "Erro ao conectar ao banco de dados: " . $e->getMessage();
        }
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
                    <form id="login-form" action="register.php" method="POST">
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
