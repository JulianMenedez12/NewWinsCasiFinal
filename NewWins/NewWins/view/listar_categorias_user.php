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
//obtener nombre de categoria para el titulo//
if ($categoria_id>0){
$categoria_name = $gestorContenido->obtenerCategoriaPorId($categoria_id);
}
// Obtener artículos relacionados con la categoría seleccionada
$articulos = [];
if ($categoria_id > 0) {
    $articulos = $gestorContenido->listarArticulosPorCategoria($categoria_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NEWWINS</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/style.css"> <!-- Agrega tu archivo CSS personalizado aquí -->
</head>

<body>
<?php
include ('header_user.php')
?>
    <!-- Navbar End -->

    <!-- Main Content Start -->
    <div class="container mt-4">
        <?php if ($categoria_id > 0 && !empty($articulos)) : ?>
            <h2 class="mb-4">Artículos en la categoría: <?php echo htmlspecialchars($categoria_name['nombre']); ?></h2>
            <div class="row">
                <?php foreach ($articulos as $articulo) : ?>
                    <?php $vistaNoticias->mostrarArticulo($articulo); ?>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No se encontraron artículos para esta categoría.</p>
        <?php endif; ?>
    </div>
    <!-- Main Content End -->

    <?php include('footer_user.php'); ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/owlcarousel/owl.carousel.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>