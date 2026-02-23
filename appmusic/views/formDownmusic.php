<?php include_once "../controllers/gestionSesiones.php";?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descarga de música</title>
</head>
<body>
    <form action="" method="post">
        <h2>Compra de canciones</h2>
        <label for="canciones">Selecciona las canciones:</label>
        <select name="canciones" id="canciones">
            <?php
                foreach ($canciones as $track) {
                    $trackValue = $track["TrackId"] . "|" . $track["Name"] . "|" . $track["UnitPrice"];
                    echo "<option value='" . htmlspecialchars($trackValue) . "'>"
                    . htmlspecialchars($track["Name"]) . " | " 
                    . htmlspecialchars($track["Composer"]) . " | " 
                    . htmlspecialchars($track['UnitPrice']) . "€</option>";
                }
            ?>
        </select>

        <!-- Mostrar el carrito -->
        <?php 
            if (!empty($_SESSION['carrito'])) {
                echo '<ul>';
                foreach ($_SESSION['carrito'] as $track) {
                    echo '<li><b>' . htmlspecialchars($track['Name']) 
                    . '</b> | '. htmlspecialchars($track['UnitPrice'])
                    . '€ x '. htmlspecialchars($track['quantity']) .'</li>';
                }
                echo '</ul>';
            }
        ?>

        <br>
        <input type="submit" name="añadir" value="Añadir al carrito">

        <?php if (!empty($_SESSION['carrito'])) { ?>
        <input type="submit" name="vaciar" value="Vaciar Carrito">
        <?php } ?>

        <br><br><br>

        <b>Precio total: <?php echo number_format($totalPrice, 2); ?>€</b>

        <br>
        <input type="submit" name="comprar" value="Comprar">
    </form>

    <a href="../controllers/inicio.php">Volver a la Página Principal</a><br>
    <a href="../controllers/logout.php">Cerrar Sesión</a>
</body>
</html>