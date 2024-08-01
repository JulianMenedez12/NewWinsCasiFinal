<?php
session_start();
include '../model/conexion.php';
include '../model/gestor_noticias.php';

$conexion = ConexionBD::obtenerConexion();
$gestorNoticias = new GestorContenido($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre']) && isset($_POST['descripcion'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $imagen = isset($_POST['imagen']) ? $_POST['imagen'] : null;

    // Llamar al método para crear categoría
    $categoria_creada = $gestorNoticias->crearCategoria($nombre, $descripcion, $imagen);

    if ($categoria_creada) {
        $_SESSION['mensaje_exito'] = "Categoría creada con éxito";
        header("Location: ../view/admin_dashboard.php?categoria=exito");
        exit();
    } else {
        $_SESSION['mensaje_error'] = "Error al crear la categoría";
        header("Location: ../view/admin_dashboard.php?categoria=error");
        exit();
    }
}
