<?php include_once "../controllers/gestionSesiones.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolver / Renovar - BiblioNet</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <h1>Red de Bibliotecas BIBLIONET</h1>
    <div class="container">
        <div class="card border-primary mb-3" style="max-width: 40rem;">
            <div class="card-header">Menú Socio - DEVOLUCIÓN / RENOVACIÓN</div>
            <div class="card-body">

                <b>Bienvenido/a:</b> <?php echo htmlspecialchars($_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido']); ?><br><br>
                <b>Identificador Socio:</b> <?php echo htmlspecialchars($_SESSION['cliente']['idusuario']); ?><br><br>

                <?php if (empty($prestamos)): ?>
                    <p><i>No tiene préstamos activos en este momento.</i></p>
                <?php else: ?>
                    <form action="" method="post">
                        <label><b>Libro en préstamo (ISBN - Título - Fecha límite):</b></label>
                        <select name="prestamo" class="form-control">
                            <?php foreach ($prestamos as $p): ?>
                                <option value="<?php echo htmlspecialchars($p['isbn']); ?>">
                                    <?php echo htmlspecialchars($p['isbn'] . ' - ' . $p['titulo'] . ' | Límite: ' . date('d/m/Y', strtotime($p['fecha_limite']))); ?>
                                    <?php if ($p['renovado'] === 'S') echo ' [RENOVADO]'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <input type="submit" name="devolver" value="Devolver">
                        <input type="submit" name="renovar"  value="Renovar">
                        <input type="button" value="Volver"
                               onclick="window.location.href='../controllers/welcome.php'">
                    </form>
                <?php endif; ?>

                <br>
                <a href="../controllers/logout.php">Cerrar Sesión</a>

            </div>
        </div>
    </div>
</body>
</html>
