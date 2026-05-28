<?php include_once "../controllers/gestionSesiones.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Préstamos - BiblioNet</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <h1>Red de Bibliotecas BIBLIONET</h1>
    <div class="container">
        <div class="card border-primary mb-3" style="max-width: 60rem;">
            <div class="card-header">Menú Socio - CONSULTA DE PRÉSTAMOS</div>
            <div class="card-body">

                <b>Bienvenido/a:</b> <?php echo htmlspecialchars($_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido']); ?><br><br>
                <b>Identificador Socio:</b> <?php echo htmlspecialchars($_SESSION['cliente']['idusuario']); ?><br><br>

                <form action="" method="post">
                    Fecha Desde:
                    <input type="date" name="fechadesde"
                           value="<?php echo htmlspecialchars($_POST['fechadesde'] ?? ''); ?>"
                           class="form-control"><br>
                    Fecha Hasta:
                    <input type="date" name="fechahasta"
                           value="<?php echo htmlspecialchars($_POST['fechahasta'] ?? ''); ?>"
                           class="form-control"><br><br>
                    <input type="submit" name="consultar" value="Consultar">
                    <input type="button" value="Volver"
                           onclick="window.location.href='../controllers/welcome.php'">
                </form>

                <?php if (!empty($prestamos)): ?>
                    <table border="1" class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>ISBN</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>F. Préstamo</th>
                                <th>F. Límite</th>
                                <th>F. Devolución</th>
                                <th>Renovado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prestamos as $p): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($p['isbn']); ?></td>
                                    <td><?php echo htmlspecialchars($p['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($p['autor']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($p['fecha_prestamo'])); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($p['fecha_limite'])); ?></td>
                                    <td><?php echo $p['fecha_devolucion'] ? date('d/m/Y', strtotime($p['fecha_devolucion'])) : '<i>En curso</i>'; ?></td>
                                    <td><?php echo $p['renovado'] === 'S' ? 'Sí' : 'No'; ?></td>
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
