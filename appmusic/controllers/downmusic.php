<?php
    include_once "../controllers/gestionSesiones.php";
    
    echo "<pre> SESSION: <br>";
    print_r($_SESSION['usuario']);
    echo "</pre>";

    include_once "../controllers/error.php";

    include_once "../db/conexionBBDD.php";
    $conn = conexionBBDD();

    include_once "../models/obtenerCanciones.php";
    $canciones = obtenerCanciones($conn);

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_POST['añadir'])) {
        $trackData = explode("|", $_POST['canciones']);
        if (count($trackData) === 3) {
            $track = [
                'TrackId' => $trackData[0],
                'Name' => $trackData[1],
                'UnitPrice' => $trackData[2],
                'quantity' => 1
            ];

            $exists = false;
            foreach ($_SESSION['carrito'] as &$existingTrack) {
                if ($existingTrack['TrackId'] === $trackData[0]) {
                    $existingTrack['quantity']++;
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $_SESSION['carrito'][] = $track;
            }

        } else { 
            trigger_error("Datos de la canción no válidos", E_USER_WARNING);
        }
    }

    $totalPrice = 0;
    foreach ($_SESSION['carrito'] as $track) {
        $totalPrice += $track['UnitPrice'] * $track['quantity'];
    }

    // Compra con Redsys
    if (isset($_POST['comprar']) && $totalPrice != 0) {
        include_once "../apiRedsys/apiRedsys.php";
        $miObj = new RedsysAPI;

        $fuc="263100000";
        $terminal="42";
        $moneda="978";
        $trans="0";
        $url="";
        $urlOK="http://localhost/appmusic/controllers/pago_correcto.php";
        $urlKO = "http://localhost/appmusic/controllers/pago_fallido.php";
        $id=time();
        $amount = $totalPrice*100;

        $miObj->setParameter("DS_MERCHANT_AMOUNT", $amount);
        $miObj->setParameter("DS_MERCHANT_ORDER", $id);
        $miObj->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
        $miObj->setParameter("DS_MERCHANT_CURRENCY", $moneda);
        $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
        $miObj->setParameter("DS_MERCHANT_TERMINAL", $terminal);
        $miObj->setParameter("DS_MERCHANT_MERCHANTURL", $url);
        $miObj->setParameter("DS_MERCHANT_URLOK", $urlOK);
        $miObj->setParameter("DS_MERCHANT_URLKO", $urlKO);

        //Datos de configuración
        $version="HMAC_SHA256_V1";
        $kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';

        //Se generan los parámetros de la petición
        $request = "";
        $params = $miObj->createMerchantParameters();
        $signature = $miObj->createMerchantSignature($kc);

        //Creamos una sesion nueva con el precioTotal para usarla en confirmar_compra.php
        $_SESSION['totalPrice'] = $totalPrice;

        ?>

        <form style="opacity: 0" id="formu" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST" >
            Ds_Merchant_SignatureVersion <input type="text" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/></br>
            Ds_Merchant_MerchantParameters <input type="text" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/></br>
            Ds_Merchant_Signature <input type="text" name="Ds_Signature" value="<?php echo $signature; ?>"/></br>
            <input type="submit" value="Enviar" >
        </form>

        <script type="text/javascript">
            document.getElementById('formu').submit();
        </script>
        <?php

    }

    if(isset($_POST['vaciar'])){
        $_SESSION['carrito'] = [];
        $totalPrice = 0;
    }

    include_once "../views/formDownmusic.php";

    $conn = null;
?>