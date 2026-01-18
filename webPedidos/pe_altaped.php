<?php
    session_start();
    include 'funciones/pe_funciones.php';

    if (!isset($_SESSION['customerNumber'])) {
        header("Location: pe_logout.php");
        exit();
    }

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    // Agregar productos al carrito
    if (isset($_POST['agregar'])) {
        $productCode = limpiar_campo($_POST['productCode']);
        $quantity = limpiar_campo($_POST['quantity']);
        agregarProd($productCode, $quantity);
    }

    // Eliminar producto del carrito
    if (isset($_POST['eliminar'])) {
        $botonEliminar = $_POST['productCodeToRemove'];
        eliminarProductoDelCarrito($botonEliminar);
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Pedido</title>
</head>

<body>
    <h1>Realizar Pedido</h1>
    <form method="POST" action="pe_altaped.php">
        <label for="productCode">Producto:</label>
        <select name="productCode" required>
            <?php
                $sql = "SELECT productCode, productName FROM products WHERE quantityInStock > 0";
                imprimirOpciones($sql, 'productCode', 'productName');
            ?>
        </select>
        <br>
        <label for="quantity">Cantidad:</label>
        <input type="number" name="quantity" min="1" required><br>
        <input type="submit" name="agregar" value="Agregar al carrito">
    </form>

    <h2>Carrito de Compras</h2>
    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Acción</th>
        </tr>
        <?php
            $conn = conexionBBDD();

            mostrarCarrito();
        ?>
    </table>

    <h3>Realizar Pedido</h3>
    <form method="POST">
        <label for="checkNumber">Número de Pago:</label>
        <input type="text" name="checkNumber" required>
        <br>
        <label for="requiredDate">Fecha de Solicitud:</label>
        <input type="date" name="requiredDate" required>
        <br>
        <input type="submit" name="realizar_pedido" value="Confirmar Pedido">
    </form>

    <a href="pe_inicio.php">Volver a inicio</a>

    <?php
        if (isset($_POST['realizar_pedido'])){
            realizarPedido($conn);
        }
    ?>
</body>

</html>