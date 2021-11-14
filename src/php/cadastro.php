<?php
// Injeta página que cuida da conexão com o banco.
require_once "db_connect.php";

// Processando os dados quando o formulário é enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    alert("Teste");
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> // action chama a si mesmo com método post.
            <label>Usuário: </label>
            <input type="text" name="username">
            <label>Senha: </label>
            <input type="text" name="password">
            <label>Confirmar senha: </label>
            <input type="text" name="confirm_password">
            <input type="submit" class="clickable" value="Cadastrar">
        </form>
    </body>
</html>