<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_tarea = $_GET['id'];
$user_id = $_SESSION['user_id'];


$stmt = $conexion->prepare("SELECT * FROM tareas WHERE id = ? AND usuario_id = ?");
$stmt->execute([$id_tarea, $user_id]);
$tarea = $stmt->fetch();

if (!$tarea) { header("Location: index.php"); exit(); }


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_titulo = $_POST['titulo'];
    $update = $conexion->prepare("UPDATE tareas SET titulo = ? WHERE id = ? AND usuario_id = ?");
    $update->execute([$nuevo_titulo, $id_tarea, $user_id]);
    header("Location: index.php");
    exit();
}
?>

<?php include 'includes/header.php'; ?>
<div class="container" style="max-width: 500px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h3>Editar Tarea</h3>
    <form method="POST">
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($tarea['titulo']); ?>" required 
               style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;">
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="flex: 1; background: #4e73df; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer;">Guardar Cambios</button>
            <a href="index.php" style="flex: 1; text-align: center; background: #858796; color: white; text-decoration: none; padding: 10px; border-radius: 4px;">Cancelar</a>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?>