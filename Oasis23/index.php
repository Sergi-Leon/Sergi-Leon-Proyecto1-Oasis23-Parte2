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

    include("header.php");
    ?>

    <form name="formulario-filtros" method="post" action="">
        <div class="filtro-salas">
            <label for="tiposala">Tipo de Sala:</label>
            <select id="tiposala" name="tiposala">
                <option value="%">Todos</option>
            </select>
        </div>

            <div class="filtro-salas">
            <label for="sala">Sala:</label>
            <select id="sala" name="sala">
                <option value="%">Todas</option>
            </select>
        </div>

        <div class="filtro-salas">
            <label for="mesa">Mesa:</label>
            <select id="mesa" name="mesa">
                <option value="%">Todas</option>
            </select>
        </div>

        <div class="filtro-salas2">
            <div class="filtro-salas filtro-medio">
                <div>
                    <input type="radio" id="disponible" name="estado" value="Libre" onclick="submitForm()" 
                    
                    <?php  
                    if ($_SESSION["estado_mesa"] == "Libre") {
                        echo 'checked';
                    }
                    ?>
                    >
                    <label for="disponible">DISPONIBLE</label>
                </div>
                <div>
                    <input type="radio" id="ocupada" name="estado" value="Ocupada" onclick="submitForm()"
                    
                    <?php  
                    if ($_SESSION["estado_mesa"] == "Ocupada") {
                        echo 'checked';
                    }
                    ?>
                    >
                    <label for="ocupada">OCUPADA</label>
                </div>
                <div>
                    <a href="">Limpiar Filtros</a>
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
        </div>
    </form>

    <div class="div-table">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tipo Sala</th>
                    <th>Nombre Sala</th>
                    <th>Mesa</th>
                    <th>Sillas</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>

            <?php
            if (!empty($sillas)) {
                foreach ($sillas as $fila) {
                    $fila_id_mesa = $fila["id_mesa"];
                    $fila_tipo_sala = $fila["tipo_sala"];
                    $fila_nombre_sala = $fila["nombre_sala"];
                    $fila_nombre_mesa = $fila["nombre_mesa"];
                    $fila_sillas_mesa = $fila["sillas_mesa"];
                    $fila_estado_mesa = $fila["estado_mesa"];

                    echo "
                        <tr class='" . ($fila_id_mesa % 2 == 0 ? 'fila-par' : 'fila-impar') . "'>
                            <td>" . $fila_tipo_sala . "</td>
                            <td>" . $fila_nombre_sala . "</td>
                            <td>" . $fila_nombre_mesa . "</td>
                            <td>" . $fila_sillas_mesa . "</td>";
                        
                    if ($fila_estado_mesa == "Libre") {
                        echo "<td id='mesa_libre'><a href='#' onclick='confirmarAccion(\"Reservar\", " . $fila_id_mesa . ")'>Reservar</a></td>";
                    } else {
                        echo "<td id='mesa_ocupada'><a href='#' onclick='confirmarAccion(\"Cancelar Reserva\", " . $fila_id_mesa . ")'>Cancelar Reserva</a></td>";
                    }
                    
                    echo "</tr>";
                }
            } else {
                echo "<tr>
                <td>No hay mesas disponibles</td>
            </tr>";
            }
            ?>
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
                        window.location.href = './proc/ocupar.php?mesa=' + mesaId + '&estado=' + (accion === 'Reservar' ? 'Ocupada' : 'Libre');
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