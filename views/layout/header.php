<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestion de Usuarios</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="header-content">
                <h1>Sistema de Gestion de Usuarios</h1>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="user-info">
                        <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></span>
                        <span class="role-badge"><?php echo $_SESSION['user_rol']; ?></span>
                        <a href="index.php?action=perfil" class="btn-link">Mi Perfil</a>
                        <a href="index.php?action=logout" class="btn-link logout">Cerrar Sesion</a>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_rol'] === 'admin'): ?>
                <nav>
                    <a href="index.php?action=index">Lista de Usuarios</a>
                </nav>
            <?php endif; ?>
        </header>
        <main>