<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprovisionar Producto en almacen</title>
</head>
<body>
    <h2>Aprovisionar producto en almacen</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="producto">Selecciona el producto:</label>
        <select name="producto" id="producto" required>
            <?php
                include "../funciones/funciones.php";
                $conn = conexionBBDD();

                $sql = "SELECT ID_PRODUCTO, NOMBRE FROM producto";
                imprimirOpciones($sql, 'ID_PRODUCTO', 'NOMBRE');
            ?>
        </select>
        <br><br>
        <label for="almacen">Selecciona el almacen:</label>
        <select name="almacen" id="almacen" required>
            <?php
                $sql = "SELECT NUM_ALMACEN, LOCALIDAD FROM almacen";
                imprimirOpciones($sql, 'NUM_ALMACEN', 'LOCALIDAD');
            ?>
        </select>
        <br><br>
        <label for="cantidad">Cantidad de producto:</label>
        <input type="number" name="cantidad" id="cantidad" required min="1">
        <br><br>

        <input type="submit" value="Aprovisionar Producto">
    </form>
</body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $producto = $_POST['producto'];
        $almacen = $_POST['almacen'];
        $cantidad = $_POST['cantidad'];

        $valores = array("NUM_ALMACEN" => $almacen, "ID_PRODUCTO" => $producto, "CANTIDAD" => $cantidad);

        insertarDatos("almacena", $valores);
    }

?>