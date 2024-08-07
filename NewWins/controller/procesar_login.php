<?php
session_start(); // Inicia o reanuda la sesión actual

// Incluir el archivo que contiene la lógica para gestionar usuarios
include '../model/gestor_usuarios.php';
// Incluir el archivo que maneja la conexión a la base de datos
require_once '../model/conexion.php';

// Configurar el tipo de contenido de la respuesta como JSON
header('Content-Type: application/json');

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["cf-turnstile-response"])) {
            $correo = $_POST["email"]; // Obtener el correo electrónico del administrador
            $contrasena = $_POST["password"]; // Obtener la contraseña del administrador
            $captchaResponse = $_POST['cf-turnstile-response']; // Obtener la respuesta del captcha
            $secretKey = '0x4AAAAAAAgIXj4GJJHN_Va3IBD_6Jyf-vM'; // Clave secreta del captcha (debe ser reemplazada por la clave secreta real)

            // Verificación del captcha utilizando la API de Turnstile de Cloudflare
            $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
            $data = [
                'secret' => $secretKey,
                'response' => $captchaResponse,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];

            $options = [
                'http' => [
                    'method'  => 'POST',
                    'header'  => "Content-Type: application/json\r\n",
                    'content' => json_encode($data)
                ]
            ];

            $context  = stream_context_create($options); // Crear el contexto de la solicitud HTTP
            $result = file_get_contents($url, false, $context); // Enviar la solicitud y obtener la respuesta
            $responseKeys = json_decode($result, true); // Decodificar la respuesta JSON

            if ($responseKeys["success"]) {
                if (!isset($_SESSION['intentos_fallidos'])) {
                    $_SESSION['intentos_fallidos'] = 0; // Contador de intentos fallidos
                    $_SESSION['ultimo_intento'] = time(); // Hora del último intento
                }

                $intentosFallidos = $_SESSION['intentos_fallidos'];
                $ultimoIntento = $_SESSION['ultimo_intento'];
                $ahora = time();

                if (($ahora - $ultimoIntento) < 20 && $intentosFallidos >= 3) {
                    echo json_encode(array('success' => false, 'message' => 'Demasiados intentos fallidos. Intenta de nuevo más tarde.'));
                    exit(); // Terminar la ejecución del script
                }

                $conexion = ConexionBD::obtenerConexion();
                $gestorUsuarios = new GestorUsuarios($conexion);
                $resultado = $gestorUsuarios->iniciarSesion($correo, $contrasena);

                if ($resultado['success']) {
                    $_SESSION['correo'] = $correo;
                    $_SESSION['intentos_fallidos'] = 0; // Reiniciar contador de intentos fallidos
                    echo json_encode(array('success' => true)); // Responder con éxito
                    exit();
                } else {
                    $_SESSION['intentos_fallidos']++;
                    $_SESSION['ultimo_intento'] = time();
                    echo json_encode(array('success' => false, 'message' => $resultado['message']));
                    exit();
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error en la verificación del captcha. Por favor, intenta nuevamente.'));
                exit();
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'No se recibieron todos los campos requeridos.'));
            exit();
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Método de solicitud no permitido.'));
        exit();
    }
} catch (Exception $e) {
    echo json_encode(array('success' => false, 'message' => 'Ocurrió un error en el servidor: ' . $e->getMessage()));
    exit();
}
?>
