<?php

include_once "gestionSesiones.php";

include_once "../db/conexionBBDD.php";
$conn = conexionBBDD();

$alquileres = [];

if(isset($_POST['consultar'])){

    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];

    include_once "../models/obtenerAlquileres.php";

    $alquileres = obtenerAlquileres(
        $conn,
        $_SESSION['usuario']['idusuario'],
        $desde,
        $hasta
    );
}

include_once "../views/formConsultar.php";

$conn = null;