<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: ../view/admin.php");
    exit();
}

include '../model/conexion.php';
include '../model/gestor_noticias.php';

$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $url = $_POST['url'];
    $categoria_id = $_POST['categoria_id'];

    if ($gestorContenido->subirNoticia($titulo, $contenido, $url, $categoria_id)) {
        header("Location: ../view/gestionar_articulos.php?status=success");
    } else {
        header("Location: ../view/edit_news.php?status=error");
    }
    exit();
}
?>
