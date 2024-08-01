<?php
require_once('conexion.php');
//archivo:../model/gestor_noticias.php
class GestorContenido
{
    private $conn;

    public function __construct($conexion)
    {
        $this->conn = $conexion;
    }

    public function subirNoticia($titulo, $contenido, $url, $categoria_id)
    {
        $fecha_publicacion = date("Y-m-d");

        if (!empty($titulo) && !empty($contenido) && !empty($url) && !empty($categoria_id)) {
            $sql = "INSERT INTO articulos (titulo, fecha_publicacion, contenido, url, categoria_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssi", $titulo, $fecha_publicacion, $contenido, $url, $categoria_id);

            if ($stmt->execute()) {
                return true; // Devolver true si la inserción fue exitosa
            } else {
                return false; // Devolver false si hubo un error en la inserción
            }
        } else {
            return false; // Devolver false si faltan datos
        }
    }

    public function listarCategorias()
    {
        $sql = "SELECT * FROM categorias";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function listarNoticias()
    {
        $sql = "SELECT a.id, c.nombre AS categoria, a.titulo, a.contenido, a.url, a.fecha_publicacion
            FROM articulos a
            JOIN categorias c ON a.categoria_id = c.id";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function eliminarNoticia($id)
    {
        $sql = "DELETE FROM articulos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarCategoria($id)
    {
        // Iniciar una transacción
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
        if (!empty($nombre) && !empty($descripcion)) {
            $stmt = $this->conn->prepare("INSERT INTO categorias (nombre, descripcion, imagen) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $descripcion, $imagen);

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
        $sql = "UPDATE articulos SET titulo = ?, contenido = ?, url = ?, categoria_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssii", $titulo, $contenido, $url, $categoria_id, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function obtenerCategoriaPorId($id)
    {
        $sql = "SELECT * FROM categorias WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException("Error preparando la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new RuntimeException("No se encontró la categoría con ID $id.");
        }
        return $result->fetch_assoc();
    }
    public function obtenerNoticiaPorId($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM articulos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
    public function listarNoticiasConPaginacion($limite, $offset)
    {
        $sql = "SELECT a.id, c.nombre AS categoria, a.titulo, a.contenido, a.url, a.fecha_publicacion 
            FROM articulos a
            JOIN categorias c ON a.categoria_id = c.id
            LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limite, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function buscarNoticias($termino)
{
    $terminos = explode(' ', $termino); // Divide la consulta en palabras
    $sql = "SELECT * FROM articulos WHERE ";
    $params = [];
    $types = '';
    foreach ($terminos as $index => $palabra) {
        if ($index > 0) {
            $sql .= " OR ";
        }
        $sql .= "(titulo LIKE ? OR contenido LIKE ?)";
        $params[] = "%" . $palabra . "%";
        $params[] = "%" . $palabra . "%";
        $types .= 'ss';
    }
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $noticias = [];
    while ($row = $result->fetch_assoc()) {
        $noticias[] = $row;
    }
    return $noticias;
}

    public function listarArticulosPorCategoria($categoria_id)
    {
        $sql = "SELECT * FROM articulos WHERE categoria_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $articulos = [];
        while ($row = $result->fetch_assoc()) {
            $articulos[] = $row;
        }

        return $articulos;
    }
    // Método para agregar un comentario
    public function agregarComentario($usuario,
        $texto,
        $puntuacion,
        $articulo_id
    ) {
        $sql = "INSERT INTO comentarios (usuario, texto, puntuacion, articulo_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $usuario, $texto,
            $puntuacion,
            $articulo_id
        );
        if (!$stmt->execute()) {
            throw new Exception("Error al agregar comentario: " . $stmt->error);
        }
        $stmt->close();
    }   
    public function obtenerComentariosPorArticuloId($articulo_id)
    {
        $sql = "SELECT usuario, fecha_hora, texto, puntuacion FROM comentarios WHERE articulo_id = ? ORDER BY fecha_hora DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $articulo_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $comentarios = [];
        while ($row = $result->fetch_assoc()) {
            $comentarios[] = $row;
        }
        $stmt->close();
        return $comentarios;
    }
    public function enviarNoticia($usuario_id, $titulo, $contenido, $categoria_id) {
        $sql = "INSERT INTO bandeja_entrada (usuario_id, titulo, contenido, categoria_id, fecha_envio) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("isss", $usuario_id, $titulo, $contenido, $categoria_id);
        return $stmt->execute();
    }
    
    public function publicarNoticia($id, $titulo, $contenido, $categoria_id) {
        try {
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

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
    public function eliminarNoticiaBandeja($id) {
        $sql = "DELETE FROM bandeja_entrada WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
    public function listarNoticiasBandeja() {
        $sql = "SELECT be.*, u.nombre_usuario FROM bandeja_entrada be JOIN usuarios_registrados u ON be.usuario_id = u.id ORDER BY fecha_envio DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function agregarValoracion($articulo_id, $usuario_id, $valoracion) {
        $valoracionExistente = $this->obtenerValoracionExistente($articulo_id, $usuario_id);
    
        if ($valoracionExistente !== null) {
            // Actualizar la valoración existente
            return $this->actualizarValoracion($articulo_id, $usuario_id, $valoracion);
        } else {
            // Insertar una nueva valoración
            $sql = "INSERT INTO valoraciones_articulos (articulo_id, usuario_id, valoracion) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('iis', $articulo_id, $usuario_id, $valoracion);
            $stmt->execute();
            return $stmt->affected_rows > 0;
        }
    }
    public function obtenerValoracionExistente($articulo_id, $usuario_id) {
        $query = "SELECT valoracion FROM valoraciones_articulos WHERE articulo_id = ? AND usuario_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $articulo_id, $usuario_id);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($valoracion);
            $stmt->fetch();
            return $valoracion;
        } else {
            return null;
        }
    }
    public function actualizarValoracion($articulo_id, $usuario_id, $valoracion) {
        $query = "UPDATE valoraciones_articulos SET valoracion = ? WHERE articulo_id = ? AND usuario_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sii', $valoracion, $articulo_id, $usuario_id);
        return $stmt->execute();
    }
    public function obtenerConteoValoraciones($articuloId) {
        $sql = "SELECT 
                    SUM(CASE WHEN valoracion = 'like' THEN 1 ELSE 0 END) AS likes,
                    SUM(CASE WHEN valoracion = 'dislike' THEN 1 ELSE 0 END) AS dislikes
                FROM valoraciones_articulos
                WHERE articulo_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $articuloId);
        $stmt->execute();
        $result = $stmt->get_result();
        $conteo = $result->fetch_assoc();
        $stmt->close();
        return $conteo;
    }

}





