<?php //http://localhost/BaseDeDatosWeb/php/login.php
session_start();

// Usuario y contraseña hardcodeados 
$usuario_correcto = 'mili';
$contraseña_correcta = 'EsLamejorActrizDeTodosLosTiempos';

// traigo lo que escribieron
if ($_SERVER ["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

// Verifico si el usuario y la contraseña son correctos
    if($usuario === $usuario_correcto && $contraseña === $contraseña_correcta) {
        $_SESSION["autenticado"] = true;
        header("Location: dashboard.php"); // acá redirigimos a dashboard.php
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}// importante terminalo con el signo que sigue a continuación
?>
<!--parte de html si no funciono ya que este es el else-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Acceso restringido</h2>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="post">
        Usuario: <input type="text" name="usuario" required><br>
        Contraseña: <input type="password" name="contraseña" required><br>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>