<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>

<body>
    <section class="bg-light py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <div class="card border border-light-subtle rounded-3 shadow-sm">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="text-center mb-3">
                                <a href="#!">
                                    <img src="../img/logo.png" alt="img-fluid" width="175" height="157">
                                </a>
                            </div>
                            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Iniciar sesión con admin</h2>
                            <form id="loginForm" action="../controller/procesar_login_admin.php" method="POST">
                                <div class="row gy-2 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" name="emailadmin" id="email" placeholder="name@example.com" required>
                                            <label for="email" class="form-label">Correo admin</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="passwordadmin" id="password" value="" placeholder="Password" required>
                                            <label for="password" class="form-label">Contraseña admin</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex gap-2 justify-content-between">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" name="rememberMe" id="rememberMe">
                                                <label class="form-check-label text-secondary" for="rememberMe">
                                                    Mantener sesión iniciada
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="cf-turnstile" data-sitekey="0x4AAAAAAAgIXngXPyh0WPqy" data-theme='light'></div>
                                        <div class="d-grid my-3">
                                            <button class="btn btn-danger btn-lg" type="submit">Iniciar Sesión</button>
                                        </div>
                                        <div class="col-12">
                                            <a href="index.php" class="link-primary text-decoration-none">Volver</a>
                                        </div>
                                    </div>
                                    <div id="alertContainer"></div> <!-- Contenedor para alertas -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Incluir SweetAlert (Swal) desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Archivo JavaScript para manejar alertas -->
    <script src="../js/alert.js"></script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar envío normal del formulario

            // Obtener datos del formulario
            var formData = new FormData(this);

            // Enviar datos mediante Fetch API
            fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Hubo un problema al comunicarse con el servidor.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        mostrarAlertaExito('Inicio de sesión correcto. Redirigiendo...');
                        setTimeout(function() {
                            window.location.href = '../view/admin_dashboard.php';
                        }, 3000);
                    } else {
                        mostrarAlertaError(data.message);
                    }
                })
                .catch(error => {
                    mostrarAlertaError(error.message);
                });
        });
    </script>

    <?php
    if (isset($_GET['error']) && $_GET['error'] == 'credenciales') {
        echo '<script src="../js/alert.js"></script>'; 
        echo '<script> mostrarAlertaError("Credenciales incorrectas. Por favor, verifica tu correo y contraseña."); </script>';
    }
    ?>
</body>

</html>
