function submitForm() {
    var formulario = document.forms["formulario-filtros"];
    var formData = new FormData(formulario);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../index.php", true);

    xhr.onload = function () {
        if (xhr.status == 200) {
            // Manejar la respuesta según sea necesario
            // Por ejemplo, si el servidor devuelve datos JSON, puedes procesarlos
            var response = JSON.parse(xhr.responseText);
            
            // Actualizar la parte de la página que desees
            var divTable = document.querySelector('.div-table');
            divTable.innerHTML = response;  // Suponiendo que la respuesta es el nuevo contenido HTML para '.div-table'
        }
    };

    xhr.send(formData);
}

function limpiarForm() {
    var formulario = document.forms["formulario-filtros"];
    formulario.reset();
    updateContent();
}

function toggleFilters() {
    var filtroSalas = document.querySelectorAll('.filtro-salas');
    for (var i = 0; i < filtroSalas.length; i++) {
        filtroSalas[i].style.display = (filtroSalas[i].style.display === 'flex') ? 'none' : 'flex';
    }
}

function confirmarCerrarSesion() {
    // Muestra un cuadro de diálogo de confirmación
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Quieres cerrar la sesión?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        // Si el usuario confirma, realiza una solicitud AJAX para cerrar sesión
        if (result.isConfirmed) {
            var xhrCerrarSesion = new XMLHttpRequest();
            xhrCerrarSesion.open("POST", './proc/cerrarsesion.php', true);
            xhrCerrarSesion.send();

            xhrCerrarSesion.onload = function () {
                if (xhrCerrarSesion.status == 200) {
                    // Puedes manejar la respuesta del servidor aquí si es necesario
                    window.location.href = './login.php'; // Redirige a la página de inicio de sesión
                }
            };
        }
    });
}
