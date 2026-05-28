<?php
    include_once 'controllers/error.php';

    if (isset($_POST['submit'])) {
        $email   = trim($_POST['email']);
        $idsocio = trim($_POST['password']);

        include_once 'db/conexionBBDD.php';
        $conn = conexionBBDD();

        include_once 'models/obtenerSocio.php';
        $socio = obtenerSocio($conn, $email, $idsocio);

        if (!empty($socio)) {
            if ($socio['fecha_baja'] !== null) {
                trigger_error("Este socio ha sido dado de baja del gimnasio.", E_USER_WARNING);
            } elseif ($socio['saldo_pendiente'] > 0) {
                trigger_error("Tiene un saldo pendiente de " . number_format($socio['saldo_pendiente'], 2) . " €. Regularice su situación para acceder.", E_USER_WARNING);
            } else {
                session_start();
                $_SESSION['cliente'] = $socio;
                header("Location: controllers/inicio.php");
                exit();
            }
        } else {
            trigger_error("Email o clave incorrectos.", E_USER_WARNING);
        }

        $conn = null;
    }

    include_once 'views/formLogin.php';
?>
