<?php
$db = mysqli_connect( // Conextión con la base de datos
    $_ENV["DB_HOST"], 
    $_ENV["DB_USER"], 
    $_ENV["DB_PASS"], 
    $_ENV["DB_NAME"]
);

$db->set_charset("utf8"); // Cambiar codificación

if (!$db) { // Mostrar errres en caso de fallos
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
