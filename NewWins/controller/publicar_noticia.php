<?php
session_start();
include '../model/conexion.php';
include '../model/gestor_noticias.php';

/**
 * Publica una noticia después de recibir datos a través de una solicitud POST.
 *
 * @param int $id ID del artículo de la noticia a publicar.
 * @param string $titulo Título de la noticia.
 * @param string $contenido Contenido de la noticia.
 * @param int $categoria_id ID de la categoría a la que pertenece la noticia.
 *
 * @return void
 */
$conexion = ConexionBD::obtenerConexion(); // Obtiene la conexión a la base de datos.
$gestorContenido = new GestorContenido($conexion); // Inicializa el gestor de contenido con la conexión.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos enviados por POST
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0; // ID del artículo de la noticia
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : ''; // Título de la noticia
    $contenido = isset($_POST['contenido']) ? $_POST['contenido'] : ''; // Contenido de la noticia
    $categoria_id = isset($_POST['categoria_id']) ? intval($_POST['categoria_id']) : 0; // ID de la categoría

    // Publicar la noticia usando el gestor de contenido
    if ($gestorContenido->publicarNoticia($id, $titulo, $contenido, $categoria_id)) {
        $_SESSION['mensaje_exito'] = "Noticia publicada con éxito."; // Mensaje de éxito en sesión
        header("Location: bandeja_entrada.php"); // Redirige a la bandeja de entrada si la publicación es exitosa
    } else {
        $_SESSION['mensaje_error'] = "Error al publicar la noticia."; // Mensaje de error en sesión
        header("Location: editar_noticia.php?id=$id"); // Redirige a la página de edición si ocurre un error
    }
    exit(); // Termina la ejecución del script para evitar la ejecución de código adicional
}
?>
