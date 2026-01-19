<?php
session_start();

// 1. SEGURIDAD: Si no hay sesión, mandamos al login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'conexion.php';

$user_id = $_SESSION['user_id'];
$user_nombre = $_SESSION['user_usuario'];

try {
    $stmt = $conexion->prepare("SELECT * FROM tareas WHERE usuario_id = ? ORDER BY fecha_creacion DESC");
    $stmt->execute([$user_id]);
    $tareas = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Error al consultar tareas: " . $e->getMessage());
    $tareas = []; 
}
?>

<?php include 'includes/header.php'; ?>

<div class="container" style="max-width: 800px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #333;">Hola, <?php echo htmlspecialchars($user_nombre); ?>! 👋</h2>
        <a href="logout.php" style="color: #dc3545; text-decoration: none; font-weight: bold; font-size: 14px; padding: 8px 12px; border: 1px solid #dc3545; border-radius: 4px;">Cerrar sesión</a>
    </div>

    <p style="color: #666;">Bienvenido a tu gestor de tareas personales.</p>
    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

    <div class="tareas-seccion">
        <h3 style="margin-bottom: 15px; color: #444;">Agregar Nueva Tarea</h3>
        
        <form action="agregar_tarea.php" method="POST" style="display: flex; gap: 10px; align-items: center;">
            <input type="text" name="titulo" placeholder="Ej: Estudiar para el examen..." required 
                   style="flex: 4; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; height: 45px; box-sizing: border-box;">
            
            <button type="submit" 
                    style="flex: 1; height: 45px; background: #4e73df; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; white-space: nowrap; transition: background 0.3s;">
                + Agregar
            </button>
        </form>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

        <h3 style="margin-bottom: 15px; color: #444;">Tus tareas Pendientes</h3>
        
        <div id="lista-tareas">
            <?php if (count($tareas) > 0): ?>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach ($tareas as $t): ?>
                        <li style="background: #f8f9fc; border: 1px solid #e3e6f0; padding: 15px; margin-bottom: 10px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                            
                            <span style="font-size: 16px; color: #4e73df; font-weight: 500;">
                                <?php echo htmlspecialchars($t['titulo']); ?>
                            </span>
                            
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <span style="font-size: 12px; color: #858796; background: #eaecf4; padding: 4px 8px; border-radius: 4px;">
                                    <?php echo date('d/m H:i', strtotime($t['fecha_creacion'])); ?>
                                </span>
                                <a href="editar_tarea.php?id=<?php echo $t['id']; ?>" style="text-decoration: none; font-size: 18px;">✏️</a>
                                <a href="eliminar_tarea.php?id=<?php echo $t['id']; ?>" 
                                   style="color: #e74a3b; text-decoration: none; font-size: 18px;" 
                                   onclick="return confirm('¿Seguro quieres borrar esta tarea?')">🗑️</a>
                            </div>

                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div style="text-align: center; padding: 30px; background: #fdfdfd; border: 2px dashed #eee; border-radius: 8px;">
                    <p style="color: #999; font-style: italic; margin: 0;">
                        Todavía no tienes tareas cargadas. ¡Empezá agregando una arriba!
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>