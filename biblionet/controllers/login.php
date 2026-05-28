<?php
include_once 'controllers/error.php';
/* En caso de que la validación sea correcta y el socio no se haya dado de baja se le permitirá el acceso a
la pantalla de welcome.php. En caso contrario, permanecerá en la pantalla de Login mostrando el
correspondiente mensaje de error. 
*/

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $idusuario = trim($_POST['password']);

    include_once 'db/conexionBBDD.php';
    $conn = conexionBBDD();

    include_once 'models/obtenerUsuario.php';
    $cliente = obtenerUsuario($conn, $email, $idusuario);

    if (!empty($cliente)) {

        if ($cliente['fecha_baja'] !== null) {
            trigger_error("Este usuario ha sido dado de baja.", E_USER_WARNING);

        } else {
            session_start();
            $_SESSION['cliente'] = $cliente;

            header("Location: controllers/welcome.php");
            exit();
        }

    } else {
        trigger_error("Email o clave incorrectos", E_USER_WARNING);
    }

    $conn = null;
}

include_once 'views/formLogin.php';
?>