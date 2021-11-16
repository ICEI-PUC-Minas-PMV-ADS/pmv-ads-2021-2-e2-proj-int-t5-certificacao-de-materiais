<?php 

session_start();

?>

<html>
    <h1>Página de Testes de autenticação e Sessão</h1>
    <?php 
        echo "usuário: " . $_SESSION["username"] . "<br>";
        echo "id: " . $_SESSION["id"] . "<br>";
        echo "logado?: " . $_SESSION["isLogged"] . "<br>"; 
    ?>
</html>