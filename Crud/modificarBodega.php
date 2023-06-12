<?php
session_start();

include("../Config/coneccion.php");

$id = $_POST['id']; // Obtén el ID de la bodega a actualizar
$codigo = $_POST['txtCodigo'];
$nombre = $_POST['txtNombre'];
$direccion = $_POST['txtDireccion'];
$dotacion = $_POST['txtDotacion'];
$estado = $_POST['txtEstado'];

$sql = "UPDATE bodegas
        SET codigo = '$codigo', nombre = '$nombre', direccion = '$direccion', dotacion = '$dotacion', estado = '$estado'
        WHERE id = $id";

$resultados = pg_query($conexion, $sql);

if ($resultados) {
    // La actualización en la tabla "bodegas" se realizó correctamente

    // Eliminar las filas existentes en la tabla intermedia para la bodega actual
    $sqlDelete = "DELETE FROM bodega_encargado WHERE bodega_id = $id";
    $resultadosDelete = pg_query($conexion, $sqlDelete);

    if (!$resultadosDelete) {
        // Ocurrió un error durante la eliminación en la tabla intermedia
        $_SESSION['flash_message'] = "Error al eliminar datos de la tabla intermedia para la bodega con ID $id.";
    }

    // Insertar las nuevas filas en la tabla intermedia con los encargados seleccionados
    $encargadoIds = $_POST['chkEncargado']; // Obtén los IDs de los encargados seleccionados

    foreach ($encargadoIds as $encargadoId) {
        $sqlInsert = "INSERT INTO bodega_encargado (bodega_id, encargado_id)
                    VALUES ($id, $encargadoId)";

        $resultadosInsert = pg_query($conexion, $sqlInsert);

        if (!$resultadosInsert) {
            // Ocurrió un error durante la inserción en la tabla intermedia
            $_SESSION['flash_message'] = "Error al insertar datos en la tabla intermedia para el encargado con ID $encargadoId.";
        }
    }

    // Si se ejecuta hasta aquí sin errores, significa que la actualización y las inserciones en la tabla intermedia se realizaron correctamente
    $_SESSION['flash_message'] = "Datos actualizados Correctamente";

    // Redirigir a index.php
    header("Location: ../index.php");
    exit; // Importante: asegúrate de usar exit después de la redirección para detener la ejecución del código restante.
} else {
    // La actualización en la tabla "bodegas" no se ejecutó correctamente
    $_SESSION['flash_message'] = "Error al actualizar la bodega.";

    // Redirigir a create.php
    header("Location: ../index.php");
    exit;
}
?>
