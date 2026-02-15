-- ============================
-- 1. Creación de la base de datos
-- ============================
CREATE DATABASE IF NOT EXISTS portfolio
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE portfolio;

-- ============================
-- 2. Tabla categorias
-- ============================
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO categorias (nombre) VALUES
('Frontend'),
('Backend'),
('Fullstack');

-- ============================
-- 3. Tabla proyectos
-- ============================
CREATE TABLE proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    categoria_id INT NOT NULL,
    imagen VARCHAR(100) NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- ============================
-- 4. Tabla tecnologias
-- ============================
CREATE TABLE tecnologias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO tecnologias (nombre) VALUES
('HTML'),
('CSS'),
('Bootstrap'),
('PHP'),
('MySQL'),
('JavaScript'),
('PDO');

-- ============================
-- 5. Tabla intermedia proyecto_tecnologia
-- ============================
CREATE TABLE proyecto_tecnologia (
    proyecto_id INT NOT NULL,
    tecnologia_id INT NOT NULL,
    PRIMARY KEY (proyecto_id, tecnologia_id),
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id)
        ON DELETE CASCADE,
    FOREIGN KEY (tecnologia_id) REFERENCES tecnologias(id)
        ON DELETE CASCADE
);

-- ============================
-- 6. Inserción de proyectos
-- ============================

INSERT INTO proyectos (titulo, descripcion, categoria_id, imagen) VALUES 
('Portfolio Personal', 'Web personal para mostrar mis trabajos y habilidades.', 1, 'proyecto1.png'),
('Tienda Online', 'Plataforma de ecommerce con carrito de compras y pasarela de pago.', 2, 'proyecto2.png'),
('Blog Corporativo', 'Blog para empresa con CMS personalizado y panel de administración.', 3, 'proyecto3.png'),
('Landing Page Promocional', 'Landing page de producto con formulario de suscripción.', 1, 'proyecto4.png'),
('Sistema de Reservas', 'Aplicación para gestionar reservas en línea con panel de administración.', 2, 'proyecto5.png'),
('Red Social de Mascotas', 'Plataforma social para amantes de mascotas con chat y muro de publicaciones.', 3, 'proyecto6.png'),
('Calculadora Online', 'Calculadora interactiva en navegador con diseño responsive.', 1, 'proyecto7.png'),
('Gestor de Tareas', 'Aplicación para crear, editar y eliminar tareas con almacenamiento en base de datos.', 3, 'proyecto8.png');

-- ============================
-- 7. Relación proyectos - tecnologias
-- ============================

-- Proyecto 1: Portfolio Personal
INSERT INTO proyecto_tecnologia VALUES
(1, 1), -- HTML
(1, 2), -- CSS
(1, 3); -- Bootstrap

-- Proyecto 2: Tienda Online
INSERT INTO proyecto_tecnologia VALUES
(2, 4), -- PHP
(2, 5); -- MySQL

-- Proyecto 3: Blog Corporativo
INSERT INTO proyecto_tecnologia VALUES
(3, 4), -- PHP
(3, 5), -- MySQL
(3, 6); -- JavaScript

-- Proyecto 4: Landing Page Promocional
INSERT INTO proyecto_tecnologia VALUES
(4, 1), -- HTML
(4, 2); -- CSS

-- Proyecto 5: Sistema de Reservas
INSERT INTO proyecto_tecnologia VALUES
(5, 4), -- PHP
(5, 5), -- MySQL
(5, 7); -- PDO

-- Proyecto 6: Red Social de Mascotas
INSERT INTO proyecto_tecnologia VALUES
(6, 4), -- PHP
(6, 6); -- JavaScript

-- Proyecto 7: Calculadora Online
INSERT INTO proyecto_tecnologia VALUES
(7, 1), -- HTML
(7, 2), -- CSS
(7, 6); -- JavaScript

-- Proyecto 8: Gestor de Tareas
INSERT INTO proyecto_tecnologia VALUES
(8, 4); -- PHP
