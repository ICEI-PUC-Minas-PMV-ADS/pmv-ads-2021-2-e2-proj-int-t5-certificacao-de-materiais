<?php

// Inicializa a sessão.
session_start();

// Limpa todas as variáveis.
$_SESSION = array();

// Destrói a sessão.
session_destroy();

// Redireciona para a página de login.
header("location: login.php");
exit;
?>