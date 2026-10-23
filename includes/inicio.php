<?php
// includes/inicio.php
?>

<style>
    .hero {
        position: relative;
        padding: 8rem 0 4rem 0;
        background-color: var(--bg-color);
        min-height: auto;
        display: flex;
        align-items: center;
    }

    /* Contenedor principal con imagen de fondo */
    .hero-container-bg {
        position: relative;
        width: 100%;
        border-radius: 20px;
        overflow: hidden;
        padding: 4.5rem 3.5rem;
        
        background-image: 
            linear-gradient(to right, #070d19 35%, rgba(7, 13, 25, 0.4) 70%, transparent 100%),
            url('img/fondo.jpg');
            
        background-position: center right;
        background-repeat: no-repeat;
        background-size: cover;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .hero-content {
        max-width: 580px;
        position: relative;
        z-index: 2;
    }

    .hero-content h1 {
        font-size: 3.2rem;
        line-height: 1.15;
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

    /* ==============================================
       TARJETAS DELGADAS Y COMPACTAS (ACCIONES)
       ============================================== */
    .hero-actions-container {
        display: flex;
        flex-direction: row; /* Posición horizontal */
        gap: 1rem;
        width: 100%;
        max-width: 480px; /* Ancho controlado para lucir estilizadas */
    }

    .hero-action-card {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.8rem;
        padding: 0.55rem 1rem; /* Padding reducido para delgadez */
        background: rgba(14, 23, 42, 0.65);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 50px; /* Forma de píldora delgada */
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .action-left {
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }

    .action-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .action-title {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .action-arrow {
        font-size: 0.8rem;
        opacity: 0.6;
        transition: transform 0.3s ease, opacity 0.3s ease;
        margin-right: 0.2rem;
    }

    /* Estilo Cyan (Servicios) */
    .hero-action-card.card-cyan:hover {
        border-color: var(--cyan-accent);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 210, 211, 0.25);
        background: rgba(14, 23, 42, 0.85);
    }
    .hero-action-card.card-cyan .action-icon {
        background: rgba(0, 210, 211, 0.15);
        color: var(--cyan-accent);
    }
    .hero-action-card.card-cyan:hover .action-arrow {
        color: var(--cyan-accent);
        transform: translateX(3px);
        opacity: 1;
    }

    /* Estilo Azul (Proyectos) */
    .hero-action-card.card-blue:hover {
        border-color: var(--primary-blue);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(29, 114, 243, 0.3);
        background: rgba(14, 23, 42, 0.85);
    }
    .hero-action-card.card-blue .action-icon {
        background: rgba(29, 114, 243, 0.15);
        color: var(--primary-blue);
    }
    .hero-action-card.card-blue:hover .action-arrow {
        color: var(--primary-blue);
        transform: translateX(3px);
        opacity: 1;
    }

    /* ==============================================
       ADAPTABILIDAD RESPONSIVE
       ============================================== */

    @media (max-width: 992px) {
        .hero {
            padding: 7rem 0 3rem 0;
        }
        
        .hero-container-bg {
            padding: 3.5rem 2.5rem;
            background-image: 
                linear-gradient(to right, #070d19 45%, rgba(7, 13, 25, 0.45) 80%, transparent 100%),
                url('img/fondo.jpg');
            background-position: 75% center;
        }

        .hero-content h1 {
            font-size: 2.6rem;
        }
    }

    @media (max-width: 768px) {
        .hero {
            padding: 6rem 0 2rem 0;
        }

        .hero-container-bg {
            padding: 2.5rem 1.5rem 2rem 1.5rem;
            background-image: 
                linear-gradient(to bottom, transparent 0%, rgba(7, 13, 25, 0.75) 40%, rgba(7, 13, 25, 0.95) 100%),
                url('img/fondo.jpg');
            background-position: top center;
            background-size: cover;
            border-radius: 16px;
        }

        .hero-content {
            max-width: 100%;
            margin-top: 180px; 
            text-align: center;
        }

        .hero-content h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.9);
        }

        .hero-content p {
            font-size: 0.95rem;
            margin-bottom: 1.6rem;
            text-shadow: 0 1px 6px rgba(0, 0, 0, 0.9);
            color: #d1d5db;
        }

        .hero-actions-container {
            margin: 0 auto;
        }
    }

    @media (max-width: 480px) {
        .hero-container-bg {
            padding: 2rem 1rem;
        }

        .hero-content {
            margin-top: 140px;
        }

        .hero-content h1 {
            font-size: 1.7rem;
            line-height: 1.25;
        }

        .hero-actions-container {
            gap: 0.5rem;
        }

        .hero-action-card {
            padding: 0.45rem 0.75rem;
            gap: 0.4rem;
        }

        .action-icon {
            width: 28px;
            height: 28px;
            font-size: 0.8rem;
        }

        .action-title {
            font-size: 0.82rem;
        }
    }
</style>

<!-- Hero Section -->
<section id="inicio" class="hero">
    <div class="container">
        <div class="hero-container-bg">
            <div class="hero-content">
                <h1>Transformamos tus ideas en Software de Alto Impacto</h1>
                <p>Desarrollo a la medida, aplicaciones móviles, web y soluciones en la nube con tecnología de vanguardia para hacer crecer tu negocio.</p>
                
                <!-- Acciones Rápidas Horizontales Delgadas -->
                <div class="hero-actions-container">
                    <a href="#servicios" class="hero-action-card card-cyan">
                        <div class="action-left">
                            <div class="action-icon">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                            <span class="action-title">Servicios</span>
                        </div>
                        <i class="fa-solid fa-chevron-right action-arrow"></i>
                    </a>

                    <a href="#proyectos" class="hero-action-card card-blue">
                        <div class="action-left">
                            <div class="action-icon">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                            <span class="action-title">Proyectos</span>
                        </div>
                        <i class="fa-solid fa-chevron-right action-arrow"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>