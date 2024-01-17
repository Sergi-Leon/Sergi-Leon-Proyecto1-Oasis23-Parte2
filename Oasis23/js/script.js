document.addEventListener("DOMContentLoaded", function () {
    var tiposala = document.getElementById("tiposala");
    console.log(tiposala);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/tiposala.php");
    xhr.onload = function () {
        if (xhr.status == 200) {
            tiposala.innerHTML = "";
            var json = JSON.parse(xhr.responseText);
            console.log(json);
            tiposala.innerHTML = json;
        }
    };
    xhr.send();

    tiposala.addEventListener('change', function () {
        saladato = tiposala.value;
        console.log(saladato);
        sala_mesa(saladato);
    });
});


function sala_mesa(valor) {
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
sala.addEventListener('change', ()=> {
    mesadato = sala.value;
    sala_mesa(mesadato)
})

mesa.addEventListener('change', ()=> {
    silladato = mesa.value;
    sala_mesa(silladato)
})

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
