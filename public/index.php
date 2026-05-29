<?php
session_start();

define('ROOT_PATH', dirname(__DIR__));

spl_autoload_register(function($class) {
    $paths = [
        ROOT_PATH . '/controllers/',
        ROOT_PATH . '/models/',
        ROOT_PATH . '/middleware/',
        ROOT_PATH . '/config/'  // Agregada esta linea para encontrar Database
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$action = $_GET['action'] ?? 'login';

switch ($action) {
    case 'login':
        AuthMiddleware::guestOnly();
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        break;
        
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
        
    case 'register':
        AuthMiddleware::guestOnly();
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            $controller->showRegister();
        }
        break;
        
    case 'index':
        AuthMiddleware::check();
        AuthMiddleware::adminOnly();
        $controller = new UsuarioController();
        $controller->index();
        break;
        
    case 'edit':
        AuthMiddleware::check();
        AuthMiddleware::adminOnly();
        $id = $_GET['id'] ?? 0;
        $controller = new UsuarioController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->update($id);
        } else {
            $controller->edit($id);
        }
        break;
        
    case 'delete':
        AuthMiddleware::check();
        AuthMiddleware::adminOnly();
        $id = $_GET['id'] ?? 0;
        $controller = new UsuarioController();
        $controller->delete($id);
        break;
        

    case 'editarPerfil':
        AuthMiddleware::check();
        $controller = new UsuarioController();
        $controller->editarPerfil();
        break;
        
    case 'actualizarPerfil':
        AuthMiddleware::check();
        $controller = new UsuarioController();
        $controller->actualizarPerfil();
        break;
        
    case 'perfil':
        AuthMiddleware::check();
        $controller = new UsuarioController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
            $controller->changePassword();
        } else {
            $controller->perfil();
        }
        break;
        
    default:
        header("Location: index.php?action=login");
        break;
}
?>