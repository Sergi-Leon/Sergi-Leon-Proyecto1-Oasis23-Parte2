<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");
    exit();
}
include ("./conexion.php");

$sillas = $_POST['sillas_mesa'];
$id_mesa = $_POST['id_mesa'];

$queryUpdateSillas = "UPDATE tbl_mesas SET sillas_mesa = :silla_mesa WHERE id_mesa = :id_mesa";
    $stmtUpdateSillas = $conn->prepare($queryUpdateSillas);
    $stmtUpdateSillas->bindParam(":silla_mesa", $sillas);
    $stmtUpdateSillas->bindParam(":id_mesa", $id_mesa);
    $stmtUpdateSillas->execute();

