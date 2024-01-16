<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header('Location: ./login.php'); // Redirigir a la página de inicio si no ha iniciado sesión
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Reserva</title>
    <link rel="stylesheet" type="text/css" href="./css/formreserva.css">
</head>
<body>
<div class="box">
<?php
// Recuperar los parámetros de la URL
$mesaId = isset($_GET['mesa_id']) ? $_GET['mesa_id'] : null;
$estadoMesa = isset($_GET['estado_mesa']) ? $_GET['estado_mesa'] : null;
$tipoSala = isset($_GET['tipo_sala']) ? $_GET['tipo_sala'] : ''; // Modificado
$idCamarero = isset($_SESSION['user']) ? $_SESSION['user'] : ''; // Modificado

if (!$mesaId || !$estadoMesa || !$tipoSala || !$idCamarero) {
    echo "Error: No se proporcionaron todos los parámetros necesarios.";
} else {
    // Incluir archivo de conexión
    include './proc/conexion.php';

    try {
        // Obtener información de la mesa
        $queryMesa = $conn->prepare("SELECT nombre_mesa FROM tbl_mesas WHERE id_mesa = :mesaId");
        $queryMesa->bindParam(":mesaId", $mesaId);
        $queryMesa->execute();
        $rowMesa = $queryMesa->fetch(PDO::FETCH_ASSOC);

        if ($rowMesa) {
            $nombreMesa = $rowMesa['nombre_mesa'];

            // Obtener el nombre del camarero
            $queryCamarero = $conn->prepare("SELECT nombre_camarero FROM tbl_camareros WHERE id_camarero = :idCamarero");
            $queryCamarero->bindParam(":idCamarero", $idCamarero);
            $queryCamarero->execute();
            $rowCamarero = $queryCamarero->fetch(PDO::FETCH_ASSOC);

            if ($rowCamarero) {
                $nombreCamarero = $rowCamarero['nombre_camarero'];

                // Obtener la hora actual
                $horaInicio = date('Y-m-d\TH:i:s');

                // Mostrar el formulario de reserva
                echo "<h3>Reservar Mesa $nombreMesa</h3>";

                // Si el estado de la mesa es libre, mostrar el formulario estándar
                if ($estadoMesa == 'Libre') {
                    echo "<form action='./proc/prococupar.php?tipo_sala=$tipoSala' method='post'>";
                    echo "<input type='hidden' name='mesa_id' value='$mesaId'>";
                    echo "<input type='hidden' name='estado_mesa' value='$estadoMesa'>";
                    echo "<input type='hidden' name='tipo_sala' value='$tipoSala'>"; // Modificado
                    echo "<input type='hidden' name='id_camarero' value='$idCamarero'>"; // Modificado
                    echo "<h1>Hora de inicio:</h1> <input type='datetime-local' name='hora_inicio' value='$horaInicio' required><br>";
                    echo "<h1>Nombre del camarero:<h1> <input type='text' name='nombre_camarero' value='$nombreCamarero' readonly><br>"; // Modificado
                    echo "<input type='submit' value='Reservar'>";
                    echo "</form>";
                    echo "<form action='./modovisual.php?tipo_sala=$tipoSala' method='post'>";
                    echo "<input type='submit' value='Volver'>";
                    echo "</form>";
                } else { // Si el estado de la mesa es ocupada, mostrar formulario diferente
                    echo "<p>La mesa está ocupada actualmente. ¿Deseas finalizar la reserva?</p>";
                    echo "<form action='./proc/prococuparfinal.php?tipo_sala=$tipoSala' method='post'>";
                    echo "<input type='hidden' name='mesa_id' value='$mesaId'>";
                    echo "<input type='hidden' name='estado_mesa' value='$estadoMesa'>";
                    echo "<input type='hidden' name='tipo_sala' value='$tipoSala'>"; // Modificado
                    echo "<input type='hidden' name='id_camarero' value='$idCamarero'>"; // Modificado
                    echo "<h1>Hora de finalización:</h1> <input type='datetime-local' name='hora_final' value='$horaInicio' required><br>";
                    echo "<input type='submit' value='Finalizar Reserva'>";
                    echo "</form>";
                    echo "<form action='./modovisual.php?tipo_sala=$tipoSala' method='post'>";
                    echo "<input type='submit' value='Volver'>";
                    echo "</form>";
                }
            } else {
                echo "No se encontró información del camarero.";
            }
        } else {
            echo "No se encontró información de la mesa.";
        }
    } catch (PDOException $e) {
        // Manejar errores de PDO
        echo "Error: " . $e->getMessage();
    }
    // Cerrar la conexión
    $conn = null;
}
?>
</div>
</body>
</html>
