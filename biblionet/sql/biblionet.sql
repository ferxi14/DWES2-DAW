-- ============================================================
--  BIBLIONET - Script de creación de Base de Datos
--  Ejecutar en MySQL/MariaDB antes de usar la aplicación
-- ============================================================

DROP DATABASE IF EXISTS biblionet;
CREATE DATABASE biblionet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE biblionet;

-- ── TABLA RUSUARIOS ──────────────────────────────────────────
CREATE TABLE rusuarios (
    idusuario        INT          NOT NULL AUTO_INCREMENT,
    nombre           VARCHAR(50)  NOT NULL,
    apellido         VARCHAR(50)  NOT NULL,
    email            VARCHAR(100) NOT NULL UNIQUE,
    fecha_alta       DATE         NOT NULL DEFAULT (CURDATE()),
    fecha_baja       DATE         DEFAULT NULL,
    prestamos_activos TINYINT     NOT NULL DEFAULT 0,
    PRIMARY KEY (idusuario)
);

-- ── TABLA RLIBROS ────────────────────────────────────────────
CREATE TABLE rlibros (
    isbn             VARCHAR(20)  NOT NULL,
    titulo           VARCHAR(200) NOT NULL,
    autor            VARCHAR(100) NOT NULL,
    genero           VARCHAR(50)  NOT NULL,
    anio_publicacion  YEAR         NOT NULL,
    disponible       CHAR(1)      NOT NULL DEFAULT 'S',
    num_copias       TINYINT      NOT NULL DEFAULT 1,
    PRIMARY KEY (isbn)
);

-- ── TABLA RPRESTAMOS ─────────────────────────────────────────
CREATE TABLE rprestamos (
    idusuario        INT          NOT NULL,
    isbn             VARCHAR(20)  NOT NULL,
    fecha_prestamo   DATETIME     NOT NULL DEFAULT NOW(),
    fecha_devolucion DATETIME     DEFAULT NULL,
    fecha_limite     DATE         NOT NULL,
    renovado         CHAR(1)      NOT NULL DEFAULT 'N',
    PRIMARY KEY (idusuario, isbn, fecha_prestamo),
    FOREIGN KEY (idusuario) REFERENCES rusuarios(idusuario),
    FOREIGN KEY (isbn)      REFERENCES rlibros(isbn)
);

-- ── DATOS DE PRUEBA ──────────────────────────────────────────

INSERT INTO rusuarios (nombre, apellido, email, fecha_alta) VALUES
    ('Ana',     'Garcia',    'ana.garcia@biblionet.es',    '2023-01-10'),
    ('Carlos',  'Lopez',     'carlos.lopez@biblionet.es',  '2023-03-05'),
    ('Maria',   'Fernandez', 'maria.fernandez@biblionet.es','2023-06-20'),
    ('Pedro',   'Martinez',  'pedro.martinez@biblionet.es', '2024-01-15'),
    ('Laura',   'Sanchez',   'laura.sanchez@biblionet.es',  '2024-02-28');

-- Usuario dado de baja (para probar el login)
INSERT INTO rusuarios (nombre, apellido, email, fecha_alta, fecha_baja) VALUES
    ('Juan',    'Baja',      'juan.baja@biblionet.es',     '2022-05-01', '2023-12-01');

INSERT INTO rlibros (isbn, titulo, autor, genero, anio_publicacion, disponible, num_copias) VALUES
    ('978-0-06-112008-4', 'To Kill a Mockingbird',        'Harper Lee',           'Novela',    1960, 'S', 3),
    ('978-0-7432-7356-5', '1984',                          'George Orwell',        'Distopía',  1949, 'S', 2),
    ('978-0-14-028329-7', 'Of Mice and Men',               'John Steinbeck',       'Novela',    1937, 'S', 2),
    ('978-0-7432-7357-2', 'El nombre de la rosa',          'Umberto Eco',          'Misterio',  1980, 'S', 1),
    ('978-84-376-0494-7', 'Cien años de soledad',          'Gabriel García Márquez','Realismo mágico',1967,'S',3),
    ('978-0-06-093546-9', 'El principito',                 'Antoine de Saint-Exupéry','Fábula', 1943, 'S', 4),
    ('978-84-339-7595-1', 'La sombra del viento',          'Carlos Ruiz Zafón',    'Misterio',  2001, 'S', 2),
    ('978-0-7432-7000-7', 'Harry Potter y la piedra filosofal','J.K. Rowling',     'Fantasía',  1997, 'S', 5),
    ('978-0-618-00222-7', 'El señor de los anillos',       'J.R.R. Tolkien',       'Fantasía',  1954, 'S', 2),
    ('978-84-204-4172-0', 'El alquimista',                 'Paulo Coelho',         'Ficción',   1988, 'S', 3),
    ('978-84-322-0341-1', 'Don Quijote de la Mancha',      'Miguel de Cervantes',  'Clásico',   1605, 'N', 1),
    ('978-0-385-33348-1', 'El código Da Vinci',            'Dan Brown',            'Thriller',  2003, 'N', 2);

-- Préstamos de prueba (Ana tiene 1 activo)
INSERT INTO rprestamos (idusuario, isbn, fecha_prestamo, fecha_limite, renovado) VALUES
    (1, '978-0-7432-7356-5', '2025-05-01 10:00:00', '2025-05-22', 'N');

-- Préstamo devuelto (para historial)
INSERT INTO rprestamos (idusuario, isbn, fecha_prestamo, fecha_devolucion, fecha_limite, renovado) VALUES
    (1, '978-0-06-112008-4', '2025-01-10 09:00:00', '2025-01-25 17:00:00', '2025-01-31', 'N'),
    (2, '978-84-376-0494-7', '2025-02-14 11:30:00', '2025-03-05 10:00:00', '2025-03-07', 'S');
