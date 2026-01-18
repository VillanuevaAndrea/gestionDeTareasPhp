<?php
session_start();

require 'conexion.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['usuario'];
    $pass= $_POST['password'];

    try{
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$u]);
        $usuario_encontrado = $stmt->fetch();

        if ($usuario_encontrado && password_verify($pass, $usuario_encontrado['password'])) {
            $_SESSION['user_id'] = $usuario_encontrado['id'];
            $_SESSION['user_usuario'] = $usuario_encontrado['usuario'];
            header("Location: index.php");
            exit();
        } else {
            $mensaje = "<p class='error'>Usuario o contraseña incorrectos.</p>";
        }
    } catch (PDOException $e) {
        error_log("Error de inicio de sesión: " . $e->getMessage());
        $mensaje = "<p class='error'>Error al iniciar sesión. Inténtelo de nuevo.</p>";
    }
}
?>
