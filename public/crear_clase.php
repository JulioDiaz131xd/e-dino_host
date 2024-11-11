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
    <link rel="stylesheet" href="/../assets/css/crear_clase.css">
    <link rel="icon" href="../assets/images/logo.ico">
</head>
<style>:root {
    --color-background-light: #f9f9f9;
    --color-text-light: #333;
    --color-background-dark: #000000;
    --color-text-dark: #ffffff;
    --color-accent-light: #8BCD3A;
    --color-accent-dark: rgb(139, 205, 58); 
    --color-button-light: #8BCD3A;
    --color-button-dark: rgb(139, 205, 58);
    --border-radius: 12px;
    --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

body {
    font-family: 'Roboto', sans-serif;
    background-color: var(--color-background-light);
    color: var(--color-text-light);
    margin: 0;
    padding: 0;
}

h1, h2, h3 {
    font-weight: 700;
    letter-spacing: 1px;
    color: var(--color-text-light);
}

header, footer {
    background-color: var(--color-background-dark);
    color: var(--color-text-dark);
    padding: 20px;
    text-align: center;
}

header a, footer p {
    color: var(--color-text-dark);
    text-decoration: none;
}

.main-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: var(--color-background-light);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
}

.main-container h2 {
    font-size: 28px;
    margin-bottom: 15px;
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    color: var(--color-text-light);
}

input[type="text"], textarea {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: var(--border-radius);
    background-color: #fff;
}

input[type="text"]:focus, textarea:focus {
    outline: none;
    border-color: var(--color-accent-light);
}

.submit-btn {
    width: 100%;
    padding: 12px;
    font-size: 18px;
    font-weight: 600;
    color: var(--color-text-dark);
    background-color: var(--color-button-light);
    border: none;
    border-radius: var(--border-radius);
    cursor: pointer;
    box-shadow: var(--box-shadow);
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.submit-btn:hover {
    background-color: var(--color-button-dark);
    transform: translateY(-3px);
}

.error-message {
    color: #ff4b4b;
    text-align: center;
    margin-top: 10px;
}

@media (max-width: 768px) {
    .main-container {
        margin: 20px;
        padding: 15px;
    }
}
</style>
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
