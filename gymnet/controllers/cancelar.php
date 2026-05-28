<?php
    include_once "../controllers/gestionSesiones.php";
    include_once "../controllers/error.php";

    include_once "../db/conexionBBDD.php";
    $conn = conexionBBDD();

    $idsocio = $_SESSION['cliente']['idsocio'];

    include_once "../models/obtenerReservasActivas.php";
    $reservas = obtenerReservasActivas($conn, $idsocio);

    // Botón Cancelar Reserva
    if (isset($_POST['cancelar'])) {
        $idclase = $_POST['reservas'];

        if (empty($idclase)) {
            trigger_error("Selecciona una clase para cancelar.", E_USER_WARNING);
        } else {
            include_once "../models/cancelarReserva.php";

            try {
                $conn->beginTransaction();

                cancelarReserva($conn, $idsocio, $idclase);
                decrementarAforo($conn, $idclase);

                $conn->commit();
                echo "<p style='color:green'><b>Reserva cancelada correctamente.</b></p>";

            } catch (PDOException $e) {
                $conn->rollBack();
                trigger_error("Error al cancelar la reserva: " . $e->getMessage(), E_USER_ERROR);
            }

            // Recargar reservas tras la cancelación
            $reservas = obtenerReservasActivas($conn, $idsocio);
        }
    }

    include_once "../views/formCancelar.php";

    $conn = null;
?>
