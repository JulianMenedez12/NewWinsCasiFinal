<?php
// Incluir archivos de configuración y conexión a la base de datos
require_once('config.php');
require_once('conexion.php');

// Archivo: ../model/gestor_noticias.php

// Definición de la clase GestorContenido
class GestorContenido
{
    // Propiedad para almacenar la conexión a la base de datos
    private $conn;

    // Constructor que inicializa la conexión a la base de datos
    public function __construct($conexion)
    {
        $this->conn = $conexion;
    }

    // Método para subir una noticia a la base de datos
    public function subirNoticia($titulo, $contenido, $url, $categoria_id)
    {
        // Crea un objeto DateTime con la zona horaria de Bogotá
        $fecha = new DateTime('now', new DateTimeZone('America/Bogota'));
        // Formatea la fecha y hora para que se ajuste al formato de la base de datos
        $fecha_publicacion = $fecha->format('Y-m-d H:i:s');

        // Verifica que todos los parámetros necesarios no estén vacíos
        if (!empty($titulo) && !empty($contenido) && !empty($url) && !empty($categoria_id)) {
            // Consulta SQL para insertar una nueva noticia en la tabla 'articulos'
            $sql = "INSERT INTO articulos (titulo, fecha_publicacion, contenido, url, categoria_id) VALUES (?, ?, ?, ?, ?)";
            // Preparar la consulta SQL
            $stmt = $this->conn->prepare($sql);
            // Vincular los parámetros a la consulta preparada
            $stmt->bind_param("ssssi", $titulo, $fecha_publicacion, $contenido, $url, $categoria_id);

            // Ejecutar la consulta y verificar si la inserción fue exitosa
            if ($stmt->execute()) {
                return true; // Devolver true si la inserción fue exitosa
            } else {
                return false; // Devolver false si hubo un error en la inserción
            }
        } else {
            return false; // Devolver false si faltan datos
        }
    }

    // Método para listar todas las categorías de la base de datos
    public function listarCategorias()
    {
        // Consulta SQL para seleccionar todas las categorías
        $sql = "SELECT * FROM categorias";
        // Ejecutar la consulta SQL
        $result = $this->conn->query($sql);
        // Devolver el resultado de la consulta
        return $result;
    }

    // Método para listar todas las noticias de la base de datos
    public function listarNoticias()
    {
        // Consulta SQL para seleccionar noticias y sus categorías
        $sql = "SELECT a.id, c.nombre AS categoria, a.titulo, a.contenido, a.url, a.fecha_publicacion
            FROM articulos a
            JOIN categorias c ON a.categoria_id = c.id";
        // Ejecutar la consulta SQL
        $result = $this->conn->query($sql);
        // Devolver el resultado de la consulta
        return $result;
    }

