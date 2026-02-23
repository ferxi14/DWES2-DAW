<?php include_once "../controllers/gestionSesiones.php"; ?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Historial de facturas entre dos fechas</title>
</head>

<body>
    <h1>Historial de facturas</h1>
    <form action="" method="post">
        Facturas realizadas entre
        <input type="date" name="inicio">
        Y
        <input type="date" name="fin">
        <br>
        <input type="submit" name="mostrar" value="Mostrar historial de facturas">
        <br>
    </form>

    <?php if (!empty($invoices)) { ?>
        <table border="1">
            <thead>
                <th>InvoiceId</th>
                <th>InvoiceDate</th>
                <th>Total</th>
            </thead>
            <tbody>
                <?php
                foreach ($invoices as $factura) {
                    echo "<tr>";
                    echo "<td>" . $factura['InvoiceId'] . "</td>";
                    echo "<td>" . $factura['InvoiceDate'] . "</td>";
                    echo "<td>" . $factura['Total'] . "€</td>";
                    echo "</tr>";
                }
    }
                ?>
            </tbody>
        </table>
    <br>
    <a href="../controllers/inicio.php">Volver a inicio</a>
    <a href="../controllers/logout.php">Cerrar sesión</a>
</body>

</html>