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
    /**
 * Método para subir una nueva noticia a la base de datos.
 *
 * @param string $titulo El título de la noticia.
 * @param string $contenido El contenido de la noticia.
 * @param string $url La URL de la noticia.
 * @param int $categoria_id El ID de la categoría a la que pertenece la noticia.
 * 
 * @return bool Devuelve true si la inserción fue exitosa, de lo contrario false.
 */
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
        return $stmt->execute();
    } else {
        return false; // Devolver false si faltan datos
    }
}

/**
 * Método para listar todas las categorías de la base de datos.
 *
 * @return mysqli_result Devuelve el resultado de la consulta.
 */
public function listarCategorias()
{
    // Consulta SQL para seleccionar todas las categorías
    $sql = "SELECT * FROM categorias";
    // Ejecutar la consulta SQL
    $result = $this->conn->query($sql);
    // Devolver el resultado de la consulta
    return $result;
}

/**
 * Método para listar todas las noticias de la base de datos.
 *
 * @return mysqli_result Devuelve el resultado de la consulta.
 */
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

/**
 * Método para eliminar una noticia de la base de datos por su ID.
 *
 * @param int $id El ID de la noticia a eliminar.
 * 
 * @return bool Devuelve true si la eliminación fue exitosa, de lo contrario false.
 */
public function eliminarNoticia($id)
{
    // Consulta SQL para eliminar una noticia por su ID
    $sql = "DELETE FROM articulos WHERE id = ?";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular el parámetro de ID a la consulta preparada
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta y verificar si la eliminación fue exitosa
    return $stmt->execute();
}

/**
 * Método para eliminar una categoría y sus artículos relacionados de la base de datos.
 *
 * @param int $id El ID de la categoría a eliminar.
 * 
 * @return bool Devuelve true si la eliminación fue exitosa, de lo contrario false.
 */
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

/**
 * Método para crear una nueva categoría en la base de datos.
 *
 * @param string $nombre El nombre de la categoría.
 * @param string $descripcion La descripción de la categoría.
 * @param string $imagen La URL de la imagen de la categoría.
 * 
 * @return bool Devuelve true si la inserción fue exitosa, de lo contrario false.
 */
public function crearCategoria($nombre, $descripcion, $imagen)
{
    // Verificar que el nombre y la descripción no estén vacíos
    if (!empty($nombre) && !empty($descripcion)) {
        // Consulta SQL para insertar una nueva categoría
        $stmt = $this->conn->prepare("INSERT INTO categorias (nombre, descripcion, imagen) VALUES (?, ?, ?)");
        // Vincular los parámetros a la consulta preparada
        $stmt->bind_param("sss", $nombre, $descripcion, $imagen);

        // Ejecutar la consulta y verificar si la inserción fue exitosa
        return $stmt->execute();
    } else {
        return false; // Devolver false si faltan datos
    }
}
/**
 * Método para editar una noticia existente en la base de datos.
 *
 * @param int $id El ID de la noticia a editar.
 * @param string $titulo El nuevo título de la noticia.
 * @param string $contenido El nuevo contenido de la noticia.
 * @param string $url La nueva URL de la noticia.
 * @param int $categoria_id El nuevo ID de la categoría de la noticia.
 * 
 * @return bool Devuelve true si la actualización fue exitosa, de lo contrario false.
 */
public function editarNoticia($id, $titulo, $contenido, $url, $categoria_id)
{
    // Consulta SQL para actualizar una noticia existente en la base de datos
    $sql = "UPDATE articulos SET titulo = ?, contenido = ?, url = ?, categoria_id = ? WHERE id = ?";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular los parámetros a la consulta preparada
    $stmt->bind_param("sssii", $titulo, $contenido, $url, $categoria_id, $id);

    // Ejecutar la consulta y verificar si la actualización fue exitosa
    return $stmt->execute();
}

/**
 * Método para obtener una categoría por su ID.
 *
 * @param int $id El ID de la categoría a obtener.
 * 
 * @return array|null Devuelve un array con los datos de la categoría si se encontró, de lo contrario null.
 * @throws RuntimeException Si ocurre un error en la consulta o si no se encuentra la categoría.
 */
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

/**
 * Método para obtener una noticia por su ID.
 *
 * @param int $id El ID de la noticia a obtener.
 * 
 * @return array|null Devuelve un array con los datos de la noticia si se encontró, de lo contrario null.
 */
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

