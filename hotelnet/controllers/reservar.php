<?php

include_once "../controllers/error.php";
include_once "../controllers/gestionSesiones.php";

if (!isset($_SESSION['cliente'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['submit'])) {

    $idhabitacion = trim($_POST['idhabitacion']);
    $fecha_entrada = trim($_POST['fecha_entrada']);
    $fecha_salida = trim($_POST['fecha_salida']);
    $idcliente = $_SESSION['cliente']['idcliente'];

    include_once '../db/conexionBBDD.php';
    $conn = conexionBBDD();

    include_once '../models/insertarReserva.php';
    $resultado = insertarReserva($conn, $idcliente, $idhabitacion, $fecha_entrada, $fecha_salida);

    if ($resultado) {
        trigger_error("Reserva realizada correctamente", E_USER_NOTICE);
    } else {
        trigger_error("Error al realizar la reserva", E_USER_WARNING);
    }
}

include_once '../db/conexionBBDD.php';
$conn = conexionBBDD();

include_once '../models/obtenerHabitaciones.php';
$habitaciones = obtenerHabitaciones($conn);

include_once "../views/formReservar.php";

$conn = null;

?>