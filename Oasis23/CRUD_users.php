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

    $sql0 = 'SELECT * FROM tbl_mesas INNER JOIN tbl_salas ON id_sala_mesa = id_sala';
    $stmt0 = $conn->query($sql0);
    $sillas0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);

    $sql = 'SELECT * FROM tbl_mesas INNER JOIN tbl_salas ON id_sala_mesa = id_sala WHERE nombre_sala LIKE :nombre_sala AND tipo_sala LIKE :tipo_sala AND sillas_mesa LIKE :sillas_mesa AND estado_mesa LIKE :estado_mesa;';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":nombre_sala", $_SESSION["nombre_sala"]);
    $stmt->bindParam(":tipo_sala", $_SESSION["tipo_sala"]);
    $stmt->bindParam(":sillas_mesa", $_SESSION["sillas_mesa"]);
    $stmt->bindParam(":estado_mesa", $_SESSION["estado_mesa"]);
    $stmt->execute();
    $sillas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include("header2.php");
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
            <label for="nombre">Nombre:</label>
            <select id="nombre" name="nombre">
                <option value="%">Todos</option>
            </select>
            <label for="apellidos">Apellidos:</label>
            <select id="apellidos" name="apellidos">
                <option value="%">Todas</option>
            </select>
            <label for="correo">Correo:</label>
            <select id="correo" name="correo">
                <option value="%">Todas</option>
            </select>
            <label for="telefono">Telefono:</label>
            <select id="telefono" name="telefono">
                <option value="%">Todas</option>
                <option value="Libre">Libre</option>
                <option value="Ocupada">Ocupada</option>
            </select>
        </div>

        <div class="filtro-salas2">
            <div class="filtro-salas filtro-medio">
                <div>
                    <a type="button" href="">Limpiar Filtros</a>
                </div>
            </div>
        </div>
    </form>

    <div class="div-table" id="tabla_resultados">
        <table class="table table-striped">
            <tbody>
            <script>
            function confirmarAccion(accion, mesaId) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres ' + accion + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, ' + accion,
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './proc/ocupar.php?mesa=' + mesaId + '&estado=' + (accion === 'Ocupar' ? 'Ocupada' : 'Libre');
                    }
                });
            }
            </script>

            </tbody>
        </table>
    </div>
</body>
</html>
<script src="js/script.js"></script>
<script>window.onload = mostrarTabla();</script>