/**
 * Método para listar noticias con paginación.
 *
 * @param int $limite El número de noticias a mostrar por página.
 * @param int $offset El desplazamiento desde el inicio de las noticias.
 * 
 * @return mysqli_result Devuelve el resultado de la consulta.
 */
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


/**
 * Método para buscar noticias basadas en un término de búsqueda.
 *
 * @param string $termino Término de búsqueda proporcionado por el usuario.
 * 
 * @return array Devuelve un array de noticias que coinciden con el término de búsqueda.
 */
public function buscarNoticias($termino)
{
    // Dividir el término de búsqueda en palabras individuales
    $terminos = explode(' ', $termino);
    // Iniciar la consulta SQL con la base de la consulta
    $sql = "SELECT * FROM articulos WHERE ";
    // Inicializar arrays para los parámetros y tipos
    $params = [];
    $types = '';
    
    // Construir la consulta SQL dinámica para buscar en el título y el contenido
    foreach ($terminos as $index => $palabra) {
        if ($index > 0) {
            $sql .= " OR ";
        }
        $sql .= "(titulo LIKE ? OR contenido LIKE ?)";
        // Agregar los parámetros con comodines '%' para búsqueda parcial
        $params[] = "%" . $palabra . "%";
        $params[] = "%" . $palabra . "%";
        // Agregar el tipo de parámetro 'ss' para cada par de parámetros de tipo string
        $types .= 'ss';
    }

    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular los parámetros de búsqueda a la consulta preparada
    $stmt->bind_param($types, ...$params);
    // Ejecutar la consulta
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

/**
 * Método para listar artículos de una categoría específica.
 *
 * @param int $categoria_id ID de la categoría.
 * 
 * @return array Devuelve un array de artículos que pertenecen a la categoría especificada.
 */
public function listarArticulosPorCategoria($categoria_id)
{
    // Consulta SQL para obtener todos los artículos de una categoría específica
    $sql = "SELECT * FROM articulos WHERE categoria_id = ?";
    // Preparar la consulta SQL
    $stmt = $this->conn->prepare($sql);
    // Vincular el parámetro de ID de categoría a la consulta preparada
    $stmt->bind_param("i", $categoria_id);
    // Ejecutar la consulta
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

/**
 * Método para agregar un comentario a un artículo.
 *
 * @param string $usuario Nombre del usuario que hace el comentario.
 * @param string $texto Texto del comentario.
 * @param int $puntuacion Puntuación dada por el usuario.
 * @param int $articulo_id ID del artículo al que se agrega el comentario.
 * 
 * @throws Exception Si ocurre un error al agregar el comentario.
 */
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

/**
 * Método para obtener todos los comentarios de un artículo específico.
 *
 * @param int $articulo_id ID del artículo.
 * 
 * @return array Devuelve un array de comentarios que pertenecen al artículo especificado.
 */
public function obtenerComentariosPorArticuloId($articulo_id) {
    $query = "SELECT c.texto, c.fecha_hora, u.nombre_usuario, u.foto_perfil
              FROM comentarios c
              JOIN usuarios_registrados u ON c.usuario = u.nombre_usuario
              WHERE c.articulo_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $articulo_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Método para enviar una noticia a la bandeja de entrada.
 *
 * @param int $usuario_id ID del usuario que envía la noticia.
 * @param string $titulo Título de la noticia.
 * @param string $contenido Contenido de la noticia.
 * @param int $categoria_id ID de la categoría de la noticia.
 * @param string $url URL de la noticia.
 * 
 * @return bool Devuelve true si la noticia se envió correctamente, false en caso contrario.
 */
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

/**
 * Método para publicar una noticia.
 *
 * @param int $id ID de la noticia en la bandeja de entrada.
 * @param string $titulo Título de la noticia.
 * @param string $contenido Contenido de la noticia.
 * @param int $categoria_id ID de la categoría de la noticia.
 * 
 * @return bool Devuelve true si la noticia se publicó correctamente, false en caso contrario.
 */
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

/**
 * Método para eliminar una noticia de la bandeja de entrada.
 *
 * @param int $id ID de la noticia en la bandeja de entrada.
 * 
 * @return bool Devuelve true si la noticia se eliminó correctamente, false en caso contrario.
 */
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

/**
 * Método para listar todas las noticias de la bandeja de entrada.
 *
 * @return array Devuelve un array de noticias con los nombres de usuario.
 */
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
/**
 * Método para agregar una valoración a un artículo.
 *
 * @param int $articulo_id ID del artículo.
 * @param int $usuario_id ID del usuario que valora el artículo.
 * @param string $valoracion Valoración del usuario ('like' o 'dislike').
 * 
 * @return bool Devuelve true si la valoración se insertó o actualizó correctamente, false en caso contrario.
 */
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

/**
 * Método para obtener una valoración existente de un artículo por un usuario.
 *
 * @param int $articulo_id ID del artículo.
 * @param int $usuario_id ID del usuario.
 * 
 * @return string|null Devuelve la valoración si existe, null en caso contrario.
 */
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

/**
 * Método para actualizar una valoración existente de un artículo por un usuario.
 *
 * @param int $articulo_id ID del artículo.
 * @param int $usuario_id ID del usuario.
 * @param string $valoracion Nueva valoración del usuario ('like' o 'dislike').
 * 
 * @return bool Devuelve true si la valoración se actualizó correctamente, false en caso contrario.
 */
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

/**
 * Método para obtener el conteo de valoraciones de un artículo.
 *
 * @param int $articuloId ID del artículo.
 * 
 * @return array Devuelve un array asociativo con el conteo de 'likes' y 'dislikes'.
 */
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
/**
 * Método para subir una noticia desde la bandeja de entrada a la tabla de artículos.
 *
 * @param int $id ID del artículo en la bandeja de entrada.
 * @param string $titulo Título del artículo.
 * @param string $contenido Contenido del artículo.
 * @param string $url URL del artículo.
 * @param int $categoria_id ID de la categoría del artículo.
 * 
 * @return bool Devuelve true si la operación fue exitosa, false en caso contrario.
 */
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

/**
 * Método para eliminar un artículo de la bandeja de entrada.
 *
 * @param int $id ID del artículo en la bandeja de entrada.
 * 
 * @return bool Devuelve true si la operación fue exitosa, false en caso contrario.
 */
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

/**
 * Método para obtener las noticias más populares basadas en el número de 'likes'.
 *
 * @return array Devuelve un array de las noticias más populares.
 */
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

/**
 * Método para obtener estadísticas basadas en una fecha proporcionada.
 *
 * @param string $fecha Fecha en formato 'YYYY-MM-DD'.
 * 
 * @return array Devuelve un array asociativo con las estadísticas.
 * @throws Exception Si hay un error en la preparación de la consulta.
 */
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

/**
 * Método para obtener estadísticas basadas en un rango de fechas proporcionado.
 *
 * @param string $fechaInicio Fecha de inicio en formato 'YYYY-MM-DD'.
 * @param string $fechaFin Fecha de fin en formato 'YYYY-MM-DD'.
 * 
 * @return array Devuelve un array asociativo con las estadísticas.
 * @throws Exception Si hay un error en la preparación de la consulta.
 */
public function obtenerEstadisticasPorRangoFechas($fechaInicio, $fechaFin) {
    $fechaInicio = $this->conn->real_escape_string($fechaInicio);
    $fechaFin = $this->conn->real_escape_string($fechaFin);
    
    $query = "
        SELECT
            (SELECT COUNT(*) FROM articulos WHERE DATE(fecha_publicacion) BETWEEN ? AND ?) AS total_articulos,
            (SELECT COUNT(*) FROM valoraciones_articulos WHERE DATE(fecha_hora) BETWEEN ? AND ?) AS total_valoraciones,
            (SELECT COUNT(*) FROM valoraciones_articulos WHERE valoracion = 'like' AND DATE(fecha_hora) BETWEEN ? AND ?) AS total_likes,
            (SELECT COUNT(*) FROM valoraciones_articulos WHERE valoracion = 'dislike' AND DATE(fecha_hora) BETWEEN ? AND ?) AS total_dislikes,
            (SELECT COUNT(*) FROM usuarios_registrados WHERE DATE(fecha_registro) BETWEEN ? AND ?) AS total_usuarios,
            (SELECT COUNT(*) FROM bandeja_entrada WHERE DATE(fecha_envio) BETWEEN ? AND ?) AS total_articulos_bandeja,
            (SELECT COUNT(*) FROM comentarios WHERE DATE(fecha_hora) BETWEEN ? AND ?) AS total_comentarios
    ";

    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $this->conn->error);
    }

    $stmt->bind_param('ssssssssssssss', $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin);

    $stmt->execute();

    $result = $stmt->get_result();
    $estadisticas = $result->fetch_assoc();

    $stmt->close();

    return $estadisticas;
}



}
    

    







