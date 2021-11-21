<?php 

session_start();
require_once("db_connect.php");

// Variáveis do texto da form.
$nome = $cnpj = $cidade = $uf = $endereco = $telefone = $cep = '';

// variáveis de feedback ao usuário.
$nome_err = $cnpj_err = $cidade_err = $uf_err = $endereco_err = $telefone_err = $cep_err = '';

if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"] === true) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // TODO: melhorar
        // Tratamento dos campos obrigatórios do formulário.
        if (empty(trim($_POST["cnpj"]))) {
            $cnpj_err = "Obrigatório informar o CNPJ.";
        } else {
            $cnpj = trim($_POST["cnpj"]);
        }

        if (empty(trim($_POST["nome"]))) {
            $nome_err = "Obrigatório informar o nome fantasia.";
        } else {
            $nome = trim($_POST["nome"]);
        }

        // Tratamento dos campos opcionais.
        ($cidade = trim($_POST["cidade"])) ? !empty(trim($_POST["cidade"])) : ($cidade = '');
        ($uf = trim($_POST["uf"])) ? !empty(trim($_POST["uf"])) : ($uf = '');
        ($endereco = trim($_POST["endereco"])) ? !empty(trim($_POST["endereco"])) : ($endereco = '');
        ($cep = trim($_POST["cep"])) ? !empty(trim($_POST["cep"])) : ($cep = '');
        ($telefone = trim($_POST["telefone"])) ? !empty(trim($_POST["telefone"])) : ($telefone = '');
        
        // Verifica se tudo está OK para inserção e insere no banco.
        if (!empty(trim($_POST["nome"])) && !empty(trim($_POST["cnpj"]))) {

            $stmt = $mysqli->prepare("INSERT INTO Laboratorio (usuario_username, nome, cnpj, uf, cidade, endereco, cep, telefone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $_SESSION["username"], $nome, $cnpj, $uf, $cidade, $endereco, $cep, $telefone);

            if ($stmt->execute()) {

                // TODO: Sucesso?
                header("location: labs.php");

            } else {
                echo "ERRO!: Falha ao inserir no banco: " . $mysqli->mysqli_error();
            }

            $stmt->close();

        }
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
        <?php
        // Checa se o usuário já logou.
        if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"] === true) {

            // Verifica se há Laboratório associado à conta.
            $stmt = $mysqli->prepare("SELECT nome, cnpj, uf, cidade, endereco, cep, telefone FROM Laboratorio WHERE usuario_username = ?");
            $stmt->bind_param('s', $_SESSION["username"]);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {

                $stmt->bind_result($nome, $cnpj, $uf, $cidade, $endereco, $cep, $telefone);
                $stmt->fetch();
                
                echo "<div class='container'><form action='labs.php' method='post'>
                    <div class='form-line'>
                        <label>CNPJ: </label>
                        <input type='text' name='cnpj' placeholder='$cnpj'></input>
                        <span style='color:red'>$cnpj_err</span>
                    </div>
                    <div class='form-line'>
                        <label>Nome Fantasia: </label>
                        <input type='text' name='nome' placeholder='$nome'></input>
                        <span style='color:red'>$nome_err</span>
                    </div>
                    <div class='form-line'>
                        <label>Estado: </label>
                        <select name='uf'>
                            <option value='--'>$uf</option>
                            <option value='AC'>AC</option><option value='AL'>AL</option><option value='AP'>AP</option><option value='AM'>AM</option>
                            <option value='BA'>BA</option><option value='CE'>CE</option><option value='DF'>DF</option><option value='ES'>ES</option>
                            <option value='GO'>GO</option><option value='MA'>MA</option><option value='MT'>MT</option><option value='MS'>MS</option>
                            <option value='MG'>MG</option><option value='PA'>PA</option><option value='PE'>PE</option><option value='PI'>PI</option>
                            <option value='RJ'>RJ</option><option value='RN'>RN</option><option value='RS'>RS</option><option value='RO'>RO</option>
                            <option value='RR'>RR</option><option value='SC'>SC</option><option value='SP'>SP</option><option value='SE'>SE</option>
                            <option value='TO'>TO</option>
                        </select>
                        <span style='color:red'>$uf_err</span>
                    </div>
                    <div class='form-line'>
                        <label>Cidade: </label>
                        <input type='text' name='cidade' placeholder='$cidade'></input>
                        <span style='color:red'>$cidade_err</span>
                    </div>
                    <div class='form-line'>
                        <label>Endereço: </label>
                        <input type='text' name='endereco' placeholder='$endereco'></input>
                        <span style='color:red'>$endereco_err</span>
                    </div>
                    <div class='form-line'>
                        <label>Telefone: </label>
                        <input type='text' name='telefone' placeholder='$telefone'></input>
                        <span style='color:red'>$telefone_err</span>
                    </div>
                    <div class='form-line'>
                        <label>CEP: </label>
                        <input type='text' name='cep' placeholder='$cep'></input>
                        <span style='color:red'>$cep_err</span>
                    </div>
                    <div class='form-line'>
                    <input id='login-btn' class='clickable' type='submit' value='SALVAR'>
                    </div>
                </form></div>"; // Fim do echo.

            } else {

                echo "<div class='container'><form action='labs.php' method='post'>
                    <div class='form-line'>
                        <label>CNPJ: </label>
                        <input type='text' name='cnpj'></input>
                        <span style='color:red'>$cnpj_err</span>
                    </div>
                    <div class='form-line'>
                        <label>Nome Fantasia: </label>
                        <input type='text' name='nome'></input>
                        <span style='color:red'>$nome_err</span>
                    </div>
                    <div class='form-line'>
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
                        <span style='color:red'>$uf_err</span>
                    </div>
                    <div class='form-line'>
                        <label>Cidade: </label>
                        <input type='text' name='cidade'></input>
                        <span style='color:red'>$cidade_err</span>
                    </div>
                    <div class='form-line'>
                        <label>Endereço: </label>
                        <input type='text' name='endereco'></input>
                        <span style='color:red'>$endereco_err</span>
                    </div>
                    <div class='form-line'>
                        <label>Telefone: </label>
                        <input type='text' name='telefone'></input>
                        <span style='color:red'>$telefone_err</span>
                    </div>
                    <div class='form-line'>
                        <label>CEP: </label>
                        <input type='text' name='cep'></input>
                        <span style='color:red'>$cep_err</span>
                    </div>
                    <div class='form-line'>
                    <input id='login-btn' class='clickable' type='submit' value='SALVAR'>
                    </div>
                </form></div>"; // Fim do echo.

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