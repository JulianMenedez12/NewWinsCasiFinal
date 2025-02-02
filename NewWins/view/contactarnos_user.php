<?php include('header_user.php'); ?>

<body>

    <div class="container my-5">
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

    </div>
</body>
</html>
