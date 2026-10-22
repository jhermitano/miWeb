<?php
// includes/header.php
require_once __DIR__ . '/../config/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JVDeveloper - Desarrollo de Software de Alto Impacto</title>

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
                <a href="#contacto" class="btn btn-blue">Contáctanos</a>
            </nav>
        </div>
    </header>