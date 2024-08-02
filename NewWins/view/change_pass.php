<title>Seguridad</title>
<?php
include('header.php')
?>

<body>
    <div class="container-xl px-4 mt-4">
        <nav class="nav nav-borders">
            <a class="nav-link ms-0" href="perfil.php">Perfil</a>
            <a class="nav-link active" href="change_pass.php">Seguridad</a>
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
            <button class="btn btn-danger-soft text-danger" type="button">Entiendo, borrar mi cuenta</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script> 
</body>

</html>