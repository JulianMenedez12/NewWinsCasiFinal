<?php
session_start();

// Incluir archivos necesarios
include '../model/conexion.php';
include '../model/gestor_noticias.php';

// Obtener conexión a la base de datos
$conexion = ConexionBD::obtenerConexion();
$gestorNoticias = new GestorContenido($conexion);

// Verificar si el método de solicitud es POST y si se enviaron los datos esperados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['titulo'], $_POST['contenido'], $_POST['url'], $_POST['categoria_id'])) {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $url = $_POST['url'];
    $categoria_id = $_POST['categoria_id'];

    // Llamar al método para subir noticia
    $noticia_subida = $gestorNoticias->subirNoticia($titulo, $contenido, $url, $categoria_id);

    // Verificar si la noticia se subió correctamente
    if ($noticia_subida) {
        // Establecer mensaje de éxito en sesión y redirigir a la página de administración
        $_SESSION['mensaje_exito'] = "Noticia subida con éxito";
        header("Location: ../view/admin_dashboard.php?noticia=exito");
        exit();
    } else {
        // Establecer mensaje de error en sesión y redirigir a la página de administración
        $_SESSION['mensaje_error'] = "Error al subir la noticia";
        header("Location: ../view/admin_dashboard.php?noticia=error");
        exit();
    }
} else {
    // Redirigir al dashboard si no se recibieron los datos esperados por POST
    header("Location: ../view/admin_dashboard.php");
    exit();
}
