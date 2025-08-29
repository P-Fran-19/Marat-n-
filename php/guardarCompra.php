<?php
$conexion = new mysqli("localhost", "root", "", "entradas");

// Recibir datos del fetch (JSON)
$datos = json_decode(file_get_contents("php://input"), true);

if (!$datos) {
    echo json_encode(["ok" => false, "error" => "No llegaron datos"]);
    exit;
}

// Extraer
$nombre   = $conexion->real_escape_string($datos["nombre"]);
$apellido = $conexion->real_escape_string($datos["apellido"]);
$email    = $conexion->real_escape_string($datos["email"]);
$cantidad = (int)$datos["cantidad"];

// Insertar en la DB
$sql = "INSERT INTO marathon (nombre, apellido, email, entradas) 
        VALUES ('$nombre', '$apellido', '$email', $cantidad)";
if ($conexion->query($sql)) {

    
    $webhookUrl = "https://TU_DOMINIO_N8N/webhook/entradas";

    $payload = [
    "nombre"   => $nombre,
    "apellido" => $apellido,
    "email"    => $email,
    "cantidad" => $cantidad
    ];

    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $response = curl_exec($ch);
    curl_close($ch);

    echo json_encode(["ok" => true]);
} else {
    echo json_encode(["ok" => false, "error" => $conexion->error]);
}
