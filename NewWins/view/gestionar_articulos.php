<?php
// admin_dashboard.php
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
<head>
    <title>Gestión de Artículos</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    <link rel="stylesheet" href="../css/bandeja.css">
</head>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div id="noticias" class="mt-4">
                <h4>Artículos Generales</h4>
                <div class="mt-4">
                    <div class="row">
                        <?php
                        include '../model/conexion.php';
                        include '../model/gestor_noticias.php';

                        $conexion = ConexionBD::obtenerConexion();
                        $gestor = new GestorContenido($conexion);
                        $result = $gestor->listarNoticias();

                        if ($result->num_rows > 0) {
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-bordered table-striped">';
                            echo '<thead class="table-dark">';
                            echo '<tr><th>ID<br><i class="bx bx-hash"></i></th><th>Categoría<br><i class="bx bxs-category-alt"></i></th><th>Título<br><i class="bx bx-list-ul"></i></th><th>Contenido<br><i class="bx bxs-book-content"></i></th><th>Imagen<br><i class="bx bx-images"></i></th><th>Acciones<br><i class="bx bx-slider"></i></th></tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            while ($row = $result->fetch_assoc()) {
                                $contenidoTruncado = htmlspecialchars($row["contenido"]);
                                if (strlen($contenidoTruncado) > 100) { // Ajusta el número de caracteres según tus necesidades
                                    $contenidoTruncado = substr($contenidoTruncado, 0, 100) . '...'; // Trunca el contenido y agrega '...'
                                }

                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["categoria"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["titulo"]) . '</td>';
                                echo '<td class="contenido-articulo">' . $contenidoTruncado . '</td>';

                                // Mostrar la imagen si la URL no está vacía
                                if (!empty($row["url"])) {
                                    echo '<td><img src="' . htmlspecialchars($row["url"]) . '" class="img-thumbnail"></td>';
                                } else {
                                    echo '<td>No hay imagen disponible</td>';
                                }

                                echo '<td>';
                                echo '<button onclick="confirmarEliminar(' . htmlspecialchars($row["id"]) . ')" class="btn btn-danger btn-sm">Eliminar <i class="bx bxs-trash"></i></button><br><br>';
                                echo '<a href="edit_news.php?id=' . htmlspecialchars($row["id"]) . '" class="btn btn-danger btn-sm">Editar <i class="bx bx-edit"></i></a>';
                                echo '</td>';
                                echo '</tr>';
                            }

                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>'; // Cierra table-responsive
                        } else {
                            echo '<p>No hay noticias disponibles.</p>';
                        }

                        $conexion->close();
                        ?>
                    </div>

                    <div class="col-md-3">
                        <?php
                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                            $conexion = ConexionBD::obtenerConexion();
                            $stmt = $conexion->prepare("SELECT * FROM articulos WHERE id = ?");
                            $stmt->bind_param("i", $id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $articulo = $result->fetch_assoc();
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
                                            <textarea id="contenido" name="contenido" class="form-control" rows="2" required><?php echo htmlspecialchars($articulo['contenido']); ?></textarea>
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
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Incluir SweetAlert (Swal) desde CDN -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <!-- Archivo JavaScript para manejar alertas -->
            <script src="../js/alert.js"></script>

            <script>
                function confirmarEliminar(id) {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción no se puede deshacer.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Realizar la petición para eliminar la noticia
                            fetch(`../controller/eliminar_noticia.php?id=${id}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: 'Eliminada!',
                                            text: 'La noticia ha sido eliminada correctamente.',
                                            icon: 'success'
                                        }).then(() => {
                                            // Redirigir a la página de gestión de artículos
                                            window.location.href = '../view/gestionar_articulos.php';
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Hubo un error al intentar eliminar la noticia.',
                                            icon: 'error'
                                        });
                                    }
                                });
                        }
                    });
                }
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
        </div>
    </div>
</div>
