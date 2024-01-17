<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");
}
include("../proc/conexion.php");

$sala = $_POST['mesa'];
$sql0 = 'SELECT nombre_mesa FROM tbl_mesas INNER JOIN tbl_salas ON id_sala_mesa = id_sala WHERE tipo_sala = :tipo_sala';
$stmt0 = $conn->prepare($sql0);
$stmt0->bindParam(":tipo_sala", $sala);
$stmt0->execute();
$sillas0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
$sillas = "<option value='%'>Todos</option>";

foreach ($sillas0 as $fila) {
    $sillasMesa = $fila["nombre_mesa"];
    $sillas .= '<option value="' . $sillasMesa . '">' . $sillasMesa . '</option>';
}

echo json_encode($sillas);
?>
