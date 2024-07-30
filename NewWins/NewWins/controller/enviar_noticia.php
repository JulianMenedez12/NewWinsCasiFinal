<?php
session_start();
include '../model/conexion.php';
include '../model/gestor_noticias.php';

$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['user_id']; // Asegúrate de que el ID del usuario esté guardado en la sesión
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
