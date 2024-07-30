<?php
class ArticuloController {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function darLike($id_articulo) {
        // Verifica si el usuario ya ha dado un like
        $sql = "SELECT COUNT(*) as total FROM valoraciones_articulos WHERE id_articulo = ? AND valoracion = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_articulo]);
        $total = $stmt->fetchColumn();

        if ($total == 0) {
            // Si el usuario no ha dado like, inserta el like
            $sql = "INSERT INTO valoraciones_articulos (id_articulo, valoracion) VALUES (?, 0)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_articulo]);
        }

        // Recalcular la cantidad total de likes
        $sql = "SELECT COUNT(*) as total_likes FROM valoraciones_articulos WHERE id_articulo = ? AND valoracion = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_articulo]);
        return $stmt->fetchColumn();
    }
}
