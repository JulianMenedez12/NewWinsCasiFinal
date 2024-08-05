<?php
// Iniciar la sesión si no está iniciada
session_start(); // Inicia la sesión para poder utilizar variables de sesión

// Incluir los archivos necesarios para la conexión a la base de datos y la gestión de noticias y usuarios
require_once '../model/conexion.php'; // Incluye el archivo que maneja la conexión a la base de datos
require_once '../model/gestor_noticias.php'; // Incluye el archivo que contiene la lógica para gestionar noticias
require_once '../model/gestor_usuarios.php'; // Incluye el archivo que contiene la lógica para gestionar usuarios

/**
 * Obtiene la conexión a la base de datos.
 *
 * @var PDO $conexion Conexión a la base de datos.
 */
$conexion = ConexionBD::obtenerConexion(); // Obtiene la conexión a la base de datos utilizando el método estático

/**
 * @var GestorContenido $gestorContenido Instancia de la clase GestorContenido para manejar el contenido de noticias.
 */
$gestorContenido = new GestorContenido($conexion); // Inicializa el gestor de contenido con la conexión a la base de datos

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * @var int $usuario_id ID del usuario basado en el correo electrónico almacenado en la sesión.
     */
    $usuario_id = GestorUsuarios::getUserIdByEmail($_SESSION['correo']); // Llama al método estático para obtener el ID del usuario

    /**
     * @var string $titulo Título de la noticia.
     * @var string $contenido Contenido de la noticia.
     * @var string $url URL de la noticia.
     * @var int $categoria_id ID de la categoría a la que pertenece la noticia.
     */
    $titulo = $_POST['titulo']; // Título de la noticia
    $contenido = $_POST['contenido']; // Contenido de la noticia
    $url = $_POST['url']; // URL de la noticia
    $categoria_id = intval($_POST['categoria_id']); // ID de la categoría a la que pertenece la noticia, convertido a entero para mayor seguridad

    // Llamar al método para enviar la noticia con los parámetros proporcionados
    if ($gestorContenido->enviarNoticia($usuario_id, $titulo, $contenido, $categoria_id, $url)) {
        // Redirigir a la página de envío de noticias con un mensaje de éxito si la operación fue exitosa
        header("Location: ../view/enviar_news.php?noticia=exito"); // Redirige al usuario con un parámetro de éxito en la URL
    } else {
        // Redirigir a la página de envío de noticias con un mensaje de error si la operación falló
        header("Location: ../view/enviar_news.php?noticia=error"); // Redirige al usuario con un parámetro de error en la URL
    }
    exit(); // Termina la ejecución del script para evitar la ejecución de código adicional
}
?>
