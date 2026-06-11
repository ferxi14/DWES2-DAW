<?php

include_once "../controllers/error.php";
include_once "../controllers/gestionSesiones.php";

if (!isset($_SESSION['cliente'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['submit'])) {

    $idhabitacion = trim($_POST['idhabitacion']);
    $fecha_reserva = trim($_POST['fecha_reserva']);
    $idcliente = $_SESSION['cliente']['idcliente'];

    include_once '../db/conexionBBDD.php';
    $conn = conexionBBDD();

    include_once '../models/gestionDevoluciones.php';
    $resultado = cancelarReserva($conn, $idcliente, $idhabitacion, $fecha_reserva);

    if ($resultado) {
        trigger_error("Reserva cancelada correctamente", E_USER_NOTICE);
    } else {
        trigger_error("Error al cancelar la reserva", E_USER_WARNING);
    }
}

include_once '../db/conexionBBDD.php';
$conn = conexionBBDD();

include_once '../models/obtenerReservas.php';
$idcliente = $_SESSION['cliente']['idcliente'];
$reservas = obtenerReservas($conn, $idcliente);

include_once "../views/formCancelar.php";

$conn = null;

?>