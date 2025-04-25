<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("SELECT * FROM contactos WHERE id = ?");
    $stmt->execute([$id]);
    $contacto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contacto) {
        echo "Contacto no encontrado.";
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);

    if (empty($nombre) || empty($telefono) || empty($email)) {
        die("Todos los campos son obligatorios.");
    }

    if (!preg_match('/^\d{9}$/', $telefono)) {
        die("El teléfono debe contener exactamente 9 dígitos numéricos.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("El correo electrónico no es válido.");
    }

    $stmt = $conexion->prepare("UPDATE contactos SET nombre = ?, telefono = ?, email = ? WHERE id = ?");
    $stmt->execute([$nombre, $telefono, $email, $id]);

    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Editar contacto</h2>
    <form action="editar.php" method="POST">
        <input type="hidden" name="id" value="<?= $contacto['id'] ?>">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($contacto['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($contacto['telefono']) ?>" required pattern="\d{9}" title="Introduce 9 dígitos numéricos">
        </div>
        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($contacto['email']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>