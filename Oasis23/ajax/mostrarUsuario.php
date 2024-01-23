<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");
    exit();
}
include ("../proc/conexion.php");
$sqlUsers = "SELECT id_camarero, username_camarero, nombre_camarero, apellidos_camarero, correo_camarero, telefono_camarero FROM tbl_camareros";
$stmtUsers = $conn->prepare($sqlUsers);
$stmtUsers -> execute();
$Users0 = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($Users0);
?>
