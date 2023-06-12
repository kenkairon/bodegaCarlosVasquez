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