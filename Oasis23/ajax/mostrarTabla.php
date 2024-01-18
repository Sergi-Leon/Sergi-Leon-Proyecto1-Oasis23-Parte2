<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");
}
include("../proc/conexion.php");

// Recoger los valores de los filtros
$tipoSala = $_POST['tiposala'];
echo "<script>console.log($tipoSala)</script>;";
$sala = $_POST['sala'];
$mesa = $_POST['mesa'];
$estado = $_POST['estado'];

// Construir y ejecutar la consulta SQL según los filtros seleccionados
$sql = 'SELECT * FROM tbl_mesas 
        INNER JOIN tbl_salas ON id_sala_mesa = id_sala 
        WHERE tipo_sala LIKE :tipo_sala AND nombre_sala LIKE :nombre_sala AND nombre_mesa LIKE :nombre_mesa AND estado_mesa LIKE :estado_mesa';
$stmt = $conn->prepare($sql);
$stmt->bindParam(":tipo_sala", $tipoSala);
$stmt->bindParam(":nombre_sala", $sala);
$stmt->bindParam(":nombre_mesa", $mesa);
$stmt->bindParam(":estado_mesa", $estado);
$stmt->execute();
$sillas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Aquí deberías imprimir el HTML de la tabla con los datos obtenidos
// Puedes usar un bucle para recorrer $sillas y mostrar cada fila

echo '<table>';
echo '<thead>';
echo '<tr><th>Tipo Sala</th><th>Nombre Sala</th><th>Mesa</th><th>Sillas</th><th>Estado</th></tr>';
echo '</thead>';
echo '<tbody>';

foreach ($sillas as $fila) {
    // Imprimir cada fila de la tabla
    echo '<tr>';
    echo '<td>' . $fila["tipo_sala"] . '</td>';
    echo '<td>' . $fila["nombre_sala"] . '</td>';
    echo '<td>' . $fila["nombre_mesa"] . '</td>';
    echo '<td>' . $fila["sillas_mesa"] . '</td>';
    echo '<td>' . $fila["estado_mesa"] . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
?>
