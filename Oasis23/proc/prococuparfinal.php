<?php

$tipoSalaSeleccionado = $_GET['tipo_sala'] ?? '';

// Recuperar los datos del formulario
$mesaId = isset($_POST['mesa_id']) ? $_POST['mesa_id'] : null;
$estadoMesa = isset($_POST['estado_mesa']) ? $_POST['estado_mesa'] : null;
$horaFinal = isset($_POST['hora_final']) ? $_POST['hora_final'] : null;
$idCamarero = isset($_POST['id_camarero']) ? $_POST['id_camarero'] : null;

if (!$mesaId || !$estadoMesa || !$horaFinal) {
    echo "Error: No se proporcionaron todos los datos necesarios.";
} else {
    // Incluir archivo de conexión
    include 'conexion.php';

    // Iniciar la transacción
    $conn->beginTransaction();

    try {
        // Convertir la hora de finalización a formato de base de datos
        $horaFinalFormatoDB = date('Y-m-d H:i:s', strtotime($horaFinal));

        // Actualizar la mesa a estado libre
        $queryUpdateMesa = "UPDATE tbl_mesas SET estado_mesa = 'Libre' WHERE id_mesa = :mesaId";
        $stmtUpdateMesa = $conn->prepare($queryUpdateMesa);
        $stmtUpdateMesa->bindParam(":mesaId", $mesaId);
        $stmtUpdateMesa->execute();

        // Verificar si la actualización fue exitosa
        if ($stmtUpdateMesa->rowCount() > 0) {
            // Actualizar la hora final en la reserva
            $queryUpdateReserva = "UPDATE tbl_reservas SET hora_final_reserva = :horaFinalFormatoDB WHERE id_mesa_reserva = :mesaId AND hora_final_reserva IS NULL";
            $stmtUpdateReserva = $conn->prepare($queryUpdateReserva);
            $stmtUpdateReserva->bindParam(":horaFinalFormatoDB", $horaFinalFormatoDB);
            $stmtUpdateReserva->bindParam(":mesaId", $mesaId);
            $stmtUpdateReserva->execute();

            // Verificar si la actualización de la reserva fue exitosa
            if ($stmtUpdateReserva->rowCount() > 0) {
                // Confirmar la transacción
                $conn->commit();
                echo "Reserva finalizada con éxito.";
            } else {
                throw new Exception("Error al actualizar la hora final de la reserva: " . $stmtUpdateReserva->errorInfo()[2]);
            }
        } else {
            throw new Exception("Error al actualizar el estado de la mesa: " . $stmtUpdateMesa->errorInfo()[2]);
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollBack();
        echo "Error en la transacción: " . $e->getMessage();
    }
    // Cerrar la conexión
    $stmtUpdateMesa->closeCursor();
    $stmtUpdateReserva->closeCursor();
}

// Redireccionar a visualT1.php después de procesar la finalización de la reserva
header('Location: ../modovisual.php?tipo_sala=' . $tipoSalaSeleccionado);
exit(); // Asegurarse de que el script se detenga después de la redirección
?>
