# GymNet - Ejemplo de referencia MVC PHP

Aplicación web de gestión de reservas de clases para un gimnasio.
Implementada con arquitectura **MVC** en PHP puro (sin clases, sin frameworks).

## Credenciales de prueba

| Email | Clave (idsocio) | Situación |
|---|---|---|
| carlos.ruiz@gymnet.es | 1 | Acceso normal, 2 reservas activas |
| maria.lopez@gymnet.es | 2 | Acceso normal, sin reservas |
| juan.baja@gymnet.es | 6 | ❌ Dado de baja |
| sara.deuda@gymnet.es | 7 | ❌ Saldo pendiente |

## Estructura de ficheros

```
gymnet/
├── index.php                        ← Punto de entrada (include login)
├── db/
│   └── conexionBBDD.php             ← función conexionBBDD() con PDO
├── controllers/
│   ├── error.php                    ← set_error_handler
│   ├── gestionSesiones.php          ← session_start() + protección
│   ├── logout.php                   ← destruir sesión
│   ├── login.php                    ← validar email + idsocio
│   ├── inicio.php                   ← menú principal
│   ├── reservar.php                 ← cesta + confirmar reserva
│   ├── cancelar.php                 ← cancelar reserva activa
│   └── consultar.php                ← historial por fechas
├── models/
│   ├── obtenerSocio.php             ← SELECT login
│   ├── obtenerClasesDisponibles.php ← SELECT clases con aforo libre
│   ├── contarReservasActivas.php    ← COUNT reservas activas
│   ├── insertarReserva.php          ← INSERT + incrementar aforo
│   ├── obtenerReservasActivas.php   ← SELECT para cancelar
│   ├── cancelarReserva.php          ← UPDATE fecha_cancelacion + decrementar aforo
│   └── obtenerReservasFechas.php    ← SELECT historial por fechas
├── views/
│   ├── formLogin.php
│   ├── formInicio.php
│   ├── formReservar.php             ← cesta con sesión
│   ├── formCancelar.php
│   └── formConsultar.php            ← tabla de resultados
├── css/
│   └── bootstrap.min.css
└── sql/
    └── gymnet.sql                   ← crear BD + datos de prueba
```

## Base de datos

```
RSOCIOS        → idsocio, nombre, apellido, email, fecha_baja, saldo_pendiente
RCLASES        → idclase, nombre, monitor, dia_semana, hora_inicio, aforo_maximo, aforo_actual, precio, activa
RRESERVAS      → idsocio (PK), idclase (PK), fecha_reserva, fecha_cancelacion, fechahorapago, precio_pagado
```

## Patrón que se repite en todos los controladores

```php
<?php
    include_once "../controllers/gestionSesiones.php"; // protección
    include_once "../controllers/error.php";

    include_once "../db/conexionBBDD.php";
    $conn = conexionBBDD();

    include_once "../models/miModelo.php";
    $datos = miFuncion($conn, ...);

    if (!isset($_SESSION['cesta'])) $_SESSION['cesta'] = [];

    if (isset($_POST['agregar']))   { /* añadir a cesta */ }
    if (isset($_POST['vaciar']))    { $_SESSION['cesta'] = []; }
    if (isset($_POST['confirmar'])) {
        $conn->beginTransaction();
        foreach ($_SESSION['cesta'] as $item) { insertar...; actualizar...; }
        $conn->commit(); // o rollBack() en el catch
        $_SESSION['cesta'] = [];
    }

    include_once "../views/miVista.php"; // SIEMPRE al final
    $conn = null;
?>
```

## Lo específico de este ejercicio

- **Login**: comprueba `fecha_baja` Y `saldo_pendiente > 0`
- **Reservar**: cesta con sesión, máx. 3 reservas activas simultáneas, incrementa `aforo_actual`
- **Cancelar**: UPDATE `fecha_cancelacion = NOW()` + decrementa `aforo_actual`
- **Consultar**: filtra por `DATE(fecha_reserva)` entre dos fechas, ordenado ASC
