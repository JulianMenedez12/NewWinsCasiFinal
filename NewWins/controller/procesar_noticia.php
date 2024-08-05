<?php
session_start(); // Inicia o reanuda la sesión actual

// Incluir el archivo que maneja la conexión a la base de datos
include '../model/conexion.php';
// Incluir el archivo que contiene la lógica para gestionar noticias
include '../model/gestor_noticias.php';

// Obtener la conexión a la base de datos
$conexion = ConexionBD::obtenerConexion();
// Crear una instancia del gestor de contenido con la conexión
$gestorContenido = new GestorContenido($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['accion'])) {
    /**
     * Maneja la acción solicitada para una noticia en la bandeja de entrada.
     *
     * @param int $id ID de la noticia obtenido de la solicitud POST.
     * @param string $accion Acción solicitada, que puede ser 'aceptar' o 'denegar'.
     * @return void
     */
    $id = $_POST['id']; // Obtener el ID de la noticia de la solicitud POST
    $accion = $_POST['accion']; // Obtener la acción solicitada de la solicitud POST

    if ($accion == 'aceptar') {
        // Redirigir al formulario de edición de la noticia
        header("Location: ../view/editar_noticia.php?id=$id");
        exit(); // Terminar la ejecución del script después de redirigir
    } elseif ($accion == 'denegar') {
        // Eliminar la noticia de la bandeja de entrada
        if ($gestorContenido->eliminarNoticiaBandeja($id)) {
            $_SESSION['mensaje_exito'] = "Noticia denegada con éxito."; // Mensaje de éxito para la sesión
        } else {
            $_SESSION['mensaje_error'] = "Error al denegar la noticia."; // Mensaje de error para la sesión
        }
        header("Location: ../view/manage_bandeja.php"); // Redirigir a la página de gestión de la bandeja de entrada
        exit(); // Terminar la ejecución del script después de redirigir
    }
}
?>
