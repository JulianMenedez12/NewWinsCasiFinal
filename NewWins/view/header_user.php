<?php
session_start();
if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("Location: index.php");
    exit();
}

require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';
require_once '../model/vistanoticias.php';

// Configuración de la base de datos
$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);
$vistaNoticias = new VistaNoticias($gestorContenido);
// Obtener la fecha actual
$fechaActual = date("d/m/Y"); // Formato de fecha: día/mes/año
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-adsense-account" content="ca-pub-8262837766739470">
    <title>NEWWINS</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css">
    <link rel="stylesheet" href="../css/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/style.css"> <!-- Agrega tu archivo CSS personalizado aquí -->
    <link rel="stylesheet" href="../css/styless.css">
    <link rel="stylesheet" href="../css/bandeja.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8262837766739470"
     crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/plugin/relativeTime.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/locale/es.js"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8262837766739470"
    crossorigin="anonymous"></script>
    <script>
        // Configura el plugin de tiempo relativo y el idioma español
        dayjs.extend(window.dayjs_plugin_relativeTime);
        dayjs.locale('es');
    </script>
    <script>
        // Configura el plugin de tiempo relativo y el idioma español
        dayjs.extend(window.dayjs_plugin_relativeTime);
        dayjs.locale('es');
    </script>
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
    <!-- Topbar Start -->
    <div class="container-fluid bg-light px-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <a href="articulos.php" class="navbar-brand d-none d-lg-block">
                    <h1 class="m-0 display-5 text-uppercase"><span class="text-danger">New</span>Wins</h1>
                </a>
            </div>

            <div class="col-lg-8 text-center text-lg-end">
                <img class="img-fluid" src="img/ads-700x70.jpg" alt="">
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-2 px-lg-5">
        <div class="container-fluid">
            <a class="navbar-brand d-block d-lg-none" href="articulos.php">
                <h1 class="m-0 display-5 text-uppercase"><span class="text-primary">New</span>Wins</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="articulos.php">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorías
                        </a>
                        <?php
                        // Incluir el archivo de conexión y creación de instancia de GestorContenido si no está incluido
                        require_once('../model/conexion.php');
                        require_once('../model/gestor_noticias.php');

                        // Crear instancia del gestor de contenido
                        $conexion = ConexionBD::obtenerConexion();
                        $gestorContenido = new GestorContenido($conexion);

                        // Obtener las categorías
                        $categorias = $gestorContenido->listarCategorias();

                        // Verificar si hay categorías disponibles
                        if ($categorias->num_rows > 0) {
                            echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                            while ($categoria = $categorias->fetch_assoc()) {
                                echo '<li><a class="dropdown-item" href="listar_categorias_user.php?categoria_id=' . $categoria['id'] . '">' . $categoria['nombre'] . '</a></li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"><a class="dropdown-item">No hay categorías disponibles</a></div>';
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="enviar_news.php">Envía tu noticia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactarnos_user.php">Contactar</a>
                    </li>
                </ul>

                <div class="col-md-8 d-flex align-items-center">
                    <a href="../controller/tendencias_controller.php" class="text-decoration-none">
                        <div class="bg-danger text-white text-center py-2 px-3 d-none d-lg-inline-block tendencia-button hvr-pulse-grow">
                            Tendencia
                        </div>
                    </a>
                    <form class="d-flex flex-grow-1" action="../controller/buscar_noticias.php" method="GET">
                        <input type="text" class="form-control me-2" name="q" placeholder="Buscar" required>
                        <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search"></i></button>
                    </form>

                    <div class="col-md-1 text-md ms-3" style="margin-right: 10px;">
                        <?php echo $fechaActual; ?>
                    </div>
                    <div class="dropdown ms-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bxs-user'></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="perfil_user.php">Ver perfil</a></li>
                            <li><a id="cerrarSesionUser" class="dropdown-item" href="#">Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Scripts al final del body -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('cerrarSesionUser').addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Cerrando sesión',
                    icon: 'info',
                    showConfirmButton: false,
                    timer: 1500 // Duración en milisegundos
                }).then(function () {
                    window.location.href = '../controller/logout.php';
                });
            });
        });
    </script>
</body>

</html>
