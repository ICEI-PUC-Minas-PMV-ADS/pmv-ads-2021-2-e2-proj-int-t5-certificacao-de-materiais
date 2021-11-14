<?php
// Injeta página que cuida da conexão com o banco.
require_once "db_connect.php";

// Variáveis de feedback. Armazenam text de apoio ao usuário.
$username_err = $password_err = $confirmpass_err = '';

// Processando os dados quando o formulário é enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tratamento do campo "Usuário".
    if (empty(trim($_POST["username"]))) {
        $username_err = "Usuário não pode ser vazio.";
    }

    //Tratamento do campo "Senha" e "Confirmar senha".
    if (empty(trim($_POST["password"]))) {
        $password_err = "Senha não pode ser vazia.";
    } else {
        if (empty(trim($_POST["confirm_password"]))) {
            $confirmpass_err = "Repita a senha para confirmação.";
        }
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
            <input type="text" name="username">
            <span style="color:red"><?php echo $username_err; ?></span><br>
            <label>Senha: </label>
            <input type="password" name="password">
            <span style="color:red"><?php echo $password_err; ?></span><br>
            <label>Confirmar senha: </label>
            <input type="password" name="confirm_password">
            <span style="color:red"><?php echo $confirmpass_err; ?></span><br>
            <input type="submit" class="clickable" value="Cadastrar">
        </form>
    </body>
</html>