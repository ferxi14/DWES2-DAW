<?php
    session_start();
    include "../funciones/funciones.php";

    if (!isset($_SESSION['nif'])) {
        header("Location: comlogoutcli.php");
        exit();
    }

    $conn = conexionBBDD();

    $compras = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['fecha_inicio'], $_POST['fecha_fin'])) {

        $fechaInicio = limpiar_campo($_POST['fecha_inicio']);
        $fechaFin    = limpiar_campo($_POST['fecha_fin']);

        $sql = "
            SELECT 
                p.NOMBRE,
                p.PRECIO,
                c.UNIDADES,
                (p.PRECIO * c.UNIDADES) AS TOTAL,
                c.FECHA_COMPRA
            FROM compra c
            JOIN producto p ON c.ID_PRODUCTO = p.ID_PRODUCTO
            WHERE c.NIF = :nif
            AND c.FECHA_COMPRA BETWEEN :inicio AND :fin
            ORDER BY c.FECHA_COMPRA
        ";

        $compras = ejecutarConsulta($sql, [
            ':nif'    => $_SESSION['nif'],
            ':inicio' => $fechaInicio . ' 00:00:00',
            ':fin'    => $fechaFin . ' 23:59:59'
        ]);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de compras</title>
</head>
<body>

<h2>Consulta de compras</h2>

<form method="POST">
    <label>Desde:</label>
    <input type="date" name="fecha_inicio" required>

    <label>Hasta:</label>
    <input type="date" name="fecha_fin" required>

    <button type="submit">Consultar</button>
</form>

<hr>

<?php if (!empty($compras)): ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Producto</th>
            <th>Precio (€)</th>
            <th>Unidades</th>
            <th>Total (€)</th>
            <th>Fecha</th>
        </tr>
        <?php foreach ($compras as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['NOMBRE']) ?></td>
                <td><?= number_format($c['PRECIO'], 2) ?></td>
                <td><?= $c['UNIDADES'] ?></td>
                <td><?= number_format($c['TOTAL'], 2) ?></td>
                <td><?= htmlspecialchars($c['FECHA_COMPRA']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <p>No hay compras en ese rango de fechas.</p>
<?php endif; ?>

<li>
    <a href="comlogoutcli.php">Cerrar sesión</a>
</li>
</body>
</html>