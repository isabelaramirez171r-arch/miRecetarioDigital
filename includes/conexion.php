<?php

// Definir los parámetros de la conexión
$host = 'localhost';
$db_name = 'recetas_db';
$username = 'root';
$password = ''; // Deja la contraseña vacía si usas XAMPP/WAMP

try {
    // Crear una nueva instancia de PDO
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);

    // Establecer el modo de error de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Opcional: para fines de depuración
    // echo "Conexión exitosa";

} catch (PDOException $e) {
    // Si la conexión falla, se captura la excepción
    // y se muestra un mensaje de error
    die("Error de conexión: " . $e->getMessage());
}
?>