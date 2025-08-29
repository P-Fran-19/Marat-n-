<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "entradas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Error en la conexión: " . $conn->connect_error);
} else {
    echo "✅ Conexión exitosa a la base de datos.";
}
?>
