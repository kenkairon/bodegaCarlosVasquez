<?php
$host = "localhost"; // Dirección del host de la base de datos
$user = "postgres"; // Nombre de usuario de la base de datos
$pass = "1234"; // Contraseña de la base de datos
$dbname = "bodegas_admin"; // Nombre de la base de datos

// Conexión a la base de datos PostgreSQL
$conexion = pg_connect("host=$host dbname=$dbname user=$user password=$pass");


// Verificar si la conexión se estableció correctamente
if (!$conexion) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}
?>




