<?php
// includes/contactos.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Procesamiento AJAX para guardar en BD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'contacto_ajax') {
    header('Content-Type: application/json');
    
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if (!empty($nombre) && !empty($email) && !empty($mensaje) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare("INSERT INTO contactos (nombre, email, mensaje) VALUES (:nombre, :email, :mensaje)");
        if ($stmt->execute([':nombre' => $nombre, ':email' => $email, ':mensaje' => $mensaje])) {
            echo json_encode(['status' => 'success', 'message' => '¡Gracias por escribirnos! Te redirigiremos a WhatsApp.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ocurrió un error al guardar el mensaje. Inténtalo nuevamente.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Por favor completa todos los campos con datos válidos.']);
    }
    exit();
}
?>

<style>
    /* Estilos de la Sección Contacto Horizontal */
    .contact-section {
        padding: 5rem 0;
        background-color: var(--bg-color);
    }

    .contact-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr 1.5fr;
        gap: 2.5rem;
        align-items: start;
    }

    .contact-intro h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: #ffffff;
    }

    .contact-intro p {
        color: var(--text-muted);
        font-size: 1rem;
        line-height: 1.6;
    }

    .contact-info-list {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        padding-top: 1rem;
    }

    .contact-info-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #ffffff;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .contact-info-item i {
        font-size: 1.2rem;
        color: var(--cyan-accent);
        width: 24px;
        text-align: center;
    }

    .contact-form-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-control-dark {
        width: 100%;
        padding: 0.9rem 1.1rem;
        background: rgba(14, 23, 42, 0.8);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: #ffffff;
        font-family: inherit;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.3s ease;
    }

    .form-control-dark:focus {
        border-color: var(--primary-blue);
    }

    .btn-send-msg {
        align-self: flex-start;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        background: #25d366;
        color: #ffffff;
        border: none;
        padding: 0.85rem 1.8rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.35);
    }

    .btn-send-msg:hover {
        background: #1ebc57;
        transform: translateY(-2px);
    }

    /* Estilos del Pie de Página / Footer */
    .site-footer {
        background-color: #050913;
        border-top: 1px solid var(--border-color);
        padding: 4rem 0 2.5rem 0;
        margin-top: 3rem;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
        gap: 2.5rem;
        align-items: start;
    }

    .footer-brand .footer-logo {
        height: 100px;
        width: auto;
        margin-bottom: 1rem;
    }

    .footer-brand p {
        color: var(--text-muted);
        font-size: 0.88rem;
        line-height: 1.5;
        max-width: 280px;
    }

    .footer-column h4 {
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.2rem;
    }

    .footer-links {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .footer-links a {
        color: var(--text-muted);
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .footer-links a:hover {
        color: var(--cyan-accent);
    }

    .social-icons-wrapper {
        display: flex;
        gap: 0.6rem;
        margin-bottom: 1.2rem;
        flex-wrap: wrap;
    }

    .social-icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.1rem;
        text-decoration: none;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .social-icon-btn:hover {
        transform: translateY(-3px);
        opacity: 0.9;
    }

    /* Tonalidades personalizadas */
    .icon-fb { background-color: #1ea1f2; }
    .icon-ig { background-color: #7042e4; }
    .icon-wa { background-color: #25d366; }
    .icon-tt { background-color: #000000; border: 1px solid rgba(255, 255, 255, 0.2); }

    .footer-bottom {
        text-align: center;
        padding-top: 3rem;
        margin-top: 3rem;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        color: var(--text-muted);
        font-size: 0.82rem;
    }

    @media (max-width: 992px) {
        .contact-wrapper {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .footer-grid {
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
    }

    @media (max-width: 576px) {
        .form-row-2 {
            grid-template-columns: 1fr;
        }
        .footer-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Sección Contacto -->
<section id="contacto" class="contact-section">
    <div class="container">
        <!-- Mensaje de alerta vía JS -->
        <div id="alertContacto" style="display: none; margin-bottom: 2rem;" class="alert"></div>

        <div class="contact-wrapper">
            <!-- Columna 1: Título y Mensaje de Entrada -->
            <div class="contact-intro">
                <h2>Contacto</h2>
                <p>¿Tienes alguna propuesta o quieres trabajar juntos?<br><strong>¡Hablemos!</strong></p>
            </div>

            <!-- Columna 2: Datos Directos -->
            <div class="contact-info-list">
                <div class="contact-info-item">
                    <i class="fa-regular fa-envelope"></i>
                    <span>jhonel.263023@gmail.com</span>
                </div>
                <div class="contact-info-item">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>+51 928 848 618</span>
                </div>
                <div class="contact-info-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Perú</span>
                </div>
            </div>

            <!-- Columna 3: Formulario AJAX -->
            <div class="contact-form-container">
                <form id="formContacto" onsubmit="return false;">
                    <div class="form-row-2">
                        <input type="text" id="contacto_nombre" name="nombre" class="form-control-dark" placeholder="Nombre" required>
                        <input type="email" id="contacto_email" name="email" class="form-control-dark" placeholder="Correo electrónico" required>
                    </div>

                    <div style="margin-top: 1rem;">
                        <textarea id="contacto_mensaje" name="mensaje" rows="4" class="form-control-dark" placeholder="Mensaje" required></textarea>
                    </div>

                    <div style="margin-top: 1.2rem;">
                        <button type="button" id="btnEnviarWA" class="btn-send-msg">
                            Enviar a WhatsApp <i class="fa-brands fa-whatsapp"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Pie de Página / Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Marca y Descripción -->
            <div class="footer-brand">
                <img src="img/redes.png" alt="JVDeveloper Logo" class="footer-logo">
                <p>Desarrollo de software de alto impacto, soluciones web escalables y arquitectura en la nube a la medida de tu negocio.</p>
            </div>

            <!-- Navegación Inicio -->
            <div class="footer-column">
                <h4>Navegación</h4>
                <ul class="footer-links">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#proyectos">Proyectos</a></li>
                    <li><a href="#contacto">Contáctanos</a></li>
                </ul>
            </div>

            <!-- Enlaces de Interés -->
            <div class="footer-column">
                <h4>Enlaces</h4>
                <ul class="footer-links">
                    <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#proyectos">Portafolio</a></li>
                    <li><a href="#contacto">Soporte</a></li>
                </ul>
            </div>

            <!-- Redes Sociales -->
            <div class="footer-column">
                <h4>Redes sociales</h4>
                <div class="social-icons-wrapper">
                    <a href="#" class="social-icon-btn icon-fb" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social-icon-btn icon-ig" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://wa.me/51928848618" target="_blank" class="social-icon-btn icon-wa" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#" class="social-icon-btn icon-tt" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnEnviarWA = document.getElementById('btnEnviarWA');
        const alertContacto = document.getElementById('alertContacto');

        if (btnEnviarWA) {
            btnEnviarWA.addEventListener('click', function() {
                const nombre = document.getElementById('contacto_nombre').value.trim();
                const email = document.getElementById('contacto_email').value.trim();
                const mensaje = document.getElementById('contacto_mensaje').value.trim();

                if (!nombre || !email || !mensaje) {
                    alert('Por favor completa todos los campos del formulario.');
                    return;
                }

                // 1. Guardar en base de datos vía AJAX sin recargar ni alterar la URL
                const formData = new FormData();
                formData.append('action', 'contacto_ajax');
                formData.append('nombre', nombre);
                formData.append('email', email);
                formData.append('mensaje', mensaje);

                fetch(window.location.pathname, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (alertContacto) {
                            alertContacto.className = 'alert alert-exito';
                            alertContacto.innerText = data.message;
                            alertContacto.style.display = 'block';
                        }
                        document.getElementById('formContacto').reset();
                    }
                })
                .catch(error => console.error('Error al guardar contacto:', error));

                // 2. Abrir WhatsApp en pestaña nueva
                const numeroTelefono = '51928848618';
                const textoWhatsApp = `*¡Nuevo mensaje desde la Web!*%0A%0A` +
                                      `*Nombre:* ${encodeURIComponent(nombre)}%0A` +
                                      `*Correo:* ${encodeURIComponent(email)}%0A` +
                                      `*Mensaje:* ${encodeURIComponent(mensaje)}`;

                const urlWhatsApp = `https://wa.me/${numeroTelefono}?text=${textoWhatsApp}`;
                window.open(urlWhatsApp, '_blank');
            });
        }
    });
</script>