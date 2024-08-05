<?php
// Iniciar la sesión si no está iniciada
if (!isset($_SESSION)) session_start(); // Inicia una nueva sesión o reanuda la sesión actual

// Verificar si el usuario está autenticado
// Si no existe la variable de sesión 'correo', redirigir al usuario a la página de inicio de sesión (admin.php)
if (!isset($_SESSION['correo'])) {
    header("Location: ../view/admin.php"); // Redirige al usuario a la página de inicio de sesión
    exit(); // Finaliza la ejecución del script para evitar que se ejecute código adicional
}

// Incluir archivos necesarios para la conexión a la base de datos y la gestión de noticias
include '../model/conexion.php'; // Incluye el archivo que contiene la lógica para conectar con la base de datos
include '../model/gestor_noticias.php'; // Incluye el archivo que contiene la lógica para gestionar noticias

// Obtener la conexión a la base de datos
$conexion = ConexionBD::obtenerConexion(); // Obtiene la conexión a la base de datos utilizando el método estático de ConexionBD
$gestorContenido = new GestorContenido($conexion); // Crea una instancia de GestorContenido, pasando la conexión como parámetro

// Verificar si el formulario fue enviado mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * Edita una noticia en la base de datos.
     *
     * @param int $id ID de la noticia que se desea editar.
     * @param string $titulo Nuevo título de la noticia.
     * @param string $contenido Nuevo contenido de la noticia.
     * @param string $url Nueva URL de la imagen de la noticia.
     * @param int $categoria_id ID de la categoría a la que pertenece la noticia.
     * @return void
     */
    $id = $_POST['id']; // ID de la noticia que se desea editar
    $titulo = $_POST['titulo']; // Nuevo título de la noticia
    $contenido = $_POST['contenido']; // Nuevo contenido de la noticia
    $url = $_POST['url']; // Nueva URL de la imagen de la noticia
    $categoria_id = $_POST['categoria_id']; // ID de la categoría a la que pertenece la noticia

    // Llama al método de la clase GestorContenido para editar la noticia
    // Pasar todos los parámetros necesarios para la edición de la noticia
    if ($gestorContenido->editarNoticia($id, $titulo, $contenido, $url, $categoria_id)) {
        // Si la edición fue exitosa, redirigir a la página de gestión de artículos con un mensaje de éxito
        header("Location: ../view/gestionar_articulos.php?status=success"); // Redirige a la página de gestión de artículos con un parámetro de éxito
    } else {
        // Si la edición falló, redirigir a la página de edición de noticias con un mensaje de error
        header("Location: ../view/edit_news.php?status=error"); // Redirige a la página de edición de noticias con un parámetro de error
    }
    exit(); // Finaliza la ejecución del script para evitar que se ejecute código adicional
}
?>
