<?php
session_start();
include '../model/conexion.php';
include '../model/gestor_noticias.php';

$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $categoria_id = $_POST['categoria_id'];

    if ($gestorContenido->publicarNoticia($id, $titulo, $contenido, $categoria_id)) {
        $_SESSION['mensaje_exito'] = "Noticia publicada con éxito.";
        header("Location: bandeja_entrada.php");
    } else {
        $_SESSION['mensaje_error'] = "Error al publicar la noticia.";
        header("Location: editar_noticia.php?id=$id");
    }
    exit();
}
?>
 