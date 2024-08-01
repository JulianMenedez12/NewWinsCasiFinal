<?php
session_start();
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';
require_once '../model/gestor_usuarios.php';

$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = GestorUsuarios::getUserIdByEmail($_SESSION['correo']);
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $categoria_id = $_POST['categoria_id'];

    if ($gestorContenido->enviarNoticia($usuario_id, $titulo, $contenido, $categoria_id)) {
        header("Location: ../view/enviar_news.php?noticia=exito");
    } else {
        header("Location: ../view/enviar_news.php?noticia=error");
    }
    exit();
}
?>
