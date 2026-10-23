<?php
// includes/inicio.php
?>

<style>
    .hero {
        position: relative;
        padding: 9rem 0 5rem 0;
        background-color: var(--bg-color);
        min-height: 560px;
        display: flex;
        align-items: center;
    }

    /* Contenedor delimitado por las líneas rosadas con la imagen de fondo adentro */
    .hero-container-bg {
        position: relative;
        width: 100%;
        border-radius: 20px;
        overflow: hidden;
        padding: 4rem 3rem;
        
        /* Imagen confinada dentro de los márgenes del contenedor central */
        background-image: 
            linear-gradient(to right, #070d19 25%, rgba(7, 13, 25, 0.6) 55%, transparent 85%),
            url('img/fondo.jpg');
            
        background-position: center right;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .hero-content {
        max-width: 580px;
        position: relative;
        z-index: 2;
    }

    .hero-content h1 {
        font-size: 3.4rem;
        line-height: 1.12;
        font-weight: 800;
        margin-bottom: 1.5rem;
        letter-spacing: -0.5px;
        color: #ffffff;
    }

    .hero-content p {
        color: var(--text-muted);
        font-size: 1.05rem;
        margin-bottom: 2.2rem;
        line-height: 1.6;
    }

    .hero-buttons {
        display: flex;
        gap: 1.2rem;
    }

    @media (max-width: 900px) {
        .hero-container-bg {
            padding: 2.5rem 1.5rem;
            background-position: center;
        }
        .hero-content h1 {
            font-size: 2.4rem;
        }
    }
</style>

<!-- Hero Section -->
<section id="inicio" class="hero">
    <div class="container">
        <!-- Caja interna que contiene la imagen recortada entre ambas líneas -->
        <div class="hero-container-bg">
            <div class="hero-content">
                <h1>Transformamos tus ideas en Software de Alto Impacto</h1>
                <p>Desarrollo a la medida, aplicaciones móviles, web y soluciones en la nube con tecnología de vanguardia para hacer crecer tu negocio.</p>
                <div class="hero-buttons">
                    <a href="#servicios" class="btn btn-cyan">Ver Servicios</a>
                    <a href="#proyectos" class="btn btn-outline">Nuestros Proyectos</a>
                </div>
            </div>
        </div>
    </div>
</section>