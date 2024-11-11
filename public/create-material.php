<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../core/models/User.php';

$usuario_id = $_SESSION['user_id'];
$clase_id = isset($_GET['clase_id']) ? intval($_GET['clase_id']) : 0;

$user = new User();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rubrica_name = $_POST['rubrica_name'];
    $criterios = $_POST['criterios'];

    if (count($criterios) > 5) {
        $error = "No puedes añadir más de 5 criterios.";
    } else {
        $result = $user->createRubric($rubrica_name, $criterios, $clase_id);

        if ($result) {
            $rubric_id = $user->getLastInsertId();

            foreach ($criterios as $criterio) {
                $criterion_name = $criterio['nombre'];
                $description = $criterio['descripcion'];
                $nivel = intval($criterio['nivel']);
                $nivel_nombre = $criterio['nivel_nombre'];

                $user->addCriterion($rubric_id, $criterion_name, $description, $nivel, $nivel_nombre);
            }

            header("Location: gestionar_clase.php?clase_id=$clase_id");
            exit();
        } else {
            $error = "Error al crear la rúbrica.";
        }
    }
}

$user->closeConnection();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Rúbrica de Evaluación - E-Dino</title>
    <link rel="stylesheet" href="../assets/css/create_material.css">
</head>

<body>
    <header>
        <h1>Crear Rúbrica de Evaluación</h1>
    </header>

    <main>
    <form action="" method="POST">
    <div>
        <label for="rubrica_name">Nombre de la Rúbrica:</label>
        <input type="text" id="rubrica_name" name="rubrica_name" required>
    </div>

    <h2>Criterios de Evaluación</h2>
    <table>
        <thead>
            <tr>
                <th>Criterio</th>
                <th>Excelente (10)</th>
                <th>Bueno (9)</th>
                <th>Regular (8)</th>
                <th>Suficiente (7)</th>
                <th>Debe mejorar (6)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Dominio del tema</td>
                <td>Excelente conocimiento del tema. <strong>Valor: 2 pts.</strong></td>
                <td>Buen conocimiento del tema. <strong>Valor: 1.8 pts.</strong></td>
                <td>Conocimiento regular del tema. <strong>Valor: 1.6 pts.</strong></td>
                <td>Poco conocimiento del tema. <strong>Valor: 1.4 pts.</strong></td>
                <td>Difícil saber si conocen el tema. <strong>Valor: 1.2 pts.</strong></td>
            </tr>
            <tr>
                <td>Comprensión del tema</td>
                <td>Contesta todas las preguntas. <strong>Valor: 2 pts.</strong></td>
                <td>Contesta la mayoría de preguntas. <strong>Valor: 1.8 pts.</strong></td>
                <td>Contesta algunas preguntas. <strong>Valor: 1.6 pts.</strong></td>
                <td>Contesta pocas preguntas. <strong>Valor: 1.4 pts.</strong></td>
                <td>No contesta las preguntas. <strong>Valor: 1.2 pts.</strong></td>
            </tr>
            <!-- Agrega más criterios aquí -->
        </tbody>
    </table>

    <button type="submit">Guardar Rúbrica</button>
</form>


        <?php if ($error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> E-Dino. Todos los derechos reservados.</p>
    </footer>

    <script>
        let criterioCount = 1;

        document.getElementById('add-criterio').addEventListener('click', function() {
            if (criterioCount < 10) {
                const tableBody = document.getElementById('criterios-table');
                const newRow = `
            <tr class="criterio" id="criterio-${criterioCount}">
                <td><input type="text" name="criterios[${criterioCount}][nombre]" required></td>
                <td><textarea name="criterios[${criterioCount}][descripcion]" required></textarea></td>
                <td><input type="number" name="criterios[${criterioCount}][nivel]" min="1" max="100" required></td>
                <td><input type="text" name="criterios[${criterioCount}][nivel_nombre]" placeholder="Descripción del nivel" required></td>
                <td>
                    <button type="button" class="delete-criterio noselect" onclick="deleteCriterio(${criterioCount})">
                        <span class="text">Eliminar</span>
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path>
                            </svg>
                        </span>
                    </button>
                </td>
            </tr>
        `;
                tableBody.insertAdjacentHTML('beforeend', newRow);
                criterioCount++;
            } else {
                alert("Solo se pueden añadir hasta 10 criterios.");
            }
        });

        function deleteCriterio(index) {
            const criterioRow = document.getElementById(`criterio-${index}`);
            criterioRow.remove();
            criterioCount--;
        }
    </script>
</body>
</html>