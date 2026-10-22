<?php
// includes/servicios.php

// Consultar Servicios desde MySQL
$servicios = $pdo->query("SELECT * FROM servicios ORDER BY orden ASC")->fetchAll();
?>

<!-- Sección Nuestros Servicios -->
<section id="servicios" class="services">
    <div class="container">
        <h2 class="section-title">Nuestros Servicios</h2>
        <div class="cards-grid">
            <?php foreach ($servicios as $servicio): ?>
                <div class="card">
                    <i class="fa-solid <?= htmlspecialchars($servicio['icono']) ?> card-icon"></i>
                    <h3><?= htmlspecialchars($servicio['titulo']) ?></h3>
                    <p><?= htmlspecialchars($servicio['descripcion']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>