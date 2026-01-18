<?php
session_start();

if (!isset($_SESSION['customerNumber'])) {
    header("Location: pe_logout.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de la web de pedidos</title>
</head>

<body>
    <div>
        <h1>Bienvenido</h1>

        <nav>
            <a href="pe_altaped.php">Realizar pedido</a>
            <br>
            <a href="pe_consped.php">Consultar pedidos</a>
            <br>
            <a href="pe_consprodstock.php">Consultar stock disponible</a>
            <br>
            <a href="pe_constock.php">Consultar stock total de una determinada linea de productos</a>
            <br>
            <a href="pe_topprod.php">Consultar unidades vendidas</a>
            <br>
            <a href="pe_conspago.php">Consultar pagos</a>
        </nav>
        <br>
        <br>
        <li>
            <a href="pe_logout.php">Cerrar sesión</a>
        </li>
    </div>
</body>

</html>