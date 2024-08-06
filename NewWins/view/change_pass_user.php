<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguridad</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include('header_user.php'); ?>

    <div class="container-xl px-4 mt-4">
        <nav class="nav nav-borders">
            <a class="nav-link ms-0" href="perfil_user.php">Perfil</a>
            <a class="nav-link active" href="change_pass_user.php">Seguridad</a>
        </nav>
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">Cambiar contraseña</div>
                    <div class="card-body">
                        <form action="../controller/change_password_c.php" method="POST">
                            <div class="mb-3">
                                <label class="small mb-1" for="currentPassword">Contraseña actual</label>
                                <input class="form-control" id="currentPassword" name="currentPassword" type="password" placeholder="Ingresa la contraseña actual" required>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="newPassword">Nueva contraseña</label>
                                <input class="form-control" id="newPassword" name="newPassword" type="password" placeholder="Ingresa la nueva contraseña" required>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="confirmPassword">Confirmar nueva contraseña</label>
                                <input class="form-control" id="confirmPassword" name="confirmPassword" type="password" placeholder="Confirma la nueva contraseña" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Guardar</button>
                        </form>
                    </div>
                </div>
                <hr class="my-4">
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Eliminar tu cuenta</div>
        <div class="card-body">
            <p>Eliminar su cuenta es una acción permanente y no se puede deshacer. Si está seguro de que desea eliminar su cuenta, seleccione el botón a continuación.</p>
            <form method="POST" action="../controller/eliminar_usuario.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
                <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['user_id']; ?>">
                <button class="btn btn-danger" type="submit">Entiendo, borrar mi cuenta</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
</body>
</html>
