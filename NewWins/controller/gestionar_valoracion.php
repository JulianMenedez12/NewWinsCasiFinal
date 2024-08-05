<?php
// Iniciar la sesión si no está iniciada
session_start();

/**
 * Verifica si la sesión del usuario está activa. Si no, redirige al login de administración.
 */
if (!isset($_SESSION['correo'])) {
    header("Location: admin.php"); // Redirige al administrador si no hay una sesión activa
    exit(); // Termina la ejecución del script
}

// Incluir archivos necesarios para la conexión a la base de datos y la gestión de noticias y usuarios
require_once '../model/conexion.php'; // Incluye el archivo que maneja la conexión a la base de datos
require_once '../model/gestor_noticias.php'; // Incluye el archivo que contiene la lógica para gestionar noticias
require_once '../model/gestor_usuarios.php'; // Incluye el archivo que contiene la lógica para gestionar usuarios

// Establecer el tipo de contenido a JSON para la respuesta
header('Content-Type: application/json'); // Define que la salida será en formato JSON

/**
 * @var int $articulo_id ID del artículo al que se le va a agregar una valoración.
 * @var string $valoracion Valoración enviada, puede ser 'like' o 'dislike'.
 */
$articulo_id = isset($_POST['articulo_id']) ? intval($_POST['articulo_id']) : 0; // Obtiene el ID del artículo, asegurándose de que sea un número entero
$valoracion = isset($_POST['valoracion']) ? $_POST['valoracion'] : ''; // Obtiene la valoración (like o dislike) enviada por POST

// Verificar que el ID del artículo es válido y que la valoración es 'like' o 'dislike'
if ($articulo_id > 0 && in_array($valoracion, ['like', 'dislike'])) {
    /**
     * @var PDO $conexion Conexión a la base de datos.
     * @var GestorContenido $gestorContenido Instancia del gestor de contenido con la conexión.
     * @var int $usuario_id ID del usuario basado en el correo electrónico almacenado en la sesión.
     * @var bool $resultado Resultado de la operación de agregar la valoración.
     * @var array $conteoValoraciones Conteo actualizado de valoraciones para el artículo.
     */
    $conexion = ConexionBD::obtenerConexion(); // Llama al método estático para obtener la conexión a la base de datos
    $gestorContenido = new GestorContenido($conexion); // Inicializa el gestor de contenido con la conexión
    $usuario_id = GestorUsuarios::getUserIdByEmail($_SESSION['correo']); // Obtiene el ID del usuario a partir del correo electrónico en la sesión

    // Procesar la valoración del artículo
    $resultado = $gestorContenido->agregarValoracion($articulo_id, $usuario_id, $valoracion); // Llama al método para agregar la valoración del artículo

    if ($resultado) {
        // Obtener el conteo actualizado de valoraciones para el artículo
        $conteoValoraciones = $gestorContenido->obtenerConteoValoraciones($articulo_id); // Llama al método para obtener el conteo actualizado de valoraciones

        // Enviar una respuesta JSON con el estado de éxito y los conteos actualizados
        echo json_encode([
            'success' => true, // Indica que la operación fue exitosa
            'likes' => $conteoValoraciones['likes'], // Número de likes actuales
            'dislikes' => $conteoValoraciones['dislikes'] // Número de dislikes actuales
        ]);
    } else {
        // Enviar una respuesta JSON indicando que la operación falló
        echo json_encode(['success' => false]); // Indica que la operación falló
    }
} else {
    // Enviar una respuesta JSON indicando que la solicitud no es válida
    echo json_encode(['success' => false]); // Indica que la solicitud es inválida
}
?>
