<?php
// archivo: ../model/gestor_usuarios.php
require_once('conexion.php'); // Incluir el archivo de conexión a la base de datos

class GestorUsuarios
{
    private $conn; // Propiedad para almacenar la conexión a la base de datos

    public function __construct()
    {
        // Obtener la conexión a la base de datos a través de la clase ConexionBD
        $this->conn = ConexionBD::obtenerConexion(); 
    }

    /**
     * Inicia sesión de un usuario con correo y contraseña.
     *
     * @param string $correo Correo electrónico del usuario.
     * @param string $contra Contraseña del usuario.
     * @return array Resultado de la operación con estado y mensaje.
     */
    public function iniciarSesion($correo, $contra)
    {
        // Consulta SQL para seleccionar al usuario por correo electrónico
        $sql = "SELECT * FROM usuarios_registrados WHERE correo_electronico = ?";
        $stmt = $this->conn->prepare($sql); // Preparar la consulta SQL
        $stmt->bind_param("s", $correo); // Vincular el parámetro de correo electrónico
        $stmt->execute(); // Ejecutar la consulta
        $result = $stmt->get_result(); // Obtener el resultado de la consulta
    
        if ($result->num_rows == 1) { // Verificar si se encontró un usuario
            $row = $result->fetch_assoc(); // Obtener los datos del usuario
            if (password_verify($contra, $row['contrasena'])) { // Verificar la contraseña
                // Almacenar información del usuario en la sesión
                $_SESSION['correo'] = $row['correo_electronico'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_nombre'] = $row['nombre'];
                $_SESSION['user_apellido'] = $row['apellido'];
                $stmt->close(); // Cerrar la declaración
                return ['success' => true]; // Retornar éxito
            } else {
                $stmt->close(); // Cerrar la declaración
                return ['success' => false, 'message' => 'La contraseña es incorrecta.']; // Contraseña incorrecta
            }
        } else {
            $stmt->close(); // Cerrar la declaración
            return ['success' => false, 'message' => 'Usuario no encontrado.']; // Usuario no encontrado
        }
    }

    /**
     * Inicia sesión de un administrador con correo y contraseña.
     *
     * @param string $correo Correo electrónico del administrador.
     * @param string $contrasena Contraseña del administrador.
     * @return bool True si el inicio de sesión es exitoso, False en caso contrario.
     */
    public function iniciarSesionAdmin($correo, $contrasena)
    {
        // Consulta SQL para obtener la contraseña y el rol de administrador
        $stmt = $this->conn->prepare("SELECT contrasena, es_admin FROM usuarios_registrados WHERE correo_electronico = ?");
        $stmt->bind_param("s", $correo); // Vincular el parámetro de correo electrónico
        $stmt->execute(); // Ejecutar la consulta
        $stmt->bind_result($hash_contrasena, $es_admin); // Obtener los resultados
        $stmt->fetch(); // Obtener el valor de las variables

        if (password_verify($contrasena, $hash_contrasena) && $es_admin == 1) { // Verificar la contraseña y el rol de administrador
            return true; // Inicio de sesión exitoso para administrador
        } else {
            return false; // Credenciales incorrectas o no es administrador
        }

        $stmt->close(); // Cerrar la declaración
    }

    /**
     * Registra un nuevo usuario en la base de datos.
     *
     * @param string $nombre Nombre del usuario.
     * @param string $apellido Apellido del usuario.
     * @param string $nombreUsuario Nombre de usuario (username).
     * @param string $correo Correo electrónico del usuario.
     * @param string $contrasena Contraseña del usuario.
     * @param string $pais Ubicación del usuario.
     * @return bool True si el registro es exitoso, False en caso contrario.
     */
    public function registrarUsuario($nombre, $apellido, $nombreUsuario, $correo, $contrasena, $pais)
    {
        // Encriptar la contraseña usando password_hash
        $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);

        // Consulta SQL para insertar un nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios_registrados (nombre_usuario, contrasena, correo_electronico, nombre, ubicacion, apellido) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql); // Preparar la consulta SQL
        $stmt->bind_param("ssssss", $nombreUsuario, $contrasenaEncriptada, $correo, $nombre, $pais, $apellido); // Vincular los parámetros

        if ($stmt->execute()) { // Ejecutar la consulta
            $stmt->close(); // Cerrar la declaración
            return true; // Registro exitoso
        } else {
            $stmt->close(); // Cerrar la declaración
            return false; // Error en el registro
        }
    }

