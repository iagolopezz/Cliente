<?php
require 'vendor/autoload.php';


$uri = getenv("MONGODB_URI");
$db = getenv("MONGODB_DB");

try {
    $cliente = new MongoDB\Client($uri);
    $coleccion = $cliente->selectCollection($db, "inscripciones");

    echo "¡Conexión exitosa a MongoDB Atlas!";
    
} catch (Exception $e) {
    echo "Error al conectar a MongoDB Atlas: " . $e->getMessage();
}
