<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: admin.php");
} else if (isset($_SESSION['correo']) == "") {
    header("Location: admin.php");
}

require_once 'header.php';
require_once '../model/conexion.php';
require_once '../model/gestor_usuarios.php';

$gestorUsuarios = new GestorUsuarios();
$usuarios = $gestorUsuarios->listarUsuarios();
?>
<head>
    <title>Gestión de usuarios</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
</head>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
                <div class="alert alert-success">El usuario ha sido actualizado correctamente.</div>
            <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error') : ?>
                <div class="alert alert-danger">Hubo un error al actualizar el usuario.</div>
            <?php endif; ?>
            <div id="usuarios" class="mt-4">
                <h4>Usuarios Registrados</h4>
                <div class="table-responsive mt-4">
                    <?php if (!empty($usuarios)) : ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID <br><i class='bx bx-hash'></i></th>
                                    <th>Nombre de Usuario <br> <i class='bx bxs-user'></i></th>
                                    <th>Correo Electrónico <br><i class='bx bxs-chat'></i></th>
                                    <th>Acciones <br><i class='bx bx-cog'></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usuario) : ?>
                                    <tr>
                                        <td><?php echo $usuario['id']; ?></td>
                                        <td><?php echo $usuario['nombre_usuario']; ?></td>
                                        <td><?php echo $usuario['correo_electronico']; ?></td>
                                        <td>
                                            <?php if ($usuario['es_admin'] == 0): ?>
                                                <form method="post" action="../controller/cambiar_admin.php">
                                                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                                    <input type="hidden" name="accion" value="dar">
                                                    <button type="submit" class="btn btn-success">Dar Admin</button>
                                                </form>
                                            <?php else: ?>
                                                <form method="post" action="../controller/cambiar_admin.php">
                                                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                                    <input type="hidden" name="accion" value="quitar">
                                                    <button type="submit" class="btn btn-danger">Quitar Admin</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p>No hay usuarios registrados.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
