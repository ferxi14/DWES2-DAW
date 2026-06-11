<?php

include_once "gestionSesiones.php";

include_once "../db/conexionBBDD.php";
$conn = conexionBBDD();

include_once "../models/gestionDevoluciones.php";

$idusuario = $_SESSION['usuario']['idusuario'];

if (isset($_POST['devolver'])) {

    $idpelicula = $_POST['idpelicula'];

    try {

        $conn->beginTransaction();

        devolverAlquiler($conn, $idusuario, $idpelicula);

        marcarPeliculaDisponible($conn, $idpelicula);

        restarAlquilerActivo($conn, $idusuario);

        $conn->commit();

    } catch (PDOException $e) {

        $conn->rollBack();

        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}

if (isset($_POST['renovar'])) {

    $idpelicula = $_POST['idpelicula'];

    $renovado = $_POST['renovado'];
    $fechaLimite = $_POST['fecha_limite'];

    if ($renovado == 'N' && date('Y-m-d') <= $fechaLimite) {
        renovarAlquiler($conn, $idusuario, $idpelicula);

    } else {

        trigger_error(
            "No se puede renovar",
            E_USER_WARNING
        );
    }
}

$alquileres = obtenerAlquileresActivos($conn, $idusuario);

include_once "../views/formDevolver.php";

$conn = null;