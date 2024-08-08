<?php include 'header.php'; ?> <!-- Incluir el encabezado común -->
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div id="noticias" class="mt-4">
                    <h4>Noticias</h4>
                    <div class="card">
                        <div class="card-body">
                            <!-- Formulario para subir noticias -->
                            <form action="../controller/subir_noticia.php" method="post">
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
                                        require_once '../controller/listar_categoria.php';
                                        echo aa();
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Subir Noticia <br><i class='bx bx-upload'></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="categorias" class="mt-4">
                    <h4>Categorías</h4>
                    <div class="card">
                        <div class="card-body">
                            <!-- Formulario para crear categorías -->
                            <form action="../controller/crear_categoria.php" method="post">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción:</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="imagen">Imagen (URL):</label>
                                    <input type="text" class="form-control" id="imagen" name="imagen">
                                </div>
                                <button type="submit" class="btn btn-secondary">Crear Categoría <br><i class='bx bxs-category'></i></button>
                            </form>
                        </div>
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
    // Verificar si hay un mensaje de éxito o error después de subir noticia
    if (isset($_GET['noticia'])) {
        if ($_GET['noticia'] == 'exito') {
            echo "<script> mostrarAlertaExito('Noticia subida correctamente.'); </script>";
        } elseif ($_GET['noticia'] == 'error') {
            echo "<script> mostrarAlertaError('Error al subir la noticia.'); </script>";
        }
    }

    // Verificar si hay un mensaje de éxito o error después de crear categoría
    if (isset($_GET['categoria'])) {
        if ($_GET['categoria'] == 'exito') {
            echo "<script> mostrarAlertaExito('Categoría creada correctamente.'); </script>";
        } elseif ($_GET['categoria'] == 'error') {
            echo "<script> mostrarAlertaError('Error al crear la categoría.'); </script>";
        }
    }
    ?>

</body>

</html>