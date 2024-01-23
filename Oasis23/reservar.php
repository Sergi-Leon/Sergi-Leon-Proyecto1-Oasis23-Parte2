<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirigir a la página de inicio si no ha iniciado sesión
    exit();
}
?>

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
    $username = $_SESSION['username'];
    
    include_once("proc/conexion.php");
    include("header2.php");

    //Dependiendo de si vengo 
    if(isset($_GET["direccion"])){
        echo"<a href='index.php'>
            <img src='./img/botonvolver.png' alt='Volver' class='volver-button'>
        </a>";
    }else{
        echo"<a href='modovisual.php'>
        <img src='./img/botonvolver.png' alt='Volver' class='volver-button'>
        </a>"; 
    }
    ?>
    <form>
    </form>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="div-table">
        <table class="table table-striped">
            <thead>
                <tr><th>Nombre</th><th>Numero Personas</th><th>Fecha</th><th>Hora</th><th>Mesa</th></tr>
            </thead>
            <tbody id="tabla_reservas">
            </tbody>
        </table>
    </div>
</body>
</html>
<script src="js/CRUD_reservas.js"></script>
<script>window.onload = mostrarReservas();</script>