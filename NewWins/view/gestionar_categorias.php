<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: admin.php");
    exit();
} else if (isset($_SESSION['correo']) == "") {
    header("Location: admin.php");
    exit();
}

include 'header.php';
?>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="mt-4">
                <h4>Categorías Generales</h4>
                <?php
                include '../model/conexion.php';
                include '../model/gestor_noticias.php';

                $conexion = ConexionBD::obtenerConexion();
                $gestor = new GestorContenido($conexion);

                $categorias = $gestor->listarCategorias();

                if ($categorias) {
                    if (!empty($categorias)) {
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-bordered table-striped">';
                        echo '<thead class="table-dark">';
                        echo '<tr>';
                        echo '<th>ID <br> <i class="bx bx-hash"></i></th>';
                        echo '<th>Nombre <br> <i class="bx bxs-label"></i></th>';
                        echo '<th>Descripción <br> <i class="bx bx-receipt"></i></th>';
                        echo '<th>Imagen <br><i class="bx bx-images"></i></th>';
                        echo '<th>Acciones <br><i class="bx bx-slider"></i></th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        foreach ($categorias as $categoria) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($categoria["id"]) . '</td>';
                            echo '<td>' . htmlspecialchars($categoria["nombre"]) . '</td>';
                            echo '<td>' . htmlspecialchars($categoria["descripcion"]) . '</td>';
                            echo '<td><img src="' . htmlspecialchars($categoria["imagen"]) . '" alt="' . htmlspecialchars($categoria["nombre"]) . '" class="img-thumbnail" style="max-width: 150px; max-height: 150px;"></td>';
                            echo '<td>';
                            echo '<a href="../controller/eliminar_categoria.php?id=' . htmlspecialchars($categoria["id"]) . '" class="btn btn-danger btn-sm">Eliminar <i class="bx bxs-trash"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo '<p class="text-muted">No hay categorías disponibles.</p>';
                    }
                } else {
                    echo '<p class="text-danger">Ocurrió un error al obtener las categorías.</p>';
                }

                $conexion->close();
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        if (status === 'success') {
            mostrarAlertaExito('Categoría eliminada correctamente.');
        } else if (status === 'error') {
            mostrarAlertaError('Error al eliminar la categoría.');
        }
    });
</script>
</body>
</html>
