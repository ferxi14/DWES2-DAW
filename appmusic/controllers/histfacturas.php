<?php
include_once "../controllers/gestionSesiones.php";
include_once "../controllers/error.php";

if(isset($_POST['mostrar'])) {
    include_once "../db/conexionBBDD.php";
    $conn = conexionBBDD();

    include_once "../models/obtenerInvoice.php";
    $invoices = obtenerInvoice($conn);
}

include_once "../views/formHistFacturas.php";
$conn = null;
?>