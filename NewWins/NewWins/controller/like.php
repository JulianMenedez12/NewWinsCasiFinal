<?php
session_start();
require_once '../model/conexion.php'; // Incluye tu archivo de conexión
require_once '../model/gestor_usuarios.php';
$user_id = GestorUsuarios::getUserIdByEmail($_SESSION['correo']);;
// Verifica que se hayan recibido los parámetros necesarios
if (isset($_POST['id_articulo']) && isset($_POST['id_usuario'])) {
    $id_articulo = intval($_POST['id_articulo']); // Asegúrate de que el ID del artículo sea un entero
    $id_usuario = $user_id; // Asegúrate de que el ID del usuario sea un entero

    // Consulta para agregar un like
    $sql = "INSERT INTO valoraciones_articulos (id_articulo, id_usuario, valoracion) VALUES (?, ?, 0)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $id_articulo, $id_usuario);
    $stmt->execute();

    // Verifica si la consulta se ejecutó correctamente
    if ($stmt->affected_rows > 0) {
        // Consulta para obtener el número actualizado de likes
        $sql = "SELECT COUNT(*) as total_likes FROM valoraciones_articulos WHERE id_articulo = ? AND valoracion = 0";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $id_articulo);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Devuelve el número de likes como respuesta
        echo $row['total_likes'];
    } else {
        echo "Error al agregar el like.";
    }
} else {
    // Devuelve los parámetros recibidos para depuración
    echo "Datos incompletos. id_articulo: " . (isset($_POST['id_articulo']) ? $_POST['id_articulo'] : 'No recibido') . ", id_usuario: " . (isset($user_id) ? $user_id : 'No recibido');
}
?>

