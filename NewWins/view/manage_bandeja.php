<?php include 'header.php'; ?>

<head>
    <title>Bandeja de mensajes</title>
</head>

<body>
    <div class="container my-5">
        <h4 class="mb-4">Bandeja de Entrada</h4>

        <?php
        // Incluir el controlador para obtener los artículos
        include '../controller/listar_bandeja.php';
        ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Autor <br><i class='bx bxs-user'></i></th>
                    <th>Fecha <br><i class='bx bx-calendar'></i></th>
                    <th>Imagen <br><i class='bx bx-images'></i></th>
                    <th>Título <br><i class='bx bx-list-ul'></i></th>
                    <th>Contenido <br><i class='bx bxs-book-content'></i></th>
                    <th>Acciones <br><i class='bx bx-cog'></i></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($articulos)) : ?>
                    <?php foreach ($articulos as $articulo) : ?>
                        <tr>
                            <td><?= htmlspecialchars($articulo["nombre_usuario"]) ?></td>
                            <td><?= date("Y-m-d H:i:s", strtotime($articulo["fecha_envio"])) ?></td>
                            <td>
                                <?php if (!empty($articulo["url"])) : ?>
                                    <img src="<?= htmlspecialchars($articulo["url"]) ?>" alt="Imagen" width="100">
                                <?php else : ?>
                                    No hay imagen
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($articulo["titulo"]) ?></td>
                            <td><?= htmlspecialchars($articulo["contenido"]) ?></td>
                            <td>
                                <form action="../controller/procesar_noticia.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $articulo['id'] ?>">
                                    <button type="submit" name="accion" value="denegar" class="btn btn-danger">Denegar</button>
                                </form>
                                <form action="../view/editar_noticia.php" method="get" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $articulo['id'] ?>">
                                    <button type="submit" class="btn btn-warning">Editar y Subir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">No hay artículos en la bandeja de entrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>