<?php
    include_once "../controllers/gestionSesiones.php";
    include_once "../controllers/error.php";

    include_once "../db/conexionBBDD.php";
    $conn = conexionBBDD();

    include_once "../models/obtenerClasesDisponibles.php";
    $clases = obtenerClasesDisponibles($conn);

    // Inicializar cesta en sesión si no existe
    if (!isset($_SESSION['cesta'])) {
        $_SESSION['cesta'] = [];
    }

    // Botón Agregar a Cesta
    if (isset($_POST['agregar'])) {
        $datos = explode("|", $_POST['clases']);

        if (count($datos) === 3) {
            $idclase = $datos[0];
            $nombre  = $datos[1];
            $precio  = $datos[2];

            if (count($_SESSION['cesta']) >= 3) {
                trigger_error("La cesta ya tiene el máximo de 3 clases.", E_USER_WARNING);
            } else {
                $yaEnCesta = false;
                foreach ($_SESSION['cesta'] as $item) {
                    if ($item['idclase'] === $idclase) {
                        $yaEnCesta = true;
                        break;
                    }
                }

                if ($yaEnCesta) {
                    trigger_error("Esta clase ya está en la cesta.", E_USER_WARNING);
                } else {
                    $_SESSION['cesta'][] = [
                        'idclase' => $idclase,
                        'nombre'  => $nombre,
                        'precio'  => $precio
                    ];
                }
            }
        } else {
            trigger_error("Datos de la clase no válidos.", E_USER_WARNING);
        }
    }

    // Botón Vaciar Cesta
    if (isset($_POST['vaciar'])) {
        $_SESSION['cesta'] = [];
    }

    // Botón Confirmar Reserva
    if (isset($_POST['confirmar'])) {
        if (empty($_SESSION['cesta'])) {
            trigger_error("La cesta está vacía.", E_USER_WARNING);
        } else {
            $idsocio = $_SESSION['cliente']['idsocio'];

            include_once "../models/contarReservasActivas.php";
            $activas = contarReservasActivas($conn, $idsocio);

            if ($activas + count($_SESSION['cesta']) > 3) {
                trigger_error("No puede tener más de 3 clases reservadas. Actualmente tiene " . $activas . " activa/s.", E_USER_WARNING);
            } else {
                include_once "../models/insertarReserva.php";

                try {
                    $conn->beginTransaction();

                    foreach ($_SESSION['cesta'] as $item) {
                        insertarReserva($conn, $idsocio, $item['idclase'], $item['precio']);
                        incrementarAforo($conn, $item['idclase']);
                    }

                    $conn->commit();
                    $_SESSION['cesta'] = [];
                    echo "<p style='color:green'><b>Reserva realizada correctamente.</b></p>";

                } catch (PDOException $e) {
                    $conn->rollBack();
                    trigger_error("Error al realizar la reserva: " . $e->getMessage(), E_USER_ERROR);
                }

                // Recargar clases disponibles tras la reserva
                $clases = obtenerClasesDisponibles($conn);
            }
        }
    }

    include_once "../views/formReservar.php";

    $conn = null;
?>
