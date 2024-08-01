<?php
session_start();
include '../model/gestor_usuarios.php';
require_once '../model/conexion.php';
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["cf-turnstile-response"])) {
            $correo = $_POST["email"];
            $contrasena = $_POST["password"];
            $captchaResponse = $_POST['cf-turnstile-response'];
            $secretKey = '0x4AAAAAAAgIXj4GJJHN_Va3IBD_6Jyf-vM'; // Reemplaza con tu clave secreta

            // Verificación del captcha
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

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $responseKeys = json_decode($result, true);

            if ($responseKeys["success"]) {
                // Inicializar los intentos fallidos y la hora del último intento si no están en la sesión
                if (!isset($_SESSION['intentos_fallidos'])) {
                    $_SESSION['intentos_fallidos'] = 0;
                    $_SESSION['ultimo_intento'] = time();
                }

                $intentosFallidos = $_SESSION['intentos_fallidos'];
                $ultimoIntento = $_SESSION['ultimo_intento'];
                $ahora = time();

                // Comprobar si el bloqueo de 10 segundos está activo
                if (($ahora - $ultimoIntento) < 20 && $intentosFallidos >= 3) {
                    echo json_encode(array('success' => false, 'message' => 'Demasiados intentos fallidos. Intenta de nuevo más tarde.'));
                    exit();
                }

                $conexion = ConexionBD::obtenerConexion();
                $gestorUsuarios = new GestorUsuarios($conexion);
                $exito = $gestorUsuarios->iniciarSesion($correo, $contrasena);

                if ($exito) {
                    $_SESSION['correo'] = $correo;
                    $_SESSION['intentos_fallidos'] = 0; // Reiniciar contador de intentos fallidos
                    echo json_encode(array('success' => true));
                    exit();
                } else {
                    $_SESSION['intentos_fallidos']++;
                    $_SESSION['ultimo_intento'] = time();
                    echo json_encode(array('success' => false, 'message' => 'Credenciales incorrectas. Por favor, verifica tu correo y contraseña.'));
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
