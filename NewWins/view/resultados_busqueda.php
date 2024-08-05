<?php
include('header_user.php');

// Incluir archivos necesarios
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';
require_once '../model/vistanoticias.php';

// Inicializar objetos necesarios
$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);
$vistaNoticias = new VistaNoticias($gestorContenido);

// Obtener término de búsqueda y resultados de la sesión
$termino = $_SESSION['termino_busqueda'] ?? '';
$resultados = $_SESSION['resultados_busqueda'] ?? [];

?>

<!-- Main Content Start -->
<div class="container mt-4">
    <?php if (!empty($termino)) : ?>
        <h2 class="mb-4">Resultados de búsqueda para: <?php echo htmlspecialchars($termino); ?></h2>
        <div class="row">
            <?php if (!empty($resultados)) : ?>
                <?php foreach ($resultados as $articulo) : ?>
                    <?php $vistaNoticias->mostrarArticulo($articulo); ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No se encontraron resultados para: <?php echo htmlspecialchars($termino); ?></p>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <p>No se especificó un término de búsqueda válido.</p>
    <?php endif; ?>
</div>
<!-- Main Content End -->

<?php include('footer_user.php'); ?>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/owl.carousel/dist/owl.carousel.min.js"></script>
<script src="https://unpkg.com/dayjs/dayjs.min.js"></script>
<script src="https://unpkg.com/dayjs/plugin/relativeTime.js"></script>
<script src="https://unpkg.com/dayjs/locale/es.js"></script>
<script>
    dayjs.extend(dayjs_plugin_relativeTime);
    dayjs.locale('es'); // Configurar dayjs para usar español

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.fecha-relativa').forEach(function(element) {
            var fecha = element.getAttribute('data-fecha');
            element.textContent = dayjs(fecha).fromNow();
        });
    });
</script>
<script src="../js/main.js"></script>
</body>

</html>
