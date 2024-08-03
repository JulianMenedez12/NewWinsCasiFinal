<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styless.css">
</head>
<body>
    <div class="container my-5">
       <!-- Div para la imagen centrada -->
        <div class="row gx-lg-5 align-items-center">
            <div class="col-12 centered-content mb-5">
                <img src="../img/logo.png" alt="img-fluid" class="img-centered">
            </div>
        </div>
        <div class="contact-content">
            <h1 class="section-title">Contáctanos</h1>
            <p>Si tienes alguna pregunta o inquietud, no dudes en contactarnos utilizando el formulario a continuación o enviándonos un correo electrónico.</p>
            
            <h2 class="section-title">Formulario de Contacto</h2>
            <form action="mailto:newwinscorreo@gmail.com" method="post" enctype="text/plain">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
            
            <h2 class="section-title mt-4">Envíanos un Correo Electrónico Directamente</h2>
            <p>También puedes enviarnos un correo electrónico directamente a través de 
                <a href="https://www.google.com/intl/es-419/gmail/about/" class="footer-link" target="_blank">Gmail.com</a> 
                a nuestro correo 
                <a href="mailto:newwinscorreo@gmail.com?subject=Consulta%20sobre%20el%20sitio%20web&body=Hola,%20me%20gustaría%20hacer%20una%20consulta." class="footer-link" target="_blank">newwinscorreo@gmail.com</a>.
            </p>

        </div>
        <div class="text-center mt-5">
            <a href="terminos_y_condiciones.php" class="btn btn-danger">Volver a los Términos y Condiciones </a>
        </div>
    </div>
</body>
</html>