    /**
     * Valida las credenciales de un usuario por nombre de usuario y contraseña.
     *
     * @param string $nombre_usuario Nombre de usuario.
     * @param string $password Contraseña del usuario.
     * @return array|false Información del usuario si las credenciales son correctas, False en caso contrario.
     */
    public function validarUsuario($nombre_usuario, $password)
    {
        // Consulta SQL para seleccionar al usuario por nombre de usuario y contraseña
        $sql = "SELECT * FROM usuarios_registrados WHERE nombre_usuario = ? AND contrasena = ?";
        $stmt = $this->conn->prepare($sql); // Preparar la consulta SQL
        $stmt->bind_param('ss', $nombre_usuario, $password); // Vincular los parámetros
        $stmt->execute(); // Ejecutar la consulta
        $result = $stmt->get_result(); // Obtener el resultado

        if ($result->num_rows == 1) { // Verificar si se encontró un usuario
            return $result->fetch_assoc(); // Retornar la información del usuario
        } else {
            return false; // Usuario no válido
        }
    }


    public function listarUsuarios()
{
    // Consulta SQL para obtener el ID, nombre de usuario y correo electrónico de todos los usuarios
    $sql = "SELECT id, nombre_usuario, correo_electronico, es_admin FROM usuarios_registrados";
    // Ejecutar la consulta SQL
    $result = $this->conn->query($sql);

    // Crear un array para almacenar los usuarios
    $usuarios = array();

    // Verificar si la consulta devuelve resultados
    if ($result->num_rows > 0) {
        // Recorrer los resultados de la consulta
        while ($row = $result->fetch_assoc()) {
            // Añadir cada usuario al array
            $usuarios[] = $row;
        }
    }

    // Retornar el array de usuarios
    return $usuarios;
}

public function actualizarPerfil($idUsuario, $username, $nombre, $apellido, $ubicacion, $correo)
{
    // Consulta SQL para actualizar los datos del perfil del usuario
    $sql = "UPDATE usuarios_registrados SET nombre_usuario = ?, nombre = ?, apellido = ?, ubicacion = ?, correo_electronico = ? WHERE id = ?";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $this->conn->error);
    }

    // Enlazar los parámetros a la consulta preparada
    $stmt->bind_param("sssssi", $username, $nombre, $apellido, $ubicacion, $correo, $idUsuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Retornar verdadero si la actualización fue exitosa
        return true;
    } else {
        // Retornar falso si hubo un error en la actualización
        return false;
    }

    // Cerrar la declaración preparada
    $stmt->close();
}

public static function getUsers()
{
    // Obtener la conexión a la base de datos
    $conn = ConexionBD::obtenerConexion();

    // Verificar si hay un error de conexión
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }

    // Inicializar el array para almacenar los usuarios
    $usuarios = [];

    // Consulta SQL para obtener el nombre de usuario, correo electrónico y rol de administrador de todos los usuarios
    $sql = "SELECT nombre_usuario, correo_electronico, es_admin FROM usuarios_registrados";
    // Ejecutar la consulta SQL
    $result = $conn->query($sql);

    // Verificar si la consulta devuelve resultados
    if ($result && $result->num_rows > 0) {
        // Obtener todos los resultados como un array asociativo
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Retornar el array de usuarios
    return $usuarios;
}

