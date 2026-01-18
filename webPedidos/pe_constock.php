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
        <title>Consultar stock total por linea de producto</title>
    </head>
    <body>
        <h2>Consultar stock total por línea de producto</h2>
        <form method ="POST">
            <label for="productLine">Seleccionar Línea de Producto:</label>
            <select name="productLine" required>
                <option value="">--Seleccione una línea de producto--</option>
                <?php
                    $conn = conexionBBDD();
                    
                    $sql = "SELECT DISTINCT productLine FROM products";
                    imprimirOpciones($sql, 'productLine', 'productLine');
                ?>
            </select>
            <br><br>
            <input type="submit" name="consultar" value="Consultar Stock">
        </form>

        <a href="pe_inicio.php">Volver al inicio</a>

        <?php
            if (isset($_POST['consultar'])) {
                $productLine = limpiar_campo($_POST['productLine']);

                $sql = "SELECT productName, quantityInStock FROM products WHERE productLine = :productLine ORDER BY quantityInStock DESC";
                $params = [':productLine' => $productLine];
                $resultado = ejecutarConsulta($sql, $params);
                
                if (!empty($resultado)) {
                    echo "<h3>Stock total para la línea de producto: " . htmlspecialchars($productLine) . "</h3>";
                    echo "<table border='1'>
                            <tr>
                                <th>Nombre del Producto</th>
                                <th>Cantidad en Stock</th>
                            </tr>";
                    foreach ($resultado as $fila) {
                        echo "<tr>
                                <td>" . htmlspecialchars($fila['productName']) . "</td>
                                <td>" . htmlspecialchars($fila['quantityInStock']) . "</td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No se encontraron productos para la línea seleccionada.</p>";
                }
            }
        ?>
    </body>
</html>