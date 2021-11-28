<?php

session_start();

// Injeta código de conexão ao banco.
require_once("db_connect.php");

// Armazena página apontada no contéudo principal.
$data = "labs.php";

// Variáveis usadas para login.
$username = $id = $password = $login_err = '';

// Página chamada por ação do usuário.
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {

    // Chamado pela barra de pesquisa.
    if ($_POST["action"] == "Buscar") {
        if (!empty(trim($_POST["searchbar"]))) {

            $_SESSION["search"] = trim($_POST["searchbar"]);
            $data = "consulta.php";
    
        }
    }
    
    // Chamado pelo botão de Cadastrar.
    if ($_POST["action"] == "Cadastrar") {

        $_SESSION["informed_username"] = trim($_POST["user-field"]);
        $_SESSION["informed_password"] = trim($_POST["pass-field"]);
        $data = "join.php";

    } 
    
    // Chamado pelo botão de logar.
    if ($_POST["action"] == "Logar") {

        // Validação Básica
        if (empty(trim($_POST["user-field"])) || empty(trim($_POST["pass-field"]))) {
            $login_err = "Preencha os campos";
        } else {

            $username = trim($_POST["user-field"]);
            $password = trim($_POST["pass-field"]);

            $stmt = $mysqli->prepare("SELECT username, password FROM Usuario WHERE username = ?");
            $stmt->bind_param('s', $username);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {

                    // Usuário existe no banco.
                    $stmt->bind_result($username, $stored_password);
                    $stmt->fetch();

                    // Valida password.
                    if ($password === $stored_password) {

                        // Validado; cria sessão.
                        session_start();
                        $_SESSION["isLogged"] = true;
                        $_SESSION["username"] = $username;

                        // Checa se já cadastrou informações do laboratório.
                        $stmt = $mysqli->prepare("SELECT id FROM Laboratorio WHERE usuario_username = ?");
                        $stmt->bind_param('s', $_SESSION["username"]);
                        $stmt->execute(); // TODO: checar sucesso.
                        $stmt->store_result();

                        if ($stmt->num_rows == 1) {

                            $stmt->bind_result($id);
                            $stmt->fetch();
                            $_SESSION["id"] = $id;  // Vincula id do LAB à sessão.
                            $data = "certs.php";    // Já fez cadastro do laboratório; desejo mais provável é gerir certificações.                               

                        } else {
                            $data = "labs.php";     // Tem que terminar cadastro do laboratório.
                        }

                    } else {
                        $login_err = "Credenciais inválidas";
                    }
                }
            } else {
                echo "ERRO!: falha ao consultar o banco. " . $mysqli->mysqli_error();
            }
    
            $stmt->close();
            $mysqli->close();

        }
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/index.css">
        <script src="script/jquery-3.6.0.min.js"></script>
        <script src="script/index.js"></script>
        <meta charset="UTF-8">
    </head>
    <body>
        <header class="o-logo"><img src="img/logo.png"></header>
        <header class="o-search">
            <div class="form-line"><form method="post" action="index.php"><input type="text" name="searchbar" placeholder="Busque aqui por um material" title="Areia, Cimento, Aço..."><input type="submit" name="action" value="Buscar"></form></div>
        </header>
        <header class='o-login'>
        <?php
        if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"] === true) {
            echo "<ul class='wrapper'><li>Bem-vindo, " . $_SESSION["username"] . "</li><li><a href='logout.php'> Fazer LogOff </a></li></ul>";
        } else {
            echo "
                <form action='index.php' method='post'>
                    <ul class='wrapper'>
                        <li class='form-row'>
                            <input type='text' name='user-field' placeholder='Usuário' pattern='[A-Za-z0-9]+' title='Somente letras e números' max='20' required>
                        </li>
                        <li class='form-row'>
                            <input type='password' name='pass-field' placeholder='Senha' title='Entre 6 a 20 caracteres' min='6' max='20' required>
                        </li>
                        <li class='form-row'>
                            <input type='submit' name='action' value='Logar'><input type='submit' name='action' value='Cadastrar'>
                        </li>
                        <li class='form-row'>
                            <span style='color:red'>" . $login_err . "</span>
                        </li>
                    <ul>
                </form>";
        }
        ?>
        </header>
        
        <div class="o-menu">
            <div class="o-con clickable" id="loadCerts"><p></p>CERTIFICAÇÕES&nbsp • </div>
            <div class="o-labs clickable" id="loadLabs"><p></p>CADASTRO&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp • </div>
            <div class="o-news clickable" id="loadNews"><p></p>NOTÍCIAS&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp • </div>
            <div class="o-about clickable" id="loadAbout"><p></p>SOBRE&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp • </div>   
            <div class="o-empty"></div>        
       </div>

        <main class="o-main">
            <div>
                <?php echo "<object id='content' type='text/html' data=" . $data . "></object>";?>
            </div>
        </main>

        <footer class="o-footer">
            <p>&nbsp</p>
            <p>Projeto de Software do Curso de Análise e Desenvolvimento de Sistemas</p>
            <p>PUC Minas - 2º Semestre de 2021</p>
            <p><a href="mailto:renan.gsouza@protonmail.com">Grupo 3 - Turma 5</a></p>
        </footer>
    </body>
</html>
