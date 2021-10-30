<?php

$servername = "localhost";
$username = "renan";
$password = "MySQL-SGBD@1989";
$dbname = "CertMat";

$material = $_POST["material"];

// Cria conexão.
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa conexão.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Query.
//$sql = "SELECT * FROM Laboratorio";
$sql = "SELECT Nome, Contato FROM Laboratorio WHERE Nome IN (SELECT Laboratorio_Nome FROM Certificacao WHERE Material_Nome = '" . $material . "');";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    echo "<center>";
    echo "<h2> Laboratórios cadastrados que emitem certificação para: " . $material;
    echo "<table border=1> <tr> <th> Laboratório </th> <th> Endereço </th> </tr>";

    // saída de cada linha.
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Nome"] . "</td><td>" . $row["Contato"] . "</td></tr>";
    }
    
    echo "</table>";

} else {
    echo "<center> <p> 0 resultados </p>";
}
$conn->close();

echo "<p><form action='consulta.php' method='post'> <input type='text' name='material' placeholder='Informe aqui o Material'><br><br> <input type='submit' value='Nova Busca'> </form> </center>";


?>


