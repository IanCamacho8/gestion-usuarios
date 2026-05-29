<?php
class AuthMiddleware {
    public static function check() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
    }
    
    public static function adminOnly() {
        self::check();
        if ($_SESSION['user_rol'] !== 'admin') {
            die("<h2>Acceso denegado</h2><p>No tienes permisos para acceder a esta pagina.</p>");
        }
    }
    
    public static function guestOnly() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?action=index");
            exit();
        }
    }
}
?>