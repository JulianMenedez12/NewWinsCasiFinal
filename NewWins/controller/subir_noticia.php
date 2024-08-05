<?php
session_start(); // Inicia la sesión si no está iniciada

// Incluir archivos necesarios para la conexión y gestión de noticias
include '../model/conexion.php'; // Incluye el archivo para la conexión a la base de datos
include '../model/gestor_noticias.php'; // Incluye el archivo que contiene la lógica para gestionar noticias

/**
 * Maneja la solicitud POST para subir una noticia.
 *
 * @param string $titulo El título de la noticia.
 * @param string $contenido El contenido de la noticia.
 * @param string $url La URL de la noticia.
 * @param int $categoria_id El identificador de la categoría de la noticia.
 */
$conexion = ConexionBD::obtenerConexion(); // Obtiene la conexión a la base de datos utilizando el método estático
$gestorNoticias = new GestorContenido($conexion); // Inicializa el gestor de noticias con la conexión a la base de datos

// Verificar si la solicitud es de tipo POST y si se enviaron los datos esperados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['titulo'], $_POST['contenido'], $_POST['url'], $_POST['categoria_id'])) {
    // Obtener los datos enviados por POST
    $titulo = $_POST['titulo']; // Título de la noticia
    $contenido = $_POST['contenido']; // Contenido de la noticia
    $url = $_POST['url']; // URL de la noticia
    $categoria_id = $_POST['categoria_id']; // ID de la categoría de la noticia

    /**
     * Intenta subir la noticia utilizando el método del gestor de noticias.
     * 
     * @return bool Retorna true si la noticia se sube correctamente, false en caso contrario.
     */
    $noticia_subida = $gestorNoticias->subirNoticia($titulo, $contenido, $url, $categoria_id);

    // Verificar si la noticia se subió correctamente
    if ($noticia_subida) {
        // Si la noticia se subió correctamente, establecer un mensaje de éxito en la sesión y redirigir al dashboard
        $_SESSION['mensaje_exito'] = "Noticia subida con éxito";
        header("Location: ../view/admin_dashboard.php?noticia=exito");
        exit(); // Finaliza la ejecución del script después de redirigir
    } else {
        // Si hubo un error al subir la noticia, establecer un mensaje de error en la sesión y redirigir al dashboard
        $_SESSION['mensaje_error'] = "Error al subir la noticia";
        header("Location: ../view/admin_dashboard.php?noticia=error");
        exit(); // Finaliza la ejecución del script después de redirigir
    }
} else {
    // Redirigir al dashboard si no se recibieron los datos esperados por POST
    header("Location: ../view/admin_dashboard.php");
    exit(); // Finaliza la ejecución del script después de redirigir
}
?>
