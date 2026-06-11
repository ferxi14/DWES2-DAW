<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HotelNet - Mis Reservas</title>
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
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .estado-activa {
            background-color: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
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
            <h1>📋 Mis Reservas Activas</h1>
        </div>

        <?php
        if (!empty($reservas)) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>Habitación</th>
                            <th>Tipo</th>
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th>Precio/Noche</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>";
            
            foreach ($reservas as $reserva) {
                echo "<tr>
                        <td>Habitación {$reserva['numero']}</td>
                        <td>{$reserva['tipo']}</td>
                        <td>{$reserva['fecha_entrada']}</td>
                        <td>{$reserva['fecha_salida']}</td>
                        <td>€{$reserva['precio_noche']}</td>
                        <td><span class='estado-activa'>{$reserva['estado']}</span></td>
                    </tr>";
            }
            
            echo "</tbody>
                  </table>";
        } else {
            echo "<div class='no-reservas'>
                    <p>No tienes reservas activas en este momento. ¿Te gustaría <a href='reservar.php'>hacer una nueva reserva</a>?</p>
                  </div>";
        }
        ?>

        <a href="inicio.php" class="back-link">← Volver al inicio</a>
    </div>
</body>
</html>