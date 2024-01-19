var tiposala = document.getElementById("tiposala");
var xhr = new XMLHttpRequest();
xhr.open("POST", "./ajax/tiposala.php");
xhr.onload = function () {
    if (xhr.status == 200) {
        tiposala.innerHTML = "";
        var json = JSON.parse(xhr.responseText);
        tiposala.innerHTML = json;
    }
};
xhr.send();
tiposala.addEventListener('change', function () {
    saladato = tiposala.value;
    sala(saladato);
    mostrarTabla();
    mostrarTabla2();
});
var salas = document.getElementById('sala');
var mesas = document.getElementById('mesa');
var estados = document.getElementById('estado');

salas.addEventListener('change',function (){ 
    mostrarTabla();
    mostrarTabla2();
    mesa(salas.value)
});
mesas.addEventListener('change', mostrarTabla);
estados.addEventListener('change', mostrarTabla);
mesas.addEventListener('change', mostrarTabla2);
estados.addEventListener('change', mostrarTabla2);

function sala(valor) {
    var sala = document.getElementById("sala");
    var xhr = new XMLHttpRequest();
    var formdata = new FormData();
    formdata.append('sala', valor);
    xhr.open("POST", "./ajax/sala.php");
    xhr.onload = function () {
        if (xhr.status == 200) {
            sala.innerHTML = "";
            var json = JSON.parse(xhr.responseText);
            sala.innerHTML = json;
        }
    };
    xhr.send(formdata);
}
function mesa(valor) {
    var mesa = document.getElementById("mesa");
    var xhr2 = new XMLHttpRequest();
    var formdata2 = new FormData();
    formdata2.append('mesa', valor);
    xhr2.open("POST", "./ajax/mesa.php");
    xhr2.onload = function () {
        if (xhr2.status == 200) {
            mesa.innerHTML = "";
            var json2 = JSON.parse(xhr2.responseText);
            mesa.innerHTML = json2;
        }
    };
    xhr2.send(formdata2);
}
function estado(valor) {
    var estado = document.getElementById("estado");
    var xhr3 = new XMLHttpRequest();
    var formdata3 = new FormData();
    formdata3.append('estado', valor);
    xhr3.open("POST", "./ajax/estado.php");
    xhr3.onload = function () {
        if (xhr3.status == 200) {
            estado.innerHTML = "";
            var json3 = JSON.parse(xhr3.responseText);
            estado.innerHTML = json3;
        }
    };
    xhr3.send(formdata3);
}
function mostrarTabla() {
    var tiposala = document.getElementById('tiposala').value;
    var sala = document.getElementById('sala').value;
    var mesa = document.getElementById('mesa').value;
    var estado = document.getElementById('estado').value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/mostrarDatos.php");

    // Configurar la función de devolución de llamada para manejar la respuesta
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Actualizar el contenido de la tabla con la respuesta del servidor
            document.getElementById('tabla_resultados').innerHTML = xhr.responseText;
        }
    };

    // Enviar los datos de los filtros al servidor
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("tiposala=" + tiposala + "&sala=" + sala + "&mesa=" + mesa + "&estado=" + estado);
}

function mostrarTabla2() {
    var tiposala = document.getElementById('tiposala').value;
    var sala = document.getElementById('sala').value;
    var mesa = document.getElementById('mesa').value;
    var estado = document.getElementById('estado').value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/mostrarDatos2.php");

    // Configurar la función de devolución de llamada para manejar la respuesta
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Actualizar el contenido de la tabla con la respuesta del servidor
            document.getElementById('tabla_resultados2').innerHTML = xhr.responseText;
        }
    };

    // Enviar los datos de los filtros al servidor
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("tiposala=" + tiposala + "&sala=" + sala + "&mesa=" + mesa + "&estado=" + estado);
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
