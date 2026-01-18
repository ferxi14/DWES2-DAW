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
    <title>Consultar pagos realizados</title>
</head>
<body>
    <h2>Consultar pagos realizados</h2>
    <form method="POST">
        <label for="customerNumber">Cliente:</label>
        <select name="customerNumber" required>
            <?php
                $conn = conexionBBDD();
                $sql = "SELECT customerNumber, customerName FROM customers";
                imprimirOpciones($sql, 'customerNumber', 'customerName');
            ?>
        </select>
        <br><br>
        <label for="startDate">Fecha Inicio:</label>
        <input type="date" name="startDate">
        <br>
        <label for="endDate">Fecha Fin:</label>
        <input type="date" name="endDate">
        <br><br>
        <input type="submit" name="consultar" value="Consultar">
    </form>
    <a href="pe_inicio.php">Volver al inicio</a>

    <?php
        if (isset($_POST['consultar']) && (!empty($_POST['startDate']) && !empty($_POST['endDate']))) {
            $customerNumber = $_POST['customerNumber'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];

            $sql = "SELECT paymentDate, checkNumber, amount 
                FROM payments 
                WHERE customerNumber = :customerNumber
                AND paymentDate BETWEEN :startDate AND :endDate";
            $params = [':customerNumber' => $customerNumber, ':startDate' => $startDate, ':endDate' => $endDate];
            $resultado = ejecutarConsulta($sql, $params);

            if (!empty($resultado)) {
                echo "<h3>Pagos Realizados</h3>";
                echo "<table border='1'>";
                echo "<tr><th>Fecha</th><th>Número de Pago</th><th>Importe</th></tr>";

                $totalAmount = 0;

                foreach ($resultado as $fila) {
                    echo "<tr>
                            <td>" . htmlspecialchars($fila['paymentDate']) . "</td>
                            <td>" . htmlspecialchars($fila['checkNumber']) . "</td>
                            <td>" . htmlspecialchars($fila['amount']) . "</td>
                          </tr>";
                    $totalAmount += $fila['amount'];
                }

                echo "</table>";
                echo "<p><b>Total Pagado:</b> $" . number_format($totalAmount, 2) . "</p>";
            } else {
                echo "<p>No se encontraron pagos para el cliente en el rango de fechas especificado.</p>";
            }
        }
    ?>
</body>
</html>