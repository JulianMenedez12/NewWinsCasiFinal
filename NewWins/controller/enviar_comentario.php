<?php
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';
require_once '../model/gestor_usuarios.php';
session_start();
$userEmail = $_SESSION['correo'];
$user = GestorUsuarios::getUserByEmail($userEmail);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['texto'])) {
    $usuario = $user['nombre_usuario']; // Nombre de usuario tomado desde la sesión
    $texto = trim($_POST['texto']);
    $articulo_id = intval($_POST['articulo_id']); // Asegurarse de que sea un número entero
    $puntuacion = 0; // Puntuación inicial de cero

    $conexion = ConexionBD::obtenerConexion();
    $gestorContenido = new GestorContenido($conexion);

    $gestorContenido->agregarComentario($usuario, $texto, $puntuacion, $articulo_id);

    header("Location: ../view/ver_noticia.php?id=" . $articulo_id);
    exit();
} else {
    $_SESSION['error'] = "El comentario no puede estar vacío.";
    header("Location: ../view/ver_noticia.php?id=" . intval($_POST['articulo_id']));
    exit();
}
?>