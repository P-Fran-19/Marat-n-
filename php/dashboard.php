<?php 
// dashboard.php (panel oculto protegido)
session_start();
if (!isset($_SESSION["autenticado"])) {
    header("Location: login.php");
    exit();
}

// 🔹 Conexión a la base de datos MySQL
$servername = "localhost";
$username = "root";   // ⚠️ cámbialo si tu usuario es distinto
$password = "";       // ⚠️ tu contraseña de MySQL
$dbname = "entradas"; // ⚠️ nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// 🔹 Consulta para traer todos los registros
$sql = "SELECT nombre, apellido, email, fecha_nacimiento, cantidad FROM compradores";
$result = $conn->query($sql);
?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel oculto</title>
    <link rel="stylesheet" href="/css/BD.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Lista de Compradores 🎟️</h1>
        <p>Estos son los registros de entradas vendidas:</p>

        <?php if ($result->num_rows > 0): ?>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Cantidad de Entradas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                            <td><?= htmlspecialchars($row['apellido']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['fecha_nacimiento']) ?></td>
                            <td><?= htmlspecialchars($row['cantidad']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty">No hay registros de compradores todavía.</p>
        <?php endif; ?>

        <a href="logout.php" class="logout-btn">Cerrar sesión</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
