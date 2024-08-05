<?php
// controller/eliminar_noticia.php

// Incluir los archivos necesarios para la conexión a la base de datos y la gestión de noticias
include '../model/conexion.php'; // Incluye el archivo que contiene la lógica para conectar con la base de datos
include '../model/gestor_noticias.php'; // Incluye el archivo que contiene la lógica para gestionar noticias

// Obtener la conexión a la base de datos
$conexion = ConexionBD::obtenerConexion(); // Obtiene una instancia de la conexión a la base de datos utilizando el método estático de ConexionBD

// Crear una instancia de GestorContenido, pasando la conexión a la base de datos como parámetro
$gestor = new GestorContenido($conexion);

/**
 * Elimina una noticia de la base de datos.
 *
 * @param int $id ID de la noticia a eliminar.
 * @return void
 */
if (isset($_GET['id'])) {
    /**
     * Obtener y convertir el parámetro 'id' a entero.
     *
     * @var int $id
     */
    $id = intval($_GET['id']); // Obtener y convertir el parámetro 'id' a entero para asegurar que es un valor numérico válido

    // Intentar eliminar la noticia utilizando el método 'eliminarNoticia' de la clase GestorContenido
    if ($gestor->eliminarNoticia($id)) {
        // Si la eliminación fue exitosa, devolver un JSON con éxito
        echo json_encode(array("success" => true)); // Codifica una respuesta JSON indicando éxito
    } else {
        // Si la eliminación falló, devolver un JSON con error
        echo json_encode(array("success" => false)); // Codifica una respuesta JSON indicando fracaso
    }
}
?>
