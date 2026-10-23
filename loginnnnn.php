<?php
// login.php
session_start();
require_once __DIR__ . '/config/conexion.php';

// Si ya hay sesión iniciada, redirigir al inicio
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nombre'] = $user['nombre'];
            $_SESSION['usuario_email'] = $user['email'];
            header('Location: index.php#proyectos');
            exit();
        } else {
            $error = "Correo electrónico o contraseña incorrectos.";
        }
    } else {
        $error = "Por favor completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Sesiones - JVDeveloper</title>
    <!-- FontAwesome Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #070d19;
            --card-bg: rgba(14, 23, 42, 0.75);
            --input-bg: rgba(7, 13, 25, 0.7);
            --primary-blue: #1d72f3;
            --cyan-accent: #00d2d3;
            --text-main: #ffffff;
            --text-muted: #8e9bb0;
            --border-color: rgba(255, 255, 255, 0.12);
            --font-family: 'Inter', sans-serif;
        }

        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: var(--font-family);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: 
                radial-gradient(circle at 50% 30%, rgba(29, 114, 243, 0.18) 0%, transparent 60%),
                url('img/fondo.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            padding: 1.5rem;
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3rem 2.5rem 2.2rem 2.5rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Encabezado y Logo Ampliado */
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-logo {
            height: 75px; /* Tamaño aumentado */
            width: auto;
            max-width: 280px;
            object-fit: contain;
            display: inline-block;
            filter: drop-shadow(0 4px 12px rgba(0, 210, 211, 0.25));
        }

        .login-card h2 { 
            text-align: center; 
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 2rem; 
            color: #fff; 
        }

        .form-group { 
            margin-bottom: 1.4rem; 
        }

        .form-group label { 
            display: block; 
            margin-bottom: 0.5rem; 
            color: var(--text-muted); 
            font-size: 0.8rem; 
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Estructura de Inputs con Iconos Laterales */
        .input-wrapper {
            display: flex;
            align-items: center;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-wrapper:focus-within {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(29, 114, 243, 0.25);
        }

        .input-icon {
            padding: 0.85rem 1rem;
            color: var(--text-muted);
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-control {
            flex: 1;
            background: transparent;
            border: none;
            padding: 0.85rem 0.5rem 0.85rem 0;
            color: #fff;
            font-family: inherit;
            font-size: 0.95rem;
            outline: none;
        }

        .input-control::placeholder {
            color: rgba(142, 155, 176, 0.5);
        }

        .btn-toggle-pwd {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 0.85rem 1rem;
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.2s ease;
        }

        .btn-toggle-pwd:hover {
            color: #fff;
        }

        /* Texto de ayuda inferior */
        .help-text {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-top: 0.4rem;
        }

        /* Botón de envío */
        .btn-login {
            width: 100%;
            padding: 0.95rem;
            background: var(--primary-blue);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 1.5rem;
            box-shadow: 0 4px 20px rgba(29, 114, 243, 0.4);
            transition: all 0.3s ease;
        }

        .btn-login:hover { 
            background: #145ed0;
            transform: translateY(-2px);
        }

        /* Enlaces inferiores */
        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 1.2rem;
            color: var(--primary-blue);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--cyan-accent);
        }

        .copyright {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-top: 2rem;
        }

        .alert-error {
            background: rgba(231, 76, 60, 0.15);
            border: 1px solid #e74c3c;
            color: #e74c3c;
            padding: 0.8rem;
            border-radius: 12px;
            margin-bottom: 1.2rem;
            text-align: center;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Logotipo centrado más grande -->
        <div class="logo-container">
            <img src="img/logo.png" alt="JVDeveloper Logo" class="login-logo">
        </div>

        <h2>Control de Sesiones</h2>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <!-- Campo 1: Correo / ID -->
            <div class="form-group">
                <label for="email">ID / Correo Electrónico</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fa-regular fa-user"></i></span>
                    <input type="email" id="email" name="email" class="input-control" placeholder="admin@jvdeveloper.com" required>
                </div>
                <div class="help-text">
                    <i class="fa-regular fa-circle-info"></i>
                    <span>Incluir correo corporativo registrado.</span>
                </div>
            </div>

            <!-- Campo 2: Contraseña -->
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fa-solid fa-key"></i></span>
                    <input type="password" id="password" name="password" class="input-control" placeholder="••••••••" required>
                    <button type="button" class="btn-toggle-pwd" id="togglePassword">
                        <i class="fa-regular fa-eye-slash" id="pwdIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Botón Principal -->
            <button type="submit" class="btn-login">
                Ingresar al Sistema
            </button>
        </form>

        <!-- Enlace de Recuperación -->
        <a href="index.php" class="forgot-link">¿Olvidó su contraseña?</a>

        <!-- Pie de derechos -->
        <div class="copyright">
            &copy; <?= date('Y') ?> JVDeveloper - Gestión de Proyectos
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const pwdIcon = document.getElementById('pwdIcon');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    
                    pwdIcon.classList.toggle('fa-eye');
                    pwdIcon.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>