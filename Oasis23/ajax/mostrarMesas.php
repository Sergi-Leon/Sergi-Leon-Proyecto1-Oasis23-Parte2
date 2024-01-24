<?php
include("../proc/conexion.php");

$sqlMesas = "SELECT id_mesa, nombre_mesa FROM tbl_mesas";
$stmtMesas = $conn->prepare($sqlMesas);
$stmtMesas->execute();
$mesas = $stmtMesas->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($mesas);
?>
