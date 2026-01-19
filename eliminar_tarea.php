<?php
session_start();
require 'conexion.php';


if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $id_tarea = $_GET['id'];
    $id_usuario = $_SESSION['user_id'];

    try {
        $stmt = $conexion->prepare("DELETE FROM tareas WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$id_tarea, $id_usuario]);
    } catch (PDOException $e) {
        error_log("Error al eliminar: " . $e->getMessage());
    }
}

header("Location: index.php");
exit();