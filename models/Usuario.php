<?php
require_once __DIR__ . '/../config/Database.php';

class Usuario {
    private $db;
    private $id;
    private $nombre;
    private $email;
    private $password;
    private $rol;
    private $activo;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getEmail() { return $this->email; }
    public function getRol() { return $this->rol; }
    public function getActivo() { return $this->activo; }
    
    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = htmlspecialchars(strip_tags($nombre)); }
    public function setEmail($email) { $this->email = htmlspecialchars(strip_tags($email)); }
    public function setPassword($password) { $this->password = $password; }
    public function setRol($rol) { $this->rol = $rol; }
    public function setActivo($activo) { $this->activo = $activo; }
    
    public function getAll() {
        $query = "SELECT id, nombre, email, rol, activo, ultimo_acceso, created_at, updated_at 
                  FROM usuarios ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getAllPaginated($limit, $offset, $search = '') {
        if (!empty($search)) {
            $query = "SELECT id, nombre, email, rol, activo, ultimo_acceso, created_at, updated_at 
                      FROM usuarios 
                      WHERE nombre LIKE :search OR email LIKE :search
                      ORDER BY created_at DESC 
                      LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($query);
            $searchParam = "%{$search}%";
            $stmt->bindParam(':search', $searchParam);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        } else {
            $query = "SELECT id, nombre, email, rol, activo, ultimo_acceso, created_at, updated_at 
                      FROM usuarios 
                      ORDER BY created_at DESC 
                      LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getTotalCount($search = '') {
        if (!empty($search)) {
            $query = "SELECT COUNT(*) as total FROM usuarios WHERE nombre LIKE :search OR email LIKE :search";
            $stmt = $this->db->prepare($query);
            $searchParam = "%{$search}%";
            $stmt->bindParam(':search', $searchParam);
        } else {
            $query = "SELECT COUNT(*) as total FROM usuarios";
            $stmt = $this->db->prepare($query);
        }
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    public function getById($id) {
        $query = "SELECT id, nombre, email, rol, activo, ultimo_acceso, created_at, updated_at 
                  FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function create() {
        $errors = $this->validate();
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        if ($this->emailExists($this->email)) {
            return ['success' => false, 'errors' => ['El email ya esta registrado']];
        }
        
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO usuarios (nombre, email, password, rol) 
                  VALUES (:nombre, :email, :password, :rol)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':rol', $this->rol);
        
        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        }
        return ['success' => false, 'errors' => ['Error al crear el usuario']];
    }
    
    public function update() {
        $query = "UPDATE usuarios SET nombre = :nombre, email = :email, rol = :rol 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':rol', $this->rol);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
    
    public function updatePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE usuarios SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function delete($id) {
        $query = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function updateLastAccess($id) {
        $query = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function validate() {
        $errors = [];
        
        if (empty($this->nombre)) {
            $errors[] = "El nombre es obligatorio";
        } elseif (strlen($this->nombre) < 3) {
            $errors[] = "El nombre debe tener al menos 3 caracteres";
        }
        
        if (empty($this->email)) {
            $errors[] = "El email es obligatorio";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El email no es valido";
        }
        
        if (empty($this->password)) {
            $errors[] = "La contrasena es obligatoria";
        } elseif (strlen($this->password) < 6) {
            $errors[] = "La contrasena debe tener al menos 6 caracteres";
        }
        
        return $errors;
    }
    
    public function emailExists($email, $excludeId = null) {
        if ($excludeId) {
            $query = "SELECT COUNT(*) as total FROM usuarios WHERE email = :email AND id != :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $excludeId);
        } else {
            $query = "SELECT COUNT(*) as total FROM usuarios WHERE email = :email";
            $stmt = $this->db->prepare($query);
        }
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] > 0;
    }
}
?>