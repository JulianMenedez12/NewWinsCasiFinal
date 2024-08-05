<?php
session_start(); // Inicia la sesión o la reanuda si ya existe

require_once '../model/conexion.php'; // Incluye el archivo para la conexión a la base de datos
require_once '../model/gestor_usuarios.php'; // Incluye el archivo para la gestión de usuarios

/**
 * Registra un nuevo usuario después de validar el captcha y los datos del formulario.
 * 
 * @param string $captchaResponse Respuesta del captcha enviada desde el formulario.
 * @param string $nombre Nombre del usuario.
 * @param string $apellido Apellido del usuario.
 * @param string $nombre_user Nombre de usuario.
 * @param string $correo Correo electrónico del usuario.
 * @param string $contrasena Contraseña del usuario.
 * @param string $pais País del usuario.
 * 
 * @return void
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verifica que la solicitud es de tipo POST
    // Verificación del captcha con cURL
    $captchaResponse = $_POST['cf-turnstile-response']; // Obtiene la respuesta del captcha desde el POST
    $secretKey = '0x4AAAAAAAgIXj4GJJHN_Va3IBD_6Jyf-vM'; // Clave secreta del captcha

    $ch = curl_init(); // Inicializa una sesión cURL
    curl_setopt($ch, CURLOPT_URL, "https://challenges.cloudflare.com/turnstile/v0/siteverify"); // Establece la URL para la verificación del captcha
    curl_setopt($ch, CURLOPT_POST, 1); // Establece el método de la solicitud como POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([ // Construye los datos de POST
        'secret' => $secretKey,
        'response' => $captchaResponse,
        'remoteip' => $_SERVER['REMOTE_ADDR'] // Dirección IP del cliente
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Configura cURL para retornar la respuesta como una cadena

    $response = curl_exec($ch); // Ejecuta la solicitud cURL
    curl_close($ch); // Cierra la sesión cURL

    $responseKeys = json_decode($response, true); // Decodifica la respuesta JSON del captcha

    if ($responseKeys["success"]) { // Verifica si la verificación del captcha fue exitosa
        if (isset($_POST["nombre"], $_POST["apellido"], $_POST["nombre_user"], $_POST["correo"], $_POST["contrasena"], $_POST["pais"])) { // Verifica que todos los campos requeridos estén presentes
            $nombre = $_POST["nombre"]; // Nombre del usuario
            $apellido = $_POST["apellido"]; // Apellido del usuario
            $nombre_user = $_POST["nombre_user"]; // Nombre de usuario
            $correo = $_POST["correo"]; // Correo electrónico del usuario
            $contrasena = $_POST["contrasena"]; // Contraseña del usuario
            $pais = $_POST["pais"]; // País del usuario

            // Validar la contraseña
            if (strlen($contrasena) < 8 || !preg_match("/[a-z]/", $contrasena) || !preg_match("/[A-Z]/", $contrasena) || !preg_match("/\d/", $contrasena) || !preg_match("/[@$!%*?&]/", $contrasena)) {
                $response = array("status" => "error", "message" => "La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un símbolo.");
                echo json_encode($response); // Envia la respuesta en formato JSON
                exit;
            }

            $conexion = ConexionBD::obtenerConexion(); // Obtiene la conexión a la base de datos
            $gestorUsuarios = new GestorUsuarios($conexion); // Crea una instancia del gestor de usuarios
            $resultado = $gestorUsuarios->registrarUsuario($nombre, $apellido, $nombre_user, $correo, $contrasena, $pais); // Registra al usuario

            if ($resultado) {
                $response = array("status" => "success", "message" => "Registro exitoso."); // Registro exitoso
            } else {
                $response = array("status" => "error", "message" => "Error en el registro."); // Error en el registro
            }
            echo json_encode($response); // Envia la respuesta en formato JSON
        } else {
            $response = array("status" => "error", "message" => "Todos los campos son obligatorios."); // Falta algún campo requerido
            echo json_encode($response); // Envia la respuesta en formato JSON
        }
    } else {
        $response = array("status" => "error", "message" => "Error en la verificación del captcha. Por favor, intenta nuevamente."); // Error en la verificación del captcha
        echo json_encode($response); // Envia la respuesta en formato JSON
    }
} else {
    $response = array("status" => "error", "message" => "Solicitud inválida."); // Solicitud no válida
    echo json_encode($response); // Envia la respuesta en formato JSON
}
?>
