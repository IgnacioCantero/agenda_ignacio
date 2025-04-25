<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
include 'db.php';

$stmt = $conexion->query("SELECT * FROM contactos ORDER BY id DESC");
$contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda de Contactos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Agenda de Contactos</h2>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>

    <form action="crear.php" method="POST" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required pattern="\d{9}" title="Introduce 9 dígitos numéricos">
            </div>
            <div class="col-md-3">
                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Añadir</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contactos as $contacto): ?>
                <tr>
                    <td><?= htmlspecialchars($contacto['nombre']) ?></td>
                    <td><?= htmlspecialchars($contacto['telefono']) ?></td>
                    <td><?= htmlspecialchars($contacto['email']) ?></td>
                    <td class="text-end">
                        <a href="editar.php?id=<?= $contacto['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="eliminar.php?id=<?= $contacto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este contacto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>