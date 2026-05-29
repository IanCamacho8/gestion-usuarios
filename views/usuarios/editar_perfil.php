<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<h2>Editar Mi Perfil</h2>

<form method="POST" action="index.php?action=actualizarPerfil" class="form-container">
    <div class="form-group">
        <label for="nombre">Nombre completo</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php?action=perfil" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>