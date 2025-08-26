<?php
// Configuración de la conexión sin especificar la base de datos
$host = 'localhost';
$username = 'root';
$password = ''; // Deja la contraseña vacía si usas XAMPP/WAMP
$db_name = 'recetas_db'; // El nombre que le darás a tu base de datos

// Intenta conectar al servidor MySQL
try {
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para verificar si la base de datos ya existe
    $stmt = $conn->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'");
    if ($stmt->fetchColumn() == 0) {
        // La base de datos no existe, la creamos
        $conn->exec("CREATE DATABASE `$db_name` CHARACTER SET utf8 COLLATE utf8_general_ci;");
        echo "Base de datos '$db_name' creada exitosamente.<br>";
    } else {
        echo "La base de datos '$db_name' ya existe.<br>";
    }

    // Cambia la conexión para usar la base de datos recién creada o ya existente
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Script SQL para crear las tablas
    $sql = "
    CREATE TABLE IF NOT EXISTS usuarios (
        id_usuario INT(11) NOT NULL AUTO_INCREMENT,
        nombre_usuario VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        contrasena VARCHAR(255) NOT NULL,
        rol ENUM('usuario', 'administrador') NOT NULL DEFAULT 'usuario',
        PRIMARY KEY (id_usuario)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE IF NOT EXISTS recetas (
        id_receta INT(11) NOT NULL AUTO_INCREMENT,
        titulo VARCHAR(255) NOT NULL,
        descripcion TEXT,
        ingredientes TEXT NOT NULL,
        pasos TEXT NOT NULL,
        imagen_url VARCHAR(255),
        tiempo_preparacion INT(5),
        id_usuario INT(11) NOT NULL,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id_receta),
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE IF NOT EXISTS comentarios (
        id_comentario INT(11) NOT NULL AUTO_INCREMENT,
        texto_comentario TEXT NOT NULL,
        id_usuario INT(11) NOT NULL,
        id_receta INT(11) NOT NULL,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id_comentario),
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
        FOREIGN KEY (id_receta) REFERENCES recetas(id_receta) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";

    // Ejecuta el script SQL para crear las tablas
    $conn->exec($sql);
    echo "Tablas creadas exitosamente.<br>";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>