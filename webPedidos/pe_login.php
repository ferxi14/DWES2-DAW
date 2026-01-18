<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Pedidos</title>
</head>

<body>
    <h1>Inicia sesión</h1>
    <form method="POST" action="pe_login.php">
        <label for="customerNumber">Usuario:</label>
        <input type="number" id="customerNumber" name="customerNumber" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="contactLastName" name="contactLastName" required>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>

    <?php

        include 'funciones/pe_funciones.php';

        if (isset($_SESSION['customerNumber'])) {
            header("Location: pe_inicio.php");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = limpiar_campo($_POST['customerNumber']);
            $clave = limpiar_campo($_POST['contactLastName']);

            $sql = "SELECT customerNumber, contactLastName FROM customers WHERE customerNumber = :customerNumber AND contactLastName = :contactLastName";
            $parametros = [
                ':customerNumber' => $usuario,
                ':contactLastName' => $clave
            ];

            $resultado = ejecutarConsulta($sql, $parametros);
            
            if (!empty($resultado)) {
                $cliente = $resultado[0];
                session_start();
                $_SESSION['customerNumber'] = $cliente['customerNumber'];
                $_SESSION['contactLastName'] = $cliente['contactLastName'];
                header("Location: pe_inicio.php");
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos";
            }
        }
    ?>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
</body>

</html>