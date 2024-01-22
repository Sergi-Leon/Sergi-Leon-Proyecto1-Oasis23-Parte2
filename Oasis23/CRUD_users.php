<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oasis23</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("location: ./login.php");
    }
    $username = $_SESSION['username'];
    
    include_once("proc/conexion.php");
    include("header.php");
    ?>
    <form>
    <a href='index.php'>
        <img src='./img/botonvolver.png' alt='Volver' class='volver-button'>
    </a>
    </form>
    <br>
    <br>
    <br>
    <br>
    <br>
    <form name="formulario-filtros" method="post" action="">
        <div class="filtro-salas">
            <label for="buscar">Buscar:</label>
            <input type="text" name="buscar" id="buscar">
        </div>

        <div class="filtro-salas2">
            <div class="filtro-salas filtro-medio">
                <div>
                    <a type="button" href="">Limpiar Filtros</a>
                </div>
            </div>
        </div>
    </form>

    <div class="div-table">
        <table class="table table-striped">
            <thead>
                <tr><th>Username</th><th>Nombre</th><th>Apellidos</th><th>Correo</th><th>Telefono</th><th>Editar</th><th>Eliminar</th></tr>
            </thead>
            <tbody id="tabla_usuarios">
            </tbody>
        </table>
    </div>
</body>
</html>
<script src="js/CRUD_usuarios.js"></script>
<script>window.onload = mostrarUsuarios();</script>