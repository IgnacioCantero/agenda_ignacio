<?php
session_start();
include 'db.php';

// Datos estáticos por ahora
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

if ($usuario === 'admin' && $contrasena === 'admin') {
    $_SESSION['usuario'] = $usuario;
    header('Location: dashboard.php');
    exit();
} else {
    echo "Usuario o contraseña incorrectos.";
}
?>