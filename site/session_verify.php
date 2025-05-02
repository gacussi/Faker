<?php
session_start();

// Verifica se o token de autenticação está configurado na sessão
if (!isset($_SESSION['auth_token']) || empty($_SESSION['auth_token'])) {
    // Redirecionar para login.php
    header("Location: login.php");
    exit;
}
?>
