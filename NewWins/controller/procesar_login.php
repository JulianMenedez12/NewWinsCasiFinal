<?php
session_start(); // Inicia o reanuda la sesión actual

// Incluir el archivo que contiene la lógica para gestionar usuarios
include '../model/gestor_usuarios.php';
// Incluir el archivo que maneja la conexión a la base de datos
require_once '../model/conexion.php';

// Configurar el tipo de contenido de la respuesta como JSON
header('Content-Type: application/json');

try {
    /**
     * Maneja la solicitud de inicio de sesión del administrador.
     *
     * @param string $correo Correo electrónico del administrador.
     * @param string $contrasena Contraseña del administrador.
     * @param string $captchaResponse Respuesta del captcha.
     * @param string $secretKey Clave secreta para la verificación del captcha.
     * @param int $intentosFallidos Número de intentos fallidos de inicio de sesión.
     * @param int $ultimoIntento Hora del último intento fallido.
     * @param int $ahora Hora actual.
     * @return void
     */
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
                // Inicializar los intentos fallidos y la hora del último intento si no están en la sesión
                if (!isset($_SESSION['intentos_fallidos'])) {
                    $_SESSION['intentos_fallidos'] = 0; // Contador de intentos fallidos
                    $_SESSION['ultimo_intento'] = time(); // Hora del último intento
                }

                $intentosFallidos = $_SESSION['intentos_fallidos'];
                $ultimoIntento = $_SESSION['ultimo_intento'];
                $ahora = time();

                // Comprobar si el bloqueo de 20 segundos está activo (10 segundos de bloqueo con un mínimo de 3 intentos fallidos)
                if (($ahora - $ultimoIntento) < 20 && $intentosFallidos >= 3) {
                    echo json_encode(array('success' => false, 'message' => 'Demasiados intentos fallidos. Intenta de nuevo más tarde.'));
                    exit(); // Terminar la ejecución del script
                }

                // Obtener la conexión a la base de datos
                $conexion = ConexionBD::obtenerConexion();
                // Crear una instancia del gestor de usuarios con la conexión
                $gestorUsuarios = new GestorUsuarios($conexion);
                // Intentar iniciar sesión del administrador con las credenciales proporcionadas
                $exito = $gestorUsuarios->iniciarSesion($correo, $contrasena);

                if ($exito) {
                    // Si el inicio de sesión es exitoso, guardar el correo en la sesión y reiniciar el contador de intentos fallidos
                    $_SESSION['correo'] = $correo;
                    $_SESSION['intentos_fallidos'] = 0; // Reiniciar contador de intentos fallidos
                    echo json_encode(array('success' => true)); // Responder con éxito
                    exit();
                } else {
                    // Si el inicio de sesión falla, incrementar el contador de intentos fallidos y actualizar la hora del último intento
                    $_SESSION['intentos_fallidos']++;
                    $_SESSION['ultimo_intento'] = time();
                    echo json_encode(array('success' => false, 'message' => 'Credenciales incorrectas. Por favor, verifica tu correo y contraseña.'));
                    exit();
                }
            } else {
                // Si la verificación del captcha falla, responder con un mensaje de error
                echo json_encode(array('success' => false, 'message' => 'Error en la verificación del captcha. Por favor, intenta nuevamente.'));
                exit();
            }
        } else {
            // Si no se recibieron todos los campos requeridos, responder con un mensaje de error
            echo json_encode(array('success' => false, 'message' => 'No se recibieron todos los campos requeridos.'));
            exit();
        }
    } else {
        // Si el método de solicitud no es POST, responder con un mensaje de error
        echo json_encode(array('success' => false, 'message' => 'Método de solicitud no permitido.'));
        exit();
    }
} catch (Exception $e) {
    // Manejar excepciones y responder con un mensaje de error
    echo json_encode(array('success' => false, 'message' => 'Ocurrió un error en el servidor: ' . $e->getMessage()));
    exit();
}
?>
