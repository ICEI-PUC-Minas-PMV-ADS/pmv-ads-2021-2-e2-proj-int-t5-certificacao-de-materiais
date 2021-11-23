<?php

session_start();

// Variáveis para 

if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"] === true) {

} else {

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
        <header class="o-header">
            <img src="img/logo.png">
            <div id="avatar">
                <?php
                    if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"] === true) {
                        echo "<p> <a href='index.php'>Sair</a></p>";
                    } else {
                        echo "<p> <a href='index.php'>Logar</a></p>";
                    }
                ?> 
                </div>
        </header>
        
        <div class="o-menu">
            <div class="o-con clickable" id="loadCons"><p></p>CERTIFICAÇÕES&nbsp • </div>
            <div class="o-labs clickable" id="loadLabs"><p></p>LABORATÓRIOS&nbsp&nbsp • </div>
            <div class="o-news clickable" id="loadNews"><p></p>NOTÍCIAS&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp • </div>
            <div class="o-about clickable" id="loadAbout"><p></p>SOBRE&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp • </div>   
            <div class="o-empty"></div>        
       </div>

        <main class="o-main">
            <div>
                <object id="content" type="text/html" data="consulta.html"></object>
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
