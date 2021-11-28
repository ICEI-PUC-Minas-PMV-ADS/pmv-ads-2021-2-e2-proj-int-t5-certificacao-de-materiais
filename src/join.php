<?php

session_start();

// Injeta página que cuida da conexão com o banco.
require_once "db_connect.php";

// Variáveis de feedback. Armazenam texto de apoio ao usuário.
$username_err = $password_err = $confirmpass_err = '';

// Variáveis para montagem da query.
$username = $password = '';

// Caso usuário já tenha informado valores de usuário e senha.
$informed_password = $informed_user = '';
if (isset($_SESSION["informed_password"])) {$informed_password = $_SESSION["informed_password"];}
if (isset($_SESSION["informed_username"])) {$informed_user = $_SESSION["informed_username"];}

// Processando os dados quando o formulário é enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Evita que os campos do formulário sejam preenchidos com dados antigos caso o usuário mude de ideia.
    $informed_password = $informed_user = '';

    // Tratamento do campo "Usuário".
    if (empty(trim($_POST["username"]))) {
        $username_err = "Usuário não pode ser vazio.";
    } elseif (!preg_match("/^[a-zA-Z0-9]+$/", trim($_POST["username"]))) {
        $username_err = "Utilize letras, números, '.' ou '_'";
    } else {

        // Checa se usuário existe no banco.
        $stmt = $mysqli->prepare("SELECT username FROM Usuario WHERE username = ?");
        $stmt->bind_param('s', $username);
        $username = trim($_POST["username"]);
        
        if ($stmt->execute()) {

            $stmt->store_result();
            if ($stmt->num_rows == 1) {$username_err = "Nome de usuário já em uso.";}
            
        } else {echo "ERRO!: falha ao consultar no banco.";}
        
        $stmt->close();

    }

    //Tratamento do campo "Senha" e "Confirmar senha".
    if (empty(trim($_POST["password"]))) {
        $password_err = "Senha não pode ser vazia.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "6 a 20 caracteres."; // TODO: obsoleto?
    } else {

        if (empty(trim($_POST["confirm_password"]))) {
            $confirmpass_err = "Confirme a senha.";
        } elseif (trim($_POST["password"]) != trim($_POST["confirm_password"])){
            $confirmpass_err = "Valores informados estão diferentes.";
        } else {
            $password = trim($_POST["password"]);
        }
    }

    // Checa se tudo está aceitável para registrar novo usuário e registra.
    if (!empty($username) && !empty($password) && empty($username_err)) {
        $stmt = $mysqli->prepare("INSERT INTO Usuario (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            
            $_SESSION["isLogged"] = true;
            $_SESSION["username"] = $username;
            echo "<script>window.parent.location.href = 'index.php'; </script>";

        } else {
            echo "ERRO!: falha ao inserir no banco.";
        }

        $stmt->close();
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
        <div id="tools"><img class="clickable" src="img/mail.png" title="Enviar por e-mail"><img class="clickable" src="img/pdf.png" title="Salvar como PDF"><img class="clickable" src="img/help.png"title="Ajuda"></div>
        <div id="content">
        <span> Escolha um usuário e Senha para cadastrar-se </span>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- action chama a si mesmo com método post. -->     
            <ul class="wrapper">
                <li class="form-row">
                    <label>Usuário: </label>
                    <input type="text" name="username" value="<?php echo $informed_user ?>" placeholder="<?php echo $username_err; ?>" min="1" max="20" pattern="[A-Za-z0-9]+" title="Somente letras e números" required>
                </li>
                <li class="form-row">
                    <label>Senha: </label>
                    <input type="password" name="password" value="<?php echo $informed_password ?>" placeholder="<?php echo $password_err; ?>" min="6" max="20" title="Entre 6 e 20 caracteres" required> 
                </li>
                <li class="form-row">
                    <label>Confirmar senha: </label>
                    <input type="password" name="confirm_password" placeholder="<?php echo $confirmpass_err; ?>" required>
                </li>
                <li class="form-row">
                    <input type="submit" class="clickable" value="Cadastrar">
                </li>
            </ul>
        </form>
    </div>
    </body>
</html>