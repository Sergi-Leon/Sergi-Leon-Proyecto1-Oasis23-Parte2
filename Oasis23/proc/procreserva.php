<?php

$tipoSalaSeleccionado = $_GET['tipo_sala'] ?? '';

// Recuperar los datos del formulario
$mesaId = isset($_POST['mesa_id']) ? $_POST['mesa_id'] : null;
$estadoMesa = isset($_POST['estado_mesa']) ? $_POST['estado_mesa'] : null;
$horaInicio = isset($_POST['hora_inicio']) ? $_POST['hora_inicio'] : null;
$idCamarero = isset($_POST['id_camarero']) ? $_POST['id_camarero'] : null;

if (!$mesaId || !$estadoMesa || !$horaInicio || ($estadoMesa == 'Libre' && !$idCamarero)) {
    echo "Error: No se proporcionaron todos los datos necesarios.";
} else {
    // Incluir archivo de conexión
    include 'conexion.php';

    // Iniciar la transacción
    $conn->beginTransaction();

    try {
        // Convertir la hora de inicio a formato de base de datos
        $horaInicioFormatoDB = date('Y-m-d H:i:s', strtotime($horaInicio));

        // Actualizar la mesa a estado ocupada
        $queryUpdateMesa = "UPDATE tbl_mesas SET estado_mesa = 'Ocupada' WHERE id_mesa = :mesaId";
        $stmtUpdateMesa = $conn->prepare($queryUpdateMesa);
        $stmtUpdateMesa->bindParam(":mesaId", $mesaId);
        $stmtUpdateMesa->execute();

        // Verificar si la actualización fue exitosa
        if ($stmtUpdateMesa->rowCount() > 0) {
            // Insertar reserva en la base de datos
            $queryInsertReserva = "INSERT INTO tbl_reservas (hora_inicio_reserva, id_camarero_reserva, id_mesa_reserva) VALUES (:horaInicioFormatoDB, :idCamarero, :mesaId)";
            $stmtInsertReserva = $conn->prepare($queryInsertReserva);
            $stmtInsertReserva->bindParam(":horaInicioFormatoDB", $horaInicioFormatoDB);
            $stmtInsertReserva->bindParam(":idCamarero", $idCamarero);
            $stmtInsertReserva->bindParam(":mesaId", $mesaId);
            $stmtInsertReserva->execute();

            // Verificar si la inserción fue exitosa
            if ($stmtInsertReserva->rowCount() > 0) {
                // Confirmar la transacción
                $conn->commit();
                echo "Reserva procesada con éxito.";
            } else {
                throw new Exception("Error al insertar la reserva: " . $stmtInsertReserva->errorInfo()[2]);
            }
        } else {
            throw new Exception("Error al actualizar el estado de la mesa: " . $stmtUpdateMesa->errorInfo()[2]);
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollBack();
        echo "Error en la transacción: " . $e->getMessage();
    } finally {
        // Cerrar la conexión
        $stmtUpdateMesa->closeCursor();
        $stmtInsertReserva->closeCursor();
    }
}

// Redireccionar a visualT1.php después de procesar la reserva
header('Location: ../modovisual.php?tipo_sala=' . $tipoSalaSeleccionado);
exit(); // Asegurarse de que el script se detenga después de la redirección
?>
