<?php
$conexion = new mysqli("localhost", "root", "", "entradas");

$maximo = 120;

// ⚠️ Cambia "personas" por el nombre real de tu tabla
$resultado = $conexion->query("SELECT SUM(entradas) AS totalReservadas FROM marathon");
$fila = $resultado->fetch_assoc();
$reservadas = $fila['totalReservadas'] ?? 0;

$disponibles = $maximo - $reservadas;

echo json_encode([
    "disponibles" => $disponibles,
    "maximo" => $maximo
]);
