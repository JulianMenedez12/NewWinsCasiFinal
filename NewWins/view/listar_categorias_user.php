<?php
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';
require_once '../model/vistanoticias.php';

// Obtener la categoría seleccionada
$categoria_id = isset($_GET['categoria_id']) ? intval($_GET['categoria_id']) : 0;

// Configuración de la base de datos
$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);
$vistaNoticias = new VistaNoticias($gestorContenido);

// Obtener la fecha actual
$fechaActual = date("d/m/Y"); // Formato de fecha: día/mes/año

// Obtener nombre de categoría para el título
$categoria_name = [];
if ($categoria_id > 0) {
    $categoria_name = $gestorContenido->obtenerCategoriaPorId($categoria_id);
}

// Obtener artículos relacionados con la categoría seleccionada
$articulos = [];
if ($categoria_id > 0) {
    $articulos = $gestorContenido->listarArticulosPorCategoria($categoria_id);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NEWWINS</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/style.css"> <!-- Agrega tu archivo CSS personalizado aquí -->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/plugin/relativeTime.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/locale/es.js"></script>
    <script>
        // Configura el plugin de tiempo relativo y el idioma español
        dayjs.extend(window.dayjs_plugin_relativeTime);
        dayjs.locale('es');
    </script>
</head>

<body>
<?php include('header_user.php'); ?>
    <!-- Main Content Start -->
    <div class="container mt-4">
        <?php if ($categoria_id > 0 && !empty($articulos)) : ?>
            <h2 class="mb-4">Artículos en la categoría: <?php echo htmlspecialchars($categoria_name['nombre']); ?></h2>
            <div class="row">
                <?php foreach ($articulos as $articulo) : ?>
                    <div class="col-md-4 mb-4">
                        <a href="ver_noticia.php?id=<?php echo $articulo['id']; ?>" style="text-decoration:none">
                            <div class="card">
                                <img src="<?php echo $articulo['url']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($articulo['titulo']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($articulo['titulo']); ?></h5>
                                    <p class="card-text">
                                        <span class="fecha-articulo" data-fecha="<?php echo $articulo['fecha_publicacion']; ?>"></span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No se encontraron artículos para esta categoría.</p>
        <?php endif; ?>
    </div>
    <!-- Main Content End -->

    <?php include('footer_user.php'); ?>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechas = document.querySelectorAll('.fecha-articulo');
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
