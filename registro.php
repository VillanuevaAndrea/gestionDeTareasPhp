<?php require 'conexion.php'; 

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user = $_POST['usuario']; 
    $pass = $_POST['password'];

    $pass_encriptada = password_hash($pass, PASSWORD_BCRYPT);

    try {
        $stmt = $conexion->prepare("INSERT INTO usuarios (usuario, password) VALUES (:u, :p)");
        $stmt->bindParam(':u', $user);
        $stmt->bindParam(':p', $pass_encriptada);

        if ($stmt->execute()) {
            $mensaje = "<p class='success'>Registro exitoso. <a href='login.php'>Iniciar sesión</a></p>";
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $mensaje = "<p class='error'>El nombre de usuario '$user' ya existe.</p>";
        } else {
            error_log($e->getMessage());
            $mensaje = "<p class='error'>No se pudo registrar el usuario.</p>";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container">
    <h2>Registro de usuario</h2>
    
    <?php echo $mensaje; ?>

    <form action="registro.php" method="POST">
        <div class="form-group">
            <label>Nombre de Usuario</label>
            <input type="text" name="usuario" required> 
        </div>

        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Registrarme</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
</div>

<?php include 'includes/footer.php'; ?>