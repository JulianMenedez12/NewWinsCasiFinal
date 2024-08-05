<?php
session_start();
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';

$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    
    $estadisticas = $gestorContenido->obtenerEstadisticasPorFecha($fecha);
    
    // Almacena las estadísticas en la sesión o pasa a la vista
    $_SESSION['estadisticas'] = $estadisticas;
    
    header("Location: ../view/estadisticas.php?fecha=$fecha");
    exit();
}
?>
