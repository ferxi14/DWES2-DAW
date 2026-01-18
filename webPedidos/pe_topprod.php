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
    <title>Productos Más Vendidos</title>
</head>
<body>
    <h2>Consultar Unidades Totales Vendidas por Producto</h2>
    <form method="POST">
        <label for="startDate">Fecha Inicio:</label>
        <input type="date" name="startDate" required>
        <br>
        <label for="endDate">Fecha Fin:</label>
        <input type="date" name="endDate" required>
        <br><br>
        <input type="submit" name="consultar" value="Consultar">
    </form>

    <a href="pe_inicio.php">Volver al inicio</a>
    <?php
        if (isset($_POST['consultar'])) {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];

            if ($startDate > $endDate) {
                echo "<p style='color:red;'>La fecha de inicio no puede ser posterior a la fecha de fin.</p>";
            } else {
                $conn = conexionBBDD();

                // Consulta sql para obtener las unidades vendidas por producto en el rango de fechas
                $sql = "SELECT p.productName, SUM(od.quantityOrdered) AS totalSold
                    FROM orderdetails od
                    JOIN orders o ON od.orderNumber = o.orderNumber
                    JOIN products p ON od.productCode = p.productCode
                    WHERE o.orderDate BETWEEN :startDate AND :endDate
                    GROUP BY p.productCode, p.productName
                    ORDER BY totalSold DESC";
                $params = [':startDate' => $startDate, ':endDate' => $endDate];
                
                $resultado = ejecutarConsulta($sql, $params);

                if (!empty($resultado)) {
                    echo "<table border='1'>";
                    echo "<tr><th>Producto</th><th>Unidades Vendidas</th></tr>";

                    foreach ($resultado as $fila) {
                        echo "<tr>
                                <td>" . htmlspecialchars($fila['productName']) . "</td>
                                <td>" . htmlspecialchars($fila['totalSold']) . "</td>
                              </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p>No se encontraron ventas en el rango de fechas especificado.</p>";
                }
                
            } 
        }
    ?>
</body>
</html>