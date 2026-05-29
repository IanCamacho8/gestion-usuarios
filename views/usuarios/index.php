<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<h2>Lista de Usuarios</h2>

<form method="GET" class="search-form">
    <input type="hidden" name="action" value="index">
    <input type="text" name="buscar" placeholder="Buscar por nombre o email..." 
           value="<?php echo htmlspecialchars($_GET['buscar'] ?? ''); ?>">
    <button type="submit" class="btn btn-primary">Buscar</button>
    <?php if (!empty($_GET['buscar'])): ?>
        <a href="index.php?action=index" class="btn btn-secondary">Limpiar</a>
    <?php endif; ?>
</form>

<?php if (empty($usuarios)): ?>
    <div class="alert alert-info">No hay usuarios registrados.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Ultimo Acceso</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                    <td>
                        <span class="role-badge <?php echo $usuario['rol']; ?>">
                            <?php echo $usuario['rol']; ?>
                        </span>
                    </td>
                    <td><?php echo $usuario['ultimo_acceso'] ?? 'Nunca'; ?></td>
                    <td><?php echo $usuario['created_at']; ?></td>
                    <td class="actions">
                        <a href="index.php?action=edit&id=<?php echo $usuario['id']; ?>" 
                           class="btn btn-edit">Editar</a>
                        <a href="index.php?action=delete&id=<?php echo $usuario['id']; ?>" 
                           class="btn btn-delete"
                           onclick="return confirm('Eliminar este usuario?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if ($totalPaginas > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <a href="?action=index&pagina=<?php echo $i; ?>&buscar=<?php echo urlencode($busqueda); ?>" 
                   class="btn-page <?php echo $i == $pagina ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>