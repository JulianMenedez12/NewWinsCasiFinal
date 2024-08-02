<html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
<?php
// Incluir los archivos necesarios
require_once '../model/conexion.php';
require '../libs/PHPMailer/src/PHPMailer.php';
require '../libs/PHPMailer/src/SMTP.php';
require '../libs/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Crear conexión
$conn = ConexionBD::obtenerConexion();

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$token = $_GET['token'] ?? '';
$show_form = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo '<script>Swal.fire("Error", "Las contraseñas no coinciden", "error").then(() => { window.location.href = "reset_password.php?token=' . $token . '"; });</script>';
        exit();
    }

    // Verificar que el token exista y no haya expirado
    $sql = "SELECT user_id FROM password_resets WHERE token = ? AND expire_date > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // Actualizar la contraseña del usuario
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $sql = "UPDATE usuarios_registrados SET contrasena = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $user_id);
        $stmt->execute();

        // Eliminar el token después de usarlo
        $sql = "DELETE FROM password_resets WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo '<script>Swal.fire("Éxito", "Tu contraseña ha sido restablecida", "success").then(() => { window.location.href = "index.php"; });</script>';
    } else {
        echo '<script>Swal.fire("Error", "El token es inválido o ha expirado", "error").then(() => { window.location.href = "recuperar_pass.php"; });</script>';
    }
} else {
    // Verificar que el token exista y no haya expirado
    $sql = "SELECT user_id FROM password_resets WHERE token = ? AND expire_date > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $show_form = true;
    } else {
        echo '<script>Swal.fire("Error", "El token es inválido o ha expirado", "error").then(() => { window.location.href = "recuperar_pass.php"; });</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <section class="bg-light py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-6 mb-4 mb-md-0">
                    <div class="card border border-light-subtle rounded-3 shadow-sm">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="text-center mb-3">
                                <a href="#!">
                                    <img src="../img/logo.png" alt="img-fluid" width="175" height="157">
                                </a>
                            </div>
                            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Restablecer Contraseña</h2>
                            <?php if ($show_form) : ?>
                                <form id="ResetPasswordForm" action="reset_pass.php" method="POST" onsubmit="return validatePassword()">
                                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Nueva contraseña" required
                                            pattern="(?=.*\d)(?=.*[!@#$%^&*]).{8,}" title="La contraseña debe tener al menos 8 caracteres, incluir un número y un símbolo">
                                            <label for="new_password" class="form-label">Nueva Contraseña</label>
                                        </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirmar nueva contraseña" required>
                                        <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                    </div>
                                    <div class="d-grid my-3">
                                        <button class="btn btn-primary btn-lg" type="submit">Restablecer</button>
                                    </div>
</form>

<script>
    function validatePassword() {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        // Validar que las contraseñas coincidan
        if (newPassword !== confirmPassword) {
            Swal.fire("Error", "Las contraseñas no coinciden", "error");
            return false;
        }

        return true;
    }
</script>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
