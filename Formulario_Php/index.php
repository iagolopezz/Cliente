<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de contacto</title>
</head>
<body>

    <h1>Formulario de contacto</h1>

    <form action="resultados.php" method="POST">

        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <br><br>

        <label>Correo electrónico:</label>
        <input type="email" name="correo" required>
        <br><br>

        <label>Edad:</label>
        <input type="number" name="edad" min="1" required>
        <br><br>


        <input type="submit" value="Enviar">

    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nombre = htmlspecialchars($_POST["nombre"]);
        $correo = htmlspecialchars($_POST["correo"]);
        $edad = htmlspecialchars($_POST["edad"]);
        

        echo "<h2>Datos recibidos</h2>";
        echo "<p>Nombre: $nombre</p>";
        echo "<p>Correo: $correo</p>";
        echo "<p>Edad: $edad</p>";
        
    }
    ?>

</body>
</html>

