<?php include_once "../controllers/gestionSesiones.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Clase - GymNet</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <h1>GymNet - Gestión de Clases</h1>
    <div class="container">
        <div class="card border-success mb-3" style="max-width: 40rem;">
            <div class="card-header">Menú Socio - RESERVAR CLASE</div>
            <div class="card-body">

                <b>Bienvenido/a:</b> <?php echo htmlspecialchars($_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido']); ?><br><br>
                <b>Identificador Socio:</b> <?php echo htmlspecialchars($_SESSION['cliente']['idsocio']); ?><br><br>
                <b>Clases disponibles en este momento:</b> <?php echo date('d/m/Y H:i'); ?><br><br>

                <form action="" method="post">

                    <label for="clases"><b>Clase/Monitor/Día:</b></label>
                    <select name="clases" id="clases" class="form-control">
                        <?php if (empty($clases)): ?>
                            <option value="">No hay clases disponibles</option>
                        <?php else: ?>
                            <?php foreach ($clases as $c): ?>
                                <?php $valor = $c['idclase'] . '|' . $c['nombre'] . '|' . $c['precio']; ?>
                                <option value="<?php echo htmlspecialchars($valor); ?>">
                                    <?php echo htmlspecialchars($c['nombre'] . ' - ' . $c['monitor'] . ' (' . $c['dia_semana'] . ' ' . substr($c['hora_inicio'], 0, 5) . ') - ' . $c['precio'] . '€'); ?>
                                    [<?php echo $c['aforo_actual'] . '/' . $c['aforo_maximo']; ?> plazas]
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <!-- Cesta actual -->
                    <?php if (!empty($_SESSION['cesta'])): ?>
                        <br>
                        <b>Cesta (<?php echo count($_SESSION['cesta']); ?>/3):</b>
                        <ul>
                            <?php foreach ($_SESSION['cesta'] as $item): ?>
                                <li><?php echo htmlspecialchars($item['nombre'] . ' - ' . $item['precio'] . ' €'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p><i>La cesta está vacía.</i></p>
                    <?php endif; ?>

                    <br>
                    <input type="submit" name="agregar"   value="Agregar a Cesta"    class="btn btn-warning">
                    <input type="submit" name="confirmar" value="Confirmar Reserva"  class="btn btn-warning">
                    <input type="submit" name="vaciar"    value="Vaciar Cesta"       class="btn btn-warning">

                </form>

                <br>
                <a href="../controllers/inicio.php">Volver a la Página Principal</a><br>
                <a href="../controllers/logout.php">Cerrar Sesión</a>

            </div>
        </div>
    </div>
</body>
</html>
