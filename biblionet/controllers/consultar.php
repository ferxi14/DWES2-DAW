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

            include_once "../models/obtenerPrestamosFechas.php";
            $prestamos = obtenerPrestamosFechas($conn, $_SESSION['cliente']['idusuario'], $inicio, $fin);

            if (empty($prestamos)) {
                trigger_error("No hay préstamos entre esas fechas.", E_USER_WARNING);
            }

            $conn = null;
        }
    }

    include_once "../views/formConsultar.php";
?>
