<?php
session_start();
require_once '../model/conexion.php';
require_once '../model/gestor_usuarios.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $conexion = ConexionBD::obtenerConexion();

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
        if (($ahora - $ultimoIntento) < 30 && $intentosFallidos >= 3) {
            $response = array("success" => false, "message" => "Demasiados intentos fallidos. Intenta de nuevo más tarde.");
            echo json_encode($response);
            exit();
        }

        // Verificar credenciales
        $gestorUsuarios = new GestorUsuarios($conexion);
        $exito = $gestorUsuarios->iniciarSesionAdmin($correo, $contrasena);

        if ($exito) {
            $_SESSION['correo'] = $correo;
            $_SESSION['intentos_fallidos'] = 0; // Reiniciar contador de intentos fallidos
            $response = array("success" => true);
        } else {
            $_SESSION['intentos_fallidos']++;
            $_SESSION['ultimo_intento'] = time();
            $response = array("success" => false, "message" => "Credenciales incorrectas. Por favor, verifica tu correo y contraseña.");
        }
        
        echo json_encode($response);
        exit();
    } else {
        $response = array("success" => false, "message" => "Error en la verificación del captcha. Por favor, intenta nuevamente.");
        echo json_encode($response);
        exit();
    }
} else {
    $response = array("success" => false, "message" => "Método de solicitud no permitido.");
    echo json_encode($response);
    exit();
}
?>
