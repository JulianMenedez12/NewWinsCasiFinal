<?php
include('header_user.php');

// detalle_noticia.php
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';
require_once '../model/gestor_usuarios.php';
if (!isset($_SESSION['correo'])) {
    header("Location: admin.php");
    exit();
}
$articulo_id = $_GET['id'];
$userEmail = $_SESSION['correo'];
$idNoticia = intval($_GET['id']);
$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);
$noticia = $gestorContenido->obtenerNoticiaPorId($idNoticia);
$comentarios = $gestorContenido->obtenerComentariosPorArticuloId($articulo_id);
// Consulta para obtener la cantidad de likes
// Consulta para obtener la cantidad de likes
$sql = "SELECT COUNT(*) as total_likes FROM valoraciones_articulos WHERE id_articulo = ? AND valoracion = 0";
$stmt = $conexion->prepare($sql); // Usando $mysqli para preparar la consulta
$stmt->bind_param('i', $id_articulo); // 'i' para indicar que el parámetro es un entero
$stmt->execute();
$result = $stmt->get_result(); // Obtener el resultado de la consulta
$row = $result->fetch_assoc(); // Obtener el array asociativo
$likes = $row['total_likes']; // Extraer el número de likes
?>
<?php
if (!$noticia) {
    echo "Noticia no encontrada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="google-adsense-account" content="ca-pub-8262837766739470">
    <title><?php echo $noticia['titulo']; ?> - NEWWINS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> <!-- Agrega tu archivo CSS personalizado aquí -->

    <!-- Incluye Day.js desde un CDN -->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/plugin/relativeTime.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/locale/es.js"></script>
    <script>
        // Configura el plugin de tiempo relativo y el idioma español
        dayjs.extend(window.dayjs_plugin_relativeTime);
        dayjs.locale('es');
    </script>

    <!-- Incluye el script de Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8262837766739470"
     crossorigin="anonymous"></script>

</head>

<body>
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <h1 class="mb-4"><?php echo $noticia['titulo']; ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p><?php echo $noticia['contenido']; ?></p>
        </div>
        <script>
function darLike($articulo_id) {
    // Enviar una solicitud AJAX para dar un like
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../controller/like.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Actualizar la cantidad de likes
            document.getElementById('like-count-' + $articulo_id).textContent = xhr.responseText;
        }
    };
    xhr.send('id_articulo=' + $articulo_id);
}
</script>
    <!-- Mostrar el botón de like y la cantidad de likes -->
    <button id="like-button-<?php echo $articulo_id; ?>" onclick="darLike(<?php echo $articulo_id; ?>)">
        Like <span id="like-count-<?php echo $articulo_id; ?>"><?php echo $likes; ?></span>
    </button>
</div>
        <div class="col-md-6">
            <p>Anuncios</p>
            <!-- Código de anuncio de Google AdSense -->
            <div class="anuncio">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8262837766739470"
     crossorigin="anonymous"></script>
<!-- anuncios_wins -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-8262837766739470"
     data-ad-slot="8899815966"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <h3>Comentarios</h3>
            <form action="../controller/enviar_comentario.php" method="POST">
                <div class="mb-3">
                    <textarea class="form-control" name="texto" placeholder="Escribe tu comentario aquí..." required></textarea>
                </div>
                <input type="hidden" name="articulo_id" value="<?php echo $articulo_id; ?>">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <h2>Comentarios</h2>
            <?php if (!empty($comentarios)) : ?>
                <?php foreach ($comentarios as $comentario) : ?>
                    <div class="mb-3">
                        <strong><?php echo htmlspecialchars($comentario['usuario']); ?></strong>
                        <span class="fecha-comentario" data-fecha="<?php echo htmlspecialchars($comentario['fecha_hora']); ?>"></span>
                        <p><?php echo htmlspecialchars($comentario['texto']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No hay comentarios aún. ¡Sé el primero en comentar!</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechas = document.querySelectorAll('.fecha-comentario');
        fechas.forEach(fecha => {
            const fechaOriginal = fecha.getAttribute('data-fecha');
            const fechaRelativa = dayjs(fechaOriginal).fromNow();
            fecha.textContent = fechaRelativa;
        });
    });
</script>

<?php
include('footer_user.php');
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/main.js"></script>
</body>

</html>
