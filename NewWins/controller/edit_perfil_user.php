<?php

// Incluir el archivo de conexión y la clase GestorUsuarios
require_once('../model/conexion.php');
require_once('../model/gestor_usuarios.php');

// Inicializar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Actualiza la información del usuario basado en el formulario enviado.
 * 
 * @param string $username Nombre de usuario nuevo.
 * @param string $firstName Primer nombre del usuario.
 * @param string $lastName Apellido del usuario.
 * @param string $location Ubicación del usuario.
 * @param string $email Nuevo correo electrónico del usuario.
 * @param string $currentEmail Correo electrónico actual del usuario.
 */
 
// Verificar si el formulario fue enviado
// Obtener los datos del formulario
$username = $_POST['inputUsername'];
$firstName = $_POST['inputFirstName'];
$lastName = $_POST['inputLastName'];
$location = $_POST['inputLocation'];
$email = $_POST['inputEmailAddress'];
$currentEmail = $_SESSION['correo'];

// Actualizar la información del usuario
GestorUsuarios::updateUser($currentEmail, $username, $firstName, $lastName, $location, $email);

// Actualizar la sesión si se cambió el correo electrónico
if ($currentEmail != $email) {
    $_SESSION['correo'] = $email;
}

// Redirigir a la página de perfil con un mensaje de éxito
header("Location: ../view/perfil_user.php?mensaje=exito_cambio");
exit;
?>

