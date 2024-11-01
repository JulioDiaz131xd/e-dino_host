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
    <title>Crear Rubrica de Evaluacion - E-Dino</title>
    <link rel="stylesheet" href="../assets/css/create_material.css">
</head>

<body>
    <header>
        <h1>Crear Rubrica de Evaluacion</h1>
    </header>

    <main>
        <form action="" method="POST">
            <div>
                <label for="rubrica_name">Nombre de la Rubrica:</label>
                <input type="text" id="rubrica_name" name="rubrica_name" required>
            </div>

            <div id="criterios-wrapper">
                <h2>Agregar Criterios</h2>
                <div class="criterio" id="criterio-0">
                    <label for="criterio[]">Criterio:</label>
                    <input type="text" name="criterios[0][nombre]" required>

                    <label for="criterio_desc[]">Descripcion:</label>
                    <textarea name="criterios[0][descripcion]" required></textarea>

                    <label for="nivel">Nivel de evaluacion:</label>
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

                    <button type="button" class="delete-criterio" onclick="deleteCriterio(0)">Eliminar Criterio</button>
                </div>
            </div>

            <button type="button" id="add-criterio">Agregar Criterio</button>
            <button type="submit">Crear Rúbrica</button>
        </form>

        <?php if (isset($error)): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> E-Dino. Todos los derechos reservados.</p>
    </footer>

    <script>
        let criterioCount = 1;

        document.getElementById('add-criterio').addEventListener('click', function() {
            const wrapper = document.getElementById('criterios-wrapper');
            const newCriterio = `
                <div class="criterio" id="criterio-${criterioCount}">
                    <label for="criterio[]">Criterio:</label>
                    <input type="text" name="criterios[${criterioCount}][nombre]" required>

                    <label for="criterio_desc[]">Descripción:</label>
                    <textarea name="criterios[${criterioCount}][descripcion]" required></textarea>

                    <label for="nivel">Niveles de Desempeño:</label>
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

                    <button type="button" class="delete-criterio" onclick="deleteCriterio(${criterioCount})">Eliminar Criterio</button>
                </div>
            `;
            wrapper.insertAdjacentHTML('beforeend', newCriterio);
            criterioCount++;
        });

        function deleteCriterio(index) {
            const criterioDiv = document.getElementById(`criterio-${index}`);
            criterioDiv.remove();
        }
    </script>
</body>

</html>
