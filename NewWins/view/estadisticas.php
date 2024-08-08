<?php
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';

$estadisticas = [];
$fechaInicio = '';
$fechaFin = '';

if (isset($_GET['fecha_inicio']) && isset($_GET['fecha_fin'])) {
    $fechaInicio = $_GET['fecha_inicio'];
    $fechaFin = $_GET['fecha_fin'];
    $estadisticas = [
        'total_articulos' => $_GET['total_articulos'],
        'total_valoraciones' => $_GET['total_valoraciones'],
        'total_comentarios' => $_GET['total_comentarios'],
        'total_usuarios' => $_GET['total_usuarios'],
        'total_likes' => $_GET['total_likes'],
        'total_dislikes' => $_GET['total_dislikes'],
        'total_articulos_bandeja' => $_GET['total_articulos_bandeja']
    ];
}
?>
<?php include('header.php'); ?>
<body>
    <!-- Main Content Start -->
    <div class="container mt-4">
        <h1>Estadísticas para el rango de fechas: <?php echo htmlspecialchars($fechaInicio); ?> a <?php echo htmlspecialchars($fechaFin); ?></h1>
        
        <form method="POST" action="../controller/estadisticas_controller.php" class="mb-4">
            <label for="fecha_inicio">Fecha de inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>
            <label for="fecha_fin">Fecha de fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>
            <button type="submit" class="btn btn-primary">Obtener Estadísticas</button>
        </form>
        
        <?php if ($fechaInicio && $fechaFin && $estadisticas) : ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Estadística</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Total de artículos publicados</td>
                            <td><?php echo htmlspecialchars($estadisticas['total_articulos']); ?></td>
                        </tr>
                        <tr>
                            <td>Total de valoraciones</td>
                            <td><?php echo htmlspecialchars($estadisticas['total_valoraciones']); ?></td>
                        </tr>
                        <tr>
                            <td>Total de comentarios</td>
                            <td><?php echo htmlspecialchars($estadisticas['total_comentarios']); ?></td>
                        </tr>
                        <tr>
                            <td>Total de usuarios registrados</td>
                            <td><?php echo htmlspecialchars($estadisticas['total_usuarios']); ?></td>
                        </tr>
                        <tr>
                            <td>Likes</td>
                            <td><?php echo htmlspecialchars($estadisticas['total_likes']); ?></td>
                        </tr>
                        <tr>
                            <td>Dislikes</td>
                            <td><?php echo htmlspecialchars($estadisticas['total_dislikes']); ?></td>
                        </tr>
                        <tr>
                            <td>Total de artículos en bandeja</td>
                            <td><?php echo htmlspecialchars($estadisticas['total_articulos_bandeja']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php elseif ($fechaInicio && $fechaFin) : ?>
            <p>No se encontraron estadísticas para el rango de fechas seleccionado.</p>
        <?php endif; ?>
    </div>
    <!-- Main Content End -->

    <?php include('footer_user.php'); ?>

    <!-- Scripts -->
    <script src="../js/main.js"></script>
</body>
</html>
