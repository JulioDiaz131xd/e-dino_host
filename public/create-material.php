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

    // Crear la rúbrica
    $result = $user->createRubric($rubrica_name, $criterios, $clase_id);
    
    if ($result) {
        $rubric_id = $user->getLastInsertId();
        
        // Guardar cada criterio asociado a la rúbrica
        foreach ($criterios as $criterio) {
            $criterion_name = $criterio['nombre'];
            $description = $criterio['descripcion'];
            $nivel = intval($criterio['nivel']);

            // Añadir el criterio a la rúbrica
            $user->addCriterion($rubric_id, $criterion_name, $description, $nivel);
        }

        header("Location: gestionar_clase.php?clase_id=$clase_id");
        exit();
    } else {
        $error = "Error al crear la rúbrica.";
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

            <div id="criterios-wrapper">
                <h2>Agregar Criterios</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Criterio</th>
                            <th>Descripción</th>
                            <th>Nivel de Evaluación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="criterios-table">
                        <tr class="criterio" id="criterio-0">
                            <td><input type="text" name="criterios[0][nombre]" required></td>
                            <td><textarea name="criterios[0][descripcion]" required></textarea></td>
                            <td>
                                <select name="criterios[0][nivel]" required>
                                    <option value="100">Excelente (100%)</option>
                                    <option value="90">Muy Bueno (90%)</option>
                                    <option value="80">Bueno (80%)</option>
                                    <option value="70">Aceptable (70%)</option>
                                    <option value="60">Regular (60%)</option>
                                    <option value="50">Debe Mejorar (50%)</option>
                                    <option value="40">Insuficiente (40%)</option>
                                    <option value="30">Muy Deficiente (30%)</option>
                                </select>
                            </td>
                            <td><button type="button" class="delete-criterio" onclick="deleteCriterio(0)">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" id="add-criterio">Agregar Criterio</button>
            <button type="submit">Crear Rúbrica</button>
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
            const tableBody = document.getElementById('criterios-table');
            const newRow = `
                <tr class="criterio" id="criterio-${criterioCount}">
                    <td><input type="text" name="criterios[${criterioCount}][nombre]" required></td>
                    <td><textarea name="criterios[${criterioCount}][descripcion]" required></textarea></td>
                    <td>
                        <select name="criterios[${criterioCount}][nivel]" required>
                            <option value="100">Excelente (100%)</option>
                            <option value="90">Muy Bueno (90%)</option>
                            <option value="80">Bueno (80%)</option>
                            <option value="70">Aceptable (70%)</option>
                            <option value="60">Regular (60%)</option>
                            <option value="50">Debe Mejorar (50%)</option>
                            <option value="40">Insuficiente (40%)</option>
                            <option value="30">Muy Deficiente (30%)</option>
                        </select>
                    </td>
                    <td><button type="button" class="delete-criterio" onclick="deleteCriterio(${criterioCount})">Eliminar</button></td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', newRow);
            criterioCount++;
        });

        function deleteCriterio(index) {
            const criterioRow = document.getElementById(`criterio-${index}`);
            criterioRow.remove();
        }
    </script>
</body>

</html>
