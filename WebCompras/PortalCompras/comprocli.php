<?php
    session_start();
    include "../funciones/funciones.php";

    if (!isset($_SESSION['nif'])) {
        header("Location: comlogoutcli.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra de productos</title>
</head>
<body>
    <h2>Compra de productos</h2>
    <form action="comprocli.php" method="POST">
        <label for="producto">Selecciona el producto: </label>
        <select name="producto" id="producto" required>
            <?php
                $sql = "SELECT ID_PRODUCTO, NOMBRE FROM producto";
                imprimirOpciones($sql, 'ID_PRODUCTO', 'NOMBRE');
            ?>
        </select><br><br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" required min="1"><br><br>

        <input type="submit" value="Añadir al carrito">
    </form>
    <h3>Carrito</h3>
    
</html>