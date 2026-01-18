<?php require 'conexion.php'; 


$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['usuario'];
    $pass= $_POST['password'];

    $pass_encriptada = password_hash($pass, PASSWORD_BCRYPT);

    try{
        $stmt = $conexion->prepare("insert into usuarios (usuario, password) VALUES (:u, :p)");
        $stmt->bindParam(':u', $user);
        $stmt->bindParam(':p', $pass_encriptada);

        if ($stmt->execute()) {
            $mensaje = "<p class='success'> Registro exitoso. <a href='login.php'>iniciar sesión</a></p>.";
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $mensaje = "<p class='error'>El nombre de usuario '$user'ya existe. Por favor, elige otro.</p>";
        } else {
            $mensaje = "<p class='error'> No se pudo registrar el usuario. Inténtelo de nuevo.</p>";
        }
    }
}

?>

<?php include 'includes/header.php'; ?>

<div class="container">
    <h2>Registro de usuario</h2>
    <form action="registro.php" method="POST">

        <div class="form-group">
            <label>Nombre de Usuario</label>
            <input type="text" name="username" required>
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