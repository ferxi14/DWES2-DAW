<?php include_once "../controllers/gestionSesiones.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Préstamo - BiblioNet</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <h1>Red de Bibliotecas BIBLIONET</h1>
    <div class="container">
        <div class="card border-primary mb-3" style="max-width: 40rem;">
            <div class="card-header">Menú Socio - REALIZAR PRÉSTAMO</div>
            <div class="card-body">

                <b>Bienvenido/a:</b> <?php echo htmlspecialchars($_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido']); ?><br><br>
                <b>Identificador Socio:</b> <?php echo htmlspecialchars($_SESSION['cliente']['idusuario']); ?><br><br>
                <b>Libros disponibles en este momento:</b> <?php echo date('d/m/Y H:i'); ?><br><br>

                <form action="" method="post">
                    <label for="libros"><b>ISBN/Título/Autor:</b></label>
                    <select name="libros" id="libros">
                        <?php if (empty($libros)): ?>
                            <option value="">No hay libros disponibles</option>
                        <?php else: ?>
                            <?php foreach ($libros as $l): ?>
                                <?php $valor = $l['isbn'] . '|' . $l['titulo'] . '|' . $l['autor']; ?>
                                <option value="<?php echo htmlspecialchars($valor); ?>">
                                    <?php echo htmlspecialchars($l['isbn'] . ' - ' . $l['titulo'] . ' (' . $l['autor'] . ')'); ?>
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
                                <li><?php echo htmlspecialchars($item['isbn'] . ' - ' . $item['titulo'] . ' (' . $item['autor'] . ')'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p><i>La cesta está vacía.</i></p>
                    <?php endif; ?>

                    <br>
                    <input type="submit" name="agregar"   value="Agregar a Cesta">
                    <input type="submit" name="confirmar" value="Confirmar Préstamo">
                    <input type="submit" name="vaciar"    value="Vaciar Cesta">
                </form>

                <br>
                <a href="../controllers/welcome.php">Volver a la Página Principal</a><br>
                <a href="../controllers/logout.php">Cerrar Sesión</a>

            </div>
        </div>
    </div>
</body>
</html>
