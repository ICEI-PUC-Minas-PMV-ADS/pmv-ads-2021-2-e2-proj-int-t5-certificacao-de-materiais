<?php 

session_start();
require_once("db_connect.php");

// Variáveis do formulário.
$nome = $cnpj = $cidade = $uf = $endereco = $telefone = $cep = '';
$nome_err = $cnpj_err = $cidade_err = $endereco_err = $telefone_err = $cep_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Já validados na submissão.
    $cnpj = trim($_POST["cnpj"]);
    $nome = trim($_POST["nome"]);

    // Tratamento dos campos opcionais.
    if (empty(trim($_POST["cidade"]))) {
        $cidade = "Não Informado";
    } else {$cidade = substr(trim($_POST["cidade"]), 0, 30);}

    ($uf = trim($_POST["uf"])) ? !empty(trim($_POST["uf"])) : ($uf = '');

    if (empty(trim($_POST["endereco"]))) {
        $endereco = "Não Informado";
    } else {$endereco = substr(trim($_POST["endereco"]), 0, 100);}

    if (empty(trim($_POST["cep"]))) {
        $cep = "Não Informado";
    } else {$cep = substr(trim($_POST["cep"]), 0, 14);}

    if (empty(trim($_POST["telefone"]))) {
        $telefone = "Não Informado";
    } else {$telefone = substr(trim($_POST["telefone"]), 0, 100);}

    
    // Verifica se tudo está OK para inserção no banco.
    if (!empty(trim($_POST["nome"])) && !empty(trim($_POST["cnpj"]))) {

        // Edita ou cadastra, dependendo se id está setado.
        if (!isset($_SESSION["id"])) {
            
            $stmt = $mysqli->prepare("INSERT INTO Laboratorio (usuario_username, nome, cnpj, uf, cidade, endereco, cep, telefone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $_SESSION["username"], $nome, $cnpj, $uf, $cidade, $endereco, $cep, $telefone);
        
        } else {

            $stmt = $mysqli->prepare("UPDATE Laboratorio SET nome = ?, cnpj = ?, uf = ?, cidade = ?, endereco = ?, cep = ?, telefone = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $nome, $cnpj, $uf, $cidade, $endereco, $cep, $telefone, $_SESSION["id"]);
        }

        if ($stmt->execute()) {

            // TODO: Sucesso?
            header("location: labs.php");

        } else {
            echo "ERRO!: " . $mysqli->error;
        }

        $stmt->close();

    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/subpages.css">
        <script src="script/jquery-3.6.0.min.js"></script>
        <script src="script/subpages.js"></script>
        <meta charset="UTF-8">
    </head>
    <body>
        <div id="tools"><img class="clickable" src="img/mail.png" title="Enviar por e-mail"><img class="clickable" src="img/pdf.png" title="Salvar como PDF"><img class="clickable" src="img/help.png"title="Ajuda"></div>
        <div id="content">
        <?php

        // Checa se o usuário já logou.
        if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"] === true) {

            // Verifica se há Laboratório associado à conta.
            $stmt = $mysqli->prepare("SELECT id, nome, cnpj, uf, cidade, endereco, cep, telefone FROM Laboratorio WHERE usuario_username = ?");
            $stmt->bind_param('s', $_SESSION["username"]);
            $stmt->execute(); // TODO: checar sucesso.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {

                $stmt->bind_result($id, $nome, $cnpj, $uf, $cidade, $endereco, $cep, $telefone);
                $stmt->fetch();

                // Associa a variável de ID do laboratório à sessão. Importante.
                $_SESSION["id"] = $id;
                
                echo "
                <form action='labs.php' method='post'>
                <ul class='wrapper'>
                    <li class='form-row'>
                        <label>CNPJ: </label>
                        <input type='text' name='cnpj' value='$cnpj' pattern='[0-9]{14}' title='14 digitos' required>
                    </li>
                    <li class='form-row'>
                        <label>Nome Fantasia: </label>
                        <input type='text' name='nome' value='$nome' min='1' max='30' required>
                    </li>
                    <li class='form-row'>
                        <label>Estado: </label>
                        <select name='uf'>
                            <option value='$uf'>$uf</option>
                            <option value='AC'>AC</option><option value='AL'>AL</option><option value='AP'>AP</option><option value='AM'>AM</option>
                            <option value='BA'>BA</option><option value='CE'>CE</option><option value='DF'>DF</option><option value='ES'>ES</option>
                            <option value='GO'>GO</option><option value='MA'>MA</option><option value='MT'>MT</option><option value='MS'>MS</option>
                            <option value='MG'>MG</option><option value='PA'>PA</option><option value='PE'>PE</option><option value='PI'>PI</option>
                            <option value='RJ'>RJ</option><option value='RN'>RN</option><option value='RS'>RS</option><option value='RO'>RO</option>
                            <option value='RR'>RR</option><option value='SC'>SC</option><option value='SP'>SP</option><option value='SE'>SE</option>
                            <option value='TO'>TO</option>
                        </select>
                    </li>
                    <li class='form-row'>
                        <label>Cidade: </label>
                        <input type='text' name='cidade' value='$cidade'>
                    </li>
                    <li class='form-row'>
                        <label>Endereço: </label>
                        <input type='text' name='endereco' value='$endereco'>
                    </li>
                    <li class='form-row'>
                        <label>Contato: </label>
                        <input type='text' name='telefone' value='$telefone' title='0 a 18 dígitos'>
                    </li>
                    <li class='form-row'>
                        <label>CEP: </label>
                        <input type='text' name='cep' value='$cep' title='14 digitos'>
                    </li>
                    <li class='form-row'>
                        <input class='clickable btn save-btn' type='submit' value='SALVAR'>
                    </li>
                </ul>
                </form>"; // Fim do echo.

            } else {

                echo "
                <form action='labs.php' method='post'>
                <ul class='wrapper'>
                    <li class='form-row'>
                        <label>CNPJ: </label>
                        <input type='text' name='cnpj' pattern='[0-9]{14}' title='14 digitos' required>
                    </li>
                    <li class='form-row'>
                        <label>Nome Fantasia: </label>
                        <input type='text' name='nome' min='1' max='30' required>
                    </li>
                    <li class='form-row'>
                        <label>Estado: </label>
                        <select name='uf'>
                            <option value='--'>--</option>
                            <option value='AC'>AC</option><option value='AL'>AL</option><option value='AP'>AP</option><option value='AM'>AM</option>
                            <option value='BA'>BA</option><option value='CE'>CE</option><option value='DF'>DF</option><option value='ES'>ES</option>
                            <option value='GO'>GO</option><option value='MA'>MA</option><option value='MT'>MT</option><option value='MS'>MS</option>
                            <option value='MG'>MG</option><option value='PA'>PA</option><option value='PE'>PE</option><option value='PI'>PI</option>
                            <option value='RJ'>RJ</option><option value='RN'>RN</option><option value='RS'>RS</option><option value='RO'>RO</option>
                            <option value='RR'>RR</option><option value='SC'>SC</option><option value='SP'>SP</option><option value='SE'>SE</option>
                            <option value='TO'>TO</option>
                        </select>
                    </li>
                    <li class='form-row'>
                        <label>Cidade: </label>
                        <input type='text' name='cidade'>
                    </li>
                    <li class='form-row'>
                        <label>Endereço: </label>
                        <input type='text' name='endereco'>
                    </li>
                    <li class='form-row'>
                        <label>Contato: </label>
                        <input type='text' name='telefone' title='0 a 18 dígitos'>
                    </li>
                    <li class='form-row'>
                        <label>CEP: </label>
                        <input type='text' name='cep' title='8 dígitos'>
                    </li>
                    <li class='form-row'>
                        <input class='clickable btn save-btn' type='submit' value='SALVAR'>
                    </li>
                </ul>
                </form>"; // Fim do echo.

            }

            $stmt->close();
            $mysqli->close();

        } else {
            
            echo "<p> Trabalha com emissão de certificados? <a href='join.php'> Cadastre-se </a> para divulgar seus serviços. </p>";
            echo "<p> Caso já tenha um perfil, faça login para gerenciar sua conta.</p>";

        }
        ?>
        </div>
    </body>
</html>