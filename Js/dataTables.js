$(document).ready(function() {
    $('#example').DataTable( {
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por página",
            "zeroRecords": "Ningún Registro Encontrado en la Tabla",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No Hay Registros Disponibles",
            "infoFiltered": "(fitrado de _MAX_ Registros Totales)",
            'search':'Buscar:',
            'paginate':{
                'next':'Siguiente',
                'previous':'Anterior'
            }
        }
    } );
} )