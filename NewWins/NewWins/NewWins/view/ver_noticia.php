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
    $conteoValoraciones = $gestorContenido->obtenerConteoValoraciones($articulo_id);
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
        <!-- Código HTML para los botones de like y dislike -->
        <div class="btn-group" role="group" aria-label="Reacciones">
    <button id="likeButton" class="btn btn-success btn-sm" data-articulo-id="<?php echo $articulo_id; ?>" style="width: 10px;">
        <i class="fas fa-thumbs-up"></i> Like <span id="likeCount"><?php echo $conteoValoraciones['likes']; ?></span>
    </button>
    <button id="dislikeButton" class="btn btn-danger btn-sm" data-articulo-id="<?php echo $articulo_id; ?>" style="width: 10px;">
        <i class="fas fa-thumbs-down"></i> Dislike <span id="dislikeCount"><?php echo $conteoValoraciones['dislikes']; ?></span>
    </button>
</div>


    <script>
                // Código JavaScript para manejar clics en los botones
                document.getElementById('likeButton').addEventListener('click', function() {
                    procesarValoracion('like');
                });

                document.getElementById('dislikeButton').addEventListener('click', function() {
                    procesarValoracion('dislike');
                });

                function procesarValoracion(valoracion) {
                    const articuloId = document.querySelector(`#${valoracion}Button`).getAttribute('data-articulo-id');
                    
                    fetch('../controller/gestionar_valoracion.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'articulo_id': articuloId,
                            'valoracion': valoracion
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Actualizar el conteo de valoraciones
                            document.querySelector('#likeButton').innerHTML = `<i class="fas fa-thumbs-up"></i> Like <span id="likeCount">${data.likes}</span>`;
                            document.querySelector('#dislikeButton').innerHTML = `<i class="fas fa-thumbs-down"></i> Dislike <span id="dislikeCount">${data.dislikes}</span>`;
                        } else {
                            alert('Error al procesar la valoración.');
                        }
                    });
                }
            </script>
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
    <script src="../js/main.js"></script>
    </body>

    </html>
