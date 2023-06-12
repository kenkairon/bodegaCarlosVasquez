<!--1 Sirve para el funcionamiento correcto de los mensajes -->
<?php require_once("./Session/flash.php"); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crud de Bodega</title>
    <!--2 cdn de framework de boostrap 5.2 para el css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!--3 cdn de iconos de boostrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!--4 Css del proyecto que se llama estilos.css-->
    <link href="Css/estilos.css" rel="stylesheet">
    <!--5 Cdn de la librería de datatables para que funcione el css-->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center form-signin"><i class="btn btn-lg bi bi-clipboard-check alert alert-success"></i> Listado de Bodegas</h2>
    </div>
    <!--6 Elaboración de Mensajes con Flash -->
    <?php if (isset($flashMessage)): ?>
        <div class="container alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $flashMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="container">
        <a href="Views/agregarBodega.php" class="btn btn-success"><i class="bi bi-house-add"></i> Agregar Bodega</a><hr>
    </div>
    <div class="container col-sm-4"><input class="form-control" type="text" id="inputEstado" placeholder="Buscar por Estado y Presione Enter"></div>
    <div class="container">
        <table class="table table-striped table-hover" id="example" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Cod</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Dotación</th>
                    <th scope="col">Nombre Encargado</th>
                    <th scope="col">Fecha/hora</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- inicio -->
                <?php
                require_once("./Config/coneccion.php");

                // Realizar la consulta a la base de datos
                $sql = " SELECT b.id, b.codigo, b.nombre, b.direccion, b.dotacion, CONCAT(e.nombre_encargado, ' ', e.apellido_paterno, ' ', e.apellido_materno) AS nombre_completo_encargado, b.fecha_creacion, b.estado
                FROM bodegas AS b
                LEFT JOIN bodega_encargado AS be ON b.id = be.bodega_id
                LEFT JOIN encargados AS e ON be.encargado_id = e.id";
                $result = pg_query($conexion, $sql);
                if (!$result) {
                    echo "Error al obtener las bodegas.";
                } else {
                    // Obtener los resultados y mostrarlos en la tabla
                    while ($row = pg_fetch_assoc($result)) {
                        // fin
                        echo "<script>var bodegaId = " . $row['id'] . ";</script>";
                        ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['codigo'] ?></td>
                            <td><?php echo $row['nombre'] ?></td>
                            <td><?php echo $row['direccion'] ?></td>
                            <td><?php echo $row['dotacion'] ?></td>
                            <td><?php echo $row['nombre_completo_encargado'] ?></td>
                            <td><?php echo $row['fecha_creacion'] ?></td>
                            <td><?php echo $row['estado'] ?></td>
                            <td>
                            <a href="Views/editarBodega.php?id=<?php echo $row['id']?>" type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i class="bi bi-pen"></i> Editar</a>
                            <a href="#" type="button" class="btn btn-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" onclick="confirmarEliminacion(<?php echo $row['id']?>)"><i class="bi bi-x-octagon"></i> Eliminar</a>
                            </td>
                        </tr>
                        <!-- inicio -->
                        <?php
                    }
                }
                // Cerrar la conexión
                pg_close($conexion);
                //fin
                ?>
            </tbody>
        </table>
    </div>
    <!--7 Cdn para trabajar con la librería de Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!--8 Se va llamar el código sweetAlert para que genere la ventana emergente -->
    <script src="Js/sweetAlert.js"></script>
    <!--9 Js de la librería tanto jquery y js de datatables-->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!--10 Configuración de datatable a travéz de su id y detalle de lenguaje en español-->
    <script src="Js/dataTables.js"></script>
    <script>
        const inputEstado = document.querySelector('#inputEstado');

        inputEstado.addEventListener('change', buscarPorEstado);

        function buscarPorEstado() {
            const valor = inputEstado.value.toLowerCase().trim();
            const filas = document.querySelectorAll('#example tbody tr');

            filas.forEach(fila => {
            const estado = fila.querySelector('td:nth-child(8)').textContent.toLowerCase();
                if (valor === '') {
                fila.style.display = ''; // Mostrar todas las filas si no se selecciona ninguna opción
                } else if (estado === valor) {
                fila.style.display = ''; // Mostrar filas que coincidan con el estado seleccionado
                } else {
                fila.style.display = 'none'; // Ocultar filas que no coincidan con el estado seleccionado
                }
            });
        }
    </script>
</body>
</html>

