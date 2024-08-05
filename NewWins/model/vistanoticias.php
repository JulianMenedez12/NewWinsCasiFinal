<?php
// Incluye el archivo que define la clase GestorContenido, necesario para acceder a los métodos de gestión de noticias
require_once('gestor_noticias.php');

// Clase VistaNoticias para gestionar la presentación de noticias en la vista
class VistaNoticias
{
    // Propiedad para almacenar una instancia de GestorContenido
    private $gestorContenido;

    // Constructor que recibe una instancia de GestorContenido
    // Esta instancia se usa para obtener datos de noticias
    public function __construct(GestorContenido $gestorContenido)
    {
        $this->gestorContenido = $gestorContenido; // Asigna la instancia de GestorContenido a la propiedad de la clase
    }

    // Método para mostrar todas las noticias
    public function mostrarNoticias()
    {
        // Obtiene la lista de noticias llamando al método listarNoticias de GestorContenido
        $noticias = $this->gestorContenido->listarNoticias();

        // Itera sobre cada noticia en la lista
        foreach ($noticias as $noticia) {
            $id = $noticia['id']; // ID de la noticia
            $titulo = $noticia['titulo']; // Título de la noticia
            $fecha_not = $noticia['fecha_publicacion']; // Fecha de publicación de la noticia
            $imagen = $noticia['url']; // URL de la imagen asociada con la noticia

            // Genera el HTML para mostrar la noticia en una tarjeta de Bootstrap
            echo '<div class="col-md-4 mb-4">';
            echo '  <a href="ver_noticia.php?id=' . $id . '" style="text-decoration:none">'; // Enlace a la página de detalle de la noticia
            echo '      <div class="card">';
            echo '          <img src="' . $imagen . '" class="card-img-top" alt="' . $titulo . '">'; // Imagen de la noticia
            echo '          <div class="card-body">';
            echo '              <h5 class="card-title">' . $titulo . '</h5>'; // Título de la noticia
            echo '              <p class="card-text"><span class="fecha-noticia" data-fecha="' . $fecha_not . '"></span></p>'; // Fecha de la noticia (con clase para manipulación de JavaScript)
            echo '          </div>';
            echo '      </div>';
            echo '  </a>';
            echo '</div>';
        }
    }

    // Método para mostrar una noticia específica identificada por su ID
    public function mostrarNoticiaPorId($id)
    {
        try {
            // Obtiene la noticia desde el gestor de contenido usando el ID proporcionado
            $noticia = $this->gestorContenido->obtenerNoticiaPorId($id);
            // Muestra la noticia en HTML llamando al método privado mostrarNoticia
            $this->mostrarNoticia($noticia);
        } catch (Exception $e) {
            // Muestra un mensaje de error si ocurre una excepción
            echo "<p>Error al obtener la noticia: " . $e->getMessage() . "</p>";
        }
    }

    // Método privado para mostrar una noticia en formato HTML
    private function mostrarNoticia($noticia)
    {
        // Genera el HTML para mostrar una noticia en una tarjeta de Bootstrap
        echo "<div class='col-lg-4 mb-4'>";
        echo "<div class='card'>";
        echo "<img src='" . htmlspecialchars($noticia['url']) . "' class='card-img-top' alt='Imagen de Noticia'>"; // Imagen de la noticia
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($noticia['titulo']) . "</h5>"; // Título de la noticia
        echo "<p class='card-text'><strong>Categoría:</strong> " . htmlspecialchars($noticia['categoria']) . "</p>"; // Categoría de la noticia
        echo "<p class='card-text'><strong>Fecha de Publicación:</strong> " . htmlspecialchars($noticia['fecha_publicacion']) . "</p>"; // Fecha de publicación de la noticia
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }

    // Método para mostrar noticias con paginación
    public function mostrarNoticiasConPaginacion($pagina = 1, $noticiasPorPagina = 10)
    {
        // Calcula el desplazamiento (offset) para la paginación
        $offset = ($pagina - 1) * $noticiasPorPagina;

        try {
            // Obtiene las noticias paginadas desde el gestor de contenido
            $result = $this->gestorContenido->listarNoticiasConPaginacion($noticiasPorPagina, $offset);

            // Verifica si se encontraron noticias
            if ($result->num_rows > 0) {
                // Itera sobre cada fila de resultados y muestra la noticia
                while ($row = $result->fetch_assoc()) {
                    $this->mostrarNoticia($row);
                }
            } else {
                // Muestra un mensaje cuando no hay noticias disponibles
                echo "<p>No hay noticias disponibles en este momento.</p>";
            }
        } catch (Exception $e) {
            // Muestra un mensaje de error si ocurre una excepción
            echo "<p>Error al listar noticias: " . $e->getMessage() . "</p>";
        }
    }

    // Método para mostrar una noticia específica con detalles, identificada por su ID
    public function mostrarNoticiaConDetalles($id)
    {
        try {
            // Obtiene la noticia desde el gestor de contenido usando el ID proporcionado
            $noticia = $this->gestorContenido->obtenerNoticiaPorId($id);
            // Muestra la noticia en HTML llamando al método privado mostrarNoticia
            $this->mostrarNoticia($noticia);
        } catch (Exception $e) {
            // Muestra un mensaje de error si ocurre una excepción
            echo "<p>Error al obtener la noticia: " . $e->getMessage() . "</p>";
        }
    }

    // Método para mostrar un artículo en formato HTML
    public function mostrarArticulo($articulo)
{
    // Extrae y sanitiza los datos del artículo
    $id = htmlspecialchars($articulo['id']);
    $titulo = htmlspecialchars($articulo['titulo']);
    $url = htmlspecialchars($articulo['url']);
    $fecha = htmlspecialchars($articulo['fecha_publicacion']); // Fecha de publicación del artículo

    // Genera el HTML para mostrar un artículo en una tarjeta de Bootstrap
    echo '<div class="col-md-4 mb-4">';
    echo '  <div class="card">';
    echo '      <img src="' . $url . '" class="card-img-top" alt="' . $titulo . '">'; // Imagen del artículo
    echo '      <div class="card-body">';
    echo '          <h5 class="card-title">' . $titulo . '</h5>'; // Título del artículo
    echo '          <p class="card-text fecha-relativa" data-fecha="' . $fecha . '"></p>'; // Fecha de publicación del artículo con data-fecha
    echo '          <a href="../view/ver_noticia.php?id=' . $id . '" class="stretched-link"></a>'; // Enlace para ver la noticia
    echo '      </div>';
    echo '  </div>';
    echo '</div>';
}
}
?>
