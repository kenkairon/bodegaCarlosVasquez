function confirmarEliminacion(bodegaId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma la eliminación, redirige a la página de eliminación
            window.location.href = "Crud/eliminarBodega.php?id=" + bodegaId;
        }
    });
}