<?php
// Archivo: model/BandejaEntradaModel.php

class BandejaEntradaModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function obtenerArticulos()
    {
        $sql = "SELECT b.id, u.nombre_usuario, b.fecha_envio, b.url, b.titulo, b.contenido
                FROM bandeja_entrada b
                JOIN usuarios_registrados u ON b.usuario_id = u.id";
        $result = $this->conn->query($sql);

        if ($result === false) {
            die("Error en la consulta SQL: " . $this->conn->error);
        }

        $articulos = [];
        while ($row = $result->fetch_assoc()) {
            $articulos[] = $row;
        }

        return $articulos;
    }
    public function obtenerArticuloPorId($id)
{
    $sql = "SELECT id, titulo, contenido, url, categoria_id FROM bandeja_entrada WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
}

