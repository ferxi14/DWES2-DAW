<?php
include_once "../controllers/gestionSesiones.php";
include_once "../controllers/error.php";

if (isset($_POST['mostrar'])) {
    $inicio = $_POST['inicio'];
    $fin = $_POST['fin'];

    if ($inicio > $fin) {
        trigger_error("La fecha de inicio no puede ser posterior a la fecha de fin.", E_USER_WARNING);
    }

    include_once "../db/conexionBBDD.php";
    $conn = conexionBBDD();

    include_once "../models/obtenerRanking.php";
    $ranking = obtenerRanking($conn, $inicio, $fin);

    if(!$ranking) {
        trigger_error("No hay canciones descargadas entre esas fechas", E_USER_WARNING);
    }
}

include_once "../views/formRanking.php";

$conn = null;
?>