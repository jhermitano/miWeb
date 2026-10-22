<?php
$mensaje_contacto = '';
$tipo_alerta = '';

// Procesamiento del Formulario de Contacto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'contacto') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if (!empty($nombre) && !empty($email) && !empty($mensaje) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare("INSERT INTO contactos (nombre, email, mensaje) VALUES (:nombre, :email, :mensaje)");
        if ($stmt->execute([':nombre' => $nombre, ':email' => $email, ':mensaje' => $mensaje])) {
            $mensaje_contacto = "¡Gracias por escribirnos! En JVDeveloper te responderemos a la brevedad.";
            $tipo_alerta = "exito";
        } else {
            $mensaje_contacto = "Ocurrió un error al guardar el mensaje. Inténtalo nuevamente.";
            $tipo_alerta = "error";
        }
    } else {
        $mensaje_contacto = "Por favor completa todos los campos con datos válidos.";
        $tipo_alerta = "error";
    }
}
?>

<style>
    .contact-box {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 3rem;
        max-width: 700px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 0.8rem 1rem;
        background: #070d19;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: #fff;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--cyan-accent);
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .alert-exito {
        background: rgba(46, 204, 113, 0.15);
        border: 1px solid #2ecc71;
        color: #2ecc71;
    }

    .alert-error {
        background: rgba(231, 76, 60, 0.15);
        border: 1px solid #e74c3c;
        color: #e74c3c;
    }
</style>

<!-- Contacto -->
<section id="contacto" class="contact">
    <div class="container">
        <h2 class="section-title">Contáctanos</h2>
        <div class="contact-box">
            <?php if (!empty($mensaje_contacto)): ?>
                <div class="alert alert-<?= $tipo_alerta ?>">
                    <?= htmlspecialchars($mensaje_contacto) ?>
                </div>
            <?php endif; ?>

            <form action="#contacto" method="POST" id="formContacto">
                <input type="hidden" name="action" value="contacto">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Tu nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="tu@email.com" required>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" rows="4" class="form-control" placeholder="Detalla tu proyecto..." required></textarea>
                </div>
                <button type="submit" class="btn btn-blue" style="width: 100%;">Enviar Mensaje</button>
            </form>
        </div>
    </div>
</section>