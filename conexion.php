<?php
$host = "localhost";
$db = "todo_list";
$usuario = "root";
$password = "";
$charser = "utf8mb4";

$dsn = "mysql:host=$host; dbname=$db;charset=$charser"; 

try {
    $conexion = new PDO($dsn, $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die ("Error de conexión: " . $e->getMessage());
}
?>
