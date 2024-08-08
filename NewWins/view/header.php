<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: admin.php");
    exit();
} else if ($_SESSION['correo'] == "") {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
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
    <title>NewWins Admin</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    
    <!-- Enlaces a Bootstrap y otros CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Script de SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.tiny.cloud/1/fj76e7aualveq77f2n0uc7mcz6cdimvxob2lx0yl9o4rwkhp/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#contenido',
            plugins: 'advlist media autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
            toolbar: 'media | undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            image_class_list: [
                { title: 'None', value: '' },
                { title: 'Responsive', value: 'img-fluid' }
            ],
            content_style: 'img { max-width: 100%; height: auto; }'
        });
    </script>
        
</head>

<body>

    <a class="navbar-brand outside-brand" href="admin_dashboard.php">
        <img src="../img/logo.png" alt="Logo">
    </a>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="gestionar_categorias.php">Gestionar Categorias <i class='bx bxs-category-alt'></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestionar_articulos.php">Gestionar Artículos <i class='bx bx-list-ul'></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="noticias.php">Ver Usuarios <i class='bx bxs-user-account'></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_bandeja.php">Bandeja de Mensajes <i class='bx bxs-inbox'></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="estadisticas.php">Estadisticas <i class='bx bxs-inbox'></i></a>
                    </li>
                </ul>
                <!-- Dropdown de usuario -->
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bxs-user'></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="perfil.php">Ver perfil</a></li>
                        <li><a id="cerrarSesion" class="dropdown-item" href="#">Cerrar sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido de la página -->

    <!-- Scripts de Bootstrap y otros JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para manejar la alerta al cerrar sesión -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('cerrarSesion').addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Cerrando sesión',
                    icon: 'info',
                    showConfirmButton: false,
                    timer: 1500 // Duración en milisegundos
                }).then(function() {
                    window.location.href = '../controller/logout.php';
                });
            });
        });
    </script>

</body>

</html>
