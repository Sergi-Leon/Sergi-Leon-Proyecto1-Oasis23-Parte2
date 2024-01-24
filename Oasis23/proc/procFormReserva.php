<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");
    exit();
}
include ("./conexion.php");

try {
    $nombreRese = $_POST['nombreRese'];
    $numPersoRese = $_POST['numPersoRese'];
    $fechaRese = $_POST['fechaRese'];
    $horaRese = $_POST['horaRese'];
    $id_mesa_reserva2 = $_POST['mesaRese'];
    

    $sqlReservas2 = "SELECT r.id_reserva2, r.nombre_reserva2, r.num_personas_reserva2, r.fecha_reserva2, r.hora_reserva2, m.nombre_mesa FROM tbl_reservas2 r INNER JOIN tbl_mesas m ON m.id_mesa = r.id_mesa_reserva2";
    $stmtReservas2 = $conn->prepare($sqlReservas2);
    $stmtReservas2 -> execute();
    $Reservas2 = $stmtReservas2->fetch(PDO::FETCH_ASSOC);

    if ($Reservas2) {
        $sqlInsertReserva = "INSERT INTO tbl_reservas2 (nombre_reserva2, num_personas_reserva2, fecha_reserva2, hora_reserva2, id_mesa_reserva2) 
        VALUES (:nombreRese, :numPersoRese, :fechaRese, :horaRese, :mesaRese)";
        $stmtInsertReserva = $conn->prepare($sqlInsertReserva);
        $stmtInsertReserva->bindParam(":nombreRese", $nombreRese);
        $stmtInsertReserva->bindParam(":numPersoRese", $numPersoRese);
        $stmtInsertReserva->bindParam(":fechaRese", $fechaRese);
        $stmtInsertReserva->bindParam(":horaRese", $horaRese);
        $stmtInsertReserva->bindParam(":mesaRese", $id_mesa_reserva2);
        $stmtInsertReserva->execute();
    }
    else {
        echo "No se encontró información de la reserva.";
    }
    
    $stmtReservas2->closeCursor();
    $stmtInsertReserva->closeCursor();
} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}
?>