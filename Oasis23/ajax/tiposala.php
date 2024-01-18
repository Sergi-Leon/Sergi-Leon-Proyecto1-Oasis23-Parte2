<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");
}
include ("../proc/conexion.php");
$sql0 = 'SELECT DISTINCT tipo_sala FROM tbl_salas';
$stmt0 = $conn->prepare($sql0);
$stmt0 -> execute();
$sillas0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
$sala = "<option value='%'>Todos</option>";
foreach ($sillas0 as $fila) {
    $tipoSala = $fila["tipo_sala"];
    $sala .= "<option value='$tipoSala'>$tipoSala</option>";
}
echo json_encode($sala);
