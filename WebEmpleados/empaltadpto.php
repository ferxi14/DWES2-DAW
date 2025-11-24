<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Empleados - Alta Departamento</title>
    </head>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <label for="dpto">Departamento:</label>
            <input type="text" id="dpto" name="dpto">

            <input type="submit" value="Enviar">
            <?php
                include "funciones.php";

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    try {
                        $conn = conexionBBDD();
                        $conn->beginTransaction();

                        // Obtener último código
                        $sql = "SELECT cod_dpto FROM departamento ORDER BY cod_dpto DESC LIMIT 1";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $ultimo = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($ultimo) {
                            $num = intval(substr($ultimo['cod_dpto'], 1)) + 1;
                        } else {
                            $num = 1;
                        }

                        $nuevoCodigo = "D" . str_pad($num, 3, "0", STR_PAD_LEFT);

                        // Insertar departamento
                        $sql = "INSERT INTO departamento (cod_dpto, nombre_dpto) VALUES (:cod_dpto, :nombre_dpto)";
                        $stmt = $conn->prepare($sql);

                        $nombre_dpto = limpiar_campo($_POST['dpto']);

                        $stmt->bindParam(':cod_dpto', $nuevoCodigo);
                        $stmt->bindParam(':nombre_dpto', $nombre_dpto);
                        $stmt->execute();

                        $conn->commit();

                        echo "<p>Departamento <b>$nombre_dpto</b> insertado con código <b>$nuevoCodigo</b>.</p>";

                    } catch (PDOException $e) {
                        $conn->rollBack();
                        echo "Error: " . $e->getMessage();

                        echo "Código de error: " . $e->getCode() . "<br>";
                    }

                }
            ?>
        </form>
    </body>
</html>