    public function eliminarNoticia($id)
{
    // Consulta SQL para eliminar una noticia por su ID
    $sql = "DELETE FROM articulos WHERE id = ?";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular el parámetro de ID a la consulta preparada
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta y verificar si la eliminación fue exitosa
    if ($stmt->execute()) {
        return true; // Devolver true si la eliminación fue exitosa
    } else {
        return false; // Devolver false si hubo un error en la eliminación
    }
}

public function eliminarCategoria($id)
{
    // Iniciar una transacción para asegurar la integridad de los datos
    $this->conn->begin_transaction();

    try {
        // Primero, eliminar todos los artículos relacionados con la categoría
        $sql_articulos = "DELETE FROM articulos WHERE categoria_id = ?";
        $stmt_articulos = $this->conn->prepare($sql_articulos);
        $stmt_articulos->bind_param("i", $id);
        $stmt_articulos->execute();

        // Luego, eliminar la categoría
        $sql_categoria = "DELETE FROM categorias WHERE id = ?";
        $stmt_categoria = $this->conn->prepare($sql_categoria);
        $stmt_categoria->bind_param("i", $id);
        $stmt_categoria->execute();

        // Si ambas operaciones fueron exitosas, confirmar la transacción
        $this->conn->commit();
        return true;
    } catch (Exception $e) {
        // Si hubo un error, revertir la transacción
        $this->conn->rollback();
        return false;
    }
}

public function crearCategoria($nombre, $descripcion, $imagen)
{
    // Verificar que el nombre y la descripción no estén vacíos
    if (!empty($nombre) && !empty($descripcion)) {
        // Consulta SQL para insertar una nueva categoría
        $stmt = $this->conn->prepare("INSERT INTO categorias (nombre, descripcion, imagen) VALUES (?, ?, ?)");
        // Vincular los parámetros a la consulta preparada
        $stmt->bind_param("sss", $nombre, $descripcion, $imagen);

        // Ejecutar la consulta y verificar si la inserción fue exitosa
        if ($stmt->execute()) {
            return true; // Devolver true si la inserción fue exitosa
        } else {
            return false; // Devolver false si hubo un error en la inserción
        }
    } else {
        return false; // Devolver false si faltan datos
    }
}

public function editarNoticia($id, $titulo, $contenido, $url, $categoria_id)
{
    // Consulta SQL para actualizar una noticia existente en la base de datos
    $sql = "UPDATE articulos SET titulo = ?, contenido = ?, url = ?, categoria_id = ? WHERE id = ?";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular los parámetros a la consulta preparada
    $stmt->bind_param("sssii", $titulo, $contenido, $url, $categoria_id, $id);

    // Ejecutar la consulta y verificar si la actualización fue exitosa
    if ($stmt->execute()) {
        return true; // Devolver true si la actualización fue exitosa
    } else {
        return false; // Devolver false si hubo un error en la actualización
    }
}

public function obtenerCategoriaPorId($id)
{
    // Consulta SQL para obtener una categoría por su ID
    $sql = "SELECT * FROM categorias WHERE id = ?";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        throw new RuntimeException("Error preparando la consulta: " . $this->conn->error);
    }

    // Vincular el parámetro de ID a la consulta preparada
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    // Verificar si se encontró la categoría
    if ($result->num_rows === 0) {
        throw new RuntimeException("No se encontró la categoría con ID $id.");
    }
    // Devolver los datos de la categoría encontrada
    return $result->fetch_assoc();
}

public function obtenerNoticiaPorId($id)
{
    // Consulta SQL para obtener una noticia por su ID
    $stmt = $this->conn->prepare("SELECT * FROM articulos WHERE id = ?");
    // Vincular el parámetro de ID a la consulta preparada
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    // Devolver los datos de la noticia encontrada
    return $resultado->fetch_assoc();
}

public function listarNoticiasConPaginacion($limite, $offset)
{
    // Consulta SQL para listar noticias con paginación
    $sql = "SELECT a.id, c.nombre AS categoria, a.titulo, a.contenido, a.url, a.fecha_publicacion 
        FROM articulos a
        JOIN categorias c ON a.categoria_id = c.id
        LIMIT ? OFFSET ?";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular los parámetros de límite y desplazamiento a la consulta preparada
    $stmt->bind_param("ii", $limite, $offset);
    $stmt->execute();
    // Devolver el resultado de la consulta
    return $stmt->get_result();
}

public function buscarNoticias($termino)
{
    // Dividir el término de búsqueda en palabras individuales
    $terminos = explode(' ', $termino);
    $sql = "SELECT * FROM articulos WHERE ";
    $params = [];
    $types = '';
    
    // Construir la consulta SQL dinámica para buscar en el título y el contenido
    foreach ($terminos as $index => $palabra) {
        if ($index > 0) {
            $sql .= " OR ";
        }
        $sql .= "(titulo LIKE ? OR contenido LIKE ?)";
        $params[] = "%" . $palabra . "%";
        $params[] = "%" . $palabra . "%";
        $types .= 'ss';
    }

    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular los parámetros de búsqueda a la consulta preparada
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    // Recopilar los resultados en un array
    $noticias = [];
    while ($row = $result->fetch_assoc()) {
        $noticias[] = $row;
    }
    // Devolver el array de noticias encontradas
    return $noticias;
}

public function listarArticulosPorCategoria($categoria_id)
{
    // Consulta SQL para obtener todos los artículos de una categoría específica
    $sql = "SELECT * FROM articulos WHERE categoria_id = ?";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular el parámetro de ID de categoría a la consulta preparada
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Recopilar los artículos en un array
    $articulos = [];
    while ($row = $result->fetch_assoc()) {
        $articulos[] = $row;
    }

    // Devolver el array de artículos
    return $articulos;
}

