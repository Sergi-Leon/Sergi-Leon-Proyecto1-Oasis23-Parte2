<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");
    exit();
}
include ("../proc/conexion.php");
$sqlReservas = "SELECT r.id_reserva2, r.nombre_reserva2, r.num_personas_reserva2, r.fecha_reserva2, r.hora_reserva2, m.nombre_mesa FROM tbl_reservas2 r INNER JOIN tbl_mesas m ON m.id_mesa = r.id_mesa_reserva2";
$stmtReservas = $conn->prepare($sqlReservas);
$stmtReservas -> execute();
$Reservas0 = $stmtReservas->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($Reservas0);

?>
