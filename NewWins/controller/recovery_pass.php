<html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
<?php
// Incluir los archivos de PHPMailer
require '../libs/PHPMailer/src/PHPMailer.php';
require '../libs/PHPMailer/src/SMTP.php';
require '../libs/PHPMailer/src/Exception.php';
require_once '../model/conexion.php';

// Usar las clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Crear conexión
$conn = ConexionBD::obtenerConexion();

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Verificar que el correo exista en la base de datos
    $sql = "SELECT id FROM usuarios_registrados WHERE correo_electronico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
        
        // Generar un token único
        $token = bin2hex(random_bytes(50));
        $expire_date = date("Y-m-d H:i:s", strtotime('+1 hour'));
        
        // Guardar el token en la base de datos
        $sql = "INSERT INTO password_resets (user_id, token, expire_date) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE token = VALUES(token), expire_date = VALUES(expire_date)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $token, $expire_date);
        $stmt->execute();
        
        // Enviar el correo de recuperación
        $mail = new PHPMailer(true);
        
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.mailersend.net';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'MS_YYa6TN@trial-0p7kx4xn637g9yjr.mlsender.net';
            $mail->Password   = 'iMSpvncMOY4Q4K3X';
            $mail->SMTPSecure = 'tls'; // Habilitar cifrado TLS
            $mail->Port       = 587;
            
            // Remitente
            $mail->setFrom('MS_YYa6TN@trial-0p7kx4xn637g9yjr.mlsender.net', 'Newwins');
            
            // Destinatario
            $mail->addAddress($email);
            
            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Restablecimiento de contraseña';
            $mail->Body    = "Haz clic en el siguiente enlace para restablecer tu contrasena de NewWins: <a href='http://localhost/newwins/NewWins/view/reset_pass.php?token=$token'>Restablecer contraseña</a>";
            $mail->AltBody = "Haz clic en el siguiente enlace para restablecer tu contrasena de NewWins: http://localhost/newwins/NewWins/view/reset_pass.php?token=$token";
            
            $mail->send();
            echo '<script>
                Swal.fire("Éxito", "El correo de recuperación ha sido enviado", "success")
                .then(() => { window.location.href = "../view/index.php"; });
            </script>';
        } catch (Exception $e) {
            echo '<script>Swal.fire("Error", "El mensaje no pudo ser enviado. Error: ' . $mail->ErrorInfo . '", "error");</script>';
        }
    } else {
        echo '<script>Swal.fire("Error", "El correo no existe en nuestros registros", "error");</script>';
    }
}
?>
