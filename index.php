<?php
session_start();
require_once 'includes/conexion.php'; // Incluye el archivo de conexión

// Consulta para obtener las recetas de la base de datos
try {
    $stmt = $conn->query("SELECT * FROM recetas ORDER BY fecha_creacion DESC");
    $recetas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener recetas: " . $e->getMessage();
    $recetas = []; // En caso de error, inicializa $recetas como un array vacío
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas de Cocina</title>
</head>
<body>
    <header>
        <h1>Bienvenido a tu Recetario</h1>
        <nav>
            <ul>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li><a href="agregar_receta.php">Subir Receta</a></li>
                    <li><a href="perfil.php">Mi Perfil</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="login.php">Iniciar Sesión</a></li>
                    <li><a href="registro.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Últimas Recetas</h2>
        <?php if (count($recetas) > 0): ?>
            <?php foreach ($recetas as $receta): ?>
                <article>
                    <h3><?php echo htmlspecialchars($receta['titulo']); ?></h3>
                    <p>Tiempo de preparación: <?php echo htmlspecialchars($receta['tiempo_preparacion']); ?> minutos</p>
                    <p><?php echo htmlspecialchars(substr($receta['descripcion'], 0, 150)); ?>...</p>
                    <a href="ver_receta.php?id=<?php echo $receta['id_receta']; ?>">Ver receta completa</a>
                </article>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aún no hay recetas. Sé el primero en subir una.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>Derechos de autor &copy; 2024 Mi Recetario</p>
    </footer>
</body>
</html>