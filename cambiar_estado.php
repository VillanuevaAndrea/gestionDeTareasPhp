<?php
session_start();
require 'conexion.php';

if (isset($_SESSION['user_id']) && isset($_GET['id']) && isset($_GET['estado'])) {
    $id_tarea = $_GET['id'];
    $nuevo_estado = $_GET['estado'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conexion->prepare("UPDATE tareas SET estado = ? WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$nuevo_estado, $id_tarea, $user_id]);
}

header("Location: index.php");
exit();