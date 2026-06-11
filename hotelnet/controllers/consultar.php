<?php

include_once "../controllers/error.php";
include_once "../controllers/gestionSesiones.php";

if (!isset($_SESSION['cliente'])) {
    header("Location: ../index.php");
    exit();
}

$idcliente = $_SESSION['cliente']['idcliente'];

include_once '../db/conexionBBDD.php';
$conn = conexionBBDD();

include_once '../models/obtenerReservas.php';
$reservas = obtenerReservas($conn, $idcliente);

include_once "../views/formConsultar.php";

$conn = null;

?>