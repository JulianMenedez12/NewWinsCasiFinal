<!DOCTYPE html>
<html lang="es">
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
            const fechas = document.querySelectorAll('.fecha-noticia');
            fechas.forEach(fecha => {
                const fechaOriginal = fecha.getAttribute('data-fecha');
                const fechaRelativa = dayjs(fechaOriginal).fromNow();
                fecha.textContent = fechaRelativa;
            });
        });
    </script>
</body>

</html>