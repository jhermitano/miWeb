<?php
// includes/proyectos.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensaje_admin = '';
$tipo_alerta_admin = '';

// Procesar el envío del formulario solo si el usuario ha iniciado sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'crear_proyecto_web') {
    if (!isset($_SESSION['usuario_id'])) {
        $mensaje_admin = "Debes iniciar sesión para subir proyectos.";
        $tipo_alerta_admin = "error";
    } else {
        $titulo = trim($_POST['titulo'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $url_proyecto = trim($_POST['url_proyecto'] ?? '');
        $orden = (int)($_POST['orden'] ?? 0);

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $fileName = $_FILES['imagen']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExtension, $extensiones_permitidas)) {
                $nuevoNombreImagen = 'proyecto_' . time() . '_' . uniqid() . '.' . $fileExtension;
                $uploadFileDir = __DIR__ . '/../img/';
                $dest_path = $uploadFileDir . $nuevoNombreImagen;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $dest_path)) {
                    $rutaBaseDatos = 'img/' . $nuevoNombreImagen;

                    $stmt = $pdo->prepare("INSERT INTO proyectos (titulo, categoria, descripcion, url_proyecto, imagen_url, orden) VALUES (:titulo, :categoria, :descripcion, :url_proyecto, :imagen_url, :orden)");
                    $exito = $stmt->execute([
                        ':titulo' => $titulo,
                        ':categoria' => $categoria,
                        ':descripcion' => $descripcion,
                        ':url_proyecto' => $url_proyecto,
                        ':imagen_url' => $rutaBaseDatos,
                        ':orden' => $orden
                    ]);

                    if ($exito) {
                        $mensaje_admin = "¡Proyecto añadido con éxito!";
                        $tipo_alerta_admin = "exito";
                    } else {
                        $mensaje_admin = "Error al guardar el registro en la base de datos.";
                        $tipo_alerta_admin = "error";
                    }
                } else {
                    $mensaje_admin = "Error al guardar la imagen en la carpeta img/. Verifique los permisos.";
                    $tipo_alerta_admin = "error";
                }
            } else {
                $mensaje_admin = "Formato no válido (solo JPG, PNG o WEBP).";
                $tipo_alerta_admin = "error";
            }
        } else {
            $mensaje_admin = "Por favor selecciona una imagen para el proyecto.";
            $tipo_alerta_admin = "error";
        }
    }
}

// Consultar SOLO los últimos 3 Proyectos ingresados desde MySQL
$proyectos = $pdo->query("SELECT * FROM proyectos ORDER BY id DESC LIMIT 3")->fetchAll();

$imagenes_fallback = [
    1 => 'img/proyecto1.jpg',
    2 => 'img/proyecto2.jpg',
    3 => 'img/proyecto3.jpg'
];
?>

