<?php
// editar.php
session_start();
if (!isset($_SESSION["autenticado"])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "entradas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM marathon WHERE ID = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $fecha = $_POST['fechadenacimiento'];
    $entradas = intval($_POST['entradas']);

    $sql = "UPDATE marathon SET 
                nombre='$nombre',
                apellido='$apellido',
                email='$email',
                fechadenacimiento='$fecha',
                entradas=$entradas
            WHERE ID=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php?msg=Registro actualizado");
        exit();
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
    if (!$row) {
    die("Registro no encontrado.");
}

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar registro</title>
</head>
<body>
    <h2>Editar registro</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $row['ID'] ?>">
        Nombre: <input type="text" name="nombre" value="<?= $row['nombre'] ?>"><br>
        Apellido: <input type="text" name="apellido" value="<?= $row['apellido'] ?>"><br>
        Email: <input type="email" name="email" value="<?= $row['email'] ?>"><br>
        Fecha de Nacimiento: <input type="date" name="fechadenacimiento" value="<?= $row['fechadenacimiento'] ?>">
        Entradas: <input type="number" name="entradas" value="<?= $row['entradas'] ?>"><br>
        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>
