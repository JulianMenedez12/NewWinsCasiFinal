<?php
// Verificar y comenzar la sesión si no está iniciada
if (!isset($_SESSION)) session_start(); // Inicia la sesión si no ha sido iniciada

// Verificar si el usuario está autenticado mediante la existencia del correo en la sesión
if (!isset($_SESSION['correo'])) {
    // Si no hay una sesión de usuario activa, redirigir al usuario a la página de administración (login)
    header("Location: admin.php"); // Redirige al usuario a la página de administración
    exit(); // Termina la ejecución del script
}

// Incluir los archivos necesarios para la conexión a la base de datos y la gestión de usuarios
require_once '../model/conexion.php'; // Incluye el archivo que contiene la lógica para conectar con la base de datos
require_once '../model/gestor_usuarios.php'; // Incluye el archivo que contiene la lógica para gestionar usuarios

/**
 * Elimina un usuario del sistema.
 *
 * @param int $idUsuario ID del usuario a eliminar.
 * @return void
 */
if (isset($_POST['id_usuario'])) {
    /**
     * Obtener el ID del usuario desde la solicitud POST y convertirlo a entero.
     *
     * @var int $idUsuario
     */
    $idUsuario = intval($_POST['id_usuario']); // Obtener el ID del usuario desde la solicitud POST y convertirlo a entero

    // Crear una instancia de la clase GestorUsuarios
    $gestorUsuarios = new GestorUsuarios();

    // Intentar eliminar el usuario utilizando el método eliminarUsuario de la clase GestorUsuarios
    if ($gestorUsuarios->eliminarUsuario($idUsuario)) {
        // Si la eliminación fue exitosa, establecer un mensaje en la sesión
        $_SESSION['mensaje'] = "Usuario eliminado exitosamente."; // Mensaje de éxito para mostrar al usuario
    } else {
        // Si la eliminación falló, establecer un mensaje de error en la sesión
        $_SESSION['mensaje'] = "Error al eliminar el usuario."; // Mensaje de error para mostrar al usuario
    }

    // Redirigir al usuario a la página de inicio después de la operación
    header("Location: ../view/index.php"); // Redirige a la página de inicio
    exit(); // Termina la ejecución del script
} else {
    // Si no se ha enviado el ID del usuario en la solicitud POST, redirigir a la página de inicio
    header("Location: ../view/index.php"); // Redirige a la página de inicio
    exit(); // Termina la ejecución del script
}
?>
