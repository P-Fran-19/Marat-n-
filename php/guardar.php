<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "entradas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$fechaNacimiento = $_POST['fechaNacimiento'];
$email = $_POST['email'];
$cantidad = $_POST['cantidad'];

$sql = "INSERT INTO marathon (nombre, apellido, fechadenacimiento, email, entradas)
        VALUES ('$nombre', '$apellido', '$fechaNacimiento', '$email', $cantidad)";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo registro creado exitosamente";
    header("Location: ../pago2.html"); // redirijo a la página principal
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
