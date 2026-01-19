<?php
    session_start();

        if (!isset($_SESSION['user_id'])) {
             header("Location: login.php");
            exit();
        }

    require 'conexion.php';
?>

<?php include 'includes/header.php'; ?>

<div class="container" style="max-width: 800px;">
    <div style="display: flex; justify-content: space-between; alingn-items: center;" >
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_usuario']); ?>!</h2>
        <a href="logout.php" style="color: #dc3545; text-decoration: none; font-weight: bold;">Cerrar sesión</a>
    </div>

    <p>
        Bienvenido a tu gestor de tareas personales.
    </p>
    <hr>

    <div class= "tareas-seccion">
        <h3>Tus tareas Pendientes</h3>
        <p style="color=#666; font-style= italic;">
        todavia no tenes tareas cargadas. ¡Pronto las agregaremos!
        </p>
        <button style="background=#4e73df;">+ Nueva Tarea </button>

    </div>
</div>

<?php include 'includes/footer.php'; ?>