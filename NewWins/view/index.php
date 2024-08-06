<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Q99HS3X12S"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-Q99HS3X12S');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <!-- Login 13 - Bootstrap Brain Component -->
    <section class="bg-light py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-6 mb-4 mb-md-0">
                    <div class="card border border-light-subtle rounded-3 shadow-sm">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="text-center mb-3">
                                <a href="#!">
                                    <img src="../img/logo.png" alt="img-fluid" width="175" height="157">
                                </a>
                            </div>
                            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Iniciar sesión con tu cuenta</h2>
                            <form id="loginForm" action="../controller/procesar_login.php" method="POST">
                                <div class="row gy-2 overflow-hidden">
                                    <!-- Formulario de inicio de sesión -->
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                                            <label for="email" class="form-label">Correo</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                            <label for="password" class="form-label">Contraseña</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex gap-2 justify-content-between">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" name="rememberMe" id="rememberMe">
                                                <label class="form-check-label text-secondary" for="rememberMe">
                                                    Mantener sesión iniciada
                                                </label>
                                                <br>
                                                <a href="recuperar_pass.php" class="link-primary text-center text-decoration-none"> ¿Olvidaste tu contraseña? </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cf-turnstile" data-sitekey="0x4AAAAAAAgIXngXPyh0WPqy" data-theme="light"></div>
                                    <input type="hidden" name="cf-turnstile-response" id="cf-turnstile-response">
                                    <div class="col-12">
                                        <div class="d-grid my-3">
                                            <button class="btn btn-danger btn-lg" type="submit">Iniciar Sesión</button>
                                        </div>
                                    </div>
                                    <?php
                                    // Verificar si hay un mensaje de error en la URL
                                    if (isset($_GET['error']) && $_GET['error'] == 'contrasena') {
                                        echo '<div class="alert alert-danger" role="alert">Hay algún dato incorrecto. Por favor, intenta nuevamente.</div>';
                                    }
                                    ?>
                                    <div class="col-12">
                                        <p class="m-0 text-secondary text-center"><a href="register.php" class="link-primary text-decoration-none">Crear Cuenta</a></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="m-0 text-secondary text-center">Admin--<a href="admin.php" class="link-primary text-decoration-none">Entrar</a></p>
                                    </div>
                                </div>
                            </form>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('loginForm').addEventListener('submit', function(event) {
                                        event.preventDefault(); // Evitar envío normal del formulario

                                        // Obtener el token del captcha
                                        const captchaToken = document.querySelector('.cf-turnstile input[name="cf-turnstile-response"]').value;

                                        // Verificar si el token del captcha está presente
                                        if (!captchaToken) {
                                            mostrarAlertaError('Por favor, completa el captcha.');
                                            return;
                                        }

                                        // Obtener datos del formulario
                                        var formData = new FormData(this);
                                        formData.append('cf-turnstile-response', captchaToken);

                                        // Enviar datos mediante Fetch API
                                        fetch(this.action, {
                                            method: 'POST',
                                            body: formData
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                mostrarAlertaExito('Inicio de sesión correcto. Redirigiendo...');
                                                setTimeout(function() {
                                                    window.location.href = '../view/articulos.php';
                                                }, 3000);
                                            } else {
                                                mostrarAlertaError(data.message);
                                            }
                                        })
                                        .catch(error => {
                                            mostrarAlertaError('Hubo un problema al comunicarse con el servidor.');
                                        });
                                    });

                                    function mostrarAlertaExito(mensaje) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Éxito',
                                            text: mensaje,
                                            showConfirmButton: false,
                                            timer: 3000
                                        });
                                    }

                                    function mostrarAlertaError(mensaje) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: mensaje
                                        });
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
