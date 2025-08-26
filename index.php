<?php
session_start();
require_once 'includes/conexion.php';

// Traer recetas para el carrusel
try {
    $stmt = $conn->query("SELECT * FROM recetas ORDER BY fecha_creacion DESC LIMIT 5");
    $recetas_carrusel = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener recetas: " . $e->getMessage();
    $recetas_carrusel = [];
}

// Traer últimas recetas para las cards
try {
    $stmt = $conn->query("SELECT * FROM recetas ORDER BY fecha_creacion DESC LIMIT 6");
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

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="Css/styles.css">

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
  
  <style>
    .swiper {
      width: 100%;
      height: 80vh;
    }
    .swiper-slide {
      display: flex;
      align-items: center;
      justify-content: center;
      background: #fff;
      padding: 20px;
    }
    .swiper-slide img {
      max-height: 400px;
      object-fit: cover;
      border-radius: 15px;
    }
  </style>
</head>
<body>

<!-- 🌟 Navbar -->
<header class="navbar">
  <div class="container">
    <h1 class="logo">Mi Recetario</h1>
    <nav>
      <ul>
        <li><a href="#hero">Inicio</a></li>
        <li><a href="#recetas">Recetas</a></li>
        <li><a href="#about">Nosotros</a></li>
      </ul>
    </nav>
  </div>
</header>

<!-- 🌟 Carrusel Dinámico -->
<div class="swiper mySwiper">
  <div class="swiper-wrapper">
    <?php foreach ($recetas_carrusel as $receta): ?>
      <div class="swiper-slide">
        <div class="container-fluid">
          <div class="row align-items-center">
            <!-- Imagen -->
            <div class="col-md-6 text-center">
              <img src="imagenes/<?= htmlspecialchars($receta['imagen']) ?>" 
                   alt="<?= htmlspecialchars($receta['titulo']) ?>" 
                   class="img-fluid">
            </div>
            <!-- Texto -->
            <div class="col-md-6 text-center">
              <h2><?= htmlspecialchars($receta['titulo']) ?></h2>
              <p><?= htmlspecialchars(substr($receta['descripcion'], 0, 120)) ?>...</p>
              <a href="detalle.php?id=<?= $receta['id'] ?>" class="btn btn-primary btn-lg">Ver más</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Controles -->
  <div class="swiper-pagination"></div>
  <div class="swiper-button-next"></div>
  <div class="swiper-button-prev"></div>
</div>

<!-- 🌟 Hero -->
<section id="hero" class="hero">
  <div class="hero__content">
    <h1>Descubre el Arte de la Cocina 🍳</h1>
    <p>Explora, comparte y crea platillos inolvidables. Inspírate y lleva tus habilidades al siguiente nivel.</p>
    <a href="#recetas" class="btn btn-primary">Ver recetas</a>
  </div>
</section>

<!-- 🌟 Últimas Recetas -->
<section id="recetas" class="recetas-section">
  <h2>Últimas Recetas</h2>
  <div class="recetas-container">
    <?php foreach ($recetas as $receta): ?>
      <div class="receta-card">
        <img src="imagenes/<?php echo $receta['imagen']; ?>" alt="<?php echo $receta['titulo']; ?>">
        <h3><?= htmlspecialchars($receta['titulo']) ?></h3>
        <p>⏱️ Tiempo: <?= htmlspecialchars($receta['tiempo'] ?? 'N/A') ?></p>
        <p>🍽️ Porciones: <?= htmlspecialchars($receta['porciones'] ?? 'N/A') ?></p>
        <a href="detalle.php?id=<?php echo $receta['id']; ?>" class="btn">Ver más</a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- 🌟 Nosotros -->
<section id="about" class="about">
  <h2>Sobre Nosotros</h2>
  <p>Somos una comunidad de amantes de la cocina que comparte recetas caseras fáciles y deliciosas.</p>
</section>

<!-- 🌟 Footer -->
<footer class="site-footer">
  <p>© <?= date('Y') ?> Mi Recetario — Todos los derechos reservados</p>
</footer>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
  var swiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
