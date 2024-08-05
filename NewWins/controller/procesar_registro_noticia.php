<?php
// Incluir el archivo que maneja la conexión a la base de datos
include '../model/conexion.php';
// Incluir el archivo que contiene la lógica para gestionar el contenido
include '../model/GestorContenido.php';

// Obtener la conexión a la base de datos
$conexion = ConexionBD::obtenerConexion();
// Crear una instancia del gestor de contenido con la conexión
$gestor = new GestorContenido($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * Maneja la solicitud POST para subir una noticia.
     *
     * @param string $titulo Título de la noticia proporcionado en la solicitud POST.
     * @param string $contenido Contenido de la noticia proporcionado en la solicitud POST.
     * @param string $url URL de la noticia proporcionado en la solicitud POST.
     * @param int $categoria_id ID de la categoría a la que pertenece la noticia, proporcionado en la solicitud POST.
     * @return void
     */
    $titulo = $_POST['titulo']; // Obtener el título de la noticia de la solicitud POST
    $contenido = $_POST['contenido']; // Obtener el contenido de la noticia de la solicitud POST
    $url = $_POST['url']; // Obtener la URL de la noticia de la solicitud POST
    $categoria_id = $_POST['categoria_id']; // Obtener el ID de la categoría de la noticia de la solicitud POST

    // Llamar al método para subir la noticia con los datos proporcionados
    $gestor->subirNoticia($titulo, $contenido, $url, $categoria_id);
}
?>
