<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Noticia</title>
    <link rel="stylesheet" href="css/styles.css">
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
    <?php include 'header_user.php'; ?> <!-- Incluir el encabezado común -->

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div id="noticias" class="mt-4">
                <h4>Enviar Noticia</h4>
                <div class="card">
                    <div class="card-body">
                        <!-- Formulario para enviar noticias -->
                        <form action="../controller/enviar_noticia.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="titulo">Título:</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required>
                            </div>
                            <div class="form-group">
                                <label for="contenido">Contenido:</label>
                                <textarea class="form-control" id="contenido" name="contenido" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="url">Imagen de portada (URL):</label>
                                <input type="text" class="form-control" id="url" name="url" required>
                            </div>
                            <div class="form-group">
                                <label for="categoria_id">Categoría:</label>
                                <select class="form-control" id="categoria_id" name="categoria_id" required>
                                    <?php
                                    include '../controller/listar_categoria.php';
                                    echo aa();
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="articulo_id" value="<?php echo $articulo_id; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar Noticia</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Incluir SweetAlert (Swal) desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Archivo JavaScript para manejar alertas -->
    <script src="../js/alert.js"></script>

    <?php
    // Verificar si hay un mensaje de éxito o error después de enviar noticia
    if (isset($_GET['noticia'])) {
        if ($_GET['noticia'] == 'exito') {
            echo "<script> mostrarAlertaExito('Noticia enviada correctamente.'); </script>";
        } elseif ($_GET['noticia'] == 'error') {
            echo "<script> mostrarAlertaError('Error al enviar la noticia.'); </script>";
        }
    }
    ?>
</body>

</html>
