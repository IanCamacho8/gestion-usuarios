<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema de Usuarios</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Registro de Usuario</h2>
            
            <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="index.php?action=register">
                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contrasena</label>
                    <input type="password" id="password" name="password" required>
                    <small>Minimo 6 caracteres</small>
                </div>
                <button type="submit" class="btn btn-primary">Registrarse</button>
                <p class="text-center">
                    Ya tienes cuenta? <a href="index.php?action=login">Inicia sesion aqui</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
<?php
unset($_SESSION['errors']);
?>