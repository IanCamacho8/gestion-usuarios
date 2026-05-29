<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<h2>Mi Perfil</h2>

<div class="profile-container">
    <div class="profile-info">
        <h3>Informacion Personal</h3>
        <div class="info-row">
            <strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?>
        </div>
        <div class="info-row">
            <strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?>
        </div>
        <div class="info-row">
            <strong>Rol:</strong> 
            <span class="role-badge <?php echo $usuario['rol']; ?>">
                <?php echo $usuario['rol']; ?>
            </span>
        </div>
        <div class="info-row">
            <strong>Fecha registro:</strong> <?php echo $usuario['created_at']; ?>
        </div>
        <div class="info-row">
            <strong>Ultimo acceso:</strong> <?php echo $usuario['ultimo_acceso'] ?? 'Nunca'; ?>
        </div>
    </div>
    
    <div class="profile-password">
        <h3>Cambiar Contrasena</h3>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php echo $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['mensaje']; ?>
                <?php unset($_SESSION['mensaje']); unset($_SESSION['tipo_mensaje']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="index.php?action=perfil">
            <input type="hidden" name="change_password" value="1">
            
            <div class="form-group">
                <label for="current_password">Contrasena actual</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            
            <div class="form-group">
                <label for="new_password">Nueva contrasena</label>
                <input type="password" id="new_password" name="new_password" required>
                <small>Minimo 6 caracteres</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmar nueva contrasena</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Actualizar Contrasena</button>
        </form>
    </div>
</div>

<div class="form-actions">
    <a href="index.php?action=editarPerfil" class="btn btn-edit">Editar Perfil</a>
    <?php if ($_SESSION['user_rol'] === 'admin'): ?>
        <a href="index.php?action=index" class="btn btn-secondary">Volver al Listado</a>
    <?php endif; ?>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>