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
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://unpkg.com/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <!-- Section: Design Block -->
    <section class="">
        <!-- Jumbotron -->
        <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
            <div class="container">
                <div class="row gx-lg-5 align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <span class="text-primary"><img src="../img/logo.png" alt="img-fluid"></span>
                        <br><br>
                        <p style="color: hsl(217, 10%, 50.8%)">
                            En NewWins, estamos comprometidos a brindarte las noticias más relevantes y actualizadas de todo el mundo.
                            Nuestra misión es mantenerte informado con integridad, objetividad y precisión. Con un equipo de periodistas apasionados y expertos en diversas áreas,
                            cubrimos una amplia gama de temas que incluyen política, economía, tecnología, cultura, deportes y más.
                        </p>
                    </div>

                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="card">
                            <div class="card-body py-5 px-md-5">
                                <!-- Formulario de registro -->
                                <form id="registroForm" action="../controller/procesar_registro.php" method="POST">
                                    <!-- Campos del formulario -->
                                    <div class="row">
                                        <div class="col-md-4 mb-4">
                                            <div class="form-outline">
                                                <input type="text" name="nombre" id="nombre" class="form-control" required />
                                                <label class="form-label" for="nombre">Nombre</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="form-outline">
                                                <input type="text" name="apellido" id="apellido" class="form-control" required />
                                                <label class="form-label" for="apellido">Apellido</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="form-outline">
                                                <input type="text" name="nombre_user" id="nombre_user" class="form-control" required />
                                                <label class="form-label" for="nombre_user">Nombre de Usuario</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-outline">
                                            <input type="email" name="correo" id="correo" class="form-control" required />
                                            <label class="form-label" for="correo">Correo</label>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-outline">
                                            <input type="password" name="contrasena" id="contrasena" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" title="La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un símbolo." required />
                                            <label class="form-label" for="contrasena">Contraseña</label>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="pais" class="form-label">País</label>
                                        <select class="form-select" id="pais" name="pais" required>
                                            <option value="" selected disabled>Selecciona tu país</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Brasil">Brasil</option>
                                            <option value="Chile">Chile</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Costa Rica">Costa Rica</option>
                                            <option value="Cuba">Cuba</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="El Salvador">El Salvador</option>
                                            <option value="Guatemala">Guatemala</option>
                                            <option value="Honduras">Honduras</option>
                                            <option value="México">México</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Panamá">Panamá</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Perú">Perú</option>
                                            <option value="Puerto Rico">Puerto Rico</option>
                                            <option value="República Dominicana">República Dominicana</option>
                                            <option value="Uruguay">Uruguay</option>
                                            <option value="Venezuela">Venezuela</option>
                                            <option value="USA">Estados Unidos</option>
                                        </select>
                                    </div>
                                    <div class="cf-turnstile" data-sitekey="0x4AAAAAAAgIXngXPyh0WPqy" data-theme='light'></div>
                                    <input type="hidden" name="cf-turnstile-response" id="cf-turnstile-response">

                                    <!-- Botón de registro -->
                                    <button type="submit" class="btn btn-primary btn-block mb-4">Registrar</button>

                                    <!-- Mensaje de redirección -->
                                    <div id="mensaje" class="text-secondary text-center"></div>
                                </form>
                                <div class="col-12">
                                    <p class="m-0 text-secondary text-center">¿Ya tienes una cuenta? <a href="index.php" class="link-primary text-decoration-none">Iniciar sesión</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Script para manejar la respuesta del registro -->
    <script>
        document.getElementById('registroForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío automático del formulario

            // Obtener el token del captcha y agregarlo a los datos del formulario
            var captchaToken = document.querySelector('.cf-turnstile input[name="cf-turnstile-response"]').value;
            document.getElementById('cf-turnstile-response').value = captchaToken;

            // Enviar los datos del formulario mediante fetch
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this) // Enviar datos del formulario
            })
            .then(response => response.json()) // Convertir respuesta a JSON
            .then(data => {
                console.log(data); // Verificar los datos recibidos
                if (data.status === 'success') {
                    // Mostrar alerta de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    // Redirigir después de 3 segundos
                    setTimeout(() => {
                        window.location.href = '../view/index.php';
                    }, 3000);
                } else {
                    // Mostrar alerta de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al procesar tu solicitud.'
                });
            });
        });
    </script>
</body>

</html>
