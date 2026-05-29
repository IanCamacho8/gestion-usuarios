<?php
class AuthController {
    private $auth;
    private $usuario;
    
    public function __construct() {
        $this->auth = new Auth();
        $this->usuario = new Usuario();
    }
    
    public function showLogin() {
        require_once '../views/auth/login.php';
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=login");
            exit();
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $result = $this->auth->login($email, $password);
        
        if ($result['success']) {
            $_SESSION['mensaje'] = "Bienvenido " . $_SESSION['user_nombre'];
            $_SESSION['tipo_mensaje'] = "success";
            
            // Redirigir segun el rol
            if ($_SESSION['user_rol'] === 'admin') {
                header("Location: index.php?action=index");
            } else {
                header("Location: index.php?action=perfil");
            }
            exit();
        } else {
            $_SESSION['error'] = $result['error'];
            header("Location: index.php?action=login");
        }
        exit();
}
    
    public function logout() {
        $this->auth->logout();
        header("Location: index.php?action=login");
        exit();
    }
    
    public function showRegister() {
        require_once '../views/auth/register.php';
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=register");
            exit();
        }
        
        $this->usuario->setNombre($_POST['nombre']);
        $this->usuario->setEmail($_POST['email']);
        $this->usuario->setPassword($_POST['password']);
        $this->usuario->setRol('user');
        
        $result = $this->usuario->create();
        
        if ($result['success']) {
            $_SESSION['mensaje'] = "Registro exitoso. Ahora puedes iniciar sesion.";
            $_SESSION['tipo_mensaje'] = "success";
            header("Location: index.php?action=login");
        } else {
            $_SESSION['errors'] = $result['errors'];
            header("Location: index.php?action=register");
        }
        exit();
    }
}
?>