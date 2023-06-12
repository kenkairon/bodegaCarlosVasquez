<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Bodega</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <div class="card border-secondary">
        <div class="card-header">Editar Registro</div>
        <div class="card-body">
            <form action="../Crud/modificarBodega.php" method="POST">
            <?php
                include_once('../Config/coneccion.php');
                $sql = "SELECT * FROM bodegas WHERE id = " . $_GET['id'];
                $resultado = pg_query($conexion, $sql);
                $row = pg_fetch_assoc($resultado);
            ?>
            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']; ?>">
                <div class="mb-3">
                    <label for="txtCodigo">Codigo:</label>
                    <input type="text" id="txtCodigo" name="txtCodigo" maxlength="5" class="form-control" value="<?php echo $row['codigo']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" id="txtNombre" name="txtNombre" maxlength="100" class="form-control"  value="<?php echo $row['nombre']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="txtApellido">Direccion:</label>
                    <input type="text" id="txtDireccion" name="txtDireccion" maxlength="100" class="form-control"  value="<?php echo $row['direccion']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="txtCorreo">Dotación:</label>
                    <input type="number" id="txtDotacion" name="txtDotacion" maxlength="100" class="form-control"  value="<?php echo $row['dotacion']; ?>" required>
                </div>
                <div class="mb-3">
                <label for="txtEstado">Estado:</label>
                    <select id="txtEstado" name="txtEstado" class="form-select" required>
                        <option value="" selected>Seleccione una opción</option>
                        <option value="Activado" <?php echo ($row['estado'] == 'Activado') ? 'selected' : ''; ?>>Activado</option>
                        <option value="Desactivado" <?php echo ($row['estado'] == 'Desactivado') ? 'selected' : ''; ?>>Desactivado</option>
                        </select>
                </div>
                <div class="mb-3">
                <label for="txtNombreCompleto"><b>Nombre Completo del Encargado</b></label><br>
                <?php
                include_once('../Config/coneccion.php');

                $bodegaId = $_GET['id'];

                $sqlEncargados = "SELECT id, CONCAT(nombre_encargado, ' ', apellido_paterno, ' ', apellido_materno) as nombre_completo_encargados from encargados";
                $resultadosEncargados = pg_query($conexion, $sqlEncargados);

                $sqlBodegaEncargados = "SELECT encargado_id FROM bodega_encargado WHERE bodega_id = $bodegaId";
                $resultadosBodegaEncargados = pg_query($conexion, $sqlBodegaEncargados);

                $encargadoIds = array(); // Arreglo para almacenar los IDs de los encargados seleccionados

                // Obtener los IDs de los encargados seleccionados
                while ($rowBodegaEncargados = pg_fetch_assoc($resultadosBodegaEncargados)) {
                $encargadoIds[] = $rowBodegaEncargados['encargado_id'];
                }

                while ($datos = pg_fetch_assoc($resultadosEncargados)) {
                    echo '<input type="checkbox" name="chkEncargado[]" value="' . $datos['id'] . '"';
                    if (in_array($datos['id'], $encargadoIds)) {
                        echo ' checked'; // Agrega el atributo "checked" si el ID está en el arreglo de encargadoIds
                    }
                    echo '>';
                    echo '<label">' . $datos['nombre_completo_encargados'] . '</label><br>';
                }
                ?>
                <button type="submit" class="btn btn-success" tabindex="5"><i class="bi bi-house-add"></i> Agregar Bodega</button>
                <a href="../index.php" class="btn btn-primary"><i class="bi bi-reply-all"></i> Volver al Inicio</a>
            </form>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>