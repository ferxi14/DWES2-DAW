<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - BiblioNet</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <h1>Red de Bibliotecas BIBLIONET</h1>
    <div class="container">
        <div class="card border-primary mb-3" style="max-width: 30rem;">
            <div class="card-header">Menú Socio - OPERACIONES</div>
            <div class="card-body">
                <!-- Mostrar nombre, apellido e id del socio desde sesión -->
                <b>Bienvenido/a:</b> <?php echo htmlspecialchars($_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido']); ?><br><br>
                <b>Identificador Cliente:</b> <?php echo htmlspecialchars($_SESSION['cliente']['idusuario']); ?><br><br>
                <!-- Botones: Realizar Préstamo, Consultar Préstamos, Devolver/Renovar -->
                <ul>
                    <li><a href="../controllers/prestamo.php">Realizar Préstamo</a></li>
                    <li><a href="../controllers/consultar.php">Consultar Préstamos</a></li>
                    <li><a href="../controllers/devolver.php">Devolver/Renovar Préstamo</a></li>
                </ul>
                <!-- Enlace: Cerrar Sesión -->
                <a href="../controllers/logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
