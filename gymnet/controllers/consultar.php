<?php
    include_once "../controllers/gestionSesiones.php";
    include_once "../controllers/error.php";

    if (isset($_POST['consultar'])) {
        $inicio = $_POST['fechadesde'];
        $fin    = $_POST['fechahasta'];

        if ($inicio > $fin) {
            trigger_error("La fecha de inicio no puede ser posterior a la fecha de fin.", E_USER_WARNING);
        } else {
            include_once "../db/conexionBBDD.php";
            $conn = conexionBBDD();

            include_once "../models/obtenerReservasFechas.php";
            $reservas = obtenerReservasFechas($conn, $_SESSION['cliente']['idsocio'], $inicio, $fin);

            if (empty($reservas)) {
                trigger_error("No hay reservas entre esas fechas.", E_USER_WARNING);
            }

            $conn = null;
        }
    }

    include_once "../views/formConsultar.php";
?>
