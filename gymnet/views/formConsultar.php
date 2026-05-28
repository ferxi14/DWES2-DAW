<?php include_once "../controllers/gestionSesiones.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Reservas - GymNet</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <h1>GymNet - Gestión de Clases</h1>
    <div class="container">
        <div class="card border-success mb-3" style="max-width: 60rem;">
            <div class="card-header">Menú Socio - CONSULTA DE RESERVAS</div>
            <div class="card-body">

                <b>Bienvenido/a:</b> <?php echo htmlspecialchars($_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido']); ?><br><br>
                <b>Identificador Socio:</b> <?php echo htmlspecialchars($_SESSION['cliente']['idsocio']); ?><br><br>

                <form action="" method="post">
                    Fecha Desde:
                    <input type="date" name="fechadesde"
                           value="<?php echo htmlspecialchars($_POST['fechadesde'] ?? ''); ?>"
                           class="form-control"><br>
                    Fecha Hasta:
                    <input type="date" name="fechahasta"
                           value="<?php echo htmlspecialchars($_POST['fechahasta'] ?? ''); ?>"
                           class="form-control"><br><br>
                    <input type="submit" name="consultar" value="Consultar" class="btn btn-warning">
                    <input type="button" value="Volver"
                           onclick="window.location.href='../controllers/inicio.php'" class="btn btn-secondary">
                </form>

                <?php if (!empty($reservas)): ?>
                    <table border="1" class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Clase</th>
                                <th>Monitor</th>
                                <th>Día</th>
                                <th>Hora</th>
                                <th>Fecha Reserva</th>
                                <th>Estado</th>
                                <th>Precio (€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservas as $r): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($r['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($r['monitor']); ?></td>
                                    <td><?php echo htmlspecialchars($r['dia_semana']); ?></td>
                                    <td><?php echo substr($r['hora_inicio'], 0, 5); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($r['fecha_reserva'])); ?></td>
                                    <td><?php echo $r['fecha_cancelacion'] ? '<span style="color:red">Cancelada</span>' : '<span style="color:green">Activa</span>'; ?></td>
                                    <td><?php echo $r['precio_pagado'] !== null ? number_format($r['precio_pagado'], 2) : '-'; ?></td>
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
