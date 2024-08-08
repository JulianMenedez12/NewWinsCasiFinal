<?php
include 'header.php';
require_once '../model/conexion.php';
require_once '../model/BandejaEntrada.php';

$conn = ConexionBD::obtenerConexion();
$model = new BandejaEntradaModel($conn);

$articulo = $model->obtenerArticuloPorId($_GET['id']);
?>
<body>
    <div class="container my-5">
        <h4 class="mb-4">Editar Noticia</h4>
        <div class="card">
            <div class="card-body">
                <form action="../controller/subir_noticia_bandeja.php" method="post">
                    <input type="hidden" name="id" value="<?= $articulo['id'] ?>">
                    <div class="form-group">
                        <label for="titulo">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($articulo['titulo']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="contenido">Contenido:</label>
                        <textarea class="form-control" id="contenido" name="contenido" rows="10"><?= htmlspecialchars($articulo['contenido']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="url">Imagen de portada (URL):</label>
                        <input type="text" class="form-control" id="url" name="url" value="<?= htmlspecialchars($articulo['url']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria_id">Categoría:</label>
                        <select class="form-control" id="categoria_id" name="categoria_id" required>
                            <?php
                            include '../controller/listar_categoria.php';
                            echo aa($articulo['categoria_id']);
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir Noticia</button>
                </form>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['estado'])): ?>
        <script>
            <?php if ($_GET['estado'] == 'exito'): ?>
                mostrarAlertaExito("Noticia subida exitosamente.");
            <?php elseif ($_GET['estado'] == 'error'): ?>
                mostrarAlertaError("Hubo un error al subir la noticia.");
            <?php endif; ?>
        </script>
    <?php endif; ?>
</body>
</html>
