<?php

if (isset($_POST['submit'])) {

    $username = trim($_POST['username']);
    $clave = trim($_POST['password']);

    include_once 'db/conexionBBDD.php';
    $conn = conexionBBDD();

    include_once 'models/obtenerCliente.php';
    $cliente = obtenerCliente($conn, $username, $clave);

    if (!empty($cliente)) {

        if ($cliente['fecha_baja'] != null) {

            trigger_error("Usuario dado de baja", E_USER_WARNING);

        } else {

            session_start();

            $_SESSION['usuario'] = $cliente;

            header("Location: controllers/inicio.php");
            exit();
        }

    } else {

        trigger_error("Email o clave incorrectos", E_USER_WARNING);
    }
}

include_once "views/formLogin.php";

$conn = null;

?>