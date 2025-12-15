<?php
session_start();

// Control de acceso: solo usuarios logueados
if (!isset($_SESSION['nif'])) {
    header("Location: comlogincli.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Área de Cliente</title>
</head>
<body>

    <h1>Área de Cliente</h1>

     <p>Bienvenido, <b><?php echo $_SESSION['nombre']; ?></b></p>

    <h3>Menú</h3>
    <ul>
        <li>
            <a href="comprocli.php">Compra de productos</a>
        </li>
        <li>
            <a href="comconscli.php">Consulta de compras</a>
        </li>
    </ul>

</body>
</html>
