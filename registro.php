<?php
session_start();
require_once 'includes/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if (!empty($nombre) && !empty($email) && !empty($contrasena)) {
        // Hashear la contraseña por seguridad
        $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

        try {
            // Prepara la consulta para evitar inyecciones SQL
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, email, contrasena) VALUES (?, ?, ?)");
            $stmt->execute([$nombre, $email, $contrasena_hash]);

            $mensaje = "¡Registro exitoso! Ahora puedes iniciar sesión.";
        } catch (PDOException $e) {
            $mensaje = "Error al registrar: " . $e->getMessage();
        }
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <header>
        <h1>Registrarse</h1>
    </header>

    <main>
        <p><?php echo $mensaje; ?></p>
        <form action="registro.php" method="POST">
            <div>
                <label for="nombre">Nombre de Usuario:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia Sesión aquí</a></p>
    </main>
</body>
</html>