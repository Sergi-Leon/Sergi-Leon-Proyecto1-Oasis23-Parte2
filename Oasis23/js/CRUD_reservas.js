var tabla_usuarios = document.getElementById('tabla_reservas');
var selectMesa = document.getElementById('mesaRese');

mostrarReservas('')
function mostrarReservas() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./ajax/mostrarReservas.php");
        xhr.onload = function() {
            var str = "";
            // console.log(xhr.responseText);
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
            mostrarMesas();
        }
    }
    xhr.send();
}

function mostrarMesas() {
    var xhr2 = new XMLHttpRequest();
    xhr2.open("POST", "./ajax/mostrarMesas.php");
    xhr2.onload = function() {
        if (xhr2.status == 200) {
            var json2 = JSON.parse(xhr2.responseText);
            // Limpiar opciones actuales en el elemento select
            selectMesa.innerHTML = '';
            // Agregar opciones de mesas al elemento select
            json2.forEach(function(mesa) {
                var option = document.createElement('option');
                option.value = mesa.id_mesa;
                option.text = mesa.nombre_mesa;
                selectMesa.add(option);
            });
        }
    }
    xhr2.send();
}

//Esto hay que meterlo en la funcion reserva para que cuando se haga la reserva se actualice la tabla
mostrarReservas('')

function FormReserva() {
    var nombreRese = document.getElementById("nombreRese").value;
    var numPersoRese = document.getElementById("numPersoRese").value;
    var fechaRese = document.getElementById("fechaRese").value;
    var horaRese = document.getElementById("horaRese").value;
    var mesaRese = document.getElementById("mesaRese").value;
    var formdata = new FormData();
    // Agrega los valores al FormData
    formdata.append("nombreRese", nombreRese);
    formdata.append("numPersoRese", numPersoRese);
    formdata.append("fechaRese", fechaRese);
    formdata.append("horaRese", horaRese);
    formdata.append("mesaRese", mesaRese);
    var xhr3 = new XMLHttpRequest();
    xhr3.open("POST", "./proc/procFormReserva.php");
    xhr3.onload = function() {
        // console.log(xhr.responseText);
        if (xhr3.status == 200) {
            var json = JSON.parse(xhr3.responseText);
            // console.log(json);
            mostrarReservas('');
        }
    }
    xhr3.send(formdata);
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

var btnReserva = document.getElementById("btnReserva");
btnReserva.addEventListener('click', function () {
    btnReservar = btnReserva.value;
    confirmarAccion2(btnReservar);
});

function confirmarAccion2(accion2) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Quieres ' + accion2 + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, ' + accion2,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = './proc/procFormReserva.php';
        }
    });
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