-- Crear base de datos
DROP DATABASE IF EXISTS catalogo_videojuegos_poo;
CREATE DATABASE IF NOT EXISTS catalogo_videojuegos_poo;
USE catalogo_videojuegos_poo;

-- Tabla de géneros (para videojuegos)
CREATE TABLE IF NOT EXISTS generos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla de plataformas (para videojuegos)
CREATE TABLE IF NOT EXISTS plataformas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL -- Espacio de sobra para el hash de la contraseña
);

-- Insertamos un usuario de prueba:
-- Usuario: admin
-- Contraseña: admin123 (encriptada con SHA2 de 256 bits)
INSERT INTO usuarios (username, password) VALUES 
('admin',('admin123'));
-- Añadir la columna de rol a la tabla usuarios
ALTER TABLE usuarios ADD COLUMN rol VARCHAR(20) DEFAULT 'usuario_normal';

-- Asegurar que el usuario admin tenga el rol de admin
UPDATE usuarios SET rol = 'admin' WHERE username = 'admin';
-- Tabla de productos (clase base)
-- Esta tabla actúa como "padre" en la jerarquía, aunque en la práctica no la usaremos directamente para insertar datos.
-- Su propósito es reflejar la estructura de herencia en la base de datos.
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    tipo ENUM('Videojuego', 'DLC') NOT NULL
);

-- Tabla de videojuegos (clase hija de Producto)
CREATE TABLE IF NOT EXISTS videojuegos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    desarrolladora VARCHAR(100),
    ano_lanzamiento INT,
    genero_id INT,
    plataforma_id INT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    FOREIGN KEY (genero_id) REFERENCES generos(id) ON DELETE SET NULL,
    FOREIGN KEY (plataforma_id) REFERENCES plataformas(id) ON DELETE SET NULL
);

-- Tabla de DLCs (clase hija de Producto)
CREATE TABLE IF NOT EXISTS dlcs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    juego_base_id INT,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    FOREIGN KEY (juego_base_id) REFERENCES videojuegos(id) ON DELETE SET NULL
);

-- Insertar datos de ejemplo para géneros y plataformas
INSERT INTO generos (nombre) VALUES
('Acción'), ('Aventura'), ('RPG'), ('Deportes'), ('Estrategia');

INSERT INTO plataformas (nombre) VALUES
('PC'), ('PS5'), ('Xbox Series X'), ('Nintendo Switch'), ('Mobile');

-- Insertar videojuegos de ejemplo
INSERT INTO videojuegos (titulo, desarrolladora, ano_lanzamiento, genero_id, plataforma_id, precio, stock) VALUES
('The Last of Us Part II', 'Naughty Dog', 2020, 1, 2, 59.99, 10),
('Elden Ring', 'FromSoftware', 2022, 3, 1, 59.99, 15),
('FIFA 23', 'EA Sports', 2022, 4, 3, 69.99, 20),
('Zelda: Breath of the Wild', 'Nintendo', 2017, 2, 4, 49.99, 5),
('God of War (2018)', 'Santa Monica Studio', 2018, 1, 2, 49.99, 12),
('Cyberpunk 2077', 'CD Projekt Red', 2020, 1, 1, 59.99, 8),
('Red Dead Redemption 2', 'Rockstar Games', 2018, 2, 2, 59.99, 10),
('The Legend of Zelda: Tears of the Kingdom', 'Nintendo', 2023, 2, 4, 69.99, 18),
('Baldur''s Gate 3', 'Larian Studios', 2023, 3, 1, 59.99, 15),
('Final Fantasy VII Remake', 'Square Enix', 2020, 3, 2, 59.99, 7);

-- Insertar DLCs de ejemplo (asociados a videojuegos existentes)
INSERT INTO dlcs (titulo, juego_base_id, descripcion, precio, stock) VALUES
('The Last of Us Part II - Left Behind', 1, 'DLC que explora la historia de Ellie y Riley.', 9.99, 20),
('Elden Ring - Shadow of the Erdtree', 2, 'Expansión con nuevas áreas, jefes y armas.', 39.99, 15),
('FIFA 23 - Ultimate Edition', 3, 'Incluye contenido adicional como jugadores icónicos.', 89.99, 10),
('Zelda: Breath of the Wild - The Champions'' Ballad', 4, 'DLC con nuevas misiones y objetos.', 19.99, 12),
('Cyberpunk 2077 - Phantom Liberty', 6, 'Expansión con una nuebd.sqlva historia y área.', 29.99, 18);