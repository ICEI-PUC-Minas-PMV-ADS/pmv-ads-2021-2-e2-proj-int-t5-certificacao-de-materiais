<?php 

session_start();
require_once("db_connect.php");

// Em caso de edição do portifólio.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "DELETE FROM Certificacao WHERE material_id = " . $_POST["delete"]; TODO: deletar
    $mysqli->query("DELETE FROM Certificacao WHERE material_id = " . $_POST["delete"]);

}

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
                $query = $mysqli->query("SELECT Certificacao.material_id AS id, Certificacao.nome AS nome, Material.nome AS material FROM Certificacao JOIN Material ON Material.id = Certificacao.material_id WHERE Certificacao.laboratorio_id = " . $_SESSION["id"]);
                if ($query->num_rows > 0) {
                    
                    echo "
                    <form action ='certs.php' method='post'>
                        <table><tr><th> Certificação </th><th> Material </th><th> DELETAR </th></tr>";
                    while ($row = $query->fetch_assoc()) {
                        echo "<tr><td>" . $row["nome"] . "</td><td>" . $row["material"] . "</td><td><input class='clickable btn del-btn' type='submit' name='delete' value='" . $row["id"] ."'></td></tr>";
                    }
                    echo "
                        </table>
                    </form>";

                }

            }

        } else {
            
            echo "<p> Trabalha com emissão de certificados? <a href='join.php'> Cadastre-se </a> para divulgar seus serviços. </p>";
            echo "<p> Já tem um pefil conosco? <a href='login.php'> Faça login </a> para acessar sua conta.</p>";

        }

        $mysqli->close();
        
        ?>
    </body>
</html>