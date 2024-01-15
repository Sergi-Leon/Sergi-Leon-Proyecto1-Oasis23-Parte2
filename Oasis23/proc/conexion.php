<?php
$dbserver = "mysql:dbname=db_Oasis23;host=localhost";
$dbuser = "root";
$dbpwd = "";

try {
   $conn = new PDO($dbserver, $dbuser, $dbpwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
   echo "conexion fallida" .$e->getMessage();
}
?>
