<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> <!-- Agrega tu archivo CSS personalizado aquí -->
    <link rel="icon" href="../img/logo.png" type="image/png">

    <!-- Incluye Day.js desde un CDN -->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/plugin/relativeTime.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/locale/es.js"></script>
</head>
<body>
    <?php include('header_user.php'); ?>

    <!-- Main Content Start -->
    <div class="container mt-4">
        <h2 class="mb-4">Noticias</h2>
        <div class="row">
            <?php
            // Mostrar todas las noticias
            $vistaNoticias->mostrarNoticias();
            ?>
        </div>
    </div>
    <!-- Main Content End -->

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
