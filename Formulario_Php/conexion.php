<?php
require 'vendor/autoload.php';


$uri = "mongodb+srv://iagolopezro_db_user:HBZV6aqMIhItZo7U@cluster0.dvctmw3.mongodb.net/?appName=Cluster0";
$db = getenv("MONGODB_DB");

try {
    $cliente = new MongoDB\Client($uri);
    $coleccion = $cliente->selectCollection($db, "inscripciones");

    echo "¡Conexión exitosa a MongoDB Atlas!";
    
} catch (Exception $e) {
    echo "Error al conectar a MongoDB Atlas: " . $e->getMessage();
}
