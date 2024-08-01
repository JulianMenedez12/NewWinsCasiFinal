<?php
//archivo:../model/gestor_usuarios.php
require_once('conexion.php');

class GestorUsuarios
{
    private $conn;

    public function __construct()
    {
        $this->conn = ConexionBD::obtenerConexion(); // Obtener la conexión
    }

    public function iniciarSesion($correo, $contra)
    {
        $sql = "SELECT * FROM usuarios_registrados WHERE correo_electronico = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($contra, $row['contrasena'])) {
                $_SESSION['correo'] = $row['correo_electronico'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_nombre'] = $row['nombre'];
                $_SESSION['user_apellido'] = $row['apellido'];
                $stmt->close();
                return ['success' => true];
            } else {
                $stmt->close();
                return ['success' => false, 'message' => 'La contraseña es incorrecta.'];
            }
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'Usuario no encontrado.'];
        }
    }
    public function iniciarSesionAdmin($correo, $contrasena)
    {
        $stmt = $this->conn->prepare("SELECT contrasena, es_admin FROM usuarios_registrados WHERE correo_electronico = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->bind_result($hash_contrasena, $es_admin);
        $stmt->fetch();

        if (password_verify($contrasena, $hash_contrasena) && $es_admin == 1) {
            // Inicio de sesión exitoso para administrador
            return true;
        } else {
            // Si las credenciales son incorrectas, devuelve false
            return false;
        }

        $stmt->close();
    }


    public function registrarUsuario($nombre, $apellido, $nombreUsuario, $correo, $contrasena, $pais)
    {
        $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);

        // Consulta para insertar el nuevo usuario
        $sql = "INSERT INTO usuarios_registrados (nombre_usuario, contrasena, correo_electronico, nombre, ubicacion, apellido) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssss", $nombreUsuario, $contrasenaEncriptada, $correo, $nombre, $pais, $apellido);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
            $stmt->close();
        }
    }
    public function validarUsuario($nombre_usuario, $password)
    {
        $sql = "SELECT * FROM usuarios_registrados WHERE nombre_usuario = ? AND contrasena = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $nombre_usuario, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
    public function listarUsuarios()
    {
        // Consulta SQL para obtener los usuarios
        $sql = "SELECT id, nombre_usuario, correo_electronico FROM usuarios_registrados";
        $result = $this->conn->query($sql);

        $usuarios = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }

        return $usuarios;
    }
 
    public function actualizarPerfil($idUsuario, $username, $nombre, $apellido, $ubicacion, $correo)
    {
        // Consulta para actualizar los datos del perfil
        $sql = "UPDATE usuarios_registrados SET nombre_usuario = ?, nombre = ?, apellido = ?, ubicacion = ?, correo_electronico = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->conn->error);
        }

        // Enlaza los parámetros a la consulta preparada
        $stmt->bind_param("sssssi", $username, $nombre, $apellido, $ubicacion, $correo, $idUsuario);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            return true; // Actualización exitosa
        } else {
            return false; // Error al actualizar
        }

        // Cierra la declaración preparada
        $stmt->close();
    }
    public static function getUsers()
    {
        $conn = ConexionBD::obtenerConexion();

        // Verificar la conexión
        if ($conn->connect_error) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }

        // Inicializar la variable $usuarios
        $usuarios = [];

        // Realizar la consulta SQL para obtener los usuarios
        $sql = "SELECT nombre_usuario, correo_electronico, es_admin FROM usuarios_registrados";
        $result = $conn->query($sql);

        // Verificar si se obtuvieron resultados
        if ($result && $result->num_rows > 0) {
            $usuarios = $result->fetch_all(MYSQLI_ASSOC); // Obtener todos los resultados como un array asociativo
        }

        // Cerrar la conexión
        $conn->close();

        return $usuarios;
    }

    public static function getUserByEmail($email)
    {

        // Crear conexión
        $conn = ConexionBD::obtenerConexion();

        // Inicializar la variable $user
        $user = null;

        // Preparar y ejecutar la consulta SQL para obtener el usuario por correo electrónico
        $stmt = $conn->prepare("SELECT nombre_usuario, nombre, foto_perfil, apellido, ubicacion, correo_electronico FROM usuarios_registrados WHERE correo_electronico = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se obtuvo un resultado
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc(); // Obtener el resultado como un array asociativo
        }

        // Cerrar la conexión
        $stmt->close();
        $conn->close();

        return $user;
    }
    public static function updateUser($currentEmail, $username, $firstName, $lastName, $location, $email)
    {
        $conn = ConexionBD::obtenerConexion();

        // Verificar la conexión
        if ($conn->connect_error) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }

        // Preparar y ejecutar la consulta SQL para actualizar el usuario
        $stmt = $conn->prepare("UPDATE usuarios_registrados SET nombre_usuario = ?, nombre = ?, apellido = ?, ubicacion = ?, correo_electronico = ? WHERE correo_electronico = ?");
        $stmt->bind_param("ssssss", $username, $firstName, $lastName, $location, $email, $currentEmail);
        $stmt->execute();

        // Cerrar la conexión
        $stmt->close();
        $conn->close();
    }
    public function subirFotoPerfil($userEmail, $file)
    {
        // Verificar si hay algún error en el archivo subido
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return 'Error al subir el archivo.';
        }

        // Verificar el tamaño del archivo (máximo 5MB)
        if ($file['size'] > 5242880) {
            return 'El archivo es demasiado grande. El tamaño máximo permitido es de 5MB.';
        }

        // Verificar el tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return 'Tipo de archivo no permitido. Solo se permiten archivos JPG, PNG y GIF.';
        }

        // Mover el archivo subido a la carpeta de destino
        $uploadDir = '../uploads/perfiles/';
        $fileName = basename($file['name']);
        $uploadFilePath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            return 'Error al mover el archivo subido.';
        }

        // Actualizar la base de datos con la nueva ruta de la foto de perfil
        $sql = "UPDATE usuarios_registrados SET foto_perfil = ? WHERE correo_electronico = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $uploadFilePath, $userEmail);

        if ($stmt->execute()) {
            return true; // Subida exitosa
        } else {
            return 'Error al actualizar la base de datos.';
        }
    }
    public function cambiarContrasena($correo, $currentPassword, $newPassword)
    {
        // Obtener la contraseña actual del usuario
        $conn=ConexionBD::obtenerConexion();
        $stmt = $this->conn->prepare("SELECT contrasena FROM usuarios_registrados WHERE correo_electronico = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->bind_result($hash_contrasena);
        $stmt->fetch();
        $stmt->close();

        // Verificar la contraseña actual
        if (password_verify($currentPassword, $hash_contrasena)) {
            // Actualizar la contraseña con la nueva
            $newHashPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE usuarios_registrados SET contrasena = ? WHERE correo_electronico = ?");
            $stmt->bind_param("ss", $newHashPassword, $correo);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }
    public static function getUserIdByEmail($email)
{
    $conn=ConexionBD::obtenerConexion();
    // Inicializar la variable $userId
    $userId = null;

    // Preparar y ejecutar la consulta SQL para obtener el id del usuario por correo electrónico
    $stmt = $conn->prepare("SELECT id FROM usuarios_registrados WHERE correo_electronico = ?");
    if ($stmt === false) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se obtuvo un resultado
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Obtener el resultado como un array asociativo
        $userId = $user['id']; // Solo obtener el id
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();

    return $userId;
}

}