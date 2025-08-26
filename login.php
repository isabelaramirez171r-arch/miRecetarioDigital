<?php
session_start();
require_once 'includes/conexion.php';

$mensaje = "";

if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if (!empty($email) && !empty($contrasena)) {
        try {
            $stmt = $conn->prepare("SELECT id_usuario, nombre_usuario, contrasena, rol FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['usuario'] = [
                    'id' => $usuario['id_usuario'],
                    'nombre' => $usuario['nombre_usuario'],
                    'rol' => $usuario['rol'] // ¡Aquí guardamos el rol!
                ];

                header("Location: index.php");
                exit();
            } else {
                $mensaje = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
            }
        } catch (PDOException $e) {
            $mensaje = "Error al iniciar sesión: " . $e->getMessage();
        }
    } else {
        $mensaje = "Por favor, ingresa tu correo y contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <p><?php echo $mensaje; ?></p>
    <form action="login.php" method="POST">
        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
        </div>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
</body>
</html>