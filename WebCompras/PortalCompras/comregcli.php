<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro clientes</title>
</head>

<body>
    <h2>Registro de clientes</h2>

    <form action="comregcli.php" method="POST">
        <label for="nif">NIF:</label>
        <input type="text" name="nif" id="nif" required><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" required><br><br>

        <label for="cp">Código postal:</label>
        <input type="text" name="cp" id="cp" required><br><br>

        <label for="direccion">Direccion:</label>
        <input type="text" name="direccion" id="direccion" required><br><br>

        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad" required><br><br>

        <input type="submit" value="Registrar Cliente">
    </form>

    <a href="comlogincli.php">Si ya tienes cuenta</a>

    <?php
        include '../funciones/funciones.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $error = "";

            $nif = limpiar_campo($_POST['nif']);
            $nombre = limpiar_campo($_POST['nombre']);
            $apellido = limpiar_campo($_POST['apellido']);
            $cp = limpiar_campo($_POST['cp']);
            $direccion = limpiar_campo($_POST['direccion']);
            $ciudad = limpiar_campo($_POST['ciudad']);

            if (!preg_match("/^\\d{8}[A-Z]$/", $nif)) {
                $error = "NIF inválido.";
            }

            if (empty($error)) {
                $conn = conexionBBDD();
                $sql = "SELECT * FROM cliente WHERE NIF = :nif";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nif', $nif);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $error = "El NIF ya está registrado.";
                }
            }

            if (empty($error)) {

                $usuario = strtolower($nombre);
                $clave = strrev(strtolower($apellido));

                $valores = [
                    "nif" => $nif,
                    "nombre" => $nombre,
                    "apellido" => $apellido,
                    "cp" => $cp,
                    "direccion" => $direccion,
                    "ciudad" => $ciudad
                ];

                insertarDatos('cliente', $valores);


                echo "Cliente registrado correctamente.<br>";
                echo "Usuario: <b>$usuario</b><br>";
                echo "Clave: <b>$clave</b>";
            } else {
                echo $error;
            }
        }
    ?>
</body>

</html>