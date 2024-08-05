<?php
// Archivo: model/BandejaEntradaModel.php

// Definición de la clase BandejaEntradaModel
class BandejaEntradaModel
{
    // Propiedad para almacenar la conexión a la base de datos
    private $conn;

    // Constructor que inicializa la conexión a la base de datos
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Método para obtener todos los artículos de la bandeja de entrada
    public function obtenerArticulos()
    {
        // Consulta SQL para obtener los artículos y los nombres de usuario asociados
        $sql = "SELECT b.id, u.nombre_usuario, b.fecha_envio, b.url, b.titulo, b.contenido
                FROM bandeja_entrada b
                JOIN usuarios_registrados u ON b.usuario_id = u.id";
        // Ejecutar la consulta SQL
        $result = $this->conn->query($sql);

        // Verificar si hubo un error en la consulta SQL
        if ($result === false) {
            die("Error en la consulta SQL: " . $this->conn->error);
        }

        // Crear un array para almacenar los artículos
        $articulos = [];
        // Recorrer los resultados de la consulta y agregar cada fila al array de artículos
        while ($row = $result->fetch_assoc()) {
            $articulos[] = $row;
        }

        // Devolver el array de artículos
        return $articulos;
    }

    // Método para obtener un artículo específico por su ID
    public function obtenerArticuloPorId($id)
    {
        // Consulta SQL para obtener un artículo por su ID
        $sql = "SELECT id, titulo, contenido, url, categoria_id FROM bandeja_entrada WHERE id = ?";
        // Preparar la consulta SQL
        $stmt = $this->conn->prepare($sql);
        // Vincular el parámetro de ID a la consulta preparada
        $stmt->bind_param("i", $id);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Verificar si se encontró un artículo con el ID proporcionado
        if ($result->num_rows > 0) {
            // Devolver los datos del artículo como un array asociativo
            return $result->fetch_assoc();
        } else {
            // Devolver null si no se encontró ningún artículo con el ID proporcionado
            return null;
        }
    }
}
?>
