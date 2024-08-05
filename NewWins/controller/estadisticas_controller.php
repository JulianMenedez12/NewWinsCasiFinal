<?php
// Incluir los archivos necesarios para la conexión a la base de datos y la gestión de noticias
require_once '../model/conexion.php'; // Incluye el archivo que maneja la conexión a la base de datos
require_once '../model/gestor_noticias.php'; // Incluye el archivo que contiene la lógica para gestionar noticias

// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /**
     * @var string $fechaInicio Fecha de inicio del rango para las estadísticas.
     * @var string $fechaFin Fecha de fin del rango para las estadísticas.
     */
    $fechaInicio = $_POST['fecha_inicio']; // Fecha de inicio del rango para las estadísticas
    $fechaFin = $_POST['fecha_fin']; // Fecha de fin del rango para las estadísticas
    
    /**
     * @var PDO $conexion Conexión a la base de datos.
     */
    $conexion = ConexionBD::obtenerConexion(); // Llama al método estático para obtener la conexión a la base de datos
    
    /**
     * @var GestorContenido $gestorContenido Instancia de la clase GestorContenido con la conexión.
     */
    $gestorContenido = new GestorContenido($conexion); // Inicializa el gestor de contenido con la conexión
    
    /**
     * @var array $estadisticas Datos estadísticos para el rango de fechas proporcionado.
     */
    $estadisticas = $gestorContenido->obtenerEstadisticasPorRangoFechas($fechaInicio, $fechaFin); // Llama al método para obtener las estadísticas
    
    // Redirigir a la página de estadísticas con los parámetros necesarios
    header("Location: ../view/estadisticas.php?fecha_inicio=$fechaInicio&fecha_fin=$fechaFin" // Redirige a la página de estadísticas con los parámetros de fecha
        . "&total_articulos={$estadisticas['total_articulos']}" // Total de artículos en el rango de fechas
        . "&total_valoraciones={$estadisticas['total_valoraciones']}" // Total de valoraciones en el rango de fechas
        . "&total_comentarios={$estadisticas['total_comentarios']}" // Total de comentarios en el rango de fechas
        . "&total_usuarios={$estadisticas['total_usuarios']}" // Total de usuarios registrados en el rango de fechas
        . "&total_likes={$estadisticas['total_likes']}" // Total de likes en el rango de fechas
        . "&total_dislikes={$estadisticas['total_dislikes']}" // Total de dislikes en el rango de fechas
        . "&total_articulos_bandeja={$estadisticas['total_articulos_bandeja']}"); // Total de artículos en la bandeja de entrada en el rango de fechas
    exit(); // Termina la ejecución del script para evitar la ejecución de código adicional
}
?>
