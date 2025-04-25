<?php
$host = '127.0.0.1';
$puerto = '3307';
$usuario = 'root';
$contrasena = 'root';
$bd = 'agenda_contactos';

try {
    $conexion = new PDO("mysql:host=$host;port=$puerto;dbname=$bd;charset=utf8", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>