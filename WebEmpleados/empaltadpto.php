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

                        $nombre_dpto = limpiar_campo($_POST['dpto']);
                        $nuevoCodigo = insertarDepartamento($conn, $nombre_dpto);
                        
                        $conn->commit();

                        //echo "<p>Departamento <b>$nombre_dpto</b> insertado con código <b>D00$nuevoCodigo</b>.</p>";

                    } catch (PDOException $e) {
                        $conn->rollBack();
                        echo "Error: " . $e->getMessage();

                        echo "Código de error: " . $e->getCode() . "<br>";
                        $errorInfo = $e->errorInfo;
                        if ($errorInfo) {
                            echo "SQLSTATE: " . $errorInfo[0] . "<br>";
                            echo "Código específico de la base de datos: " . $errorInfo[1]
                                . "<br>Mensaje específico de la base de datos: " . $errorInfo[2] . "<br>";

                            if ($errorInfo[1] == 1062) 
                                echo "<p>El departamento ya existe.</p>";
                            
                        }
                    }
                    $conn = null;
                }
            ?>
        </form>
    </body>
</html>