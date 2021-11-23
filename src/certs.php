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

            // Checa se o usuário ainda não fez o cadastro das informações de laboratório.
            if (!isset($_SESSION["id"])) {
                echo "<p> Antes de gerenciar seu portifólio de certificações, por favor, finalize o <a href='labs.php'> cadastro do laboratório.</a>";
            } else {
                
                echo "<p> Bem-vindo, " . $_SESSION['username'] . ".";
                
                // Popula tabela com certificações cadastradas.
                $query = $mysqli->query("SELECT Certificacao.nome AS c_nome, Material.nome AS m_nome FROM Certificacao, Material WHERE laboratorio_id = " . $_SESSION['id']);
                if ($query->num_rows > 0) {
                    
                    echo "<table><tr><th> Certificação </th><th> Material </th></tr>";
                    while ($row = $query->fetch_assoc()) {
                        echo "<tr><td>" . $row["c_nome"] . "</td><td>" . $row["m_nome"] . "</td></tr>";
                    }
                    echo "</table>";

                }

            }

        } else {
            
            echo "<p> Trabalha com emissão de certificados? <a href='join.php'> Cadastre-se </a> para divulgar seus serviços. </p>";
            echo "<p> Já tem um pefil conosco? <a href='login.php'> Faça login </a> para acessar sua conta.</p>";

        }
        ?>
    </body>
</html>