<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");
    exit();
}
include("../proc/conexion.php");
$filtro="";
if($_POST["tiposala"]!="%"){
    $tiposala = $_POST["tiposala"];
    $filtro=" WHERE tipo_sala = :tipo_sala ";
}else{
    $_POST["sala"]="%";
}
if($_POST["sala"]!="%"){
    $sala = $_POST["sala"];
    if($filtro==""){
        $filtro="WHERE nombre_sala = :nombre_sala ";
    }else{
        $filtro =$filtro." AND nombre_sala= :nombre_sala";
    }
}else{
    $_POST["mesa"]="%";
}
if($_POST["mesa"]!="%"){
    $mesa = $_POST["mesa"];
    if($filtro==""){
        $filtro="WHERE nombre_mesa = :nombre_mesa ";
    }else{
        $filtro =$filtro." AND nombre_mesa= :nombre_mesa";
    }
}
if($_POST["estado"]!="%"){
    $estado = $_POST["estado"];
    if($filtro==""){
        $filtro="WHERE estado_mesa = :estado_mesa ";
    }else{
        $filtro =$filtro." AND estado_mesa= :estado_mesa";
    }
}
$sql = 'SELECT * FROM tbl_mesas INNER JOIN tbl_salas ON id_sala_mesa = id_sala ';
if($filtro!=""){
    $sql .=$filtro;
}
$stmt = $conn->prepare($sql);
if($_POST["tiposala"]!="%"){
    $stmt->bindParam(":tipo_sala", $tiposala);
}
if($_POST["sala"]!="%"){
    $stmt->bindParam(":nombre_sala", $sala);
}
if($_POST["mesa"]!="%"){
    $stmt->bindParam(":nombre_mesa", $mesa);
}
if($_POST["estado"]!="%"){
    $stmt->bindParam(":estado_mesa", $estado);
}
$stmt->execute();
$sillas = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (!$sillas == 0) {
    foreach ($sillas as $fila) {
        // Imprimir cada fila de la tabla
        echo '<tr>';
        echo '<td>' . $fila["tipo_sala"] . '</td>';
        echo '<td>' . $fila["nombre_sala"] . '</td>';
        echo '<td>' . $fila["nombre_mesa"] . '</td>';
        echo '<td>' . $fila["sillas_mesa"] . '</td>';
        echo '<td>' . $fila["estado_mesa"] . '</td>';
        $fila_id_mesa = $fila["id_mesa"];
        $fila_nombre_mesa = $fila["nombre_mesa"];
        $fila_sillas_mesa = $fila["sillas_mesa"];
        if ($fila["estado_mesa"] == "Libre") {
            echo "<script src='../js/ocupar.js'></script>";
            echo "<td><button id='btnOcuDesocu' class='mesa-libre' onclick='confirmarAccion(\"Ocupar\", " . $fila_id_mesa . ",1)'>Ocupar</button></td>";
        } else {
            echo "<td><button id='btnOcuDesocu' class='mesa-ocupada' onclick='confirmarAccion(\"Cancelar Ocupacion\", " . $fila_id_mesa . ",1)'>Cancelar Ocupacion</button></td>";
        }
        echo "<td><button id='btnModificar' class='mesa-modificada' onclick='modificarMesa(\"$fila_id_mesa\", \"$fila_sillas_mesa\")'>Modificar</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td>No hay mesas disponibles</td></tr>";
}

?>