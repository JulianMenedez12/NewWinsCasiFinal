<?php
// Incluir los archivos necesarios para la conexión a la base de datos y la gestión de noticias y usuarios
require_once '../model/conexion.php'; // Incluye el archivo que maneja la conexión a la base de datos
require_once '../model/gestor_noticias.php'; // Incluye el archivo que contiene la lógica para gestionar noticias
require_once '../model/gestor_usuarios.php'; // Incluye el archivo que contiene la lógica para gestionar usuarios

// Iniciar la sesión si no está iniciada
session_start(); // Inicia la sesión para poder utilizar variables de sesión

/**
 * Obtiene el correo electrónico del usuario autenticado desde la sesión.
 *
 * @var string $userEmail Correo electrónico del usuario autenticado.
 */
$userEmail = $_SESSION['correo']; // Obtiene el correo electrónico del usuario autenticado

/**
 * Obtiene los datos del usuario basándose en el correo electrónico almacenado en la sesión.
 *
 * @var array $user Datos del usuario obtenidos.
 */
$user = GestorUsuarios::getUserByEmail($userEmail); // Llama al método estático para obtener los datos del usuario

/**
 * Verifica si la solicitud es de tipo POST y si el campo 'texto' no está vacío.
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['texto'])) {
    /**
     * @var string $usuario Nombre de usuario tomado desde la información del usuario obtenida.
     */
    $usuario = $user['nombre_usuario']; // Nombre de usuario tomado desde la información del usuario obtenida

    /**
     * @var string $texto Texto del comentario enviado en la solicitud POST.
     */
    $texto = trim($_POST['texto']); // Elimina espacios en blanco al inicio y al final del texto del comentario

    /**
     * @var int $articulo_id ID del artículo al que se está agregando el comentario.
     */
    $articulo_id = intval($_POST['articulo_id']); // Convierte el ID del artículo a entero para evitar inyecciones SQL

    /**
     * @var int $puntuacion Puntuación inicial del comentario.
     */
    $puntuacion = 0; // Inicializa la puntuación del comentario en cero

    /**
     * @var PDO $conexion Conexión a la base de datos.
     */
    $conexion = ConexionBD::obtenerConexion(); // Obtiene la conexión a la base de datos utilizando el método estático

    /**
     * @var GestorContenido $gestorContenido Instancia de la clase GestorContenido.
     */
    $gestorContenido = new GestorContenido($conexion); // Inicializa el gestor de contenido con la conexión a la base de datos

    // Llamar al método para agregar el comentario al artículo especificado
    $gestorContenido->agregarComentario($usuario, $texto, $puntuacion, $articulo_id); // Agrega el comentario a la base de datos

    // Redirigir al usuario a la página de la noticia con el comentario agregado
    header("Location: ../view/ver_noticia.php?id=" . $articulo_id); // Redirige al usuario a la vista de la noticia
    exit(); // Termina la ejecución del script para evitar la ejecución de código adicional
} else {
    // Si el comentario está vacío, establecer un mensaje de error en la sesión
    $_SESSION['error'] = "El comentario no puede estar vacío."; // Mensaje de error para informar al usuario

    // Redirigir al usuario a la página de la noticia con el ID especificado
    header("Location: ../view/ver_noticia.php?id=" . intval($_POST['articulo_id'])); // Redirige a la página de la noticia
    exit(); // Termina la ejecución del script para evitar la ejecución de código adicional
}
?>
