<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['titulo'])) {
    $titulo = trim($_POST['titulo']); 
    $prioridad = (int)$_POST['prioridad']; 
    $user_id = $_SESSION['user_id'];
    $estado_inicial = 0; 

    if (!empty($titulo)) {
        try {
            $stmt = $conexion->prepare("INSERT INTO tareas (usuario_id, titulo, prioridad, estado, fecha_creacion) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$user_id, $titulo, $prioridad, $estado_inicial]);
        } catch (PDOException $e) {
            error_log("Error al insertar tarea: " . $e->getMessage());
        }
    }
}

header("Location: index.php");
exit();
?>