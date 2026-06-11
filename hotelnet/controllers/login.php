<?php

include_once "../controllers/error.php";

if (isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $clave = trim($_POST['password']);

    include_once 'db/conexionBBDD.php';
    $conn = conexionBBDD();

    include_once 'models/obtenerCliente.php';
    $cliente = obtenerCliente($conn, $email, $clave);

    if (!empty($cliente)) {

        if ($cliente['fecha_baja'] != null) {

            trigger_error("Cliente dado de baja", E_USER_WARNING);

        } else {

            session_start();

            $_SESSION['cliente'] = $cliente;

            header("Location: controllers/inicio.php");
            exit();
        }

    } else {

        trigger_error("Email o contraseña incorrectos", E_USER_WARNING);
    }
}

include_once "views/formLogin.php";

$conn = null;

?>