<style>
    .projects {
        padding: 5rem 0 1.5rem 0;
    }

    /* Cabecera ajustada para centrar el título perfectamente */
    .project-header-actions {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 2.5rem;
    }

    .project-header-actions .section-title {
        margin-bottom: 0;
        text-align: center;
    }

    /* Posiciona el botón flotando a la derecha */
    .btn-add-project {
        position: absolute;
        right: 0;
        background: linear-gradient(135deg, #00d2d3, #1d72f3);
        color: #070d19;
        font-weight: 700;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: transform 0.2s ease;
    }

    .btn-add-project:hover {
        transform: translateY(-2px);
    }

    .modal-form-container {
        display: none;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    .modal-form-container.active {
        display: block;
    }

    .modal-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .modal-form-grid .full-width {
        grid-column: span 2;
    }

    .project-card-img {
        width: 100%;
        height: 190px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 1.2rem;
        border: 1px solid var(--border-color);
        display: block;
    }

    /* Tarjetas con alineación y texto totalmente centrados */
    .project-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        text-align: center;
    }

    .project-card-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }

    .project-category {
        color: var(--cyan-accent);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Estilos del Botón Ir al sitio web centrado */
    .btn-visit-site {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.2rem;
        width: 100%;
        padding: 0.7rem 1rem;
        background: rgba(29, 114, 243, 0.15);
        color: var(--cyan-accent);
        border: 1px solid var(--cyan-accent);
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-visit-site:hover {
        background: var(--cyan-accent);
        color: #070d19;
        transform: translateY(-2px);
    }

    .process-section {
        padding: 1rem 0 3rem 0;
    }

    .process-section .section-title {
        margin-bottom: 1.8rem;
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
        padding: 0.9rem 0.8rem;
        border-radius: 12px;
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .step-1 { background: linear-gradient(135deg, #00d2d3, #00a8ff); color: #070d19; }
    .step-2 { background: linear-gradient(135deg, #8b5cf6, #6c5ce7); }
    .step-3 { background: linear-gradient(135deg, #1d72f3, #00d2ff); }
    .step-4 { background: linear-gradient(135deg, #8b5cf6, #6c5ce7); }
    .step-5 { background: linear-gradient(135deg, #1d72f3, #0088ff); }

    .step-arrow { color: var(--text-muted); font-size: 1.2rem; }

    @media (max-width: 900px) {
        .project-header-actions {
            flex-direction: column;
            gap: 1rem;
        }
        .btn-add-project {
            position: static;
        }
        .modal-form-grid { grid-template-columns: 1fr; }
        .modal-form-grid .full-width { grid-column: span 1; }
        .process-steps { flex-direction: column; gap: 1rem; }
        .step-box { width: 100%; }
        .step-arrow { transform: rotate(90deg); }
    }
</style>

<!-- Sección Proyectos Recientes -->
<section id="proyectos" class="projects">
    <div class="container">
        <div class="project-header-actions">
            <h2 class="section-title">Nuestros Proyectos Recientes</h2>
            
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <button class="btn-add-project" id="btnToggleForm">
                    <i class="fa-solid fa-plus"></i> Añadir Proyecto
                </button>
            <?php endif; ?>
        </div>

        <?php if (!empty($mensaje_admin)): ?>
            <div class="alert alert-<?= $tipo_alerta_admin ?>" style="margin-bottom: 1.5rem;">
                <?= htmlspecialchars($mensaje_admin) ?>
            </div>
        <?php endif; ?>

        <!-- Formulario protegido por sesión -->
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <div class="modal-form-container <?= !empty($mensaje_admin) ? 'active' : '' ?>" id="formNuevoProyecto">
                <h3 style="margin-bottom: 1rem; color: var(--cyan-accent); text-align: center;">Publicar Nuevo Proyecto</h3>
                <form action="#proyectos" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="crear_proyecto_web">
                    
                    <div class="modal-form-grid">
                        <div class="form-group">
                            <label for="titulo">Título del Proyecto</label>
                            <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ej: Plataforma E-Commerce" required>
                        </div>

                        <div class="form-group">
                            <label for="categoria">Categoría</label>
                            <input type="text" id="categoria" name="categoria" class="form-control" placeholder="Ej: Fintech / Retail" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" rows="3" class="form-control" placeholder="Detalla las características principales..." required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="url_proyecto">Enlace al Sitio Web (URL)</label>
                            <input type="url" id="url_proyecto" name="url_proyecto" class="form-control" placeholder="https://ejemplo.com">
                        </div>

                        <div class="form-group">
                            <label for="imagen">Imagen del Proyecto</label>
                            <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="orden">Orden de Posición</label>
                            <input type="number" id="orden" name="orden" class="form-control" value="1" min="0" required>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                        <button type="submit" class="btn btn-blue" style="flex: 1;">Guardar y Publicar</button>
                        <button type="button" class="btn btn-outline" id="btnCancelarForm">Cancelar</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <!-- Rejilla de los Últimos 3 Proyectos Cargados desde MySQL (Contenido Centrado) -->
        <div class="cards-grid">
            <?php foreach ($proyectos as $index => $proyecto): ?>
                <?php 
                    if (!empty($proyecto['imagen_url'])) {
                        $img_proyecto = $proyecto['imagen_url'];
                    } else {
                        $img_proyecto = $imagenes_fallback[$index + 1] ?? 'img/proyecto1.jpg';
                    }
                    
                    $url = !empty($proyecto['url_proyecto']) ? $proyecto['url_proyecto'] : '#';
                ?>
                <div class="card project-card">
                    <div class="project-card-content">
                        <img src="<?= htmlspecialchars($img_proyecto) ?>" alt="<?= htmlspecialchars($proyecto['titulo']) ?>" class="project-card-img">
                        <p class="project-category"><?= htmlspecialchars($proyecto['categoria']) ?></p>
                        <h3 style="margin-top: 0.4rem;"><?= htmlspecialchars($proyecto['titulo']) ?></h3>
                        <p style="margin-top: 0.5rem;"><?= htmlspecialchars($proyecto['descripcion']) ?></p>
                    </div>

                    <!-- Botón Ir al sitio web -->
                    <a href="<?= htmlspecialchars($url) ?>" target="_blank" class="btn-visit-site">
                        Ir al sitio web <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnToggle = document.getElementById('btnToggleForm');
        const btnCancelar = document.getElementById('btnCancelarForm');
        const formContainer = document.getElementById('formNuevoProyecto');

        if (btnToggle && formContainer) {
            btnToggle.addEventListener('click', function() {
                formContainer.classList.toggle('active');
            });
        }

        if (btnCancelar && formContainer) {
            btnCancelar.addEventListener('click', function() {
                formContainer.classList.remove('active');
            });
        }
    });
</script>