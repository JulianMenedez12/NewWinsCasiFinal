<?php
session_start();
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';

// Configuración de la base de datos
$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);

// Obtener las noticias de tendencia
$noticiasTendencia = $gestorContenido->obtenerNoticiasTendencia();

if ($noticiasTendencia === false) {
    // En caso de error, redirigir a la vista con un parámetro de error
    header("Location: ../view/tendencias.php?error=no_tendencias");
    exit();
}

// Almacenar las noticias en la sesión si no hay error
$_SESSION['noticiasTendencia'] = $noticiasTendencia;

// Redirigir a la vista de tendencias
header("Location: ../view/tendencias.php");
exit();
?>
