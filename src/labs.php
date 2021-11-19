<?php 

session_start();
require_once("db_connect.php");

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/subpages.css">
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
        // Checa se o usuário já logou.
        if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"] === true) {

            echo "<p> Bem vindo, " . htmlspecialchars($_SESSION["username"]) . ".</p>";
            echo "<p> <a href='logout.php'>Sair</a></p>";

            // Verifica se há Laboratório associado à conta.
            $stmt = $mysqli->prepare("SELECT id FROM Laboratorio WHERE usuario_username = ?");
            $stmt->bind_param('s', $_SESSION["username"]);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                
                // TODO: Há laboratório cadastrado ao login. Direcionar direto para as certificações?

            } else {

                // TODO: Finalizar cadastro com informações de endereço. Página nova?
                
            }

            $stmt->close();
            $mysqli->close();

        } else {
            
            echo "<p> Trabalha com emissão de certificados? <a href='join.php'> Cadastre-se </a> para divulgar seus serviços. </p>";
            echo "<p> Já tem um pefil conosco? <a href='login.php'> Faça login </a> para acessar sua conta.</p>";

        }
        ?>
    </body>
</html>