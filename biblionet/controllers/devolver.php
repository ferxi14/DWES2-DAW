<?php
    include_once "../controllers/gestionSesiones.php";
    include_once "../controllers/error.php";

    include_once "../db/conexionBBDD.php";
    $conn = conexionBBDD();

    $idusuario = $_SESSION['cliente']['idusuario'];

    include_once "../models/obtenerPrestamosActivos.php";
    $prestamos = obtenerPrestamosActivos($conn, $idusuario);

    // Botón Devolver
    if (isset($_POST['devolver'])) {
        $isbn = $_POST['prestamo'];

        include_once "../models/registrarDevolucion.php";

        try {
            $conn->beginTransaction();

            registrarDevolucion($conn, $idusuario, $isbn);
            marcarLibroDisponible($conn, $isbn);

            // Decrementar prestamos_activos en BD y sesión
            $activos = $_SESSION['cliente']['prestamos_activos'] - 1;
            actualizarPrestamosActivosDevolver($conn, $idusuario, $activos);
            $_SESSION['cliente']['prestamos_activos'] = $activos;

            $conn->commit();
            echo "<p style='color:green'><b>Libro devuelto correctamente.</b></p>";

        } catch (PDOException $e) {
            $conn->rollBack();
            trigger_error("Error al devolver el libro: " . $e->getMessage(), E_USER_ERROR);
        }

        // Recargar lista de préstamos
        $prestamos = obtenerPrestamosActivos($conn, $idusuario);
    }

    // Botón Renovar
    if (isset($_POST['renovar'])) {
        $isbn = $_POST['prestamo'];

        include_once "../models/renovarPrestamo.php";
        $prestamo = obtenerDatosPrestamo($conn, $idusuario, $isbn);

        if ($prestamo['renovado'] === 'S') {
            trigger_error("Este préstamo ya ha sido renovado anteriormente. No se puede renovar de nuevo.", E_USER_WARNING);
        } elseif ($prestamo['fecha_limite'] < date('Y-m-d')) {
            trigger_error("El préstamo está vencido y no puede renovarse.", E_USER_WARNING);
        } else {
            try {
                $conn->beginTransaction();
                renovarPrestamo($conn, $idusuario, $isbn);
                $conn->commit();
                echo "<p style='color:green'><b>Préstamo renovado. Nueva fecha límite: "
                    . date('d/m/Y', strtotime($prestamo['fecha_limite'] . ' +14 days'))
                    . "</b></p>";
            } catch (PDOException $e) {
                $conn->rollBack();
                trigger_error("Error al renovar el préstamo: " . $e->getMessage(), E_USER_ERROR);
            }
        }

        // Recargar lista de préstamos
        $prestamos = obtenerPrestamosActivos($conn, $idusuario);
    }

    include_once "../views/formDevolver.php";

    $conn = null;
?>
