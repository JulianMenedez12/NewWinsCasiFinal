<?php
// Iniciar la sesión si no está iniciada
session_start(); 

// Incluir archivos necesarios para la conexión a la base de datos y la gestión de noticias
require_once '../model/conexion.php'; // Incluye el archivo para la conexión a la base de datos
require_once '../model/gestor_noticias.php'; // Incluye el archivo que contiene la lógica para gestionar noticias

/**
 * Maneja la solicitud POST para subir una noticia a la bandeja de entrada.
 *
 * @param int $id El identificador del artículo.
 * @param string $titulo El título del artículo.
 * @param string $contenido El contenido del artículo.
 * @param string $url La URL del artículo.
 * @param int $categoria_id El identificador de la categoría del artículo.
 */
$conexion = ConexionBD::obtenerConexion(); // Obtiene la conexión a la base de datos utilizando el método estático
$gestorContenido = new GestorContenido($conexion); // Inicializa el gestor de noticias con la conexión a la base de datos

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados por POST
    $id = $_POST['id']; // Identificador del artículo
    $titulo = $_POST['titulo']; // Título del artículo
    $contenido = $_POST['contenido']; // Contenido del artículo
    $url = $_POST['url']; // URL del artículo
    $categoria_id = $_POST['categoria_id']; // ID de la categoría del artículo

    /**
     * Intenta subir la noticia a la bandeja de entrada utilizando el método del gestor de noticias.
     * 
     * @return void Redirige a la vista de gestión de la bandeja con un estado de éxito o error.
     */
    if ($gestorContenido->subirNoticiaBandeja($id, $titulo, $contenido, $url, $categoria_id)) {
        // Si la operación es exitosa, redirigir a la vista de gestión de la bandeja con un estado de éxito
        header("Location: ../view/manage_bandeja.php?id=$id&estado=exito");
    } else {
        // Si la operación falla, redirigir a la vista de gestión de la bandeja con un estado de error
        header("Location: ../view/manage_bandeja.php?id=$id&estado=error");
    }
    exit(); // Finaliza la ejecución del script después de redirigir
}
?>
