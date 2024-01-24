var btnOcuDesocu = document.getElementById("btnOcuDesocu");
btnOcuDesocu.addEventListener('click', function () {
    btnLibreOcupadoMesa = btnOcuDesocu.value;
    confirmarAccion(btnLibreOcupadoMesa);
});



function confirmarAccion(accion, mesaId, modo) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Quieres ' + accion + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, ' + accion,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = './proc/ocupar.php?mesa=' + mesaId + '&estado=' + (accion === 'Ocupar' ? 'Ocupada' : 'Libre')+'&modo='+modo;
        }
    });
}