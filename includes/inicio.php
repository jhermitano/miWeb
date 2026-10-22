<style>
    .hero {
        padding: 9rem 0 5rem 0;
        position: relative;
        background-color: var(--bg-color);
        overflow: hidden;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 2rem;
        align-items: center;
        min-height: 480px;
    }

    .hero-content {
        z-index: 2;
    }

    .hero-content h1 {
        font-size: 3.5rem;
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
        max-width: 90%;
        line-height: 1.6;
    }

    .hero-buttons {
        display: flex;
        gap: 1.2rem;
    }

    .hero-graphic {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-bg-img {
        width: 100%;
        height: auto;
        max-height: 480px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
        border: 1px solid var(--border-color);
    }

    @media (max-width: 900px) {
        .hero-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- Hero Section -->
<section id="inicio" class="hero">
    <div class="container hero-grid">
        <div class="hero-content">
            <h1>Transformamos tus ideas en Software de Alto Impacto</h1>
            <p>Desarrollo a la medida, aplicaciones móviles, web y soluciones en la nube con tecnología de vanguardia para hacer crecer tu negocio.</p>
            <div class="hero-buttons">
                <a href="#servicios" class="btn btn-cyan">Ver Servicios</a>
                <a href="#proyectos" class="btn btn-outline">Nuestros Proyectos</a>
            </div>
        </div>
        <div class="hero-graphic">
            <img src="img/fondo.jpg" alt="JVDeveloper Soluciones de Software" class="hero-bg-img">
        </div>
    </div>
</section>