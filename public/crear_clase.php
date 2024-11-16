<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol_id'] !== 1) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../core/models/class.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['class-name'] ?? '';
    $descripcion = $_POST['class-description'] ?? '';

    $codigo = $user->createClass($_SESSION['user_id'], $nombre, $descripcion);

    if ($codigo) {
        header("Location: dashboard.php?message=Clase creada exitosamente");
    } else {
        $error = "Error al crear la clase.";
    }
}

?>
<php
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Crear Clase - E-Dino</title>
        <link rel="stylesheet" href="../assets/css/dashboard-user.css">
        <link rel="icon" href="../assets/images/logo.ico">
    </head>
    <body>
        <h2>Crear Nueva Clase</h2>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="crear_clase.php">
            <label for="class-name">Nombre de la Clase</label>
            <input type="text" id="class-name" name="class-name" required>

            <label for="class-description">Descripcion</label>
            <textarea id="class-description" name="class-description" required></textarea>

            <button type="submit">Crear Clase</button>
        </form>
    </body>

    </html>