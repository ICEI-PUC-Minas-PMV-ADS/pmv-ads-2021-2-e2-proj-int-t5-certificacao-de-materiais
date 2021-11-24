<?php

session_start();

require_once("db_connect.php");

// Variáveis de feedback. Armazenam texto de apoio ao usuário.
$password = $username = $username_err = $password_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    ($username = trim($_POST["username"])) ? (!empty(trim($_POST["username"]))) : ($username_err = "Informe o usuário");
    ($password = trim($_POST["password"])) ? (!empty(trim($_POST["password"]))) : ($password_err = "Informe a senha");

    if (!empty($username) && !empty($password)) {

        $stmt = $mysqli->prepare("SELECT username, password FROM Usuario WHERE username = ?");
        $stmt->bind_param('s', $username);

        if ($stmt->execute()) {
            
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                
                // Usuário encontrado na base.
                $stmt->bind_result($username, $stored_password);
                $stmt->fetch();

                if ($password === $stored_password) {

                    session_start();

                    $_SESSION["isLogged"] = true;
                    $_SESSION["username"] = $username;

                    header("location: labs.php");
                } else {
                    $password_err = $username_err = "Usuário ou senha inválidos";
                }
            }

        } else {
            echo "ERRO!: falha ao consultar o banco. " . $mysqli->mysqli_error();
        }

        $stmt->close();
    }
}

$mysqli->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/subpages.css">
        <meta chaset="UTF-8">
    </head>
    <body>
        <div class="container">
            <form action="login.php" method="post">
                <div class="form-line">
                    <label>Usuário: </label>
                    <input type="text" name="username">
                    <label style="color:red"><?php echo $username_err ?></label>
                </div>
                <div class="form-line">
                    <label>Senha: </label>
                    <input type="password" name="password">
                    <label style="color:red"><?php echo $password_err ?></label>
                </div>
                <div class="form-line">
                    <input id="login-btn" class="clickable login-btn btn" type="submit" value="LOGAR">
                </div>
            </form>
        </div>
    </body>
</html>