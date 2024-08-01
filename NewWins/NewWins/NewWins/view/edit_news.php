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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Artículos</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alert.js"></script> <!-- Asegúrate de usar la ruta correcta -->
        <script src="https://cdn.tiny.cloud/1/fj76e7aualveq77f2n0uc7mcz6cdimvxob2lx0yl9o4rwkhp/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#contenido',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            image_class_list: [
                { title: 'None', value: '' },
                { title: 'Responsive', value: 'img-fluid' }
            ],
            content_style: 'img { max-width: 100%; height: auto; }'
        });
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php
            require_once '../model/conexion.php';
            require_once '../model/gestor_noticias.php';
            $conexion = ConexionBD::obtenerConexion();
            $gestor = new GestorContenido($conexion);
            $result = $gestor->listarNoticias();
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $conexion = ConexionBD::obtenerConexion();
                $stmt = $conexion->prepare("SELECT * FROM articulos WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $articulo = $result->fetch_assoc();
            }
            ?>
            <div class="card mt-4">
                <div class="card-header">Editar Noticia</div>
                <div class="card-body">
                    <form action="../controller/editar_noticia.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($articulo['id']); ?>">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo htmlspecialchars($articulo['titulo']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="contenido" class="form-label">Contenido</label>
                            <textarea class="form-control" id="contenido" name="contenido" rows="10"><?php echo htmlspecialchars($articulo['contenido']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">URL de la Imagen</label>
                            <input type="text" id="url" name="url" class="form-control" value="<?php echo htmlspecialchars($articulo['url']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoría</label>
                            <select id="categoria_id" name="categoria_id" class="form-control" required>
                                <?php
                                $categorias = $gestor->listarCategorias();
                                while ($categoria = $categorias->fetch_assoc()) {
                                    $selected = ($categoria['id'] == $articulo['categoria_id']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($categoria['id']) . "' $selected>" . htmlspecialchars($categoria['nombre']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        if (status === 'success') {
            mostrarAlertaExito('Noticia editada correctamente.');
        } else if (status === 'error') {
            mostrarAlertaError('Error al editar la noticia.');
        }
    });
</script>
</body>
</html>
