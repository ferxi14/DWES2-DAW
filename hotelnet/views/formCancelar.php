<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HotelNet - Cancelar Reserva</title>
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
            border-bottom: 2px solid #e74c3c;
            padding-bottom: 20px;
        }
        h1 {
            color: #e74c3c;
            margin: 0;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .reservas {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .reserva-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .reserva-card:hover {
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.2);
            border-color: #e74c3c;
        }
        .reserva-card h3 {
            margin-top: 0;
            color: #333;
        }
        .reserva-info {
            margin: 10px 0;
            color: #555;
            font-size: 14px;
        }
        .reserva-card input[type="radio"] {
            margin-right: 10px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background: #c0392b;
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
        .no-reservas {
            padding: 20px;
            background-color: #e8f4f8;
            border-left: 4px solid #667eea;
            border-radius: 4px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>❌ Cancelar Reserva</h1>
        </div>

        <div class="warning">
            <strong>⚠️ Atención:</strong> Al cancelar una reserva, esta acción no puede deshacerse. Por favor, selecciona con cuidado.
        </div>

        <?php
        if (!empty($reservas)) {
            echo "<form method='POST' action=''>
                    <p>Selecciona la reserva que deseas cancelar:</p>
                    <div class='reservas'>";
            
            foreach ($reservas as $reserva) {
                echo "<div class='reserva-card'>
                        <label style='display: flex; align-items: flex-start; cursor: pointer;'>
                            <input type='radio' name='idhabitacion' value='{$reserva['idhabitacion']}' required style='margin-top: 5px;'>
                            <div>
                                <h3>Habitación {$reserva['numero']}</h3>
                                <div class='reserva-info'><strong>Tipo:</strong> {$reserva['tipo']}</div>
                                <div class='reserva-info'><strong>Entrada:</strong> {$reserva['fecha_entrada']}</div>
                                <div class='reserva-info'><strong>Salida:</strong> {$reserva['fecha_salida']}</div>
                                <div class='reserva-info'><strong>Reserva:</strong> {$reserva['fecha_reserva']}</div>
                                <input type='hidden' name='fecha_reserva' value='{$reserva['fecha_reserva']}'>
                            </div>
                        </label>
                    </div>";
            }
            
            echo "    </div>
                    <button type='submit' name='submit'>Confirmar Cancelación</button>
                  </form>";
        } else {
            echo "<div class='no-reservas'>
                    <p>No tienes reservas para cancelar. <a href='reservar.php'>¿Deseas hacer una nueva reserva?</a></p>
                  </div>";
        }
        ?>

        <a href="inicio.php" class="back-link">← Volver al inicio</a>
    </div>
</body>
</html>