<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HotelNet - Inicio</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 20px;
        }
        h1 {
            color: #667eea;
            margin: 0;
        }
        .user-info {
            text-align: right;
        }
        .user-info p {
            margin: 5px 0;
            color: #555;
        }
        .menu {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .menu-item {
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s;
            text-decoration: none;
            display: block;
        }
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        .menu-item h3 {
            margin: 0 0 10px 0;
        }
        .logout {
            text-align: center;
        }
        .logout a {
            background: #e74c3c;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }
        .logout a:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏨 Bienvenido a HotelNet</h1>
            <div class="user-info">
                <p><strong><?php echo $_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellidos']; ?></strong></p>
                <p><?php echo $_SESSION['cliente']['email']; ?></p>
            </div>
        </div>

        <div class="menu">
            <a href="reservar.php" class="menu-item">
                <h3>📅 Nueva Reserva</h3>
                <p>Reserva una habitación para tus próximas vacaciones</p>
            </a>
            <a href="consultar.php" class="menu-item">
                <h3>📋 Mis Reservas</h3>
                <p>Consulta tus reservas activas</p>
            </a>
            <a href="cancelar.php" class="menu-item">
                <h3>❌ Cancelar Reserva</h3>
                <p>Cancela una reserva existente</p>
            </a>
            <a href="logout.php" class="menu-item" style="background: #e74c3c;">
                <h3>🚪 Cerrar Sesión</h3>
                <p>Cierra tu sesión</p>
            </a>
        </div>
    </div>
</body>
</html>