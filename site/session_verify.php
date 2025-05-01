<?php
session_start(); // Iniciar a sessão

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Redirecionar para a página de login se não estiver logado
    header("Location: login.php");
    exit();
}
?>
