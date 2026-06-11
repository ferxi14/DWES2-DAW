<?php
    include_once "../controllers/gestionSesiones.php";
    include_once "../controllers/error.php";

    include_once "../db/conexionBBDD.php";
    $conn = conexionBBDD();

    $dni = $_SESSION['usuario']['dni'];

    include_once "../models/obtenerPedidos.php";
    $pedidos = obtenerPedidosCliente($conn, $dni);

    $lineas    = [];
    $pedidoSel = null;

    if (isset($_POST['consultar'])) {
        $numPedido = $_POST['pedidos'];
        $lineas    = obtenerLineasPedido($conn, $numPedido);

        foreach ($pedidos as $p) {
            if ($p['num_pedido'] == $numPedido) {
                $pedidoSel = $p;
                break;
            }
        }

        if (empty($lineas)) {
            trigger_error("No se encontraron líneas para ese pedido.", E_USER_WARNING);
        }
    }

    if (isset($_POST['volver'])) {
        header("Location: ../controllers/inicio.php");
        exit();
    }

    include_once "../views/formPedidos.php";
    $conn = null;
?>