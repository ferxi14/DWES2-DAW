<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HotelNet - Nueva Reserva</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 20px;
        }
        h1 {
            color: #667eea;
            margin: 0 0 10px 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.1);
        }
        .habitaciones {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .habitacion-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .habitacion-card:hover {
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
            border-color: #667eea;
        }
        .habitacion-card input[type="radio"] {
            width: auto;
            margin-right: 10px;
        }
        .habitacion-info {
            margin-top: 10px;
        }
        .habitacion-info p {
            margin: 5px 0;
            color: #555;
        }
        .price {
            font-size: 18px;
            font-weight: bold;
            color: #667eea;
            margin-top: 10px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background: #5568d3;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #667eea;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📅 Nueva Reserva</h1>
            <p>Selecciona una habitación y las fechas de tu estancia</p>
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label>Selecciona una habitación:</label>
                <div class="habitaciones">
                    <?php
                    if (!empty($habitaciones)) {
                        foreach ($habitaciones as $hab) {
                            echo "<div class='habitacion-card'>
                                    <label style='display: flex; align-items: center; margin-bottom: 0; cursor: pointer;'>
                                        <input type='radio' name='idhabitacion' value='{$hab['idhabitacion']}' required style='width: auto; margin-right: 10px;'>
                                        <span><strong>Hab. {$hab['numero']}</strong></span>
                                    </label>
                                    <div class='habitacion-info'>
                                        <p><strong>{$hab['tipo']}</strong></p>
                                        <p>Capacidad: {$hab['capacidad']} persona(s)</p>
                                        <div class='price'>€{$hab['precio_noche']}/noche</div>
                                    </div>
                                </div>";
                        }
                    } else {
                        echo "<p>No hay habitaciones disponibles en este momento.</p>";
                    }
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label for="fecha_entrada">Fecha de entrada:</label>
                <input type="date" id="fecha_entrada" name="fecha_entrada" required>
            </div>

            <div class="form-group">
                <label for="fecha_salida">Fecha de salida:</label>
                <input type="date" id="fecha_salida" name="fecha_salida" required>
            </div>

            <button type="submit" name="submit">Confirmar Reserva</button>
        </form>

        <a href="inicio.php" class="back-link">← Volver al inicio</a>
    </div>
</body>
</html>