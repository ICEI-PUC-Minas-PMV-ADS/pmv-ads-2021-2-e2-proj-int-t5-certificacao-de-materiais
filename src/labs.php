<?php 

session_start();

// Checa se o usuário já logou.
if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"] === true) {
    
    echo "<p> Bem vindo, " . $_SESSION["username"] . "<p>";
} else {
    
    echo "<p> Trabalha com emissão de certificados? <a href='cadastro.php'> Cadastre-se </a> para divulgar seus serviços. </p>";
    echo "<p> Já tem um pefil conosco? <a href='login.php'> Faça login </a> para acessar sua conta.</p>";
}

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/subpages.css">
        <meta charset="UTF-8">
    </head>
    <body>
        <!-- -->
    </body>
</html>