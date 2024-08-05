<?php
require_once '../model/conexion.php'; // Incluye el archivo que maneja la conexión a la base de datos

/**
 * Obtiene una lista de opciones HTML para un elemento <select> basado en las categorías de la base de datos.
 * 
 * @return string $salida Código HTML para las opciones del elemento <select>.
 */
function aa() {
    // Establece la conexión a la base de datos
    $conexion = ConexionBD::obtenerConexion(); // Obtiene la conexión a la base de datos utilizando el método estático
    
    $salida = ""; // Inicializa la variable para almacenar el código HTML
    
    // Consulta SQL para obtener todas las categorías
    $sql = "SELECT * FROM categorias";
    $result = $conexion->query($sql); // Ejecuta la consulta SQL
    
    // Itera sobre los resultados de la consulta
    while ($fila = $result->fetch_assoc()) {
        // Agrega cada categoría como una opción en el código HTML
        $salida .= "<option value='" . $fila['id'] . "'>" . $fila['nombre'] . "</option>";
    }
    
    return $salida; // Devuelve el código HTML con las opciones para el elemento <select>
}
?>
