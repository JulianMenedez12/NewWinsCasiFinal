<?php
// Iniciar la sesión si no está iniciada
if (!isset($_SESSION)) {
    session_start(); // Inicia una nueva sesión o reanuda la existente
}

// Destruir todas las variables de sesión
$_SESSION = array(); // Limpia todas las variables de sesión

// Destruir la sesión actual
session_destroy(); // Elimina la sesión actual del servidor

// Redirigir al usuario a la página de inicio de sesión o a donde desees
header("Location: ../view/index.php"); // Redirige al usuario a la página de inicio
exit(); // Termina la ejecución del script para evitar cualquier código adicional
?>
