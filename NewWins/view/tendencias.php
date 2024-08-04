<?php 
include 'header_user.php'; 

// Recuperar noticias de tendencia desde la sesión
$noticiasTendencia = isset($_SESSION['noticiasTendencia']) ? $_SESSION['noticiasTendencia'] : [];
unset($_SESSION['noticiasTendencia']); // Limpiar datos después de usarlos

// Verificar si hay un mensaje de error en la URL
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias en Tendencia</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> <!-- Agrega tu archivo CSS personalizado aquí -->

    <!-- Incluye Day.js desde un CDN -->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/plugin/relativeTime.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/locale/es.js"></script>
</head>
<body>
    <!-- Tendencias Start -->
    <div class="container mt-4">
        <h2 class="mb-4">Noticias en Tendencia</h2>
        
        <?php if ($error === 'no_tendencias'): ?>
            <div class="alert alert-warning" role="alert">
                No hay noticias en tendencia en este momento.
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if (!empty($noticiasTendencia)): ?>
                <?php foreach ($noticiasTendencia as $noticia): ?>
                    <div class="col-md-4 mb-4">
                        <a href="ver_noticia.php?id=<?php echo $noticia['id']; ?>" style="text-decoration:none">
                            <div class="card">
                                <img src="<?php echo $noticia['url']; ?>" class="card-img-top" alt="<?php echo $noticia['titulo']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $noticia['titulo']; ?></h5>
                                    <p class="card-text"><span class="fecha-noticia" data-fecha="<?php echo $noticia['fecha_publicacion']; ?>"></span></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- En caso de que no haya noticias, pero sin error específico -->
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        No hay noticias en tendencia en este momento.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Tendencias End -->

    <?php include('footer_user.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/owlcarousel/owl.carousel.min.js"></script>
    <script src="../js/main.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        dayjs.extend(window.dayjs_plugin_relativeTime);
        dayjs.locale('es');
        
        const fechas = document.querySelectorAll('.fecha-noticia');
        fechas.forEach(fecha => {
            const fechaOriginal = fecha.getAttribute('data-fecha');
            if (fechaOriginal) {
                const fechaRelativa = dayjs(fechaOriginal).fromNow();
                fecha.textContent = fechaRelativa;
            } else {
                console.log('Fecha original no encontrada');
            }
        });
    });
    </script>
</body>
</html>
