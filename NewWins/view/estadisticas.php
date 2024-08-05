<?php
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';

$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);

$estadisticas = [];
$fecha = '';

if (isset($_GET['fecha'])) {
    $fecha = $_GET['fecha'];
    $estadisticas = $gestorContenido->obtenerEstadisticasPorFecha($fecha);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estadísticas</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Incluye tu archivo CSS aquí -->
    <style>
        .table-container {
            margin-top: 20px;
        }
        .stats-table {
            width: 100%;
            border-collapse: collapse;
        }
        .stats-table th, .stats-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .stats-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <!-- Main Content Start -->
    <div class="container mt-4">
        <h1>Estadísticas para la fecha: <?php echo htmlspecialchars($fecha); ?></h1>
        
        <form method="GET" action="" class="mb-4">
            <label for="fecha">Selecciona una fecha:</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>" required>
            <button type="submit" class="btn btn-primary">Obtener Estadísticas</button>
        </form>
        
        <div class="table-container">
            <?php if ($fecha && !empty($estadisticas)) : ?>
                <table class="stats-table">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Total de artículos publicados</td>
                            <td><?php echo isset($estadisticas['total_articulos']) ? htmlspecialchars($estadisticas['total_articulos']) : 'No disponible'; ?></td>
                        </tr>
                        <tr>
                            <td>Total de valoraciones</td>
                            <td><?php echo isset($estadisticas['total_valoraciones']) ? htmlspecialchars($estadisticas['total_valoraciones']) : 'No disponible'; ?></td>
                        </tr>
                        <tr>
                            <td>Likes</td>
                            <td><?php echo isset($estadisticas['total_likes']) ? htmlspecialchars($estadisticas['total_likes']) : 'No disponible'; ?></td>
                        </tr>
                        <tr>
                            <td>Dislikes</td>
                            <td><?php echo isset($estadisticas['total_dislikes']) ? htmlspecialchars($estadisticas['total_dislikes']) : 'No disponible'; ?></td>
                        </tr>
                        <tr>
                            <td>Total de usuarios registrados</td>
                            <td><?php echo isset($estadisticas['total_usuarios']) ? htmlspecialchars($estadisticas['total_usuarios']) : 'No disponible'; ?></td>
                        </tr>
                        <tr>
                            <td>Total de artículos en bandeja</td>
                            <td><?php echo isset($estadisticas['total_articulos_bandeja']) ? htmlspecialchars($estadisticas['total_articulos_bandeja']) : 'No disponible'; ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php elseif ($fecha) : ?>
                <p>No se encontraron estadísticas para la fecha seleccionada.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Main Content End -->

    <?php include('footer_user.php'); ?>

    <!-- Scripts -->
    <script src="../js/main.js"></script>
</body>
</html>
