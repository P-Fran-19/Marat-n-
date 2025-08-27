<?php
session_start();

if (!isset($_SESSION["autenticado"])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "entradas";

// creamos una nueva conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// en caso de error no va un try catch?
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
// ya que cada pesona la creamos con el id unico, lo usamos para eliminar (isset si no es null true sino false)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM marathon WHERE ID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=Registro eliminado");
        exit();
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
}

// mandamos a travez de la conexion la consulta y si da verdadero vuelve a dashboard.php sino muestra el error
if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error al eliminar el registro: " . $conn->error;
}
if (!isset($_GET['id'])) {
    die("Error: falta el ID para eliminar.");
}

?>