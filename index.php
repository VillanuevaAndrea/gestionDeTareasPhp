<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'conexion.php';
$user_id = $_SESSION['user_id'];
$user_nombre = $_SESSION['user_usuario'];

$nombres_estado = [0 => 'Pendiente', 1 => 'En Proceso', 2 => 'Completada'];
$iconos_estado = [0 => 'fa-circle', 1 => 'fa-spinner fa-spin', 2 => 'fa-check-circle'];
$colores_prioridad = [1 => '#5acc61', 2 => '#f6c23e', 3 => '#e74a3b'];
$nombres_prio = [1 => 'Baja', 2 => 'Media', 3 => 'Alta'];

try {
    $stmt = $conexion->prepare("SELECT * FROM tareas WHERE usuario_id = ? ORDER BY prioridad DESC, fecha_creacion DESC");
    $stmt->execute([$user_id]);
    $tareas = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
    $tareas = []; 
}

include 'includes/header.php'; 
?>

<div class="container" style="max-width: 800px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #333; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-user-circle" style="color: #4e73df;"></i> 
            Hola, <?php echo htmlspecialchars($user_nombre); ?>!
        </h2>
        <a href="logout.php" style="color: #dc3545; text-decoration: none; font-weight: bold; font-size: 14px; padding: 8px 12px; border: 1px solid #dc3545; border-radius: 4px;">Cerrar sesión</a>
    </div>

    <p style="color: #666;">Bienvenido a tu gestor de tareas personales.</p>
    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

    <div class="tareas-seccion">
        <h3 style="margin-bottom: 15px; color: #444;">Agregar Nueva Tarea</h3>
        
        <form action="agregar_tarea.php" method="POST" style="display: flex; gap: 10px; align-items: center;">
            <input type="text" name="titulo" placeholder="Ej: Estudiar para el examen..." required 
                   style="flex: 3; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; height: 45px; box-sizing: border-box;">
            
            <select name="prioridad" style="flex: 1; height: 45px; border: 1px solid #ddd; border-radius: 4px; padding: 0 10px; background: white;">
                <option value="1">Baja</option>
                <option value="2" selected>Media</option>
                <option value="3">Alta</option>
            </select>

            <button type="submit" style="flex: 1; height: 45px; background: #4e73df; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                <i class="fas fa-plus"></i> Agregar
            </button>
        </form>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

        <h3 style="margin-bottom: 15px; color: #444;">Mis Tareas</h3>
        
        <div id="lista-tareas">
            <?php if (count($tareas) > 0): ?>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach ($tareas as $t): ?>
                        <?php 
                            
                            $p_val = $t['prioridad'];
                            if ($p_val === 'baja') $p_id = 1;
                            elseif ($p_val === 'media') $p_id = 2;
                            elseif ($p_val === 'alta') $p_id = 3;
                            else $p_id = (int)$p_val;

                            $e_id = (int)($t['estado'] ?? 0); 
                        ?>
                        <li style="background: #fff; border: 1px solid #e3e6f0; border-left: 8px solid <?php echo $colores_prioridad[$p_id] ?? '#ccc'; ?>; padding: 15px; margin-bottom: 10px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                            
                            <div>
                                <span style="font-size: 16px; color: #333; font-weight: 500; <?php echo ($e_id == 2) ? 'text-decoration: line-through; color: #858796;' : ''; ?>">
                                    <?php echo htmlspecialchars($t['titulo']); ?>
                                </span>
                                <br>
                                <small style="color: #858796;">
                                    Prioridad: <strong><?php echo $nombres_prio[$p_id] ?? 'N/A'; ?></strong> | 
                                    Estado: <strong><?php echo $nombres_estado[$e_id] ?? 'Pendiente'; ?></strong>
                                </small>
                            </div>
                            
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <?php $prox_estado = ($e_id + 1) % 3; ?>
                                <a href="cambiar_estado.php?id=<?php echo $t['id']; ?>&estado=<?php echo $prox_estado; ?>" 
                                   style="color: #4e73df; text-decoration: none; font-size: 20px;" title="Cambiar Estado">
                                   <i class="fas <?php echo $iconos_estado[$e_id] ?? 'fa-circle'; ?>"></i>
                                </a>

                                <a href="editar_tarea.php?id=<?php echo $t['id']; ?>" style="color: #f6c23e; text-decoration: none; font-size: 18px;"><i class="fas fa-edit"></i></a>
                                
                                <a href="eliminar_tarea.php?id=<?php echo $t['id']; ?>" style="color: #e74a3b; text-decoration: none; font-size: 18px;" onclick="return confirm('¿Borrar?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div style="text-align: center; padding: 30px; border: 2px dashed #eee;">
                    <p style="color: #999;">Aún no tienes tareas cargadas.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>