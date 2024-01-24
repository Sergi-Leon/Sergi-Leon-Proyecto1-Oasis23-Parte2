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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
    <div class="container">
        <div>
        <div class="div-reserva2 card">
            <form id="formReserva" action="" method="post">
            <div class="form-group">
                <label for="nombreRese">Nombre: </label>
                <input type="text" name="nombreRese" id="nombreRese" class="form-control">
            </div>
            <div class="form-group">
                <label for="numPersoRese">Nº personas: </label>
                <input type="number" name="numPersoRese" id="numPersoRese" class="form-control">
            </div>
            <div class="form-group">
                <label for="fechaRese">Fecha: </label>
                <input type="date" name="fechaRese" id="fechaRese" class="form-control">
            </div>
            <div class="form-group">
                <label for="horaRese">Hora: </label>
                <input type="time" name="horaRese" id="horaRese" class="form-control">
            </div>
            <div class="form-group">
                <label for="mesaRese">Mesa: </label>
                <!-- Lista desplegable con todos los nombres de las mesas -->
                <select name="mesaRese" id="mesaRese" class="form-control"></select>
            </div>
            <div class="form-group">
                <input type="button" id="btnReserva" value="Reservar" class="form-control">
            </div>
            </form>
        </div>
        </div>
        
        <div class="div-table2">
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