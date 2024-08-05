<?php
require_once('../model/gestor_usuarios.php'); // Incluye el archivo que gestiona las funcionalidades de los usuarios

session_start(); // Inicia la sesión para manejar variables de sesión

/**
 * Verifica si el usuario está autenticado. Si no, redirige al administrador.
 *
 * @return void
 */
if (!isset($_SESSION['correo'])) {
    header("Location: ../view/admin.php"); // Redirige al usuario al administrador si no está autenticado
    exit(); // Finaliza la ejecución del script después de redirigir
}

// Obtener el correo electrónico del usuario desde la sesión
$userEmail = $_SESSION['correo']; 

// Crear una instancia del gestor de usuarios
$gestorUsuarios = new GestorUsuarios();

/**
 * Maneja la subida de la foto de perfil del usuario.
 *
 * @param string $userEmail El correo electrónico del usuario.
 * @param array $fileData Información del archivo de la foto de perfil (usualmente $_FILES['foto_perfil']).
 * 
 * @return bool|string Devuelve true si la foto se subió correctamente, o un mensaje de error en caso contrario.
 */
$result = $gestorUsuarios->subirFotoPerfil($userEmail, $_FILES['foto_perfil']); 

if ($result === true) {
    // Redirigir al perfil del usuario con un mensaje de éxito
    header("Location: ../view/perfil_user.php?mensaje=exito");
} else {
    // Redirigir al perfil del usuario con un mensaje de error
    header("Location: ../view/perfil_user.php?mensaje=" . urlencode($result));
}
exit(); // Finaliza la ejecución del script después de redirigir
?>
