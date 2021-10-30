<?php

$servername = "localhost";
$username = "renan";
$password = "MySQL-SGBD@1989";
$dbname = "CertMat";

// Cria conexão.
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa conexão.
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

// Query.
$sql = "SELECT * FROM Laboratorio";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // saída de cada linha.
  while($row = $result->fetch_assoc()) {
    echo "Nome: " . $row["Nome"]. " - Contato: " . $row["Contato"]. "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();

?>
