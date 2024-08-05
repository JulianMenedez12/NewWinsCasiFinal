<?php
session_start(); // Inicia la sesión si no está iniciada

// Incluir archivos necesarios para la conexión y gestión de noticias
require_once '../model/conexion.php'; // Incluye el archivo para la conexión a la base de datos
require_once '../model/gestor_noticias.php'; // Incluye el archivo que contiene la lógica para gestionar noticias

/**
 * Configura la conexión a la base de datos y obtiene las noticias de tendencia.
 *
 * @return void
 */
$conexion = ConexionBD::obtenerConexion(); // Obtiene la conexión a la base de datos utilizando el método estático
$gestorContenido = new GestorContenido($conexion); // Inicializa el gestor de contenido con la conexión a la base de datos

/**
 * Obtiene las noticias de tendencia desde el gestor de noticias.
 *
 * @return array|false Un array con las noticias de tendencia o false en caso de error.
 */
$noticiasTendencia = $gestorContenido->obtenerNoticiasTendencia(); // Llama al método para obtener noticias de tendencia

if ($noticiasTendencia === false) {
    // Si ocurre un error al obtener las noticias de tendencia, redirige a la vista con un parámetro de error
    header("Location: ../view/tendencias.php?error=no_tendencias");
    exit(); // Finaliza la ejecución del script después de redirigir
}

// Almacena las noticias en la sesión si no hubo error
$_SESSION['noticiasTendencia'] = $noticiasTendencia;

// Redirige a la vista de tendencias
header("Location: ../view/tendencias.php");
exit(); // Finaliza la ejecución del script después de redirigir
?>
