<?php
// Iniciar una nueva sesión o reanudar la sesión existente
session_start();

// Verificar si el usuario ha iniciado sesión mediante la comprobación de la variable de sesión 'correo'
// Si no ha iniciado sesión, redirigir al usuario a la página de inicio de sesión y finalizar la ejecución del script
if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("Location: index.php");
    exit();
}

// Incluir los archivos necesarios para la conexión a la base de datos y el gestor de contenido
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';

// Obtener la conexión a la base de datos utilizando el método estático obtenerConexion de la clase ConexionBD
$conexion = ConexionBD::obtenerConexion();

// Crear una instancia del gestor de contenido pasando la conexión a la base de datos como parámetro
$gestorContenido = new GestorContenido($conexion);

// Comprobar si el método de la solicitud es GET y si el parámetro 'q' está presente en la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    // Escapar caracteres especiales en el término de búsqueda para evitar inyección de código
    $termino = htmlspecialchars($_GET['q']);

    /**
     * Realizar la búsqueda de noticias en la base de datos
     * @param string $termino El término de búsqueda ingresado por el usuario
     * @return array $resultados Los resultados de la búsqueda como un array asociativo
     */
    $resultados = $gestorContenido->buscarNoticias($termino);

    // Guardar los resultados de la búsqueda y el término de búsqueda en las variables de sesión
    $_SESSION['resultados_busqueda'] = $resultados;
    $_SESSION['termino_busqueda'] = $termino;
}

// Redirigir al usuario a la página de resultados de búsqueda
header("Location: ../view/resultados_busqueda.php");
exit();
?>
