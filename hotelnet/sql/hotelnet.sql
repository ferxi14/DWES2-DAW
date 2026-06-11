DROP DATABASE IF EXISTS hotelnet;
CREATE DATABASE hotelnet;
USE hotelnet;

-- =========================
-- TABLA CLIENTES
-- =========================

CREATE TABLE rclientes (
    idcliente INT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    fecha_registro DATE NOT NULL,
    fecha_baja DATE NULL
);

-- =========================
-- TABLA HABITACIONES
-- =========================

CREATE TABLE rhabitaciones (
    idhabitacion INT PRIMARY KEY,
    numero INT UNIQUE NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    capacidad INT NOT NULL,
    precio_noche DECIMAL(8,2) NOT NULL,
    disponible CHAR(1) DEFAULT 'S'
);

-- =========================
-- TABLA RESERVAS
-- =========================

CREATE TABLE rreservas (
    idcliente INT,
    idhabitacion INT,
    fecha_reserva DATE,
    fecha_entrada DATE NOT NULL,
    fecha_salida DATE NOT NULL,
    fecha_cancelacion DATE NULL,
    estado VARCHAR(20) DEFAULT 'activa',

    PRIMARY KEY (idcliente, idhabitacion, fecha_reserva),

    FOREIGN KEY (idcliente)
        REFERENCES rclientes(idcliente),

    FOREIGN KEY (idhabitacion)
        REFERENCES rhabitaciones(idhabitacion)
);

-- =========================
-- DATOS DE PRUEBA CLIENTES
-- =========================

INSERT INTO rclientes VALUES
(1,'Ana','García','ana@hotelnet.es','612345678','2024-01-10',NULL),
(2,'Luis','Martín','luis@hotelnet.es','623456789','2024-02-15',NULL),
(3,'Marta','López','marta@hotelnet.es','634567890','2024-03-20',NULL),
(4,'Pedro','Sánchez','pedro@hotelnet.es','645678901','2024-04-05',NULL),
(5,'Sara','Ruiz','sara@hotelnet.es','656789012','2024-05-01','2025-01-01');

-- =========================
-- DATOS DE PRUEBA HABITACIONES
-- =========================

INSERT INTO rhabitaciones VALUES
(101,101,'Individual',1,45.00,'S'),
(102,102,'Individual',1,45.00,'S'),
(103,103,'Doble',2,70.00,'S'),
(104,104,'Doble',2,70.00,'N'),
(105,105,'Suite',4,150.00,'S'),
(106,106,'Suite',4,150.00,'S'),
(107,107,'Familiar',3,110.00,'S'),
(108,108,'Familiar',3,110.00,'N'),
(109,109,'Deluxe',2,120.00,'S'),
(110,110,'Deluxe',2,120.00,'S');

-- =========================
-- RESERVAS DE PRUEBA
-- =========================

INSERT INTO rreservas VALUES
(
    2,
    103,
    '2025-05-01',
    '2025-05-15',
    '2025-05-18',
    NULL,
    'activa'
);

UPDATE rhabitaciones
SET disponible='N'
WHERE idhabitacion=103;

INSERT INTO rreservas VALUES
(
    4,
    105,
    '2025-05-10',
    '2025-06-01',
    '2025-06-05',
    NULL,
    'activa'
);

UPDATE rhabitaciones
SET disponible='N'
WHERE idhabitacion=105;

INSERT INTO rreservas VALUES
(
    1,
    101,
    '2025-05-20',
    '2025-05-25',
    '2025-05-27',
    NULL,
    'activa'
);

UPDATE rhabitaciones
SET disponible='N'
WHERE idhabitacion=101;