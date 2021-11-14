<?php
// Injeta página que cuida da conexão com o banco.
require_once "db_connect.php";

// Variáveis de feedback. Armazenam text de apoio ao usuário.
$username_err, $password_err = '';

// Processando os dados quando o formulário é enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Usuário não pode ser vazio.
    if (empty(trim($_POST["username"]))) {
        $username_err = "Usuário não pode ser vazio."
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/subpages.css">
    </head>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- action chama a si mesmo com método post. -->
            <label>Usuário: </label>
            <input type="text" name="username"><span class="feedback_err"><?php echo $username_err; ?></span></br>
            <label>Senha: </label>
            <input type="text" name="password"><span class="feedback_err"><?php echo $password_err; ?></span></br>
            <label>Confirmar senha: </label>
            <input type="text" name="confirm_password"></br>
            <input type="submit" class="clickable" value="Cadastrar">
        </form>
    </body>
</html>