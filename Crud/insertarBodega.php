<?php
session_start(); // Iniciar la sesión (asegúrate de llamar a session_start() antes de cualquier salida HTML)

include("../Config/coneccion.php");

$codigo = $_POST['txtCodigo'];
$nombre = $_POST['txtNombre'];
$direccion = $_POST['txtDireccion'];
$dotacion = $_POST['txtDotacion'];
$estado = $_POST['txtEstado'];

$sql = "INSERT INTO bodegas (codigo, nombre, direccion, dotacion, estado, fecha_creacion)
        VALUES ('$codigo', '$nombre', '$direccion', '$dotacion', '$estado', CURRENT_TIMESTAMP)";

$resultados = pg_query($conexion, $sql);

if ($resultados) {
    // La inserción en la tabla "bodegas" se realizó correctamente
    $sql = "SELECT currval(pg_get_serial_sequence('bodegas', 'id')) AS last_insert_id";
    $resultados = pg_query($conexion, $sql);
    $row = pg_fetch_assoc($resultados);
    $bodegaId = $row['last_insert_id']; // Obtén el ID de la bodega recién insertada

    $encargadoIds = $_POST['chkEncargado']; // Obtén los IDs de los encargados seleccionados

    foreach ($encargadoIds as $encargadoId) {
        $sql = "INSERT INTO bodega_encargado (bodega_id, encargado_id)
                VALUES ($bodegaId, $encargadoId)";

        $resultados = pg_query($conexion, $sql);

        if (!$resultados) {
            // Ocurrió un error durante la inserción en la tabla intermedia
            $_SESSION['flash_message'] = "Error al insertar datos en la tabla intermedia para el encargado con ID $encargadoId.";
        }
    }

    // Si se ejecuta hasta aquí sin errores, significa que todas las inserciones se realizaron correctamente
    $_SESSION['flash_message'] = "Datos ingresados correctamente.";

    // Redirigir a index.php
    header("Location: ../index.php");
    exit; // Importante: asegúrate de usar exit después de la redirección para detener la ejecución del código restante.
} else {
    // La inserción en la tabla "bodegas" no se ejecutó correctamente
    $_SESSION['flash_message'] = "Error al agregar la bodega.";

    // Redirigir a index.php
    header("Location: ../index.php");
    exit;
}
?>

