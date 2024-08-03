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

    if ($gestorContenido->subirNoticiaBandeja($id, $titulo, $contenido, $url, $categoria_id)) {
        header("Location: ../view/manage_bandeja.php?id=$id&estado=exito");
    } else {
        header("Location: ../view/manage_bandeja.php?id=$id&estado=error");
    }
    exit();
}
?>
