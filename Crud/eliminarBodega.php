<?php
session_start(); // Iniciar la sesión (asegúrate de llamar a session_start() antes de cualquier salida HTML)

include("../Config/coneccion.php");

$id = $_GET['id']; // Obtén el ID de la bodega a eliminar

// Eliminar filas relacionadas en la tabla intermedia
$sqlDelete = "DELETE FROM bodega_encargado WHERE bodega_id = $id";
$resultadosDelete = pg_query($conexion, $sqlDelete);

if ($resultadosDelete) {
    // La eliminación en la tabla intermedia se realizó correctamente

    // Eliminar la entrada de la tabla principal
    $sql = "DELETE FROM bodegas WHERE id = $id";
    $resultados = pg_query($conexion, $sql);

    if ($resultados) {
        // La eliminación en la tabla principal se realizó correctamente
        $_SESSION['flash_message'] = "Bodega eliminada correctamente.";

        // Redirigir a index.php
        header("Location: ../index.php");
        exit; // Asegúrate de usar exit después de la redirección para detener la ejecución del código restante.
    } else {
        // La eliminación en la tabla principal no se ejecutó correctamente
        $_SESSION['flash_message'] = "Error al eliminar la bodega.";

        // Redirigir a index.php
        header("Location: ../index.php");
        exit;
    }
} else {
    // Ocurrió un error durante la eliminación en la tabla intermedia
    $_SESSION['flash_message'] = "Error al eliminar datos de la tabla intermedia para la bodega con ID $id.";

    // Redirigir a index.php
    header("Location: ../index.php");
    exit;
}
?>

