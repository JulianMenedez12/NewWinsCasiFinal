<?php
session_start();
require_once '../model/conexion.php';
require_once '../model/gestor_usuarios.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificación del captcha con cURL
    $captchaResponse = $_POST['cf-turnstile-response'];
    $secretKey = '0x4AAAAAAAgIXj4GJJHN_Va3IBD_6Jyf-vM';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://challenges.cloudflare.com/turnstile/v0/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret' => $secretKey,
        'response' => $captchaResponse,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseKeys = json_decode($response, true);

    if ($responseKeys["success"]) {
        if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["nombre_user"]) && isset($_POST["correo"]) && isset($_POST["contrasena"]) && isset($_POST["pais"])) {
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $nombre_user = $_POST["nombre_user"];
            $correo = $_POST["correo"];
            $contrasena = $_POST["contrasena"];
            $pais = $_POST["pais"];

            // Validar la contraseña
            if (strlen($contrasena) < 8 || !preg_match("/[a-z]/", $contrasena) || !preg_match("/[A-Z]/", $contrasena) || !preg_match("/\d/", $contrasena) || !preg_match("/[@$!%*?&]/", $contrasena)) {
                $response = array("status" => "error", "message" => "La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un símbolo.");
                echo json_encode($response);
                exit;
            }

            $conexion = ConexionBD::obtenerConexion();
            $gestorUsuarios = new GestorUsuarios($conexion);
            $resultado = $gestorUsuarios->registrarUsuario($nombre, $apellido, $nombre_user, $correo, $contrasena, $pais);

            if ($resultado) {
                $response = array("status" => "success", "message" => "Registro exitoso.");
            } else {
                $response = array("status" => "error", "message" => "Error en el registro.");
            }
            echo json_encode($response);
        } else {
            $response = array("status" => "error", "message" => "Todos los campos son obligatorios.");
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "error", "message" => "Error en la verificación del captcha. Por favor, intenta nuevamente.");
        echo json_encode($response);
    }
} else {
    $response = array("status" => "error", "message" => "Solicitud inválida.");
    echo json_encode($response);
}
?>
