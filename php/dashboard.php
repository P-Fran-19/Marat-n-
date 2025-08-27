<?php 
// dashboard.php
session_start();
if (!isset($_SESSION["autenticado"])) {
    header("Location: login.php");
    exit();
}

// Conexión a la BD
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "entradas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta CORRECTA
$sql = "SELECT ID, nombre, apellido, email, fechadenacimiento, entradas FROM marathon";
$result = $conn->query($sql);
?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Fran database</title>
    <link href="../css/BD.css" rel="stylesheet" >
</head>
<body>
    <div class="dashboard-container">
        <h1>Lista de Compradores 🎟️</h1>
        <p>Estos son los registros de entradas vendidas:</p>

        <?php if ($result && $result->num_rows > 0): ?>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID de compra</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Cantidad de Entradas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ID']) ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['apellido']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['fechadenacimiento']) ?></td>
                        <td><?= htmlspecialchars($row['entradas']) ?></td>
                        <td>
                            <td>
                                <button class="btn editar" onclick="location.href='editar.php?id=<?= $row['ID'] ?>'">Editar</button>
                                <button class="btn eliminar" 
                                onclick="if(confirm('AVISO: Estas por eliminar al registro con ID <?= $row['ID'] ?>. ¿Estás seguro?')) location.href='eliminar.php?id=<?= $row['ID'] ?>'">Eliminar</button>
                            </td>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        <?php else: ?>
            <p class="empty">No hay registros de compradores todavía.</p>
        <?php endif; ?>

        <a href="logout.php" class="logout-btn">Cerrar sesión</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
