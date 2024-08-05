<?php
// Iniciar una nueva sesión o reanudar la sesión existente
session_start();

// Incluir los archivos necesarios para la conexión a la base de datos y el gestor de noticias
include '../model/conexion.php';
include '../model/gestor_noticias.php';

// Obtener una conexión a la base de datos
$conexion = ConexionBD::obtenerConexion();
// Crear una instancia del gestor de contenido/noticias
$gestorNoticias = new GestorContenido($conexion);

// Comprobar si la solicitud se ha realizado mediante el método POST y si los campos 'nombre' y 'descripcion' están presentes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre']) && isset($_POST['descripcion'])) {
    /**
     * Maneja la creación de una nueva categoría en la base de datos.
     *
     * @param string $nombre Nombre de la categoría.
     * @param string $descripcion Descripción de la categoría.
     * @param string|null $imagen Imagen de la categoría (opcional). Puede ser null si no se proporciona.
     * @return void
     */
    $nombre = $_POST['nombre']; // Nombre de la categoría
    $descripcion = $_POST['descripcion']; // Descripción de la categoría
    $imagen = isset($_POST['imagen']) ? $_POST['imagen'] : null; // Imagen de la categoría (opcional)

    // Llamar al método para crear una nueva categoría en la base de datos
    $categoria_creada = $gestorNoticias->crearCategoria($nombre, $descripcion, $imagen);

    // Verificar si la categoría se ha creado correctamente
    if ($categoria_creada) {
        // Si la categoría se creó con éxito, guardar un mensaje de éxito en la sesión
        $_SESSION['mensaje_exito'] = "Categoría creada con éxito";
        // Redirigir al usuario al panel de administración con un parámetro de éxito en la URL
        header("Location: ../view/admin_dashboard.php?categoria=exito");
        exit();
    } else {
        // Si hubo un error al crear la categoría, guardar un mensaje de error en la sesión
        $_SESSION['mensaje_error'] = "Error al crear la categoría";
        // Redirigir al usuario al panel de administración con un parámetro de error en la URL
        header("Location: ../view/admin_dashboard.php?categoria=error");
        exit();
    }
}
?>
