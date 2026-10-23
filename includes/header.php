<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/conexion.php';

// Lógica para procesar el login directamente en la misma página
$error_login = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login_modal') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        // Comparación directa de contraseña en texto plano
        if ($user && $password === $user['password']) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nombre'] = $user['nombre'];
            $_SESSION['usuario_email'] = $user['email'];
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        } else {
            $error_login = "Correo electrónico o contraseña incorrectos.";
        }
    } else {
        $error_login = "Por favor completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JVDeveloper - Desarrollo de Software de Alto Impacto</title>

    <!-- Favicon de la Pestaña del Navegador -->
    <link rel="icon" type="image/png" href="img/logo.png">
    <link rel="shortcut icon" type="image/png" href="img/logo.png">

    <!-- FontAwesome Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Estilos CSS Replicando la Maqueta -->
    <style>
        :root {
            --bg-color: #070d19;            
            --card-bg: #0e172a;           
            --primary-blue: #1d72f3;       
            --cyan-accent: #00d2d3;        
            --purple-accent: #8b5cf6;      
            --text-main: #ffffff;          
            --text-muted: #8e9bb0;         
            --border-color: rgba(255, 255, 255, 0.08);
            --font-family: 'Inter', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: var(--font-family);
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: 92%;
            max-width: 1240px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 2.5rem;
            color: var(--text-main);
        }

        /* Fixed Navigation Header */
        header {
            position: fixed;
            top: 15px;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        /* Floating Glassmorphism Nav Bar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.6rem 1.5rem;
            background: rgba(14, 23, 42, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .logo-img {
            height: 48px;
            width: auto;
            max-width: 200px;
            object-fit: contain;
            display: block;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover, .nav-links a.active {
            color: #1d72f3;
            border-bottom: 2px solid #1d72f3;
            padding-bottom: 4px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-access {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--text-muted);
            font-size: 0.9rem;
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            cursor: pointer;
            background: transparent;
        }

        .btn-access:hover {
            color: var(--cyan-accent);
            border-color: var(--cyan-accent);
        }

        /* Botones */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.6rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-blue {
            background: #1d72f3;
            color: #fff;
            box-shadow: 0 4px 15px rgba(29, 114, 243, 0.4);
        }

        .btn-blue:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-cyan {
            background: linear-gradient(135deg, #00d2d3, #00a8ff);
            color: #070d19;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0, 210, 211, 0.3);
        }

        .btn-cyan:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: #ffffff;
        }

        /* Secciones y Tarjetas */
        .services, .why-us, .projects, .process, .testimonials, .contact {
            padding: 5rem 0;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 2.5rem;
            border-radius: 16px;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-blue);
        }

        .card-icon {
            font-size: 2.8rem;
            background: linear-gradient(135deg, var(--cyan-accent), var(--purple-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
        }

        .card h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .card p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* ==============================================
           ESTILOS PARA LA VENTANA MODAL FLOTANTE (LOGIN)
           ============================================== */
        .login-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(7, 13, 25, 0.45);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            padding: 1.5rem;
        }

        .login-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .login-modal-card {
            position: relative;
            background: rgba(14, 23, 42, 0.92);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 2.8rem 2.2rem 2rem 2.2rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7);
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }

        .login-modal-overlay.active .login-modal-card {
            transform: translateY(0);
        }

        .btn-close-modal {
            position: absolute;
            top: 18px;
            right: 20px;
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 1.4rem;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .btn-close-modal:hover {
            color: #ffffff;
        }

        .modal-logo-container {
            text-align: center;
            margin-bottom: 1.2rem;
        }

        .modal-login-logo {
            height: 120px;
            width: auto;
            max-width: 260px;
            object-fit: contain;
            display: inline-block;
            filter: drop-shadow(0 4px 12px rgba(0, 210, 211, 0.25));
        }

        .login-modal-card h2 { 
            text-align: center; 
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.8rem; 
            color: #fff; 
        }

        .modal-form-group { 
            margin-bottom: 1.2rem; 
        }

        .modal-form-group label { 
            display: block; 
            margin-bottom: 0.4rem; 
            color: var(--text-muted); 
            font-size: 0.8rem; 
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal-input-wrapper {
            display: flex;
            align-items: center;
            background: rgba(7, 13, 25, 0.75);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .modal-input-wrapper:focus-within {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(29, 114, 243, 0.25);
        }

        .modal-input-icon {
            padding: 0.85rem 1rem;
            color: var(--text-muted);
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-input-control {
            flex: 1;
            background: transparent;
            border: none;
            padding: 0.85rem 0.5rem 0.85rem 0;
            color: #fff;
            font-family: inherit;
            font-size: 0.95rem;
            outline: none;
        }

        .modal-input-control::placeholder {
            color: rgba(142, 155, 176, 0.5);
        }

        .btn-toggle-pwd-modal {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 0.85rem 1rem;
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.2s ease;
        }

        .btn-toggle-pwd-modal:hover {
            color: #fff;
        }

        .modal-help-text {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--text-muted);
            font-size: 0.78rem;
            margin-top: 0.4rem;
        }

        .btn-modal-login {
            width: 100%;
            padding: 0.9rem;
            background: var(--primary-blue);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 1.2rem;
            box-shadow: 0 4px 20px rgba(29, 114, 243, 0.4);
            transition: all 0.3s ease;
        }

        .btn-modal-login:hover { 
            background: #145ed0;
            transform: translateY(-2px);
        }

        .modal-forgot-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--primary-blue);
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .modal-forgot-link:hover {
            color: var(--cyan-accent);
        }

        .modal-copyright {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.78rem;
            margin-top: 1.6rem;
        }

        @media (max-width: 900px) {
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header>
        <div class="container">
            <nav>
                <a href="#inicio" class="logo">
                    <img src="img/logo.png" alt="JVDeveloper Logo" class="logo-img">
                </a>
                <ul class="nav-links">
                    <li><a href="#inicio" class="active">Inicio</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#proyectos">Proyectos</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
                <div class="nav-actions">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="logout.php" class="btn-access" title="Cerrar Sesión">
                            <i class="fa-solid fa-right-from-bracket"></i> Salir
                        </a>
                    <?php else: ?>
                        <button class="btn-access" id="btnOpenLogin" title="Iniciar Sesión">
                            <i class="fa-solid fa-user-lock"></i> Acceder
                        </button>
                    <?php endif; ?>
                    <a href="#contacto" class="btn btn-blue">Contáctanos</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- VENTANA MODAL SUPERPUESTA DE LOGIN -->
    <div class="login-modal-overlay <?= !empty($error_login) ? 'active' : '' ?>" id="loginModalOverlay">
        <div class="login-modal-card">
            <!-- Botón de Cerrar Modal -->
            <button type="button" class="btn-close-modal" id="btnCloseLogin">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Logotipo Centrado -->
            <div class="modal-logo-container">
                <img src="img/login.png" alt="JVDeveloper Logo" class="modal-login-logo">
            </div>

            <?php if (!empty($error_login)): ?>
                <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid #e74c3c; color: #e74c3c; padding: 0.8rem; border-radius: 12px; margin-bottom: 1.2rem; text-align: center; font-size: 0.85rem;">
                    <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error_login) ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <input type="hidden" name="action" value="login_modal">
                
                <!-- ID / Correo -->
                <div class="modal-form-group">
                    <label for="modal_email">Correo Electrónico</label>
                    <div class="modal-input-wrapper">
                        <span class="modal-input-icon"><i class="fa-regular fa-user"></i></span>
                        <input type="email" id="modal_email" name="email" class="modal-input-control" placeholder="admin@jvdeveloper.com" required>
                    </div>
                    <div class="modal-help-text">
                        <i class="fa-regular fa-circle-info"></i>
                        <span>Incluir correo corporativo registrado.</span>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="modal-form-group">
                    <label for="modal_password">Contraseña</label>
                    <div class="modal-input-wrapper">
                        <span class="modal-input-icon"><i class="fa-solid fa-key"></i></span>
                        <input type="password" id="modal_password" name="password" class="modal-input-control" placeholder="••••••••" required>
                        <button type="button" class="btn-toggle-pwd-modal" id="togglePasswordModal">
                            <i class="fa-regular fa-eye-slash" id="pwdIconModal"></i>
                        </button>
                    </div>
                </div>

                <!-- Botón de Inicio de Sesión -->
                <button type="submit" class="btn-modal-login">
                    Ingresar al Sistema
                </button>
            </form>

            <a href="#Inicio" class="modal-forgot-link" onclick="document.getElementById('loginModalOverlay').classList.remove('active');">Volver al Inicio</a>

            <div class="modal-copyright">
                &copy; <?= date('Y') ?> JVDeveloper - Gestión de Proyectos
            </div>
        </div>
    </div>

    <!-- Script de control del Modal flotante -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginOverlay = document.getElementById('loginModalOverlay');
            const btnOpen = document.getElementById('btnOpenLogin');
            const btnClose = document.getElementById('btnCloseLogin');
            const togglePasswordModal = document.getElementById('togglePasswordModal');
            const modalPasswordInput = document.getElementById('modal_password');
            const pwdIconModal = document.getElementById('pwdIconModal');

            // Abrir Modal
            if (btnOpen && loginOverlay) {
                btnOpen.addEventListener('click', function() {
                    loginOverlay.classList.add('active');
                });
            }

            // Cerrar Modal con botón X
            if (btnClose && loginOverlay) {
                btnClose.addEventListener('click', function() {
                    loginOverlay.classList.remove('active');
                });
            }

            // Cerrar Modal al hacer clic fuera de la tarjeta
            if (loginOverlay) {
                loginOverlay.addEventListener('click', function(e) {
                    if (e.target === loginOverlay) {
                        loginOverlay.classList.remove('active');
                    }
                });
            }

            // Ojo conmutador de contraseña
            if (togglePasswordModal && modalPasswordInput) {
                togglePasswordModal.addEventListener('click', function() {
                    const isPassword = modalPasswordInput.getAttribute('type') === 'password';
                    modalPasswordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    
                    pwdIconModal.classList.toggle('fa-eye');
                    pwdIconModal.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>