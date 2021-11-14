<?php
// Variáveis de acesso.
define("DB_SERVER", "localhost");
define("DB_USER", "public_user");
define("DB_PASS", "EEFKrc!!51NdI");
define("DB_NAME", "CDM");

// Conexão com MySQL.
$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Valida conexão.
if ($mysqli === false) {
    die("ERRO!: Falha de conexão com o banco." . $mysqli->connect_error);
}

?>