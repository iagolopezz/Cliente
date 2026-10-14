
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados del formulario</title>
</head>
<body>

    <h1>Resultados del formulario</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        echo "<p>Error: no se han enviado datos.</p>";
        exit;
    }

    $nombre = trim($_POST["nombre"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $edad = $_POST["edad"] ?? "";

    $errores = [];

    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    if (filter_var($edad, FILTER_VALIDATE_INT) === false
        || (int)$edad < 1) {
        $errores[] = "La edad debe ser un número entero mayor que cero.";
    }

    if (!empty($errores)) {
        echo "<h2>Se han encontrado errores:</h2>";
        echo "<ul>";

        foreach ($errores as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }

        echo "</ul>";
    } else {
        echo "<h2>Datos correctos</h2>";
        echo "<p>Nombre: " . htmlspecialchars($nombre) . "</p>";
        echo "<p>Correo: " . htmlspecialchars($correo) . "</p>";
        echo "<p>Edad: " . htmlspecialchars((string)$edad) . "</p>";
    }
    ?>

    <p><a href="index.php">Volver al formulario</a></p>

</body>
</html>