public static function getUserByEmail($email)
{
    // Crear conexión a la base de datos
    $conn = ConexionBD::obtenerConexion();

    // Inicializar la variable $user
    $user = null;

    // Preparar la consulta SQL para obtener el usuario por correo electrónico
    $stmt = $conn->prepare("SELECT nombre_usuario, nombre, foto_perfil, apellido, ubicacion, correo_electronico FROM usuarios_registrados WHERE correo_electronico = ?");
    if ($stmt === false) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }

    // Enlazar el parámetro del correo electrónico a la consulta preparada
    $stmt->bind_param("s", $email);
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Verificar si se obtuvo un resultado
    if ($result && $result->num_rows > 0) {
        // Obtener el resultado como un array asociativo
        $user = $result->fetch_assoc();
    }

    // Cerrar la declaración preparada
    $stmt->close();
    // Cerrar la conexión a la base de datos
    $conn->close();

    // Retornar el usuario
    return $user;
}

public static function updateUser($currentEmail, $username, $firstName, $lastName, $location, $email)
{
    // Crear conexión a la base de datos
    $conn = ConexionBD::obtenerConexion();

    // Verificar la conexión a la base de datos
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }

    // Preparar la consulta SQL para actualizar el usuario
    $stmt = $conn->prepare("UPDATE usuarios_registrados SET nombre_usuario = ?, nombre = ?, apellido = ?, ubicacion = ?, correo_electronico = ? WHERE correo_electronico = ?");
    // Enlazar los parámetros a la consulta preparada
    $stmt->bind_param("ssssss", $username, $firstName, $lastName, $location, $email, $currentEmail);
    // Ejecutar la consulta
    $stmt->execute();

    // Cerrar la declaración preparada
    $stmt->close();
    // Cerrar la conexión a la base de datos
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
    // Obtener la contraseña actual del usuario desde la base de datos
    $conn = ConexionBD::obtenerConexion();
    $stmt = $this->conn->prepare("SELECT contrasena FROM usuarios_registrados WHERE correo_electronico = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->bind_result($hash_contrasena);
    $stmt->fetch();
    $stmt->close();

    // Verificar si la contraseña actual proporcionada coincide con la almacenada en la base de datos
    if (password_verify($currentPassword, $hash_contrasena)) {
        // Encriptar la nueva contraseña
        $newHashPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        // Actualizar la contraseña en la base de datos con la nueva encriptada
        $stmt = $this->conn->prepare("UPDATE usuarios_registrados SET contrasena = ? WHERE correo_electronico = ?");
        $stmt->bind_param("ss", $newHashPassword, $correo);
        $stmt->execute();
        $stmt->close();
        return true; // Contraseña cambiada exitosamente
    } else {
        return false; // La contraseña actual es incorrecta
    }
}

public static function getUserIdByEmail($email)
{
    // Crear conexión a la base de datos
    $conn = ConexionBD::obtenerConexion();
    // Inicializar la variable $userId
    $userId = null;

    // Preparar la consulta SQL para obtener el ID del usuario por correo electrónico
    $stmt = $conn->prepare("SELECT id FROM usuarios_registrados WHERE correo_electronico = ?");
    if ($stmt === false) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }

    // Enlazar el parámetro del correo electrónico a la consulta preparada
    $stmt->bind_param("s", $email);
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Verificar si se obtuvo un resultado
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Obtener el resultado como un array asociativo
        $userId = $user['id']; // Extraer el ID del usuario
    }

    // Cerrar la declaración preparada
    $stmt->close();
    // Cerrar la conexión a la base de datos
    $conn->close();

    return $userId; // Retornar el ID del usuario
}
public function darAdmin($idUsuario) {
    $sql = "SELECT darAdmin(?) AS result";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['result'] > 0;
}
public function quitarAdmin($idUsuario) {
    $sql = "SELECT quitarAdmin(?) AS result";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['result'] > 0;
}
public function eliminarUsuario($idUsuario) {
    $sql = "CALL EliminarUsuario(?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}
}