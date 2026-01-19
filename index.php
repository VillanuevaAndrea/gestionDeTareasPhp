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
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Hola, <?php echo htmlspecialchars($_SESSION['user_usuario']); ?>!</h2>
        <a href="logout.php" style="color: #dc3545; text-decoration: none; font-weight: bold;">Cerrar sesión</a>
    </div>

    <p>Bienvenido a tu gestor de tareas personales.</p>
    <hr>

    <div class="tareas-seccion">
        <h3>Agregar Nueva Tarea</h3>
        <form action="agregar_tarea.php" method="POST" 
            style="display: flex; gap: 10px; margin-top: 15px; align-items: center; max-width: 100%;">
    
            <input type="text" name="titulo" placeholder="Ej: Leer libro..." required 
            style="flex: 4; padding: 10px 15px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; height: 40px; box-sizing: border-box;">
    
    <button type="submit" 
            style="width: auto; height: 40px; background: #5d78ff; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 14px; padding: 0 20px; box-sizing: border-box; display: flex; align-items: center; justify-content: center;">
        + Agregar
    </button>
</form>

        <hr>

        <h3>Tus tareas Pendientes</h3>
        <div id="lista-tareas">
            <p style="color: #666; font-style: italic;">
                Todavía no tienes tareas cargadas. ¡Prueba agregar una arriba!
            </p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>