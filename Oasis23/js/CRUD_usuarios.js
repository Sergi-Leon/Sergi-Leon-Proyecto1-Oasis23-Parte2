// Actualizar
var buscar = document.getElementById("buscar");
buscar.addEventListener("keyup", ()=>{
    var valor = buscar.value;
    if(valor ==""){
        mostrarUsuarios('');
    }else{
        mostrarUsuarios(valor);
    }
})

mostrarUsuarios('')
function mostrarUsuarios(valor) {
    var tabla_usuarios = document.getElementById('tabla_usuarios');
    if (tabla_usuarios) {

        var formdata = new FormData();
        formdata.append('busqueda', valor);

        var xhr = new XMLHttpRequest();

        xhr.open("POST", "./ajax/mostrarUsuario.php");

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
                        str += "<td>" + item.username_camarero + "</td>";
                        str += "<td>" + item.nombre_camarero + "</td>";
                        str += "<td>" + item.apellidos_camarero + "</td>";
                        str += "<td>" + item.correo_camarero + "</td>";
                        str += "<td>" + item.telefono_camarero + "</td>";
                        str += "<td>";
                        str += "<button onclick='formEditarUsuario(" + item.id_camarero + ", \"" + item.username_camarero + "\", \"" + item.nombre_camarero + "\", \"" + item.apellidos + "\", \"" + item.correo + "\", \"" + item.telefono + "\")' name='editar_user' class='btn btn-custom' style='background-color: #F88379; color: white; " + "transition: background-color 0.3s;'>" + "Editar</button>";
                        str += "</td>";
                        str += "<td>";
                        str += "<input id='eliminarUsuario' type='hidden' value='" + item.id_camarero + "'>";
                        str += "<button onclick='eliminarUsuario(" + item.id_camarero + ")' name='eliminar_user' class='btn btn-danger'>Eliminar</button>";
                        str += "</td>";
                        str += "</tr>";
                        tabla += str;
                });
                tabla_usuarios.innerHTML = tabla;
            }
        }
        xhr.send(formdata);
    } else {
        console.error("Elemento 'tabla_usuarios' no encontrado .");
    }
};

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