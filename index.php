<?php
// Inicializamos la variable de estado
$status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dbname = $_POST['dbname'];
    
    // Crear conexión
    $conn = new mysqli($host, $username, $password);

    // Verificar conexión
    if ($conn->connect_error) {
        $status = "Conexión fallida: " . $conn->connect_error;
    } else {
        // Crear base de datos
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        if ($conn->query($sql) === TRUE) {
            // Seleccionar la base de datos
            $conn->select_db($dbname);

            // Leer el archivo SQL
            $dumpFile = 'newwinsDUMP.sql';
            $queries = file_get_contents($dumpFile);
            if ($queries === false) {
                $status = "Error al leer el archivo SQL.";
            } else {
                // Dividir el contenido en consultas
                $queries = explode(';', $queries);

                // Ejecutar las consultas
                foreach ($queries as $query) {
                    $query = trim($query);
                    if (!empty($query)) {
                        if ($conn->query($query) === FALSE) {
                            $status = "Error al ejecutar la consulta: " . $conn->error;
                            break;
                        }
                    }
                }

                if (empty($status)) {
                    // Insertar usuario admin
                    $adminPassword = password_hash('contraseña', PASSWORD_DEFAULT);
                    $insertAdmin = "INSERT INTO usuarios_registrados (nombre_usuario, contrasena, correo_electronico, apellido, es_admin) 
                                    VALUES ('admin', '$adminPassword', 'admin@gmail.com', 'Admin', 1)";
                    
                    if ($conn->query($insertAdmin) === FALSE) {
                        $status = "Error al insertar el usuario admin: " . $conn->error;
                    } else {
                        // Actualizar el archivo de conexión
                        $conexionFile = 'NewWins/model/conexion.php';
                        $conexionContent = "<?php\n";
                        $conexionContent .= "class ConexionBD {\n";
                        $conexionContent .= "    public static function obtenerConexion() {\n";
                        $conexionContent .= "        \$servername = '$host';\n";
                        $conexionContent .= "        \$username = '$username';\n";
                        $conexionContent .= "        \$password = '$password';\n";
                        $conexionContent .= "        \$dbname = '$dbname';\n";
                        $conexionContent .= "\n";
                        $conexionContent .= "        \$conn = new mysqli(\$servername, \$username, \$password, \$dbname);\n";
                        $conexionContent .= "\n";
                        $conexionContent .= "        if (\$conn->connect_error) {\n";
                        $conexionContent .= "            die(\"Conexión fallida: \" . \$conn->connect_error);\n";
                        $conexionContent .= "        }\n";
                        $conexionContent .= "\n";
                        $conexionContent .= "        return \$conn;\n";
                        $conexionContent .= "    }\n";
                        $conexionContent .= "}\n";
                        $conexionContent .= "?>";

                        // Guardar el archivo de conexión
                        if (file_put_contents($conexionFile, $conexionContent) === false) {
                            $status = "Error al actualizar el archivo de conexión.";
                        } else {
                            $status = "Base de datos configurada y archivo de conexión actualizado.";
                        }
                    }
                }
            }
        } else {
            $status = "Error al crear la base de datos: " . $conn->error;
        }
    }

    // Mostrar la alerta y redirigir
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Instalador de Base de Datos</title>
        <link rel='stylesheet' href='https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: '" . (strpos($status, "Error") === false ? "Éxito" : "Error") . "',
                text: '$status',
                icon: '" . (strpos($status, "Error") === false ? "success" : "error") . "'
            }).then(() => { window.location.href = 'NewWins/view/index.php'; });
        </script>
    </body>
    </html>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalador de Base de Datos</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Instalador de Base de Datos NewWins</h1>
        <img src="NewWins/img/logo.png" alt="img-fluid" width="175" height="157">
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="host" class="form-label">Host</label>
                <input type="text" class="form-control" id="host" name="host" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="dbname" class="form-label">Nombre de la Base de Datos</label>
                <input type="text" class="form-control" id="dbname" name="dbname" required>
            </div>
            <button type="submit" class="btn btn-primary">Instalar</button>
        </form>
    </div>
</body>