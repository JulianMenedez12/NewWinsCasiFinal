<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: admin.php");
    exit();
}

require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';
require_once '../model/gestor_usuarios.php';

// Asegúrate de que la conexión a la base de datos esté en la misma sesión
header('Content-Type: application/json');

// Obtén los datos enviados por POST
$articulo_id = isset($_POST['articulo_id']) ? intval($_POST['articulo_id']) : 0;
$valoracion = isset($_POST['valoracion']) ? $_POST['valoracion'] : '';

// Asegúrate de que el valor de la valoración sea válido
if ($articulo_id > 0 && in_array($valoracion, ['like', 'dislike'])) {
    $conexion = ConexionBD::obtenerConexion();
    $gestorContenido = new GestorContenido($conexion);

    // Obtén el ID del usuario desde la sesión
    $usuario_id = GestorUsuarios::getUserIdByEmail($_SESSION['correo']); // Asegúrate de que `usuario_id` esté disponible en la sesión

    // Procesa la valoración
    $resultado = $gestorContenido->agregarValoracion($articulo_id,$usuario_id, $valoracion );

    if ($resultado) {
        // Obtén el conteo actualizado de valoraciones
        $conteoValoraciones = $gestorContenido->obtenerConteoValoraciones($articulo_id);
        
        echo json_encode([
            'success' => true,
            'likes' => $conteoValoraciones['likes'],
            'dislikes' => $conteoValoraciones['dislikes']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
