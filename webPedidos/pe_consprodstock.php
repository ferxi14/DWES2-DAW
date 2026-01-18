<?php
    session_start();
    include 'funciones/pe_funciones.php';

    if (!isset($_SESSION['customerNumber'])) {
        header("Location: pe_login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Consultar stock de producto</title>
    </head>
    <body>
        <h2>Consultar stock de producto</h2>
        <form method="POST">
            <label for="productName">Seleccionar Producto:</label>
            <select name="productName" required>
                <option value="">--Seleccione un producto--</option>
                <?php
                    $conn = conexionBBDD();

                    // obtener los nombres de los productos
                    $sql = "SELECT productName FROM products";
                    imprimirOpciones($sql, 'productName', 'productName');
                ?>
            </select><br><br>
            <input type="submit" name="consultar" value="Consultar Stock">
        </form>

        <a href="pe_inicio.php">Volver al inicio</a>

        <?php
            if (isset($_POST['consultar'])) {
                $productName = limpiar_campo($_POST['productName']);

                $sql = "SELECT productName, quantityInStock FROM products WHERE productName = :productName";
                $params = [':productName' => $productName];
                $resultado = ejecutarConsulta($sql, $params);
                if (!empty($resultado)) {
                    echo "<h3>Stock del producto: " . htmlspecialchars($resultado[0]['productName']) . "</h3>";
                    echo "<p>Cantidad en stock: " . htmlspecialchars($resultado[0]['quantityInStock']) . "</p>";
                } else {
                    echo "<p>Producto no encontrado.</p>";
                }
            }
        ?>
    </body>
</html>