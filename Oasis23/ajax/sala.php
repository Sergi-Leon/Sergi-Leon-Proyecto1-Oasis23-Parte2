<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");
}
include("../proc/conexion.php");
$tipoSala = $_POST['sala'];
$sql0 = 'SELECT nombre_sala FROM tbl_salas WHERE tipo_sala = :tipo_sala';
$stmt0 = $conn->prepare($sql0);
$stmt0->bindParam(":tipo_sala", $tipoSala);
$stmt0->execute();
$salas = $stmt0->fetchAll(PDO::FETCH_ASSOC);
$mesa = "<option value='%'>Todos</option>";

foreach ($salas as $fila) {
    $nombreSala = $fila["nombre_sala"];
    $mesa .= '<option value="' . $nombreSala . '">' . $nombreSala . '</option>';
}
echo json_encode($mesa);
?>
