<?php

session_start();

// Armazena página apontada no contéudo principal.
$data = '';

// Variáveis usadas para login.
$login_err = '';

// Página chamada por ação do usuário.
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {

    // Chamado pela barra de pesquisa.
    if ($_POST["action"] == "Buscar") {
        if (!empty(trim($_POST["searchbar"]))) {

            $_SESSION["search"] = trim($_POST["searchbar"]);
            $data = "consulta.php";
    
        } else {$data = "certs.php";}
    }
    
    // Chamado pelo botão de logar.
    if ($_POST["action"] == "Cadastrar") {

        $_SESSION["informed_username"] = trim($_POST["user-field"]);
        $_SESSION["informed_password"] = trim($_POST["pass-field"]);
        $data = "join.php";

    } 
    
    // Chamado pelo botão de logar.
    if ($_POST["action"] == "Logar") {

        // Validações
        if (empty(trim($_POST["user-field"])) || empty(trim($_POST["pass-field"]))) {
            $login_err = "Campos vazios";
        } else {

            $_SESSION["informed_username"] = trim($_POST["user-field"]);
            $_SESSION["informed_password"] = trim($_POST["pass-field"]);
            
        }
    }

} else {$data = "certs.php";}

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
        <header class="o-login">
            <form action="index.php" method="post">
                <ul class="wrapper">
                    <li class="form-row">
                        <input type="text" name="user-field" placeholder="Usuário">
                    </li>
                    <li class="form-row">
                        <input type="password" name="pass-field" placeholder="Senha">
                    </li>
                    <li class="form-row">
                        <input type="submit" name="action" value="Logar"><input type="submit" name="action" value="Cadastrar">
                    </li>
                    <li class="form-row">
                        <span style="color:red"><?php echo $login_err ?></span>
                    </li>
                <ul>
            </form>
        </header>
        
        <div class="o-menu">
            <div class="o-con clickable" id="loadCerts"><p></p>CERTIFICAÇÕES&nbsp • </div>
            <div class="o-labs clickable" id="loadLabs"><p></p>LABORATÓRIOS&nbsp&nbsp • </div>
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
