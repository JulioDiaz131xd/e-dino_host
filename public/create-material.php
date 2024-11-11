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

    // Validación para máximo 5 criterios
    if (count($criterios) > 5) {
        $error = "No puedes añadir más de 5 criterios.";
    } else {
        // Crear la rúbrica
        $result = $user->createRubric($rubrica_name, $criterios, $clase_id);

        if ($result) {
            $rubric_id = $user->getLastInsertId();

            // Guardar cada criterio asociado a la rúbrica
            foreach ($criterios as $criterio) {
                $criterion_name = $criterio['nombre'];
                $description = $criterio['descripcion'];
                $nivel = intval($criterio['nivel']);
                $nivel_nombre = $criterio['nivel_nombre'];

                // Añadir el criterio a la rúbrica
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

            <div id="criterios-wrapper">
                <h2>Agregar Criterios</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Criterio</th>
                            <th>Descripción</th>
                            <th>Nivel (%)</th>
                            <th>Nombre del Nivel</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="criterios-table">
                        <tr class="criterio" id="criterio-0">
                            <td><input type="text" name="criterios[0][nombre]" required></td>
                            <td><textarea name="criterios[0][descripcion]" required></textarea></td>
                            <td><input type="number" name="criterios[0][nivel]" min="1" max="100" required></td>
                            <td><input type="text" name="criterios[0][nivel_nombre]" placeholder="Descripción del nivel" required></td>
                            <td><button type="button" class="delete-criterio noselect" onclick="deleteCriterio(0)">
                                    <span class="text">Eliminar</span>
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path>
                                        </svg>
                                    </span>
                                </button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" id="add-criterio">Agregar Criterio</button>
            <button type="submit" id="save">
                <div class="svg-wrapper-1">
                    <div class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" class="icon">
                            <path d="M22,15.04C22,17.23 20.24,19 18.07,19H5.93C3.76,19 2,17.23 2,15.04C2,13.07 3.43,11.44 5.31,11.14C5.28,11 5.27,10.86 5.27,10.71C5.27,9.33 6.38,8.2 7.76,8.2C8.37,8.2 8.94,8.43 9.37,8.8C10.14,7.05 11.13,5.44 13.91,5.44C17.28,5.44 18.87,8.06 18.87,10.83C18.87,10.94 18.87,11.06 18.86,11.17C20.65,11.54 22,13.13 22,15.04Z"></path>
                        </svg>
                    </div>
                </div>
                <span>Crear Rúbrica</span>
            </button>
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
            if (criterioCount < 5) {
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
                alert("Solo se pueden añadir hasta 5 criterios.");
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