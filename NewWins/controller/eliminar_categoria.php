<?php
// controller/eliminar_categoria.php

// Incluir los archivos necesarios para la conexión a la base de datos y la gestión de noticias
include '../model/conexion.php'; // Incluye el archivo que contiene la lógica para conectar con la base de datos
include '../model/gestor_noticias.php'; // Incluye el archivo que contiene la lógica para gestionar noticias

// Obtener la conexión a la base de datos
$conexion = ConexionBD::obtenerConexion(); // Obtiene una instancia de la conexión a la base de datos utilizando el método estático de ConexionBD

// Crear una instancia de GestorContenido, pasando la conexión a la base de datos como parámetro
$gestor = new GestorContenido($conexion);

/**
 * Elimina una categoría de la base de datos.
 *
 * @param int $id ID de la categoría a eliminar.
 * @return void
 */
if (isset($_GET['id'])) {
    /**
     * Obtener y convertir el parámetro 'id' a entero.
     *
     * @var int $id
     */
    $id = intval($_GET['id']); // Obtener y convertir el parámetro 'id' a entero

    // Intentar eliminar la categoría utilizando el método 'eliminarCategoria' de la clase GestorContenido
    if ($gestor->eliminarCategoria($id)) {
        // Si la eliminación fue exitosa, redirigir a la página de gestión de categorías con un mensaje de éxito
        header("Location: ../view/gestionar_categorias.php?status=success"); // Redirige a la página de gestión de categorías con un parámetro de éxito en la URL
    } else {
        // Si la eliminación falló, redirigir a la página de gestión de categorías con un mensaje de error
        header("Location: ../view/gestionar_categorias.php?status=error"); // Redirige a la página de gestión de categorías con un parámetro de error en la URL
    }
    // Finalizar la ejecución del script después de la redirección
    exit(); // Evita que se ejecute cualquier código adicional después de la redirección
}
?>
