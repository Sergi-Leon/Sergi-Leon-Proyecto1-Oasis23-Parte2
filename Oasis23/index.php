<?php
    session_start();
    $username = $_SESSION['username'];
    $cargo = $_SESSION['id_cargo'];
    if (!isset($_SESSION["user"])) {
        header("location: ./login.php");
        exit();
    }elseif ($cargo == 2) {
        header("location: ./modovisual.php");
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
    echo "<script>
        window.onload = function() {
            if (!localStorage.getItem('alertBienvenido')) {
                Swal.fire({
                    title: 'Bienvenido $username',
                    icon: 'success',
                });
                localStorage.setItem('alertBienvenido', 'true');
            }
        };
    </script>";

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

    //ID del usuario
    $id = $_SESSION['user'];
    $sqlUser = 'SELECT * FROM tbl_camareros WHERE id_camarero = :id_camarero;';
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->execute();
    $users = $stmtUser->fetchAll(PDO::FETCH_ASSOC);

    include("header.php");
    ?>
    <p id='id_user' style='display: none;'><?php echo $_SESSION['user']; ?></p>
    <form name="formulario-filtros" method="post" action="">
        <div class="filtro-salas">
            <label for="tiposala">Tipo de Sala:</label>
            <select id="tiposala" name="tiposala">
                <option value="%">Todos</option>
            </select>
            <label for="sala">Sala:</label>
            <select id="sala" name="sala">
                <option value="%">Todas</option>
            </select>
            <label for="mesa">Mesa:</label>
            <select id="mesa" name="mesa">
                <option value="%">Todas</option>
            </select>
            <label for="estado">Estado:</label>
            <select id="estado" name="estado">
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
            <div class="filtro-salas filtro-medio">
                <div class="filtro-visual">
                <a
                    <?php if ($_SESSION["tipo_sala"] == "%") {
                        echo "style='pointer-events:none;'";
                    } ?>
                    href='modovisual.php?tipo_sala=<?php echo $_SESSION["tipo_sala"] ?>'>Ver Mesas</a>
                </div>
            </div>
            <div class="filtro-salas filtro-medio">
                <div>
                    <a type="button" href="./CRUD_users.php">Gestionar usuarios</a>
                </div>
            </div>
            <div class="filtro-salas filtro-medio">
                <div>
                    <a type="button" href="./reservar.php?direccion=1">Reservar</a>
                </div>
            </div>
        </div>
    </form>

    <div class="div-table">
        <table class="table table-striped">
            <thead>
                <tr><th>Tipo Sala</th><th>Nombre Sala</th><th>Mesa</th><th>Sillas</th><th>Estado</th><th>Ocupar</th><th>Modificar</th></tr>
            </thead>
            <tbody id="tabla_resultados">
            </tbody>
        </table>
    </div>
</body>
</html>
<script src="js/script.js"></script>
<script>window.onload = mostrarTabla();</script>
<script src="js/ocupar.js"></script>