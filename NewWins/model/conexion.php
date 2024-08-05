<?php
// Definición de la clase ConexionBD
class ConexionBD {
    // Método estático para obtener una conexión a la base de datos
    public static function obtenerConexion() {
        // Datos de la conexión a la base de datos
        $servername = '127.0.0.1'; // Dirección del servidor de la base de datos
        $username = 'root'; // Nombre de usuario para la conexión
        $password = 'root'; // Contraseña para la conexión
        $dbname = 'newwins'; // Nombre de la base de datos

        // Crear una nueva conexión a la base de datos usando mysqli
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar si la conexión tuvo éxito
        if ($conn->connect_error) {
            // Si hay un error en la conexión, mostrar un mensaje y detener la ejecución
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Devolver el objeto de conexión
        return $conn;
    }
}
?>
