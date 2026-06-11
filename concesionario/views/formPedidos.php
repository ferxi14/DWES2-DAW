<?php include_once "../controllers/gestionSesiones.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta Pedidos - Concesionario</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<h1>Concesionario</h1>
<div class="container">
<div class="card border-success mb-3" style="max-width:55rem;">
    <div class="card-header">Concesionario - Clientes - Consulta Pedidos</div>
    <div class="card-body">

        <b>Nombre Cliente:</b> <?php echo htmlspecialchars($_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellidos']); ?><br>
        <b>Email:</b> <?php echo htmlspecialchars($_SESSION['usuario']['email']); ?><br><br>

        <form action="" method="post">
            <b>Pedidos:</b>
            <select name="pedidos" class="form-control">
                <?php if (empty($pedidos)): ?>
                    <option value="">No tiene pedidos</option>
                <?php else: ?>
                    <?php foreach ($pedidos as $p): ?>
                        <option value="<?php echo $p['num_pedido']; ?>">
                            Pedido <?php echo $p['num_pedido']; ?> -
                            <?php echo $p['fecha_venta']; ?> -
                            <?php echo number_format($p['importe_total'], 2); ?> €
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <br>
            <input type="submit" name="consultar" value="Consultar Pedido" class="btn btn-warning">
            <input type="submit" name="volver"    value="Volver"           class="btn btn-secondary">
        </form>

        <?php if (!empty($lineas) && $pedidoSel): ?>
            <br>
            <table class="table table-bordered">
                <thead><tr><th>Num Pedido</th><th>Fecha</th><th>Importe Total</th></tr></thead>
                <tbody>
                    <tr>
                        <td><?php echo $pedidoSel['num_pedido']; ?></td>
                        <td><?php echo $pedidoSel['fecha_venta']; ?></td>
                        <td><?php echo number_format($pedidoSel['importe_total'], 2); ?> €</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Num Bastidor</th><th>Matrícula</th><th>Marca</th>
                        <th>Modelo</th><th>Kms</th><th>Precio</th><th>Descuento</th><th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lineas as $l): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($l['num_bastidor']); ?></td>
                            <td><?php echo htmlspecialchars($l['matricula']); ?></td>
                            <td><?php echo htmlspecialchars($l['marca']); ?></td>
                            <td><?php echo htmlspecialchars($l['modelo']); ?></td>
                            <td><?php echo $l['kms']; ?></td>
                            <td><?php echo number_format($l['precio_vehiculo'], 2); ?> €</td>
                            <td><?php echo number_format($l['descuento'], 2); ?> €</td>
                            <td><?php echo $l['fecha_venta']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <br>
        <a href="../controllers/logout.php">Cerrar Sesión</a>

    </div>
</div>
</div>
</body>
</html>

