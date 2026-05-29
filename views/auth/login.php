<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Usuarios</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Iniciar Sesion</h2>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?php echo $_SESSION['error']; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['mensaje']; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="index.php?action=login">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contrasena</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Ingresar</button>
                <p class="text-center">
                    No tienes cuenta? <a href="index.php?action=register">Registrate aqui</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
<?php
unset($_SESSION['error']);
unset($_SESSION['mensaje']);
unset($_SESSION['tipo_mensaje']);
?>