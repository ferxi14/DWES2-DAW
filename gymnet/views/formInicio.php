<?php include_once "../controllers/gestionSesiones.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - GymNet</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <h1>GymNet - Gestión de Clases</h1>
    <div class="container">
        <div class="card border-success mb-3" style="max-width: 30rem;">
            <div class="card-header">Menú Socio - OPERACIONES</div>
            <div class="card-body">

                <b>Bienvenido/a:</b> <?php echo htmlspecialchars($_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido']); ?><br><br>
                <b>Identificador Socio:</b> <?php echo htmlspecialchars($_SESSION['cliente']['idsocio']); ?><br><br>

                <ul>
                    <li><a href="../controllers/reservar.php">Reservar Clase</a></li>
                    <li><a href="../controllers/consultar.php">Consultar Mis Reservas</a></li>
                    <li><a href="../controllers/cancelar.php">Cancelar Reserva</a></li>
                </ul>

                <a href="../controllers/logout.php">Cerrar Sesión</a>

            </div>
        </div>
    </div>
</body>
</html>
