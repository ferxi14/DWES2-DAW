-- Creación de la base de datos
DROP DATABASE IF EXISTS concesionario;
CREATE DATABASE IF NOT EXISTS concesionario;
USE concesionario;

-- Tabla Clientes 
CREATE TABLE Clientes (
    dni VARCHAR(10) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE,
    email VARCHAR(255) NOT NULL,
    clave VARCHAR(100) NOT NULL,
    PRIMARY KEY (dni)
) ENGINE=InnoDB;


-- Tabla Vehiculos
CREATE TABLE Vehiculos (
    num_bastidor VARCHAR(50) NOT NULL,
    matricula VARCHAR(20) NOT NULL,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    kms INT,
    precio_vehiculo DECIMAL(10,2) NOT NULL,
    descuento DECIMAL(10,2),
    fecha_venta DATE,
    PRIMARY KEY (num_bastidor)
	
) ENGINE=InnoDB;

-- Tabla Pedido (actualizada para referenciar a Empleados mediante dni_empleado)
CREATE TABLE Pedidos (
    num_pedido INT NOT NULL AUTO_INCREMENT,
    dni VARCHAR(10) NOT NULL,
    fecha_venta DATE,
    importe_total DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (num_pedido),
    FOREIGN KEY (dni) REFERENCES Clientes(dni)
) ENGINE=InnoDB;

-- Tabla LineasPedido
CREATE TABLE LineasPedido (
    num_pedido INT NOT NULL,
    num_linea INT NOT NULL,
    num_bastidor VARCHAR(50) NOT NULL,
    precio_vehiculo DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (num_pedido, num_linea),
    FOREIGN KEY (num_pedido) REFERENCES Pedidos(num_pedido),
    FOREIGN KEY (num_bastidor) REFERENCES Vehiculos(num_bastidor)
) ENGINE=InnoDB;


USE concesionario;

-- Insertar datos en Clientes
INSERT INTO Clientes (dni, nombre, apellidos, fecha_nacimiento, email,clave) VALUES
('12345678A', 'Juan', 'Perez', '1980-05-15', 'juan.perez@example.com','APerez'),
('23456789B', 'Ana', 'Garcia', '1990-08-20', 'ana.garcia@example.com', 'BGarcia'),
('34567890C', 'Luis', 'Martinez', '1975-12-30', 'luis.martinez@example.com','CMartinez');


-- Insertar datos en Vehiculos 
INSERT INTO Vehiculos (num_bastidor, matricula, marca, modelo, kms, precio_vehiculo,descuento,fecha_venta) VALUES
('BAS12345', 'ABC123', 'Toyota', 'Corolla', 50000, 15000.00, 500.00,'2025-02-01'),
('BAS23456', 'DEF456', 'Honda', 'Civic', 30000, 18000.00, 1000.00,'2025-02-01'),
('BAS34567', 'GHI789', 'Ford', 'Focus', 40000, 17000.00, 0.00, null),
('BAS45678', 'JKL012', 'Chevrolet', 'Cruze', 60000, 16000.00,3000.00, null),
('BAS56789', 'MNO345', 'BMW', '3 Series', 25000, 35000.00,2000.00, null),
('BAS67890', 'PQR678', 'Audi', 'A4', 30000, 33000.00,0.00, null),
('BAS78901', 'STU901', 'Mercedes', 'C-Class', 20000, 40000.00,0.00, '2025-02-05');

-- Insertar datos en Pedido 
INSERT INTO Pedidos (num_pedido, dni, fecha_venta, importe_total) VALUES
(1, '12345678A', '2025-02-01', 31500.00),
(2, '23456789B', '2025-02-05', 40000.00);

-- Insertar datos en LineasPedido
INSERT INTO LineasPedido (num_pedido, num_linea, num_bastidor, precio_vehiculo) VALUES
(1, 1, 'BAS12345', 14500.00),
(1, 2, 'BAS23456', 17000.00),
(2, 1, 'BAS78901', 40000.00);


