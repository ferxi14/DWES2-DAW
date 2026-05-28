<?php include_once "../controllers/gestionSesiones.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelar Reserva - GymNet</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <h1>GymNet - Gestión de Clases</h1>
    <div class="container">
        <div class="card border-success mb-3" style="max-width: 40rem;">
            <div class="card-header">Menú Socio - CANCELAR RESERVA</div>
            <div class="card-body">

                <b>Bienvenido/a:</b> <?php echo htmlspecialchars($_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido']); ?><br><br>
                <b>Identificador Socio:</b> <?php echo htmlspecialchars($_SESSION['cliente']['idsocio']); ?><br><br>

                <?php if (empty($reservas)): ?>
                    <p><i>No tiene reservas activas en este momento.</i></p>
                <?php else: ?>
                    <form action="" method="post">
                        <label><b>Clase reservada:</b></label>
                        <select name="reservas" class="form-control">
                            <?php foreach ($reservas as $r): ?>
                                <option value="<?php echo htmlspecialchars($r['idclase']); ?>">
                                    <?php echo htmlspecialchars($r['nombre'] . ' - ' . $r['monitor'] . ' (' . $r['dia_semana'] . ' ' . substr($r['hora_inicio'], 0, 5) . ') - ' . $r['precio_pagado'] . ' €'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <input type="submit" name="cancelar" value="Cancelar Reserva" class="btn btn-warning">
                        <input type="button" value="Volver"
                               onclick="window.location.href='../controllers/inicio.php'" class="btn btn-secondary">
                    </form>
                <?php endif; ?>

                <br>
                <a href="../controllers/logout.php">Cerrar Sesión</a>

            </div>
        </div>
    </div>
</body>
</html>
