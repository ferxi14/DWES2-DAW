<?php
include_once "../controllers/gestionSesiones.php";
include_once "../apiRedsys/apiRedsys.php";
$miObj = new RedsysAPI;

if (!empty($_POST)) {		
    $version = $_POST["Ds_SignatureVersion"];
    $datos = $_POST["Ds_MerchantParameters"];
    $signatureRecibida = $_POST["Ds_Signature"];

    $decodec = $miObj->decodeMerchantParameters($datos);	
    $kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';
    $firma = $miObj->createMerchantSignatureNotif($kc,$datos);	

    if ($firma === $signatureRecibida){
        $response = $miObj->getParameter('Ds_Response');
        
        if ($response !== null && intval($response) >= 0 && intval($response) <= 99) {
            echo "Pago realizado con éxito";
        } else {
            echo "Pago cancelado o denegado";
        }
    } else {
        echo "FIRMA KO";
    }

} else {
    if (!empty($_GET)) {
        $version = $_GET["Ds_SignatureVersion"];
        $datos = $_GET["Ds_MerchantParameters"];
        $signatureRecibida = $_GET["Ds_Signature"];	

        $decodec = $miObj->decodeMerchantParameters($datos);
        $kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';
        $firma = $miObj->createMerchantSignatureNotif($kc,$datos);

        if ($firma === $signatureRecibida){
            $response = $miObj->getParameter('Ds_Response');
            
            // Solo guarda si el código indica éxito (0000-0099)
            if ($response !== null && intval($response) >= 0 && intval($response) <= 99) {
                
                include_once "../db/conexionBBDD.php";
                $conn = conexionBBDD();

                $customerId = $_SESSION['usuario']['CustomerId'];
                $totalPrice = $_SESSION['totalPrice'];
                $billingAddress = $_SESSION['usuario']['Address'];
                $billingCity = $_SESSION['usuario']['City'];
                $billingState = $_SESSION['usuario']['State'];
                $billingCountry = $_SESSION['usuario']['Country'];
                $billingPostalCode = $_SESSION['usuario']['PostalCode'];

                try {
                    $conn->beginTransaction();

                    include_once "../models/obtenerMaxId.php";
                    $invoiceId = obtenerMaxInvoiceId($conn);

                    include_once "../models/insertarInvoice.php";
                    insertarInvoice(
                        $conn, 
                        $invoiceId, 
                        $customerId, 
                        $billingAddress, 
                        $billingCity, 
                        $billingState, 
                        $billingCountry, 
                        $billingPostalCode, 
                        $totalPrice
                    );

                    $invoiceLineId = obtenerMaxInvoiceLineId($conn);

                    include_once "../models/insertarInvoiceLine.php";
                    foreach ($_SESSION['carrito'] as $item) {
                        insertarInvoiceLine($conn, $invoiceLineId, $invoiceId, $item['TrackId'], $item['UnitPrice'], $item['quantity']);
                        $invoiceLineId++;
                    }

                    $_SESSION['carrito'] = [];
                    $conn->commit();

                    echo "Pago realizado con exito";
                } catch (PDOException $e) {
                    $conn->rollBack();
                    trigger_error("Error al procesar la factura: " . $e->getMessage(), E_USER_ERROR);
                }
                $conn = null;
                
            } else {
                header("Location: pago_fallido.php?code=" . $response);
                exit;
            }
        } else {
            trigger_error("Firma KO", E_USER_NOTICE);
        }
    } else {
        die("No se recibió respuesta");
    }
}

$conn = null;
?>
<html>
    <body>
        <br><br><a href="../controllers/inicio.php">Volver al inicio</a><br><br>
    </body>
</html>