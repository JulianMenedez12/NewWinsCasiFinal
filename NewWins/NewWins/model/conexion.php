<?php

class ConexionBD {
    public static function obtenerConexion() {
        $servername = '127.0.0.1';
        $username = 'root';
        $password = '';
        $dbname = 'newwins';

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        return $conn;
    }
}

?>
