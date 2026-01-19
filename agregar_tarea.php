<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['titulo'])) {
    
    $titulo = $_POST['titulo'];
    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $conexion->prepare("INSERT INTO tareas (usuario_id, titulo) VALUES (:u_id, :titulo)");
        
        $stmt->execute([
            ':u_id'   => $user_id,
            ':titulo' => $titulo
        ]);

        header("Location: index.php");
        exit();

    } catch (PDOException $e) {
        
        error_log("Error al insertar tarea: " . $e->getMessage());
        echo "Error al guardar la tarea.";
    }
} else {
    
    header("Location: index.php");
    exit();
}