<?php
session_start();
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';

$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $url = $_POST['url'];
    $categoria_id = $_POST['categoria_id'];

    if ($gestorContenido->subirNoticiaBandeja($titulo, $contenido, $url, $categoria_id)) {
        $gestorContenido->eliminarDeBandeja($id); // Eliminar de la bandeja de entrada
        header("Location: ../view/manage_bandeja.php?noticia=exito");
    } else {
        header("Location: ../view/editar_noticia.php?id=$id&noticia=error");
    }
    exit();
}
?>
