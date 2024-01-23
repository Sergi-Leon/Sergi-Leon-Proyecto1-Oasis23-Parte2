var tabla_usuarios = document.getElementById('tabla_reservas');

mostrarReservas('')

function mostrarReservas() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./ajax/mostrarReservas.php");
        xhr.onload = function() {
            var str = "";
            // console.log(xhr.responseText);
            //var miID = document.getElementById('id_camarero').textContent;
            if (xhr.status == 200) {
                var json = JSON.parse(xhr.responseText);
                // console.log(json);
                var tabla = "";
                // console.log(miID);
                json.forEach(function(item) {
                    str = "<tr>";
                        str += "<td>" + item.nombre_reserva2 + "</td>";
                        str += "<td>" + item.num_personas_reserva2 + "</td>";
                        str += "<td>" + item.fecha_reserva2 + "</td>";
                        str += "<td>" + item.hora_reserva2 + "</td>";
                        str += "<td>" + item.nombre_mesa + "</td>";
                        str += "</td>";
                        str += "</tr>";
                    tabla += str;
                });
            tabla_usuarios.innerHTML = tabla;
            document.getElementById('mostrarImagen').innerHTML = xhr.responseText;
        }
    }
    xhr.send();
}

function FormReserva() {

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

var btnSesion = document.getElementById("btnSesion");
btnSesion.addEventListener('click', function () {
    cerrarSesion = btnSesion.value;
    confirmarCerrarSesion(cerrarSesion);
});

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

var btnReserva = document.getElementById("btnReserva");
btnReserva.addEventListener('click', function () {
    btnReservar = btnReserva.value;
    confirmarAccion2(btnReservar);
});

function confirmarAccion2(accion2, mesaId2) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Quieres ' + accion2 + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, ' + accion2,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = './proc/reservar.php?mesa=' + mesaId2 + '&estado=' + (accion2 === 'Ocupar' ? 'Ocupada' : 'Libre');
        }
    });
}