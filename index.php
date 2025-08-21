<?php
session_start();
require_once 'includes/conexion.php';

try {
    $stmt = $conn->query("SELECT * FROM recetas ORDER BY fecha_creacion DESC LIMIT 4");
    $recetas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener recetas: " . $e->getMessage();
    $recetas = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recetas de Cocina</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #e8f5e9; }
        header { background-color: #4CAF50; color: white; padding: 1em 2em; text-align: center; }
        nav ul { list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #388E3C; }
        nav li { float: left; }
        nav li a { display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; }
        nav li a:hover { background-color: #4CAF50; }
        .container { padding: 2em; text-align: center; }
        .welcome-section { background-color: white; padding: 2em; margin-bottom: 2em; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .welcome-section h2 { color: #388E3C; }
        .recipe-grid { display: flex; justify-content: center; flex-wrap: wrap; gap: 20px; }
        .recipe-card { background-color: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); padding: 1em; width: 300px; text-align: left; }
        .recipe-card h3 { color: #4CAF50; }
        footer { background-color: #333; color: white; text-align: center; padding: 1em 0; position: relative; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <header>
        <h1>Mi Recetario</h1>
    </header>

    <nav>
        <ul>
            <?php if (isset($_SESSION['usuario'])): ?>
                <?php if ($_SESSION['usuario']['rol'] === 'administrador'): ?>
                    <li><a href="admin/dashboard.php">Panel de Administración</a></li>
                <?php endif; ?>
                <li><a href="agregar_receta.php">Subir Receta</a></li>
                <li><a href="perfil.php">Mi Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="login.php">Iniciar Sesión</a></li>
                <li><a href="registro.php">Registrarse</a></li>
            <?php endif; ?>
            <li><a href="#about">Nosotros</a></li>
            <li><a href="#contact">Contáctenos</a></li>
            <li><a href="#services">Servicios</a></li>
        </ul>
    </nav>

    <div class="container">
        <section class="welcome-section">
            <h2>Descubre el Arte de la Cocina</h2>
            <p>¡Bienvenido a nuestro recetario! Aquí encontrarás una comunidad apasionada por la gastronomía. Explora, comparte y crea platillos inolvidables, desde recetas tradicionales hasta creaciones innovadoras. ¡Inspírate y lleva tus habilidades culinarias al siguiente nivel!</p>
        </section>

        <h2>Últimas Recetas</h2>
        <div class="recipe-grid">
            <?php if (count($recetas) > 0): ?>
                <?php foreach ($recetas as $receta): ?>
                    <div class="recipe-card">
                        <h3><?php echo htmlspecialchars($receta['titulo']); ?></h3>
                        <p>Tiempo: <?php echo htmlspecialchars($receta['tiempo_preparacion']); ?> min</p>
                        <p>Porciones: <?php echo htmlspecialchars($receta['porciones']); ?></p>
                        <a href="ver_receta.php?id=<?php echo $receta['id_receta']; ?>">Ver más</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aún no hay recetas. Sé el primero en subir una.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="container" style="background-color: white; border-top: 1px solid #ddd; margin-top: 2em; padding-top: 2em;">
        <section id="about">
            <h2>Sobre Nosotros</h2>
            <p>Somos una plataforma dedicada a conectar a amantes de la cocina. Nuestra misión es ser el lugar de referencia para encontrar, compartir y disfrutar de las mejores recetas caseras de la comunidad.</p>
        </section>
        <section id="contact">
            <h2>Contáctenos</h2>
            <p>¿Tienes alguna pregunta, sugerencia o quieres colaborar? No dudes en contactarnos a través de nuestro correo: <a href="mailto:info@mirecetario.com">info@mirecetario.com</a>.</p>
        </section>
        <section id="services">
            <h2>Nuestros Servicios</h2>
            <ul>
                <li>Acceso a un vasto catálogo de recetas.</li>
                <li>Oportunidad de subir y compartir tus propias creaciones.</li>
                <li>Sistema de calificación y comentarios.</li>
                <li>Búsqueda avanzada por ingredientes, tiempo y categoría.</li>
            </ul>
        </section>
    </div>

    <footer>
        <p>Derechos de autor &copy; 2024 Mi Recetario</p>
    </footer>
</body>
</html>