<?php

session_start();

// Armazena página apontada no contéudo principal.
$data = '';

// Caso buscado por material ou certificação.
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty(trim($_POST["searchbar"]))) {

    $_SESSION["search"] = trim($_POST["searchbar"]);
    $data = "consulta.php";

} else {
    $data = "certs.php";
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
            <div class="form-line"><form method="post" action="index.php"><input type="text" name="searchbar" placeholder="Busque aqui por um material" title="Areia, Cimento, Aço..."><input type="submit" value="Buscar"></form></div>
        </header>
        <header class="o-avatar"></header>
        
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
