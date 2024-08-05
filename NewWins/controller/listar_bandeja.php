<?php
// Archivo: controller/listar_bandeja.php

require_once '../model/conexion.php'; // Incluye el archivo que maneja la conexión a la base de datos
require_once '../model/BandejaEntrada.php'; // Incluye el archivo que contiene la lógica para gestionar la bandeja de entrada

/**
 * @var PDO $conn Conexión a la base de datos.
 * @var BandejaEntradaModel $model Instancia del modelo para manejar la bandeja de entrada.
 * @var array $articulos Artículos obtenidos de la bandeja de entrada.
 */

// Crear conexión
$conn = ConexionBD::obtenerConexion(); // Obtiene la conexión a la base de datos utilizando el método estático

// Crear instancia del modelo
$model = new BandejaEntradaModel($conn); // Inicializa el modelo de la bandeja de entrada con la conexión

// Obtener los artículos de la bandeja de entrada
$articulos = $model->obtenerArticulos(); // Llama al método para obtener los artículos de la bandeja de entrada

// Cerrar la conexión
$conn = null; // Cierra la conexión a la base de datos asignando null a la variable

// Los artículos ya están disponibles para la vista
?>
