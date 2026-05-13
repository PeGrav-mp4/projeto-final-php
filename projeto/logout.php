<?php
// =============================================
// Arquivo: logout.php
// Função: Encerrar a sessão do usuário e redirecionar para o login
// =============================================

session_start();      // Inicia a sessão atual para poder destruí-la
session_destroy();    // Apaga todos os dados da sessão ($_SESSION)

header("Location: login.php"); // Redireciona para a tela de login
exit;
?>