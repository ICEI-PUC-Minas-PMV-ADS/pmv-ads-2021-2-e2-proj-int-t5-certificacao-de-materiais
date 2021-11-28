<?php 

session_start();
require_once("db_connect.php");

// Variáveis para inserção.
$material = $material_id = '';

// Em caso de edição do portifólio.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Caso de inserção de Certificação.
    if ($_POST["action"] == "Adicionar"){

        // Antes de Inserir, checa se material já existe no banco. TODO: Validação e tratamentos de entradas. Usar prepare.
        $result = $mysqli->query("SELECT id FROM Material WHERE nome = '" . $_POST["material"] . "'");
        if ($result->num_rows == 0) {
            $mysqli->query("INSERT INTO Material (nome) VALUES ('" . $_POST["material"] . "')");
            $result->free_result();
        }
        $result = $mysqli->query("SELECT id FROM Material WHERE nome = '" . $_POST["material"] . "'");
        $row = $result->fetch_assoc();
        $material_id = $row["id"];
        $result->free_result();

        // Agora material definitivamente existe. Cria certificação.
        $stmt = $mysqli->prepare("INSERT INTO Certificacao (laboratorio_id, material_id, nome) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $_SESSION["id"], $material_id, $_POST["form-nome"]);
        $stmt->execute();
        $stmt->close();

    //Caso de deleção de Certificação.
    } else {
        $mysqli->query("DELETE FROM Certificacao WHERE material_id = " . $_POST["action"]);
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/subpages.css">
        <meta charset="UTF-8">
    </head>
    <body>
        <div id="tools"><img class="clickable" src="img/mail.png" title="Enviar por e-mail"><img class="clickable" src="img/pdf.png" title="Salvar como PDF"><img class="clickable" src="img/help.png"title="Ajuda"></div>
        <div id="cert-content">
        <?php
        // Checa se o usuário já logou.
        if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"] === true) {

            // Checa se o usuário ainda não fez o cadastro das informações de laboratório.
            if (!isset($_SESSION["id"])) {
                echo "<p> Antes de gerenciar seu portifólio de certificações, por favor, finalize o <a href='labs.php'> cadastro do laboratório.</a>";
            } else {
                
                echo "<form action ='certs.php' method='post'>
                    <table><tr><th> Certificação </th><th> Material </th><th></th></tr>";
                
                // Popula tabela com certificações cadastradas.
                $result = $mysqli->query("SELECT Certificacao.material_id AS id, Certificacao.nome AS nome, Material.nome AS material FROM Certificacao JOIN Material ON Material.id = Certificacao.material_id WHERE Certificacao.laboratorio_id = " . $_SESSION["id"]);
                if ($result->num_rows > 0) {
                    
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class=''><td>" . $row["nome"] . "</td><td>" . $row["material"] . "</td><td><button class='clickable' type='submit' name='action' value='" . $row["id"] ."'>Deletar</button></td></tr>";
                    }

                } else {
                    echo "<tr><td></td><td> Ainda não há certificações cadastradas. </td><td></td></tr>";
                }

                $result->free_result();

                // Form de cadastro para adição de mais certificações.
                echo "<tr><td><input type='text' name='form-nome'></td><td><input type='text' name='material'></td><td><input type='submit' name='action' class='clickable' value='Adicionar'></td></tr>";
                echo "</table></form>";

            }

        } else {
            
            echo "<p> Trabalha com emissão de certificados? <a href='join.php'> Cadastre-se </a> para divulgar seus serviços. </p>";
            echo "<p> Caso já tenha um perfil, faça login para gerenciar suas certificações.</p>";

        }

        $mysqli->close();
        
        ?>
        </div>
    </body>
</html>