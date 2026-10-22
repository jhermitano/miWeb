<?php
// Consultar Proyectos desde MySQL
$proyectos = $pdo->query("SELECT * FROM proyectos ORDER BY orden ASC")->fetchAll();
?>

<style>
    /* Estilos de Tarjetas de Proyectos con Imagen */
    .project-card-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 1.2rem;
        border: 1px solid var(--border-color);
    }

    /* Estilos de la Sección Proceso de Trabajo */
    .process-section {
        padding: 4rem 0 2rem 0;
    }

    .process-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .step-box {
        flex: 1;
        min-width: 140px;
        padding: 1rem 0.8rem;
        border-radius: 12px;
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }

    .step-box:hover {
        transform: translateY(-3px);
    }

    /* Colores exactos de los bloques de proceso */
    .step-1 {
        background: linear-gradient(135deg, #00d2d3, #00a8ff);
        color: #070d19;
    }

    .step-2 {
        background: linear-gradient(135deg, #8b5cf6, #6c5ce7);
    }

    .step-3 {
        background: linear-gradient(135deg, #1d72f3, #00d2ff);
    }

    .step-4 {
        background: linear-gradient(135deg, #8b5cf6, #6c5ce7);
    }

    .step-5 {
        background: linear-gradient(135deg, #1d72f3, #0088ff);
    }

    /* Flecha entre pasos */
    .step-arrow {
        color: var(--text-muted);
        font-size: 1.2rem;
    }

    @media (max-width: 900px) {
        .process-steps {
            flex-direction: column;
            gap: 1rem;
        }
        .step-box {
            width: 100%;
        }
        .step-arrow {
            transform: rotate(90deg);
        }
    }
</style>

<!-- Sección Proyectos Recientes -->
<section id="proyectos" class="projects">
    <div class="container">
        <h2 class="section-title">Nuestros Proyectos Recientes</h2>
        <div class="cards-grid">
            <?php foreach ($proyectos as $proyecto): ?>
                <div class="card">
                    <?php if (!empty($proyecto['imagen_url'])): ?>
                        <img src="<?= htmlspecialchars($proyecto['imagen_url']) ?>" alt="<?= htmlspecialchars($proyecto['titulo']) ?>" class="project-card-img">
                    <?php endif; ?>
                    <p style="color: var(--cyan-accent); font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">
                        <?= htmlspecialchars($proyecto['categoria']) ?>
                    </p>
                    <h3 style="margin-top: 0.4rem;"><?= htmlspecialchars($proyecto['titulo']) ?></h3>
                    <p><?= htmlspecialchars($proyecto['descripcion']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Sección Nuestro Proceso de Trabajo -->
<section class="process-section">
    <div class="container">
        <h2 class="section-title">Nuestro Proceso de Trabajo</h2>
        <div class="process-steps">
            <div class="step-box step-1">1. Análisis</div>
            <i class="fa-solid fa-arrow-right step-arrow"></i>

            <div class="step-box step-2">2. Diseño</div>
            <i class="fa-solid fa-arrow-right step-arrow"></i>

            <div class="step-box step-3">3. Desarrollo</div>
            <i class="fa-solid fa-arrow-right step-arrow"></i>

            <div class="step-box step-4">4. Pruebas</div>
            <i class="fa-solid fa-arrow-right step-arrow"></i>

            <div class="step-box step-5">5. Lanzamiento</div>
        </div>
    </div>
</section>