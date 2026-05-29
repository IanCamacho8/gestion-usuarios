# Sistema de Gestion de Usuarios

Sistema completo de gestion de usuarios desarrollado por la sala 4, con PHP, MySQL, POO y el patron MVC. En este repositorio está el código fuente, el archivo SQL y el README.

## Instalacion

1. Clonar los archivos del repositorio en `..\xampp\htdocs\gestion-usuarios` (XAMPP) o `..\wamp64\www\gestion-usuarios` (WAMP)

2. Abrir phpMyAdmin y ejecutar el archivo `database.sql` para crear la base de datos y las tablas

3. Verificar/Configurar la conexion a la base de datos en `config/Database.php`:
   - $host = 'localhost' (si usas puerto diferente, cambiar a 'localhost:3307' u otro, en nuestro caso usamos el puerto 3309 por conflictos con el puerto default)
   - $dbname = 'usuarios_mvc'
   - $username = 'root'
   - $password = '' (dejalo vacio o pon tu contrasena)

4. Acceder a la aplicacion en: http://localhost/gestion-usuarios/public/

## Credenciales de Acceso

| Rol | Email | Contrasena |
|-----|-------|------------|
| Administrador | admin@sistema.com | password | #una cuenta usada para verificar que este rol funcione
| Usuario Normal | (registrar uno nuevo) | (a eleccion) |



## Caracteristicas Principales

- Autenticacion de usuarios (login, logout, sesiones PHP)
- Registro de nuevos usuarios (rol 'user' por defecto)
- CRUD completo de usuarios (solo administradores)
- Roles diferenciados: admin y user
- Edicion de perfil propio
- Cambio de contrasena
- Paginacion en listado de usuarios
- Busqueda de usuarios por nombre o email
- Registro de ultimo acceso
- Diseno responsive

## Estructura del Proyecto (MVC)

gestion-usuarios/
├── config/ - Configuracion de base de datos
├── models/ - Modelos: Usuario.php, Auth.php
├── controllers/ - Controladores: UsuarioController.php, AuthController.php
├── views/ - Vistas: login, register, listado, edicion, perfil
├── middleware/ - Middleware para autenticacion y roles
├── public/ - Front controller (index.php)
├── assets/ - CSS y recursos estaticos
└── database.sql - Script de base de datos


## Permisos por Rol

| Accion | Administrador | Usuario Normal |
|--------|---------------|----------------|
| Ver listado de usuarios | Si | No |
| Editar cualquier usuario | Si | No |
| Eliminar usuarios | Si | No |
| Editar su propio perfil | Si | Si |
| Cambiar su contrasena | Si | Si |

## Tecnologias Utilizadas

- PHP 7.4+ (POO, PDO)
- MySQL / MariaDB
- HTML5 + CSS3 (diseno responsive)
- Sesiones PHP
- Password Hashing (bcrypt)

## Requisitos del Servidor

- Apache / Nginx
- PHP 7.4 o superior
- MySQL 5.7 o MariaDB 10.2
- Extension PDO PHP habilitada

## Estructura MVC Explicada

El proyecto sigue el patron Modelo-Vista-Controlador:

- **Modelos**: Contienen la logica de negocio y acceso a datos. La clase Usuario maneja CRUD y validaciones. La clase Auth maneja autenticacion.

- **Vistas**: Archivos PHP que presentan la interfaz de usuario. Usan HTML y CSS basico, con logica minima para mostrar datos.

- **Controladores**: Reciben peticiones del usuario, procesan datos a traves de los modelos y cargan las vistas correspondientes.

- **Middleware**: Intercepta peticiones para verificar autenticacion y permisos de rol.