// Método para agregar un comentario a un artículo
public function agregarComentario($usuario, $texto, $puntuacion, $articulo_id)
{
    // Consulta SQL para insertar un nuevo comentario
    $sql = "INSERT INTO comentarios (usuario, texto, puntuacion, articulo_id) VALUES (?, ?, ?, ?)";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular los parámetros del comentario a la consulta preparada
    $stmt->bind_param("ssii", $usuario, $texto, $puntuacion, $articulo_id);
    
    // Ejecutar la consulta y manejar posibles errores
    if (!$stmt->execute()) {
        throw new Exception("Error al agregar comentario: " . $stmt->error);
    }
    // Cerrar la declaración
    $stmt->close();
}

// Método para obtener todos los comentarios de un artículo específico
public function obtenerComentariosPorArticuloId($articulo_id)
{
    // Consulta SQL para seleccionar los comentarios de un artículo ordenados por fecha
    $sql = "SELECT usuario, fecha_hora, texto, puntuacion FROM comentarios WHERE articulo_id = ? ORDER BY fecha_hora DESC";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular el parámetro de ID de artículo a la consulta preparada
    $stmt->bind_param("i", $articulo_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Recopilar los comentarios en un array
    $comentarios = [];
    while ($row = $result->fetch_assoc()) {
        $comentarios[] = $row;
    }
    // Cerrar la declaración
    $stmt->close();
    
    // Devolver el array de comentarios
    return $comentarios;
}

// Método para enviar una noticia a la bandeja de entrada
public function enviarNoticia($usuario_id, $titulo, $contenido, $categoria_id, $url)
{
    // Consulta SQL para insertar una noticia en la bandeja de entrada
    $sql = "INSERT INTO bandeja_entrada (usuario_id, titulo, contenido, categoria_id, url, fecha_envio) VALUES (?, ?, ?, ?, ?, NOW())";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    
    if ($stmt === false) {
        return false; // Devolver false si hubo un error preparando la consulta
    }
    
    // Vincular los parámetros de la noticia a la consulta preparada
    $stmt->bind_param("issis", $usuario_id, $titulo, $contenido, $categoria_id, $url);
    
    // Ejecutar la consulta y devolver true si fue exitosa, false en caso contrario
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
    
public function publicarNoticia($id, $titulo, $contenido, $categoria_id)
{
    try {
        // Iniciar una transacción
        $this->conn->beginTransaction();

        // Insertar la noticia en la tabla de artículos
        $sqlInsert = "INSERT INTO articulos (titulo, contenido, categoria_id) VALUES (:titulo, :contenido, :categoria_id)";
        $stmtInsert = $this->conn->prepare($sqlInsert);
        $stmtInsert->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmtInsert->bindParam(':contenido', $contenido, PDO::PARAM_STR);
        $stmtInsert->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmtInsert->execute();

        // Eliminar la noticia de la bandeja de entrada
        $sqlDelete = "DELETE FROM bandeja_entrada WHERE id = :id";
        $stmtDelete = $this->conn->prepare($sqlDelete);
        $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtDelete->execute();

        // Confirmar la transacción
        $this->conn->commit();
        return true;
    } catch (Exception $e) {
        // Si ocurre un error, revertir la transacción
        $this->conn->rollBack();
        return false;
    }
}

public function eliminarNoticiaBandeja($id)
{
    // Consulta SQL para eliminar una noticia de la bandeja de entrada
    $sql = "DELETE FROM bandeja_entrada WHERE id = ?";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular el parámetro de ID a la consulta preparada
    $stmt->bind_param('i', $id);
    // Ejecutar la consulta y devolver el resultado
    return $stmt->execute();
}

public function listarNoticiasBandeja()
{
    // Consulta SQL para obtener todas las noticias de la bandeja de entrada con los nombres de usuario
    $sql = "SELECT be.*, u.nombre_usuario FROM bandeja_entrada be JOIN usuarios_registrados u ON be.usuario_id = u.id ORDER BY fecha_envio DESC";
    // Preparar y ejecutar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    // Obtener todos los resultados como un array asociativo
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function agregarValoracion($articulo_id, $usuario_id, $valoracion)
{
    // Verificar si ya existe una valoración del artículo por el usuario
    $valoracionExistente = $this->obtenerValoracionExistente($articulo_id, $usuario_id);

    if ($valoracionExistente !== null) {
        // Actualizar la valoración existente si ya existe
        return $this->actualizarValoracion($articulo_id, $usuario_id, $valoracion);
    } else {
        // Insertar una nueva valoración si no existe
        $sql = "INSERT INTO valoraciones_articulos (articulo_id, usuario_id, valoracion) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iis', $articulo_id, $usuario_id, $valoracion);
        $stmt->execute();
        // Devolver true si se insertó la valoración
        return $stmt->affected_rows > 0;
    }
}

public function obtenerValoracionExistente($articulo_id, $usuario_id)
{
    // Consulta SQL para verificar si existe una valoración del artículo por el usuario
    $query = "SELECT valoracion FROM valoraciones_articulos WHERE articulo_id = ? AND usuario_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('ii', $articulo_id, $usuario_id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Obtener el resultado si existe
        $stmt->bind_result($valoracion);
        $stmt->fetch();
        return $valoracion;
    } else {
        // Devolver null si no existe
        return null;
    }
}

public function actualizarValoracion($articulo_id, $usuario_id, $valoracion)
{
    // Consulta SQL para actualizar la valoración de un artículo por un usuario
    $query = "UPDATE valoraciones_articulos SET valoracion = ? WHERE articulo_id = ? AND usuario_id = ?";
    $stmt = $this->conn->prepare($query);
    // Vincular los parámetros: valoracion como string, articulo_id y usuario_id como enteros
    $stmt->bind_param('sii', $valoracion, $articulo_id, $usuario_id);
    // Ejecutar la consulta y devolver el resultado
    return $stmt->execute();
}

public function obtenerConteoValoraciones($articuloId)
{
    // Consulta SQL para contar los 'likes' y 'dislikes' para un artículo
    $sql = "SELECT 
                SUM(CASE WHEN valoracion = 'like' THEN 1 ELSE 0 END) AS likes,
                SUM(CASE WHEN valoracion = 'dislike' THEN 1 ELSE 0 END) AS dislikes
            FROM valoraciones_articulos
            WHERE articulo_id = ?";
    $stmt = $this->conn->prepare($sql);
    // Vincular el parámetro: articulo_id como entero
    $stmt->bind_param("i", $articuloId);
    $stmt->execute();
    $result = $stmt->get_result();
    // Obtener el conteo de valoraciones como un array asociativo
    $conteo = $result->fetch_assoc();
    $stmt->close();
    return $conteo;
}

public function subirNoticiaBandeja($id, $titulo, $contenido, $url, $categoria_id)
{
    // Obtener los detalles del artículo desde la bandeja de entrada
    $sql_select = "SELECT usuario_id, titulo, contenido, url, categoria_id FROM bandeja_entrada WHERE id = ?";
    $stmt_select = $this->conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $resultado = $stmt_select->get_result()->fetch_assoc();
    $stmt_select->close();

    if (!$resultado) {
        // Si no se encuentra el artículo en la bandeja de entrada, devolver false
        return false;
    }

    // Insertar el artículo en la tabla de artículos
    $sql_insert = "INSERT INTO articulos (titulo, fecha_publicacion, contenido, url, categoria_id) VALUES (?, NOW(), ?, ?, ?)";
    $stmt_insert = $this->conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssi", $titulo, $contenido, $url, $categoria_id);
    $exito = $stmt_insert->execute();
    $stmt_insert->close();

    if ($exito) {
        // Si la inserción es exitosa, eliminar el artículo de la bandeja de entrada
        $sql_delete = "DELETE FROM bandeja_entrada WHERE id = ?";
        $stmt_delete = $this->conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();
        $stmt_delete->close();
    }

    return $exito;
}

public function eliminarDeBandeja($id)
{
    // Consulta SQL para eliminar un artículo de la bandeja de entrada
    $sql = "DELETE FROM bandeja_entrada WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    // Vincular el parámetro: id como entero
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta y devolver el resultado
    return $stmt->execute();
}

public function obtenerNoticiasTendencia()
{
    // Consulta SQL para obtener las noticias más populares basadas en el número de 'likes'
    $sql = "SELECT a.id, a.titulo, a.contenido, a.url, a.fecha_publicacion 
            FROM articulos a
            INNER JOIN (
                SELECT articulo_id, COUNT(*) AS total_likes 
                FROM valoraciones_articulos 
                WHERE valoracion = 'like' 
                GROUP BY articulo_id
            ) v ON a.id = v.articulo_id
            ORDER BY v.total_likes DESC
            LIMIT 10"; // Ajusta el límite según tus necesidades

    $resultado = $this->conn->query($sql);
    
    if ($resultado) {
        // Convertir el resultado en un array asociativo
        $noticiasArray = [];
        while ($row = $resultado->fetch_assoc()) {
            $noticiasArray[] = $row;
        }
        return $noticiasArray;
    } else {
        // Retornar un array vacío en caso de error
        return [];
    }
}

public function obtenerEstadisticasPorFecha($fecha)
{
    // Asegúrate de escapar la fecha para evitar inyecciones SQL
    $fecha = $this->conn->real_escape_string($fecha);
    
    // Consulta SQL para obtener estadísticas basadas en la fecha proporcionada
    $query = "
        SELECT
            (SELECT COUNT(*) FROM articulos WHERE DATE(fecha_publicacion) = ?) AS total_articulos,
            (SELECT COUNT(*) FROM valoraciones_articulos WHERE DATE(fecha_hora) = ?) AS total_valoraciones,
            (SELECT COUNT(*) FROM valoraciones_articulos WHERE valoracion = 'like' AND DATE(fecha_hora) = ?) AS total_likes,
            (SELECT COUNT(*) FROM valoraciones_articulos WHERE valoracion = 'dislike' AND DATE(fecha_hora) = ?) AS total_dislikes,
            (SELECT COUNT(*) FROM usuarios_registrados WHERE DATE(fecha_registro) = ?) AS total_usuarios,
            (SELECT COUNT(*) FROM bandeja_entrada WHERE DATE(fecha_envio) = ?) AS total_articulos_bandeja
    ";

    // Prepara la declaración
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $this->conn->error);
    }

    // Vincula los parámetros
    $stmt->bind_param('ssssss', $fecha, $fecha, $fecha, $fecha, $fecha, $fecha);

    // Ejecuta la consulta
    $stmt->execute();

    // Obtén el resultado
    $result = $stmt->get_result();
    $estadisticas = $result->fetch_assoc();

    // Cierra la declaración
    $stmt->close();

    return $estadisticas;
}
public function obtenerEstadisticasPorRangoFechas($fechaInicio, $fechaFin) {
    // Asegúrate de escapar las fechas para evitar inyecciones SQL
    $fechaInicio = $this->conn->real_escape_string($fechaInicio);
    $fechaFin = $this->conn->real_escape_string($fechaFin);
    
    // Consulta SQL para obtener estadísticas basadas en el rango de fechas proporcionado
    $query = "
        SELECT
            (SELECT COUNT(*) FROM articulos WHERE DATE(fecha_publicacion) BETWEEN ? AND ?) AS total_articulos,
            (SELECT COUNT(*) FROM valoraciones_articulos WHERE DATE(fecha_hora) BETWEEN ? AND ?) AS total_valoraciones,
            (SELECT COUNT(*) FROM valoraciones_articulos WHERE valoracion = 'like' AND DATE(fecha_hora) BETWEEN ? AND ?) AS total_likes,
            (SELECT COUNT(*) FROM valoraciones_articulos WHERE valoracion = 'dislike' AND DATE(fecha_hora) BETWEEN ? AND ?) AS total_dislikes,
            (SELECT COUNT(*) FROM usuarios_registrados WHERE DATE(fecha_registro) BETWEEN ? AND ?) AS total_usuarios,
            (SELECT COUNT(*) FROM bandeja_entrada WHERE DATE(fecha_envio) BETWEEN ? AND ?) AS total_articulos_bandeja
    ";

    // Prepara la declaración
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $this->conn->error);
    }

    // Vincula los parámetros
    $stmt->bind_param('ssssssssssss', $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin);

    // Ejecuta la consulta
    $stmt->execute();

    // Obtén el resultado
    $result = $stmt->get_result();
    $estadisticas = $result->fetch_assoc();

    // Cierra la declaración
    $stmt->close();

    return $estadisticas;
}

}
    

    







