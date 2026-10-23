-- sql/schema.sql

CREATE DATABASE IF NOT EXISTS jvdeveloper_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE jvdeveloper_db;

CREATE TABLE IF NOT EXISTS servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    icono VARCHAR(50) NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    orden INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    orden INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS testimonios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente VARCHAR(100) NOT NULL,
    cargo VARCHAR(100) NOT NULL,
    comentario TEXT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO servicios (icono, titulo, descripcion, orden) VALUES
('fa-code', 'Desarrollo a la Medida', 'Sistemas web robustos, APIs escalables y aplicaciones personalizadas desarrolladas con PHP, HTML5, CSS3, JS y MySQL.', 1),
('fa-mobile-screen-button', 'Aplicaciones Móviles', 'Soluciones móviles nativas y multiplataforma optimizadas para ofrecer la mejor experiencia de usuario.', 2),
('fa-cloud', 'Cloud & DevOps', 'Despliegue y gestión de infraestructura en la nube, optimización de servidores y automatización de procesos.', 3);

INSERT INTO proyectos (titulo, categoria, descripcion, orden) VALUES
('E-Commerce de Alta Escala', 'Fintech / Retail', 'Plataforma transaccional optimizada para gestionar miles de transacciones y pedidos simultáneos.', 1),
('App de Gestión Logística', 'Mobile App', 'Sistema en tiempo real para rastreo de flota, rutas dinámicas e inventario automatizado.', 2),
('SaaS Analytics Dashboard', 'Cloud Web', 'Panel interactivo de inteligencia de negocios con generación de reportes y métricas avanzadas.', 3);

INSERT INTO testimonios (cliente, cargo, comentario) VALUES
('María Barrón', 'Directora de Tecnología - TechCorp', 'El equipo de JVDeveloper logró transformar por completo nuestra plataforma web. Su entrega fue puntual y con excelente calidad de código.'),
('Sergi Molea', 'CEO - InnovaGroup', 'Entendieron la visión de nuestro SaaS desde el primer día y escalaron nuestro sistema con total estabilidad.'),
('Jane Mos', 'Gerente de Operaciones - GlobalLog', 'La atención personalizada, el soporte constante y la arquitectura robusta superaron nuestras expectativas.');

ALTER TABLE proyectos ADD COLUMN imagen_url VARCHAR(255) DEFAULT NULL AFTER descripcion;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insertar usuario admin inicial (contraseña: admin123 encripada con password_hash)
INSERT INTO usuarios (nombre, email, password) VALUES
('Administrador', 'admin@jvdeveloper.com', '$2y$10$w3/uOnI0rJvG2/G2o4rF/.4B8A2yQ1.K8nZ1W8mJ8f1k9e5J0QG.a');

ALTER TABLE proyectos ADD COLUMN url_proyecto VARCHAR(255) DEFAULT NULL AFTER descripcion;