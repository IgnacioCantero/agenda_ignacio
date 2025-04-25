<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);

    // Validaciones
    if (empty($nombre) || empty($telefono) || empty($email)) {
        die("Todos los campos son obligatorios.");
    }

    if (!preg_match('/^\d{9}$/', $telefono)) {
        die("El teléfono debe contener exactamente 9 dígitos numéricos.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("El correo electrónico no es válido.");
    }

    // Insertar si pasa validación
    $stmt = $conexion->prepare("INSERT INTO contactos (nombre, telefono, email) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $telefono, $email]);

    header('Location: dashboard.php');
    exit();
}
?>