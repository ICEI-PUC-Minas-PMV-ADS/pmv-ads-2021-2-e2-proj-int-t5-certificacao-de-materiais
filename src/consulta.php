<?php

session_start();

require_once("db_connect.php");

// Variáveis.
$cer_nome = $mat_nome = $lab_nome = $lab_cnpj = $lab_uf = $lab_cidade = $lab_end = $lab_cep = $lab_tel = '';


if (isset($_SESSION["search"])) {

    $stmt = $mysqli->prepare("SELECT
        Certificacao.nome AS cer_nome,
        Material.nome AS mat_nome,
        Laboratorio.cnpj AS lab_cnpj,
        Laboratorio.nome AS lab_nome,
        Laboratorio.uf AS lab_uf,
        Laboratorio.cidade AS lab_cidade,
        Laboratorio.endereco AS lab_end,
        Laboratorio.cep AS lab_cep,
        Laboratorio.telefone AS lab_tel
        FROM Certificacao
        JOIN Laboratorio ON Laboratorio.id = Certificacao.laboratorio_id
        JOIN Material ON Material.id = Certificacao.material_id
        WHERE Material.nome = ?");
    $stmt->bind_param("s", $_SESSION["search"]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cer_nome, $mat_nome, $lab_nome, $lab_cnpj, $lab_uf, $lab_cidade, $lab_end, $lab_cep, $lab_tel);
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

            echo "<table><tr><th>Certificação</th><th>Material</th><th>Laboratório</th><th>CNPJ</th><th>UF</th><th>Cidade</th><th>Endereço</th><th>CEP</th><th>Telefone</th></tr>";
            while ($stmt->fetch()) {
                echo "<tr><td>" . $cer_nome . "</td><td>" . $mat_nome . "</td><td>" . $lab_nome . "</td><td>" . $lab_cnpj . "</td><td>" . $lab_uf . "</td><td>" . $lab_cidade . "</td><td>" . $lab_end . "</td><td>" . $lab_cep . "</td><td>" . $lab_tel .  "</td></tr>";
            }
            echo "</table>";

            $stmt->close();
            $mysqli->close();
        ?>
    </body>
</html>