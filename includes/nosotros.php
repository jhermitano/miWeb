<?php
// includes/nosotros.php
?>

<style>
    /* Ajuste de cuadrícula a 4 columnas para que quepan todos los elementos en una fila */
    .four-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 1.8rem;
    }

    .why-us-card {
        background: transparent; /* Se eliminó el fondo de la tarjeta para coincidir con la imagen sin bordes/tarjetas pesadas */
        border: none; /* Sin bordes para un aspecto más limpio de sección en nosotros */
        text-align: center;
        padding: 1.5rem 1rem;
        transition: transform 0.3s ease;
    }

    .why-us-card:hover {
        transform: translateY(-5px);
    }

    .why-us-icon {
        font-size: 3rem;
        background: linear-gradient(135deg, var(--cyan-accent), var(--purple-accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
        display: inline-block;
        filter: drop-shadow(0px 4px 8px rgba(139, 92, 246, 0.2));
    }

    .why-us-card h3 {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--text-main);
    }

    .why-us-card p {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .four-cards-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }
</style>

<!-- Sección Por qué elegirnos -->
<section id="nosotros" class="why-us">
    <div class="container">
        <h2 class="section-title">Por qué elegirnos</h2>
        <div class="four-cards-grid">
            
            <!-- Columna 1: Metodologías Ágiles -->
            <div class="why-us-card">
                <i class="fa-solid fa-sync why-us-icon"></i>
                <h3>Metodologías Ágiles</h3>
                <p>Metodologías enfocadas en la adaptabilidad y el aporte constante de valor de manera iterativa.</p>
            </div>

            <!-- Columna 2: Equipo de Expertos -->
            <div class="why-us-card">
                <i class="fa-solid fa-users why-us-icon"></i>
                <h3>Equipo de Expertos</h3>
                <p>Profesionales capacitados en el desarrollo de software y sistemas de última generación.</p>
            </div>

            <!-- Columna 3: Seguridad y Escalabilidad -->
            <div class="why-us-card">
                <i class="fa-solid fa-shield-halved why-us-icon"></i>
                <h3>Seguridad y Escalabilidad</h3>
                <p>Desarrollo con arquitectura robusta que garantiza máxima seguridad y flexibilidad de crecimiento.</p>
            </div>

            <!-- Columna 4: Soporte Continuo -->
            <div class="why-us-card">
                <i class="fa-solid fa-headset why-us-icon"></i>
                <h3>Soporte Continuo</h3>
                <p>Soporte continuo con comunicación activa para garantizar la estabilidad y optimización de tu plataforma.</p>
            </div>

        </div>
    </div>
</section>