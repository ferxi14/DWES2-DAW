<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Cliente</title>
</head>
<body>
    <h2>Login de Cliente</h2>

    <form action="comlogincli.php" method="POST">
        <label for="usuario">Nombre de Usuario:</label>
        <input type="text" name="usuario" id="usuario" required><br><br>

        <label for="clave">Clave:</label>
        <input type="password" name="clave" id="clave" required><br><br>

        <input type="submit" value="Iniciar Sesión">

        <a href="comregcli.php">Si no tienes cuenta</a>
    </form>

    <?php
        
        include "../funciones/funciones.php";

        // Si ya está logueado
        if (isset($_SESSION['nif'])) {
            header("Location: index.php");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $usuario = strtolower(limpiar_campo($_POST['usuario']));
            $clave   = strtolower(limpiar_campo($_POST['clave']));

            $sql = "SELECT * FROM cliente WHERE NOMBRE = :usuario";
            $parametros = [':usuario' => $usuario];

            $resultado = ejecutarConsulta($sql, $parametros);

            if (!empty($resultado)) {

                $cliente = $resultado[0];
                $clave_correcta = strrev(strtolower($cliente['APELLIDO']));

                if ($clave === $clave_correcta) {
                    session_start();
                    $_SESSION['nif'] = $cliente['NIF'];
                    $_SESSION['nombre'] = $cliente['NOMBRE'];
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Clave incorrecta.";
                }

            } else {
                echo "El usuario no existe.";
            }
        }
        ?>

</body>
</html>