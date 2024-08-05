<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("Location: admin.php");
    exit();
}

require_once '../model/conexion.php';
require_once '../model/gestor_usuarios.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUsuario = intval($_POST['id']);
    $accion = $_POST['accion'];
    $gestorUsuarios = new GestorUsuarios();

    if ($accion == 'dar') {
        $resultado = $gestorUsuarios->darAdmin($idUsuario);
    } else if ($accion == 'quitar') {
        $resultado = $gestorUsuarios->quitarAdmin($idUsuario);
    } else {
        $resultado = false;
    }

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
