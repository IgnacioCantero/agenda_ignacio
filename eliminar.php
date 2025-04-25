<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("DELETE FROM contactos WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: dashboard.php');
exit();
?>