<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oasis23</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <?php // FILTRO

    session_start();

    if (!isset($_SESSION["user"])) {
        header("location: ./login.php");
    }
    $username = $_SESSION['username'];

    echo "<script>
    // Este script se ejecutará cuando se cargue la página
    window.onload = function() {
        // Verificar si ya se ha mostrado el mensaje de bienvenida
        if (!localStorage.getItem('alertBienvenido')) {
            // Mostrar mensaje de bienvenida utilizando SweetAlert
            Swal.fire({
                title: 'Bienvenido $username',
                icon: 'success',
              });
            // Marcar que se ha mostrado el mensaje de bienvenida
            localStorage.setItem('alertBienvenido', 'true');
            }
        };
    </script>";

    if (empty($_POST["tipo-sala"])) {
        $_SESSION["tipo_sala"] = "%";
    } else {
        $_SESSION["tipo_sala"] = $_POST["tipo-sala"];
    }

    if (empty($_POST["sala"])) {
        $_SESSION["nombre_sala"] = "%";
    } else {
        $_SESSION["nombre_sala"] = $_POST["sala"];
    }

    if (empty($_POST["sillas"])) {
        $_SESSION["sillas_mesa"] = "%";
    } else {
        $_SESSION["sillas_mesa"] = $_POST["sillas"];
    }

    if (empty($_POST["estado"])) {
        $_SESSION["estado_mesa"] = "%";
    } else {
        $_SESSION["estado_mesa"] = $_POST["estado"];
    }

    
    include_once("proc/conexion.php");

    $sql0 = 'SELECT * FROM tbl_mesas INNER JOIN tbl_salas ON id_sala_mesa = id_sala';
    $stmt0 = mysqli_prepare($conn, $sql0);
    mysqli_stmt_execute($stmt0);
    $resultado0 = mysqli_stmt_get_result($stmt0);
    while ($fila0 = mysqli_fetch_assoc($resultado0)) {
        $sillas0[] = $fila0;
    }

    $sql = 'SELECT * FROM tbl_mesas INNER JOIN tbl_salas ON id_sala_mesa = id_sala WHERE nombre_sala LIKE ? AND tipo_sala LIKE ? AND sillas_mesa LIKE ? AND estado_mesa LIKE ?;';
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $_SESSION["nombre_sala"], $_SESSION["tipo_sala"], $_SESSION["sillas_mesa"], $_SESSION["estado_mesa"]);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $sillas[] = $fila;
    }

    mysqli_stmt_close($stmt);

    include("header.php");

    ?>

    <form name="formulario-filtros" method="post" action="">
        <div class="filtro-salas">
            <?php
                $tipo_salas_duplicadas = array();
                if (!empty($sillas0)) {
                    foreach ($sillas0 as $fila) {
                        $fila_tipo_sala = $fila["tipo_sala"];
                        
                        if (!isset($tipo_salas_duplicadas[$fila_tipo_sala])) {

                            echo '
                            <div>
                                <input type="radio" id="' . $fila_tipo_sala . '" name="tipo-sala" value="' . $fila_tipo_sala . '" onclick="submitForm()" ';
                        
                                if ($_SESSION["tipo_sala"] == $fila_tipo_sala) {
                                    echo 'checked';
                                }
                                
                                echo '>
                                <label for="' . $fila_tipo_sala . '">' . $fila_tipo_sala . '</label>
                            </div>
                            ';

                            $tipo_salas_duplicadas[$fila_tipo_sala] = true;
                        }
                        
                    }
                } else {
                    echo '
                    <div>
                        <input type="radio" id="tipo-sala" name="tipo-sala" value="tipo-sala" onclick="submitForm()">
                        <label for="tipo-sala">No hay salas disponibles</label>
                    </div>
                    ';
                }
            ?>
        </div>

        <div class="filtro-salas">
            <?php
                $salas_duplicadas = array();
                
                if (!empty($sillas0)) {
                    foreach ($sillas0 as $fila) {
                        $fila_nombre_sala = $fila["nombre_sala"];
                        
                        if (!isset($salas_duplicadas[$fila_nombre_sala])) {

                            echo '
                            <div>
                                <input type="radio" id="' . $fila_nombre_sala . '" name="sala" value="' . $fila_nombre_sala . '" onclick="submitForm()" ';
                        
                                if ($_SESSION["nombre_sala"] == $fila_nombre_sala) {
                                    echo 'checked';
                                }
                                
                                echo '>
                                <label for="' . $fila_nombre_sala . '">' . $fila_nombre_sala . '</label>
                            </div>
                            ';

                            $salas_duplicadas[$fila_nombre_sala] = true;
                        }
                        
                    }
                } else {
                    echo '
                    <div>
                        <input type="radio" id="tipo-sala" name="tipo-sala" value="tipo-sala" onclick="submitForm()">
                        <label for="tipo-sala">No hay salas disponibles</label>
                    </div>
                    ';
                }
            ?>
        </div>

        <div class="filtro-salas">
            <?php
                $sillas_duplicadas = array();
                
                if (!empty($sillas0)) {
                    foreach ($sillas0 as $fila) {
                        $fila_sillas_mesa = $fila["sillas_mesa"];
                        
                        if (!isset($sillas_duplicadas[$fila_sillas_mesa])) {

                            echo '
                            <div>
                                <input type="radio" id="silla-' . $fila_sillas_mesa . '" name="sillas" value="' . $fila_sillas_mesa . '" onclick="submitForm()" ';
                        
                                if ($_SESSION["sillas_mesa"] == $fila_sillas_mesa) {
                                    echo 'checked';
                                }
                                
                                echo '>
                                <label for="silla-' . $fila_sillas_mesa . '">' . $fila_sillas_mesa . ' SILLAS</label>
                            </div>
                            ';

                            $sillas_duplicadas[$fila_sillas_mesa] = true;
                        }
                    }
                } else {
                    echo '
                    <div>
                        <input type="radio" id="tipo-sala" name="tipo-sala" value="tipo-sala" onclick="submitForm()">
                        <label for="tipo-sala">No hay salas disponibles</label>
                    </div>
                    ';
                }
            ?>
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
                            <td>" . $fila_sillas_mesa . "</td>
                    ";
                        
                    if ($fila_estado_mesa == "Libre") {
                        echo "<td id='mesa_libre'><a href='#' onclick='confirmarAccion(\"Reservar\", " . $fila_id_mesa . ")'>Reservar</a></td>";
                    } else {
                        echo "<td id='mesa_ocupada'><a href='#' onclick='confirmarAccion(\"Cancelar Reserva\", " . $fila_id_mesa . ")'>Cancelar Reserva</a></td>";
                    }
                    
                    echo"</tr>";
                }
            } else {
                echo "<tr>
                <td>No hay mesas disponibles</td>
            </tr>";
            }
            ?>
            <script>
            function confirmarAccion(accion, mesaId) {
                // Muestra un cuadro de diálogo de confirmación
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres ' + accion + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, ' + accion,
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    // Si el usuario confirma, redirecciona a la siguiente página
                    if (result.isConfirmed) {
                        window.location.href = './proc/reservar.php?mesa=' + mesaId + '&estado=' + (accion === 'Reservar' ? 'Ocupada' : 'Libre');
                    }
                });
            }
            </script>

            </tbody>
        </table>

    </div>
</body>
</html>