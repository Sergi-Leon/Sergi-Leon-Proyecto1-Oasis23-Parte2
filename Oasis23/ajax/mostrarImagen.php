<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/modovisual.css">
    <title>Document</title>
</head>
<body>
    
<?php
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
        // Obtener la ruta de la imagen de la mesa (reemplázala con tu lógica)
        $imagen_mesa = "./img/mesas/mesa6.png";
        // Imprimir la etiqueta de contenedor
        echo '<div class="mesa-item">';
        // Imprimir el nombre de la mesa
        echo '<p class="nombre-mesa">' . $fila["nombre_mesa"] . '</p>';
        // Imprimir la etiqueta de imagen
        echo '<img src="' . $imagen_mesa . '" alt="Mesa ' . $fila["nombre_mesa"] . '" class="mesa-imagen" width="100" height="100">';
        $fila_id_mesa = $fila["id_mesa"];
        // Imprimir el botón dentro del contenedor
        echo '<div class="boton-ocupar">';
        if ($fila["estado_mesa"] == "Libre") {
            echo "<button id='mesa_libre' class='mesa-libre' onclick='confirmarAccion(\"Ocupar\", " . $fila_id_mesa . ")'>Ocupar</button>";
        } else {
            echo "<button id='mesa_ocupada' class='mesa-ocupada' onclick='confirmarAccion(\"Cancelar Ocupacion\", " . $fila_id_mesa . ")'>Cancelar Ocupacion</button>";
        }
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No hay mesas disponibles";
}

?>
</body>
</html>