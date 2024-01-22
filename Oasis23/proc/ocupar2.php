<?php

session_start();

if (!isset($_SESSION["user"]) || !isset($_GET["mesa"]) || !isset($_GET["estado"])) {
    header("Location: ../index.php");
}

$id_camarero = $_SESSION["user"];
$id_mesa = $_GET["mesa"];
$estado_mesa = $_GET["estado"];

include_once("conexion.php");

try {
    $conn->beginTransaction();

    $sql = 'UPDATE tbl_mesas SET estado_mesa = :estado_mesa WHERE id_mesa = :id_mesa;';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":estado_mesa", $estado_mesa);
    $stmt->bindParam(":id_mesa", $id_mesa);
    $stmt->execute();

    if ($estado_mesa == "Ocupada") {
        $horaInicio = date('Y-m-d\TH:i:s');

        $sql2 = 'INSERT INTO tbl_reservas (hora_inicio_reserva, hora_final_reserva, id_camarero_reserva, id_mesa_reserva)
        VALUES (:horaInicio, NULL, :id_camarero, :id_mesa);';
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(":horaInicio", $horaInicio);
        $stmt2->bindParam(":id_camarero", $id_camarero);
        $stmt2->bindParam(":id_mesa", $id_mesa);
        $stmt2->execute();
    } else {
        $horaFinal = date('Y-m-d\TH:i:s');

        $sql2 = 'UPDATE tbl_reservas INNER JOIN tbl_mesas ON id_mesa = id_mesa_reserva 
        SET hora_final_reserva = :horaFinal WHERE id_mesa = :id_mesa AND estado_mesa = "Libre";';
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(":horaFinal", $horaFinal);
        $stmt2->bindParam(":id_mesa", $id_mesa);
        $stmt2->execute();
    }

    $conn->commit();
    
    $stmt->closeCursor();
    $stmt2->closeCursor();

    header("Location: ../modovisual.php");

} catch (PDOException $e) {
    $conn->rollBack();
    echo $e->getMessage();
    die();
}
?>
