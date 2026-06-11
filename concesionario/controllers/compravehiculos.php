<?php
    include_once "../controllers/gestionSesiones.php";
    include_once "../controllers/error.php";

    include_once "../db/conexionBBDD.php";
    $conn = conexionBBDD();

    include_once "../models/obtenerVehiculos.php";
    $vehiculos = obtenerVehiculos($conn);

    if (!isset($_SESSION['cesta'])) {
        $_SESSION['cesta'] = [];
    }

    if (isset($_POST['agregar'])) {
        $datos       = explode("|", $_POST['vehiculos']);
        $numBastidor = $datos[0];
        $matricula   = $datos[1];
        $nombre      = $datos[2];
        $precio      = $datos[3];
        $descuento   = $datos[4];
        $precioFinal = $precio - $descuento;
        
        $yaEnCesta = false;
        foreach ($_SESSION['cesta'] as $vehiculo) {
            if ($vehiculo['numBastidor'] == $numBastidor) {
                $yaEnCesta = true;
                break;
            }
        }

        if ($yaEnCesta) {
            trigger_error("Este vehiculo ya está en la cesta", E_USER_WARNING);
        } else {
            $_SESSION['cesta'][] = [
                'numBastidor' => $numBastidor,
                'matricula'   => $matricula, 
                'nombre'      => $nombre,
                'precio'      => $precio,
                'descuento'   => $descuento,
                'precioFinal' => $precioFinal
            ];
        }
    }

    if (isset($_POST['vaciar'])) {
        $_SESSION['cesta'] = [];
    }

    if (isset($_POST['pedido'])) {
        if (empty($_SESSION['cesta'])) {
            trigger_error ("La cesta esta vacia" , E_USER_WARNING);
        } else {
            $dni = $_SESSION['usuario']['dni'];

            // importe total
            $importeTotal = 0;
            foreach ($_SESSION['cesta'] as $vehiculo) {
                $importeTotal += $vehiculo['precioFinal'];
            }

            include_once "../models/insertarPedido.php";

            try {
                $conn->beginTransaction();

                $numPedido = insertarPedido($conn, $dni, $importeTotal);
                
                foreach ($_SESSION['cesta'] as $vehiculo) {
                    insertarLineaPedido($conn, $numPedido, $vehiculo['numBastidor'], $vehiculo['precioFinal']);
                    marcarVehiculoVendido($conn, $vehiculo['numBastidor']);
                }

                $conn->commit();

                $_SESSION['ultimo_pedido'] = [
                    'num_pedido'    => $numPedido,
                    'fecha_venta'   => date('Y-m-d'),
                    'importe_total' => $importeTotal
                ];

                $_SESSION['cesta'] = [];
                $vehiculos = obtenerVehiculos($conn);

            } catch (PDOException $e) {
                $conn->rollBack();
                trigger_error("Error al realizar la compra: " . $e->getMessage(), E_USER_ERROR);
            }
        }
    }

    if (isset($_POST['volver'])) {
        unset($_SESSION['ultimo_pedido']);
        header("Location: ../controllers/inicio.php");
        exit();
    }

    include_once "../views/formCompravehiculos.php";
    $conn = null;
?>