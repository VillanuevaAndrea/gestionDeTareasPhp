<?php require 'conexion.php'; ?>
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