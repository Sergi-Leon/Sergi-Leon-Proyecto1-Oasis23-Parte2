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
    <br>
    <br>
    <br>
    <br>
    <br>
    <div>
        <div class="div-reserva">
            <form action="./proc/procFormReserva.php" method="post">
                <label for="nombreRese">Nombre: </label>
                <input type="text" name="nombreRese" id="nombreRese">
                <br>
                <label for="numPersoRese">Nº personas: </label>
                <input type="number" name="numPersoRese" id="numPersoRese">
                <br>
                <label for="fechaRese">Fecha: </label>
                <input type="date" name="fechaRese" id="fechaRese">
                <br>
                <label for="horaRese">Hora: </label>
                <input type="time" name="horaRese" id="horaRese">
                <br>
                <label for="mesaRese">Mesa: </label>
                <!-- Lista desplegable con todos los nombres de las mesas -->
                <select name="mesaRese" id="mesaRese"></select>
                <br>
                <input type="button" id="btnReserva" value="Reservar" onclick="FormReserva()">
            </form>
        </div>
        <div class="div-table">
            <table class="table table-striped">
                <thead>
                    <tr><th>Nombre</th><th>Numero Personas</th><th>Fecha</th><th>Hora</th><th>Mesa</th></tr>
                </thead>
                <tbody id="tabla_reservas">
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<script src="js/CRUD_reservas.js"></script>
<script>window.onload = mostrarReservas();</script>