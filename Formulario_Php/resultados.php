<?php
require 'vendor/autoload.php';

// 1. Validar que la petición venga por POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>Error</title></head><body><p>Error: no se han enviado datos.</p><p><a href='index.php'>Volver al formulario</a></p></body></html>";
    exit;
}

$nombre = trim($_POST["nombre"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$edad = $_POST["edad"] ?? "";

$errores = [];

// 2. Procesar validaciones
if (empty($nombre)) {
    $errores[] = "El nombre es obligatorio.";
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo electrónico no es válido.";
}

if (filter_var($edad, FILTER_VALIDATE_INT) === false || (int)$edad < 1) {
    $errores[] = "La edad debe ser un número entero mayor que cero.";
}

// Si hay errores de validación, se muestran y se detiene la ejecución
if (!empty($errores)) {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>Errores</title></head><body>";
    echo "<h2>Se han encontrado errores:</h2><ul>";
    foreach ($errores as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul><p><a href='index.php'>Volver al formulario</a></p></body></html>";
    exit;
}

// 3. Conexión y operaciones con MongoDB Atlas
$uri = getenv("MONGODB_URI");
$db = getenv("MONGODB_DB");

try {
    if (!$uri || !$db) {
        throw new Exception("Las variables de entorno MONGODB_URI o MONGODB_DB no están configuradas.");
    }

    $cliente = new MongoDB\Client($uri);
    $coleccion = $cliente->selectCollection($db, "inscripciones");

    // Insertar el nuevo registro enviado por el usuario
    $coleccion->insertOne([
        'nombre' => $nombre,
        'correo' => $correo,
        'edad'   => (int)$edad,
        'fecha'  => new MongoDB\BSON\UTCDateTime()
    ]);

    // Consultar todos los registros de la base de datos para listarlos abajo
    $cursor = $coleccion->find([], ['sort' => ['fecha' => -1]]);
    $documentos = iterator_to_array($cursor);

} catch (Exception $e) {
    $error_bd = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de la Inscripción</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .success-box { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .error-box { background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .btn { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>

    <h1>Procesamiento de Inscripción</h1>

    <?php if (isset($error_bd)): ?>
        <!-- Si falló la base de datos, mostramos el error técnico -->
        <div class="error-box">
            <strong>Error de Base de Datos:</strong> <?php echo htmlspecialchars($error_bd); ?>
        </div>
    <?php else: ?>
        <!-- Si todo fue bien, confirmamos el éxito del envío actual -->
        <div class="success-box">
            <strong>¡Éxito!</strong> Tus datos se han guardado correctamente en MongoDB Atlas.
        </div>

        <h2>Listado completo de inscritos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo electrónico</th>
                    <th>Edad</th>
                    <th>Fecha de registro</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($documentos)): ?>
                    <tr>
                        <td colspan="4">No hay registros guardados todavía.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($documentos as $doc): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($doc['nombre'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($doc['correo'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($doc['edad'] ?? ''); ?></td>
                            <td>
                                <?php 
                                if (isset($doc['fecha']) && $doc['fecha'] instanceof MongoDB\BSON\UTCDateTime) {
                                    echo $doc['fecha']->toDateTime()->format('Y-m-d H:i:s');
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p style="margin-top: 30px;"><a href="index.php" class="btn">Volver al formulario</a></p>

</body>
</html>
