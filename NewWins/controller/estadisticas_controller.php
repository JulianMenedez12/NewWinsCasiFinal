<?php
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaFin = $_POST['fecha_fin'];
    
    $conexion = ConexionBD::obtenerConexion();
    $gestorContenido = new GestorContenido($conexion);
    
    $estadisticas = $gestorContenido->obtenerEstadisticasPorRangoFechas($fechaInicio, $fechaFin);
    
    header("Location: ../view/estadisticas.php?fecha_inicio=$fechaInicio&fecha_fin=$fechaFin&total_articulos={$estadisticas['total_articulos']}&total_valoraciones={$estadisticas['total_valoraciones']}&total_comentarios={$estadisticas['total_comentarios']}&total_usuarios={$estadisticas['total_usuarios']}&total_likes={$estadisticas['total_likes']}&total_dislikes={$estadisticas['total_dislikes']}&total_articulos_bandeja={$estadisticas['total_articulos_bandeja']}");
    exit();
}
?>
