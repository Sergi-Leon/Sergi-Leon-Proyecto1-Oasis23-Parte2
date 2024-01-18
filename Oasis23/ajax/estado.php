<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");
}
include("../proc/conexion.php");

$mesa = $_POST['estado'];
$sql0 = 'SELECT DISTINCT estado_mesa FROM tbl_mesas INNER JOIN tbl_salas ON id_sala_mesa = id_sala WHERE tipo_sala = :tipo_sala';
$stmt0 = $conn->prepare($sql0);
$stmt0->bindParam(":tipo_sala", $mesa);
$stmt0->execute();
$sillas0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
$estados = "<option value='%'>Todos</option>";

foreach ($sillas0 as $fila) {
    $mesasEstado = $fila["estado_mesa"];
    $estados .= '<option value="' . $mesasEstado . '">' . $mesasEstado . '</option>';
}

echo json_encode($estados);
?>
