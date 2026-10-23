<?php
// includes/servicios.php

// Consultar Servicios desde MySQL
$servicios = $pdo->query("SELECT * FROM servicios ORDER BY orden ASC")->fetchAll();

// Mapeo de imágenes locales para cada servicio
$imagenes_servicios = [
    1 => 'img/desarrollo.png',
    2 => 'img/aplicaciones.png',
    3 => 'img/nube.png'
];
?>

<style>
    /* Alineación centrada de todo el contenido de las tarjetas */
    .service-card {
        text-align: center;
        padding: 3rem 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    /* Tamaño ampliado del contenedor de imágenes */
    .service-img-container {
        width: 100px;
        height: 100px;
        margin: 0 auto 1.8rem auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .service-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        filter: drop-shadow(0px 4px 10px rgba(0, 0, 0, 0.3));
    }

    .service-card h3 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-main);
    }

    .service-card p {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        max-width: 90%;
        margin: 0 auto;
    }
</style>

<!-- Sección Nuestros Servicios -->
<section id="servicios" class="services">
    <div class="container">
        <h2 class="section-title">Nuestros Servicios</h2>
        <div class="cards-grid">
            <?php foreach ($servicios as $index => $servicio): ?>
                <?php 
                    // Selecciona la imagen correspondiente según la posición (1, 2 o 3)
                    $img_path = $imagenes_servicios[$index + 1] ?? 'img/desarrollo.png';
                ?>
                <div class="card service-card">
                    <div class="service-img-container">
                        <img src="<?= htmlspecialchars($img_path) ?>" alt="<?= htmlspecialchars($servicio['titulo']) ?>" class="service-img">
                    </div>
                    <h3><?= htmlspecialchars($servicio['titulo']) ?></h3>
                    <p><?= htmlspecialchars($servicio['descripcion']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>