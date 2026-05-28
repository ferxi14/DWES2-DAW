-- ============================================================
--  GYMNET - Script de creación de Base de Datos
--  Ejecutar en MySQL/MariaDB antes de usar la aplicación
-- ============================================================

DROP DATABASE IF EXISTS gymnet;
CREATE DATABASE gymnet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gymnet;

-- ── TABLA RSOCIOS ─────────────────────────────────────────────
CREATE TABLE rsocios (
    idsocio          INT          NOT NULL AUTO_INCREMENT,
    nombre           VARCHAR(50)  NOT NULL,
    apellido         VARCHAR(50)  NOT NULL,
    email            VARCHAR(100) NOT NULL UNIQUE,
    fecha_alta       DATE         NOT NULL DEFAULT (CURDATE()),
    fecha_baja       DATE         DEFAULT NULL,
    saldo_pendiente  DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (idsocio)
);

-- ── TABLA RCLASES ─────────────────────────────────────────────
CREATE TABLE rclases (
    idclase          INT          NOT NULL AUTO_INCREMENT,
    nombre           VARCHAR(100) NOT NULL,
    descripcion      VARCHAR(200) DEFAULT NULL,
    monitor          VARCHAR(100) NOT NULL,
    dia_semana       VARCHAR(20)  NOT NULL,
    hora_inicio      TIME         NOT NULL,
    duracion_min     SMALLINT     NOT NULL,
    aforo_maximo     TINYINT      NOT NULL DEFAULT 10,
    aforo_actual     TINYINT      NOT NULL DEFAULT 0,
    precio           DECIMAL(6,2) NOT NULL,
    activa           CHAR(1)      NOT NULL DEFAULT 'S',
    PRIMARY KEY (idclase)
);

-- ── TABLA RRESERVAS ───────────────────────────────────────────
CREATE TABLE rreservas (
    idsocio          INT          NOT NULL,
    idclase          INT          NOT NULL,
    fecha_reserva    DATETIME     NOT NULL DEFAULT NOW(),
    fecha_cancelacion DATETIME    DEFAULT NULL,
    fechahorapago    DATETIME     DEFAULT NULL,
    precio_pagado    DECIMAL(6,2) DEFAULT NULL,
    PRIMARY KEY (idsocio, idclase),
    FOREIGN KEY (idsocio) REFERENCES rsocios(idsocio),
    FOREIGN KEY (idclase) REFERENCES rclases(idclase)
);

-- ── DATOS DE PRUEBA ───────────────────────────────────────────

INSERT INTO rsocios (nombre, apellido, email, fecha_alta) VALUES
    ('Carlos',  'Ruiz',      'carlos.ruiz@gymnet.es',     '2024-01-10'),
    ('Maria',   'Lopez',     'maria.lopez@gymnet.es',     '2024-02-05'),
    ('Pedro',   'Garcia',    'pedro.garcia@gymnet.es',    '2024-03-20'),
    ('Laura',   'Martinez',  'laura.martinez@gymnet.es',  '2024-04-15'),
    ('Ana',     'Sanchez',   'ana.sanchez@gymnet.es',     '2024-05-01');

-- Socio dado de baja (para probar el login)
INSERT INTO rsocios (nombre, apellido, email, fecha_alta, fecha_baja) VALUES
    ('Juan',    'Baja',      'juan.baja@gymnet.es',       '2023-01-01', '2024-01-01');

-- Socio con saldo pendiente (para probar el login)
INSERT INTO rsocios (nombre, apellido, email, fecha_alta, saldo_pendiente) VALUES
    ('Sara',    'Deuda',     'sara.deuda@gymnet.es',      '2024-01-01', 15.00);

INSERT INTO rclases (nombre, descripcion, monitor, dia_semana, hora_inicio, duracion_min, aforo_maximo, aforo_actual, precio, activa) VALUES
    ('Yoga',          'Clase de relajación y flexibilidad',  'Elena Vega',   'Lunes',    '09:00:00', 60, 12, 3,  10.00, 'S'),
    ('Spinning',      'Ciclismo indoor de alta intensidad',  'Marcos Gil',   'Martes',   '18:00:00', 45, 15, 8,  12.00, 'S'),
    ('Pilates',       'Trabajo de core y postura',           'Sofia Mora',   'Miércoles','10:00:00', 60, 10, 2,  10.00, 'S'),
    ('Zumba',         'Baile y cardio latino',               'Ana Torres',   'Jueves',   '19:00:00', 55, 20, 5,  8.00,  'S'),
    ('CrossFit',      'Entrenamiento funcional intenso',     'Iván Roca',    'Viernes',  '07:00:00', 60, 8,  7,  15.00, 'S'),
    ('Natación',      'Clases de técnica y resistencia',     'Laura Nieto',  'Sábado',   '11:00:00', 45, 6,  6,  12.00, 'S'),
    ('Meditación',    'Mindfulness y respiración',           'Elena Vega',   'Domingo',  '10:00:00', 30, 15, 0,  8.00,  'S'),
    ('Boxeo',         'Técnica y acondicionamiento',         'Roberto Cruz', 'Lunes',    '20:00:00', 60, 10, 0,  14.00, 'S'),
    ('Body Pump',     'Clase de fuerza con barras',          'Marcos Gil',   'Miércoles','19:00:00', 60, 20, 1,  10.00, 'S'),
    ('GAP',           'Glúteos, abdomen y piernas',          'Sofia Mora',   'Viernes',  '18:00:00', 45, 18, 0,  9.00,  'S'),
    ('Stretching',    'Clase de estiramientos globales',     'Ana Torres',   'Martes',   '09:00:00', 40, 12, 0,  7.00,  'S'),
    ('HIIT',          'Entrenamiento en intervalos',         'Iván Roca',    'Jueves',   '07:00:00', 30, 10, 9,  13.00, 'N'); -- Clase inactiva

-- Reservas de Carlos (idsocio=1): ya tiene 2 activas
INSERT INTO rreservas (idsocio, idclase, fecha_reserva, fechahorapago, precio_pagado) VALUES
    (1, 1, '2025-05-01 10:00:00', '2025-05-01 10:01:00', 10.00),
    (1, 4, '2025-05-03 12:00:00', '2025-05-03 12:01:00', 8.00);

-- Reserva cancelada (historial)
INSERT INTO rreservas (idsocio, idclase, fecha_reserva, fecha_cancelacion) VALUES
    (1, 2, '2025-04-10 09:00:00', '2025-04-11 08:00:00');
