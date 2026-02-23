<?php
include_once "../controllers/gestionSesiones.php";
include_once "../controllers/error.php";

if(isset($_POST['mostrar'])){
    $inicio = $_POST['inicio'];
    $fin = $_POST['fin'];

    if ($inicio > $fin) {
        trigger_error("La fecha de inicio no puede ser posterior a la fecha de fin.", E_USER_WARNING);
    }

    include_once "../db/conexionBBDD.php";
    $conn = conexionBBDD();

    include_once "../models/obtenerInvoiceFechas.php";
    $invoices = obtenerInvoiceFechas($conn, $inicio, $fin);
    if(empty($invoices))
        trigger_error("No hay facturas entre estas fechas", E_USER_WARNING);
    
    /*
    echo "<pre> SESSION: <br>";
    print_r($invoices);
    echo "</pre>";
    */
}

include_once "../views/formFacturas.php";

$conn = null;
?>