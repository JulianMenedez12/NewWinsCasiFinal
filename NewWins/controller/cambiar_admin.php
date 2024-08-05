<?php
// Iniciar una nueva sesión o reanudar la sesión existente si no está ya iniciada
if (!isset($_SESSION)) session_start();

// Verificar si el usuario ha iniciado sesión comprobando la variable de sesión 'correo'
// Si no ha iniciado sesión, redirigir al usuario a la página de administración y finalizar la ejecución del script
if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("Location: admin.php");
    exit();
}

// Incluir los archivos necesarios para la conexión a la base de datos y el gestor de usuarios
require_once '../model/conexion.php';
require_once '../model/gestor_usuarios.php';

// Comprobar si el método de la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /**
     * Maneja la solicitud POST para conceder o revocar permisos de administrador a un usuario.
     *
     * @param int $idUsuario ID del usuario al que se le concederá o revocará el permiso de administrador.
     * @param string $accion Acción a realizar, puede ser 'dar' para conceder permisos o 'quitar' para revocar permisos.
     * @return void
     */
    $idUsuario = intval($_POST['id']); // Convertir el ID del usuario a un entero
    $accion = $_POST['accion']; // Obtener la acción (dar o quitar permisos de administrador)
    
    // Crear una instancia del gestor de usuarios
    $gestorUsuarios = new GestorUsuarios();

    // Ejecutar la acción correspondiente basada en el valor de $accion
    if ($accion == 'dar') {
        // Llamar al método darAdmin para conceder permisos de administrador
        $resultado = $gestorUsuarios->darAdmin($idUsuario);
    } else if ($accion == 'quitar') {
        // Llamar al método quitarAdmin para revocar permisos de administrador
        $resultado = $gestorUsuarios->quitarAdmin($idUsuario);
    } else {
        // Si la acción no es válida, establecer el resultado como false
        $resultado = false;
    }

    // Redirigir a la página de noticias con el estado del resultado (éxito o error)
    if ($resultado) {
        // Redirigir con mensaje de éxito
        header("Location: ../view/noticias.php?status=success");
    } else {
        // Redirigir con mensaje de error
        header("Location: ../view/noticias.php?status=error");
    }
    exit();
}
?>
