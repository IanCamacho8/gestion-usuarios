<?php
class UsuarioController {
    private $usuario;
    private $auth;
    
    public function __construct() {
        $this->usuario = new Usuario();
        $this->auth = new Auth();
    }
    
    public function index() {
        $pagina = $_GET['pagina'] ?? 1;
        $limite = 10;
        $offset = ($pagina - 1) * $limite;
        $busqueda = $_GET['buscar'] ?? '';
        
        $totalUsuarios = $this->usuario->getTotalCount($busqueda);
        $totalPaginas = ceil($totalUsuarios / $limite);
        
        $usuarios = $this->usuario->getAllPaginated($limite, $offset, $busqueda);
        
        require_once '../views/usuarios/index.php';
    }
    
    public function edit($id) {
        $usuario = $this->usuario->getById($id);
        if (!$usuario) {
            $_SESSION['error'] = "Usuario no encontrado";
            header("Location: index.php?action=index");
            exit();
        }
        require_once '../views/usuarios/edit.php';
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=edit&id=" . $id);
            exit();
        }
        
        $this->usuario->setId($id);
        $this->usuario->setNombre($_POST['nombre']);
        $this->usuario->setEmail($_POST['email']);
        $this->usuario->setRol($_POST['rol']);
        
        if ($this->usuario->emailExists($_POST['email'], $id)) {
            $_SESSION['error'] = "El email ya esta registrado por otro usuario";
            header("Location: index.php?action=edit&id=" . $id);
            exit();
        }
        
        if ($this->usuario->update()) {
            $_SESSION['mensaje'] = "Usuario actualizado correctamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['error'] = "Error al actualizar el usuario";
        }
        
        header("Location: index.php?action=index");
        exit();
    }
    
    public function delete($id) {
        $usuario = $this->usuario->getById($id);
        if (!$usuario) {
            $_SESSION['error'] = "Usuario no encontrado";
            header("Location: index.php?action=index");
            exit();
        }
        
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = "No puedes eliminar tu propio usuario";
            header("Location: index.php?action=index");
            exit();
        }
        
        if ($this->usuario->delete($id)) {
            $_SESSION['mensaje'] = "Usuario eliminado correctamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['error'] = "Error al eliminar el usuario";
        }
        
        header("Location: index.php?action=index");
        exit();
    }
    
    public function perfil() {
        $usuario = $this->usuario->getById($_SESSION['user_id']);
        require_once '../views/usuarios/perfil.php';
    }
    
    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=perfil");
            exit();
        }
        
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        $auth = new Auth();
        $loginResult = $auth->login($_SESSION['user_email'], $currentPassword);
        
        if (!$loginResult['success']) {
            $_SESSION['error'] = "Contrasena actual incorrecta";
            header("Location: index.php?action=perfil");
            exit();
        }
        
        if (strlen($newPassword) < 6) {
            $_SESSION['error'] = "La nueva contrasena debe tener al menos 6 caracteres";
            header("Location: index.php?action=perfil");
            exit();
        }
        
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = "Las contrasenas no coinciden";
            header("Location: index.php?action=perfil");
            exit();
        }
        
        if ($this->usuario->updatePassword($_SESSION['user_id'], $newPassword)) {
            $_SESSION['mensaje'] = "Contrasena actualizada correctamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['error'] = "Error al actualizar la contrasena";
        }
        
        header("Location: index.php?action=perfil");
        exit();
    }
    public function editarPerfil() {
        $usuario = $this->usuario->getById($_SESSION['user_id']);
        if (!$usuario) {
            $_SESSION['error'] = "Usuario no encontrado";
            header("Location: index.php?action=perfil");
            exit();
        }
        require_once '../views/usuarios/editar_perfil.php';
    }

    public function actualizarPerfil() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=perfil");
            exit();
        }
        
        $id = $_SESSION['user_id'];
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        
        // Validaciones basicas
        if (empty($nombre)) {
            $_SESSION['error'] = "El nombre es obligatorio";
            header("Location: index.php?action=editarPerfil");
            exit();
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email no valido";
            header("Location: index.php?action=editarPerfil");
            exit();
        }
        
        // Verificar si el email ya existe (excepto el propio)
        if ($this->usuario->emailExists($email, $id)) {
            $_SESSION['error'] = "El email ya esta registrado por otro usuario";
            header("Location: index.php?action=editarPerfil");
            exit();
        }
        
        $this->usuario->setId($id);
        $this->usuario->setNombre($nombre);
        $this->usuario->setEmail($email);
        $this->usuario->setRol($_SESSION['user_rol']);
        
        if ($this->usuario->update()) {
            // Actualizar los datos de sesion
            $_SESSION['user_nombre'] = $nombre;
            $_SESSION['user_email'] = $email;
            
            $_SESSION['mensaje'] = "Perfil actualizado correctamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['error'] = "Error al actualizar el perfil";
        }
        
        header("Location: index.php?action=perfil");
        exit();
    }

}
?>