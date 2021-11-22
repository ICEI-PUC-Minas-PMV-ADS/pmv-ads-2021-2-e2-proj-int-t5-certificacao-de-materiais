<?php
// Injeta página que cuida da conexão com o banco.
require_once "db_connect.php";

// Variáveis de feedback. Armazenam texto de apoio ao usuário.
$username_err = $password_err = $confirmpass_err = '';

// Variáveis para montagem da query.
$username = $password = '';

// Processando os dados quando o formulário é enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Tratamento do campo "Usuário".
    if (empty(trim($_POST["username"]))) {
        $username_err = "Usuário não pode ser vazio.";
    } elseif (!preg_match("/^[a-zA-Z0-9_.]+$/", trim($_POST["username"]))) {
        $username_err = "Usuário só pode conter letras, números, ponto ou underline.";
    } else {

        // Checa se usuário existe no banco.
        $stmt = $mysqli->prepare("SELECT username FROM Usuario WHERE username = ?");
        $stmt->bind_param('s', trim($_POST["username"]));
        
        if ($stmt->execute()) {

            $stmt->store_result();
            
            if ($stmt->num_rows == 1) {
                $username_err = "Nome de usuário já em uso.";
            } else {
                $username = trim($_POST["username"]);
            }
        } else {
            echo "ERRO!: falha ao consultar no banco.";
        }
        
        $stmt->close();
    }

    //Tratamento do campo "Senha" e "Confirmar senha".
    if (empty(trim($_POST["password"]))) {
        $password_err = "Senha não pode ser vazia.";
    } elseif (strlen(trim($_POST[password])) < 8) {
        $password_err = "Senha tem que ter pelo menos 8 caracteres.";
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
    if (!empty($username) && !empty($password)) {
        $stmt = $mysqli->prepare("INSERT INTO Usuario (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            // TODO: cadastro realizado com sucesso redirecionar já logado.
            header("location: login.php");
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