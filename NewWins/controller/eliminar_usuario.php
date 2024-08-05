<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: admin.php");
    exit();
}

require_once '../model/conexion.php';
require_once '../model/gestor_usuarios.php';

if (isset($_POST['id_usuario'])) {
    $idUsuario = intval($_POST['id_usuario']);
    $gestorUsuarios = new GestorUsuarios();

    if ($gestorUsuarios->eliminarUsuario($idUsuario)) {
        $_SESSION['mensaje'] = "Usuario eliminado exitosamente.";
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el usuario.";
    }

    header("Location: ../view/index.php");
    exit();
} else {
    header("Location: ../view/index.php");
    exit();
}
?>
