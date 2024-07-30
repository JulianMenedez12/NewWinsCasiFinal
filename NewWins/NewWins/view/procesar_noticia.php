<?php
session_start();
include '../model/conexion.php';
include '../model/gestor_noticias.php';

$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['accion'])) {
    $id = $_POST['id'];
    $accion = $_POST['accion'];

    if ($accion == 'aceptar') {
        // Redirigir al formulario de edición de la noticia
        header("Location: ../view/editar_noticia.php?id=$id");
        exit();
    } elseif ($accion == 'denegar') {
        // Eliminar la noticia de la bandeja de entrada
        if ($gestorContenido->eliminarNoticiaBandeja($id)) {
            $_SESSION['mensaje_exito'] = "Noticia denegada con éxito.";
        } else {
            $_SESSION['mensaje_error'] = "Error al denegar la noticia.";
        }
        header("Location: ../view/bandeja_entrada.php");
        exit();
    }
}
?>
