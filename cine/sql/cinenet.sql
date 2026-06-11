DROP DATABASE IF EXISTS cinenet;
CREATE DATABASE cinenet;
USE cinenet;

-- =========================
-- TABLA USUARIOS
-- =========================

CREATE TABLE rusuarios (
    idusuario INT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    fecha_alta DATE NOT NULL,
    fecha_baja DATE NULL,
    alquileres_activos INT DEFAULT 0
);

-- =========================
-- TABLA PELICULAS
-- =========================

CREATE TABLE rpeliculas (
    idpelicula INT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    director VARCHAR(100) NOT NULL,
    genero VARCHAR(50) NOT NULL,
    disponible CHAR(1) DEFAULT 'S',
    anio INT NOT NULL
);

-- =========================
-- TABLA ALQUILERES
-- =========================

CREATE TABLE ralquileres (
    idusuario INT,
    idpelicula INT,
    fecha_alquiler DATE,
    fecha_limite DATE NOT NULL,
    fecha_devolucion DATE NULL,
    renovado CHAR(1) DEFAULT 'N',

    PRIMARY KEY (idusuario, idpelicula, fecha_alquiler),

    FOREIGN KEY (idusuario)
        REFERENCES rusuarios(idusuario),

    FOREIGN KEY (idpelicula)
        REFERENCES rpeliculas(idpelicula)
);

-- =========================
-- DATOS DE PRUEBA USUARIOS
-- =========================

INSERT INTO rusuarios VALUES
(1,'Ana','García','ana@cinenet.es','2024-01-10',NULL,0),
(2,'Luis','Martín','luis@cinenet.es','2024-02-15',NULL,1),
(3,'Marta','López','marta@cinenet.es','2024-03-20',NULL,0),
(4,'Pedro','Sánchez','pedro@cinenet.es','2024-04-05',NULL,2),
(5,'Sara','Ruiz','sara@cinenet.es','2024-05-01','2025-01-01',0);

-- =========================
-- DATOS DE PRUEBA PELICULAS
-- =========================

INSERT INTO rpeliculas VALUES
(101,'Origen','Christopher Nolan','Ciencia Ficción','S',2010),
(102,'Interstellar','Christopher Nolan','Ciencia Ficción','S',2014),
(103,'Gladiator','Ridley Scott','Acción','S',2000),
(104,'Titanic','James Cameron','Drama','S',1997),
(105,'Avatar','James Cameron','Ciencia Ficción','S',2009),
(106,'Joker','Todd Phillips','Drama','S',2019),
(107,'El Padrino','Francis Ford Coppola','Drama','S',1972),
(108,'Matrix','Wachowski','Ciencia Ficción','S',1999),
(109,'Seven','David Fincher','Thriller','S',1995),
(110,'Whiplash','Damien Chazelle','Drama','S',2014);

-- =========================
-- ALQUILERES DE PRUEBA
-- =========================

INSERT INTO ralquileres VALUES
(
    2,
    103,
    '2025-05-01',
    '2025-05-08',
    NULL,
    'N'
);

UPDATE rpeliculas
SET disponible='N'
WHERE idpelicula=103;

INSERT INTO ralquileres VALUES
(
    4,
    107,
    '2025-05-10',
    '2025-05-17',
    '2025-05-15',
    'N'
);

INSERT INTO ralquileres VALUES
(
    4,
    108,
    '2025-05-20',
    '2025-05-27',
    NULL,
    'S'
);

UPDATE rpeliculas
SET disponible='N'
WHERE idpelicula=108;