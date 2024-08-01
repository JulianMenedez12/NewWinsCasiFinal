<?php
require_once('gestor_noticias.php');
//archivo:../model/vistanoticias.php
class VistaNoticias
{
    private $gestorContenido;

    public function __construct(GestorContenido $gestorContenido)
    {
        $this->gestorContenido = $gestorContenido;
    }

    // Mostrar todas las noticias
    public function mostrarNoticias()
    {
        $noticias = $this->gestorContenido->listarNoticias();
        foreach ($noticias as $noticia) {
            $id = $noticia['id']; // Ajusta el índice según tu base de datos
            $titulo = $noticia['titulo'];
            $fecha_not = $noticia['fecha_publicacion'];
            $imagen = $noticia['url']; // Ajusta el índice según tu base de datos

            echo '<div class="col-md-4 mb-4">';
            echo '  <a href="ver_noticia.php?id=' . $id . '" style=text-decoration:none>';
            echo '      <div class="card">';
            echo '          <img src="' . $imagen . '" class="card-img-top" alt="' . $titulo . '">';
            echo '          <div class="card-body">';
            echo '              <h5 class="card-title">' . $titulo . '</h5>';
            echo '              <p class="card-text">' . $fecha_not . '</p>';
            echo '          </div>';
            echo '      </div>';
            echo '  </a>';
            echo '</div>';
        }
    }

    // Mostrar una noticia específica por ID
    public function mostrarNoticiaPorId($id)
    {
        try {
            $noticia = $this->gestorContenido->obtenerNoticiaPorId($id);
            $this->mostrarNoticia($noticia);
        } catch (Exception $e) {
            echo "<p>Error al obtener la noticia: " . $e->getMessage() . "</p>";
        }
    }

    // Mostrar una noticia en HTML
    private function mostrarNoticia($noticia)
    {
        echo "<div class='col-lg-4 mb-4'>";
        echo "<div class='card'>";
        echo "<img src='" . htmlspecialchars($noticia['url']) . "' class='card-img-top' alt='Imagen de Noticia'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($noticia['titulo']) . "</h5>";
        echo "<p class='card-text'><strong>Categoría:</strong> " . htmlspecialchars($noticia['categoria']) . "</p>";
        echo "<p class='card-text'><strong>Fecha de Publicación:</strong> " . htmlspecialchars($noticia['fecha_publicacion']) . "</p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }


    public function mostrarNoticiasConPaginacion($pagina = 1, $noticiasPorPagina = 10)
    {
        $offset = ($pagina - 1) * $noticiasPorPagina;

        try {
            $result = $this->gestorContenido->listarNoticiasConPaginacion($noticiasPorPagina, $offset);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->mostrarNoticia($row);
                }
            } else {
                echo "<p>No hay noticias disponibles en este momento.</p>";
            }
        } catch (Exception $e) {
            echo "<p>Error al listar noticias: " . $e->getMessage() . "</p>";
        }
    }

    public function mostrarNoticiaConDetalles($id)
    {
        try {
            $noticia = $this->gestorContenido->obtenerNoticiaPorId($id);
            $this->mostrarNoticia($noticia);
        } catch (Exception $e) {
            echo "<p>Error al obtener la noticia: " . $e->getMessage() . "</p>";
        }
    }
    public function mostrarArticulo($articulo)
    {
        $id = htmlspecialchars($articulo['id']);
        $titulo = htmlspecialchars($articulo['titulo']);
        $url = htmlspecialchars($articulo['url']);
        $fecha = htmlspecialchars($articulo['fecha_publicacion']); // Ajusta el nombre del campo según tu base de datos

        echo '<div class="col-md-4 mb-4">';
        echo '  <div class="card">';
        echo '      <img src="' . $url . '" class="card-img-top" alt="' . $titulo . '">';
        echo '      <div class="card-body">';
        echo '          <h5 class="card-title">' . $titulo . '</h5>';
        echo '          <p class="card-text">' . $fecha . '</p>'; // Mostrar la fecha del artículo
        echo '          <a href="../view/ver_noticia.php?id=' . $id . '" class="stretched-link"></a>'; // Enlace para ver la noticia
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }

}
?>