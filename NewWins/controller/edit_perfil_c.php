<?php

// Incluir el archivo de conexión a la base de datos y la clase GestorUsuarios
require_once('../model/conexion.php'); // Archivo que contiene la lógica para conectar con la base de datos
require_once('../model/gestor_usuarios.php'); // Archivo que contiene la lógica para gestionar usuarios

// Inicializar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia una nueva sesión o reanuda la sesión actual
}

// Verificar si el formulario fue enviado mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * Actualiza la información del usuario en la base de datos.
     *
     * @param string $username Nombre de usuario ingresado en el formulario.
     * @param string $firstName Primer nombre ingresado en el formulario.
     * @param string $lastName Apellido ingresado en el formulario.
     * @param string $location Ubicación ingresada en el formulario.
     * @param string $email Nuevo correo electrónico ingresado en el formulario.
     * @param string $currentEmail Correo electrónico actual almacenado en la sesión.
     * @return void
     */
    $username = $_POST['inputUsername']; // Nombre de usuario ingresado en el formulario
    $firstName = $_POST['inputFirstName']; // Primer nombre ingresado en el formulario
    $lastName = $_POST['inputLastName']; // Apellido ingresado en el formulario
    $location = $_POST['inputLocation']; // Ubicación ingresada en el formulario
    $email = $_POST['inputEmailAddress']; // Nuevo correo electrónico ingresado en el formulario
    $currentEmail = $_SESSION['correo']; // Correo electrónico actual almacenado en la sesión

    // Actualizar la información del usuario en la base de datos
    // Llama al método estático updateUser de la clase GestorUsuarios
    GestorUsuarios::updateUser($currentEmail, $username, $firstName, $lastName, $location, $email);

    // Verificar si el correo electrónico se ha cambiado
    if ($currentEmail != $email) {
        // Actualizar el correo electrónico en la sesión si ha cambiado
        $_SESSION['correo'] = $email; // Actualiza la sesión con el nuevo correo electrónico
    }

    // Redirigir al usuario a la página de perfil con un mensaje de éxito en la URL
    header("Location: ../view/perfil.php?mensaje=exito_cambio");
    exit; // Finaliza el script para evitar que se ejecute código adicional
}
?>
