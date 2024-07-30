<?php
session_start();

if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("Location: index.php");
    exit();
}

require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';

$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    $termino = htmlspecialchars($_GET['q']);

    // Realizar la búsqueda en la base de datos
    $resultados = $gestorContenido->buscarNoticias($termino);

    // Guardar los resultados en la sesión para mostrar en la vista
    $_SESSION['resultados_busqueda'] = $resultados;
    $_SESSION['termino_busqueda'] = $termino;
}

// Redirigir a la página de resultados de búsqueda
header("Location: ../view/resultados_busqueda.php");
exit();
